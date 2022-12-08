<?php

namespace App\Http\Controllers\Admin;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\MassDestroyTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TasksController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('task_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $tasks = Task::with('goals')->get();
        $tasks = Task::all();

        $listings = [
            'goals' => Goal::all(),
        ];

        return Inertia::render('Tasks', ['tasks' => $tasks, 'listings' => $listings]);
    }

    public function store(StoreTaskRequest $request)
    {
        $request['user_id'] = auth()->user()->id;
        Task::create($request->all());

        return back()->success(__('common.success.created'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(Task $task)
    {
        abort_if(Gate::denies('task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyTaskRequest $request)
    {
        Task::whereIn('id', request('ids'))->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
