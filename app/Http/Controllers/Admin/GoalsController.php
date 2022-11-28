<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Resources\GoalsHierarchicalResource;
use App\Http\Resources\GoalsSimpleResource;
use App\Models\CompleteLevel;
use App\Models\Entity;
use App\Models\User;
use App\Services\GoalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Http\Requests\MassDestroyGoalRequest;
use App\Http\Requests\StoreGoalRequest;
use App\Http\Requests\UpdateGoalRequest;

class GoalsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('goal_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $goals = Goal::with(['entity', 'audits' => function ($query) {
            $query->orderBy('updated_at', 'desc');
        }])->get();
        $goalsSimpleCollection = GoalsSimpleResource::collection($goals)->collection;


        $goalsHierarchical = GoalsHierarchicalResource::collection(Goal::with([
            'subGoals',
            'subGoals.subGoals',
            'subGoals.subGoals.subGoals',
            'completeLevel',
            'entity',
            'subGoals.entity',
            'subGoals.subGoals.entity',
            'subGoals.subGoals.subGoals.entity',
            'user',
            'subGoals.user',
            'subGoals.subGoals.user',
            'subGoals.subGoals.subGoals.user',
        ])
            ->whereHas('entity', function ($query) {
                $query->where('is_root_node', '=', 1);
            })->get())->collection;

        $goalsHierarchical = ['id' => 0, 'data' => ['name' => 'Liepājas Pašvaldība'], 'children' => $goalsHierarchical];

        $users = User::all();
        $entities = Entity::all();

        $listings = [
          'goals' => $goals,
          'completeLevels' => CompleteLevel::all(),
          'entities' => $entities,
          'users' => $users,
          'entitiesAndUsersGrouped' => [[
              'label' => 'Struktūrvienības',
              'items' => $entities->filter(function ($ent) {
                  return GoalService::creatableByCurrentUser(null, $ent->id);
              })->map(function ($ent) {
                  $ent->entity_type = "entity";
                  return $ent;
              })->flatten(),
              ], [
              'label' => 'Darbinieki',
              'items' => $users->filter(function ($user) {
                  return GoalService::creatableByCurrentUser($user->id, null);
              })->map(function ($user) {
                  $user->entity_type = "user";
                  return $user;
              })->flatten(),
            ]
          ],
        ];

//        dd($listings['entitiesAndUsersGrouped']);

        return Inertia::render('Goals', [
            'goals' => $goalsSimpleCollection,
            'listings' => $listings,
            'goalsHierarchical' => $goalsHierarchical
        ]);
    }

    public function store(StoreGoalRequest $request)
    {
        $user_id = request()->get('user_id');
        $entity_id = request()->get('entity_id');
        if (!GoalService::creatableByCurrentUser($user_id, $entity_id)) {
            throw new CustomException(__('common.error.goalCannotBeCreated'));
        }

        Goal::create($request->all());

        return back()->success(__('common.success.created'));
    }

    public function update(UpdateGoalRequest $request, Goal $goal)
    {
        // check if the goal is editable by the user
        if (!$goal->editableByCurrentUser()) {
            throw new CustomException(__('common.error.goalCannotBeEdited'));
        }

        $goal->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(Goal $goal)
    {
        abort_if(Gate::denies('goal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!$goal->editableByCurrentUser()) {
            throw new CustomException(__('common.error.goalCannotBeEdited'));
        }

        if ($goal->subGoals()->count() > 0) {
            return back()->danger(__('common.error.goalHasSubgoals'));
        }

        $goal->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyGoalRequest $request)
    {
        $goals = Goal::whereIn('id', request('ids'));
        $goalsArr = $goals->get();
        foreach ($goalsArr as $goal) {
            if (!$goal->editableByCurrentUser()) {
                throw new CustomException(__('common.error.goalCannotBeEdited'));
            }

            if ($goal->subGoals()->count() > 0) {
                return back()->danger(__('common.error.goalHasSubgoals'));
            }
        }

        $goals->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
