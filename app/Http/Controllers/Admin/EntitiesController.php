<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\EntitiesForTableResource;
use App\Http\Resources\EntityResource;
use App\Models\EntityLevel;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Http\Requests\MassDestroyEntityRequest;
use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;

class EntitiesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('entity_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entities = Entity::all();

//        $entitiesHierarchical = EntityResource::collection(Entity::where('is_root_node', '=', 0)->get())->collection;
        $entitiesHierarchical = EntityResource::make(Entity::with([
            'subEntities.supervisor',
            'subEntities.subEntities.supervisor',
            'subEntities.subEntities.subEntities.supervisor',
            'subEntities.subEntities.subEntities'
        ])->where('is_root_node', '=', 1)->firstOrFail());

        $users = User::all();
        $usersWithEntityAssigned = User::whereNotNull('entity_id')->get();

        $listings = [
            'entities' => $entities,
            'entityLevels' => EntityLevel::all(),
            'users' => $users,
        ];

//        $entitiesWithUsers = [...$entities, ...$usersWithEntityAssigned];

        return Inertia::render('Entities', [
            'entitiesHierarchical' => $entitiesHierarchical,
            'entities' => EntitiesForTableResource::collection($entities)->collection,
            'listings' => $listings
        ]);
    }

    public function store(StoreEntityRequest $request)
    {
        Entity::create($request->all());

        return back()->success(__('common.success.created'));
    }

    public function update(UpdateEntityRequest $request, Entity $entity)
    {
        $entity->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(Entity $entity)
    {
        abort_if(Gate::denies('entity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entity->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyEntityRequest $request)
    {
        Entity::whereIn('id', request('ids'))->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
