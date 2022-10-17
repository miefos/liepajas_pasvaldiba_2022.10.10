<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\GoalsResource;
use App\Models\CompleteLevel;
use App\Models\Entity;
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

        $goals = Goal::all();

        $goalsHierarchical = GoalsResource::collection(Goal::with([
            'subGoals',
            'subGoals.subGoals',
            'subGoals.subGoals.subGoals',
            'completeLevel',
            'entity'
        ])->whereNull('parent_goal_id')->get())->collection;

        $goalsHierarchical = ['id' => 0, 'data' => ['name' => 'Liepājas Pašvaldība'], 'children' => $goalsHierarchical];

        $listings = [
          'goals' => Goal::all(),
          'completeLevels' => CompleteLevel::all(),
          'entities' => Entity::all(),
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

    public function update(UpdateGoalRequest $request, Goal $goal)
    {
        $goal->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(Goal $goal)
    {
        abort_if(Gate::denies('goal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $goal->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyGoalRequest $request)
    {
        Goal::whereIn('id', request('ids'))->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
