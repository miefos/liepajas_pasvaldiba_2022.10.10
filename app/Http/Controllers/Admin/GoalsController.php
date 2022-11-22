<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\GoalsResource;
use App\Models\CompleteLevel;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

        $goals = Goal::with(['audits' => function ($query) {
            $query->orderBy('updated_at', 'desc');
        }])->get();

        $goalsHierarchical = GoalsResource::collection(Goal::with([
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

        $listings = [
          'goals' => Goal::all(),
          'completeLevels' => CompleteLevel::all(),
          'entities' => Entity::all(),
          'users' => User::all()
        ];

        return Inertia::render('Goals', [
            'goals' => $goals,
            'listings' => $listings,
            'goalsHierarchical' => $goalsHierarchical
        ]);
    }

    public function store(StoreGoalRequest $request)
    {
        Goal::create($request->all());

        return back()->success(__('common.success.created'));
    }

    public function update(Request $request, Goal $goal)
    {
        $goal->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(Goal $goal)
    {
        abort_if(Gate::denies('goal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            if ($goal->subGoals()->count() > 0) {
                return back()->danger(__('common.error.goalHasSubgoals'));
            }
        }

        $goals->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
