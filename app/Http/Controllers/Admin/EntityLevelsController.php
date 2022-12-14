<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\EntityLevel;
use App\Http\Requests\MassDestroyEntityLevelRequest;
use App\Http\Requests\StoreEntityLevelRequest;
use App\Http\Requests\UpdateEntityLevelRequest;

class EntityLevelsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('entity_level_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entityLevels = EntityLevel::all();

        $listings = [
          'entityLevels' => $entityLevels,
          'booleanShowAll' => [
              ['value' => 0, 'name' => 'Nerādīt'],
              ['value' => 1, 'name' => 'Rādīt'],
          ],
          'booleanEmployeeLevel' => [
              ['value' => 0, 'name' => 'Nav'],
              ['value' => 1, 'name' => 'Ir'],
          ]
        ];

        return Inertia::render('EntityLevels', [
            'entityLevels' => $entityLevels,
            'listings' => $listings
        ]);
    }

    public function store(StoreEntityLevelRequest $request)
    {
        EntityLevel::create($request->all());

        return back()->success(__('common.success.created'));
    }

    public function update(UpdateEntityLevelRequest $request, EntityLevel $entity_level)
    {
        $entity_level->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(EntityLevel $entity_level)
    {
        abort_if(Gate::denies('entity_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($entity_level->subEntityLevels()->count()) {
            return back()->danger(__('common.error.entityLevelHasSubentityLevels'));
        }

        if ($entity_level->entities()->count()) {
            return back()->danger(__('common.error.entityLevelHasEntities'));
        }

        $entity_level->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyEntityLevelRequest $request)
    {
        $entityLevels = EntityLevel::whereIn('id', request('ids'));
        $entityLevelsArr = $entityLevels->get();
        foreach ($entityLevelsArr as $entityLevel) {
            if ($entityLevel->subEntityLevels()->count()) {
                return back()->danger(__('common.error.entityLevelHasSubentityLevels'));
            }

            if ($entityLevel->entities()->count()) {
                return back()->danger(__('common.error.entityLevelHasEntities'));
            }
        }

        $entityLevels->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
