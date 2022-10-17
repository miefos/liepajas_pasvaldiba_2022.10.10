<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\CompleteLevel;
use App\Http\Requests\MassDestroyCompleteLevelRequest;
use App\Http\Requests\StoreCompleteLevelRequest;
use App\Http\Requests\UpdateCompleteLevelRequest;

class CompleteLevelsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('complete_level_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $completeLevels = CompleteLevel::all();

        return Inertia::render('CompleteLevels', ['completeLevels' => $completeLevels]);
    }

    public function store(StoreCompleteLevelRequest $request)
    {
        CompleteLevel::create($request->all());

        return back()->success(__('common.success.created'));
    }

    public function update(UpdateCompleteLevelRequest $request, CompleteLevel $complete_level)
    {
        $complete_level->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(CompleteLevel $complete_level)
    {
        abort_if(Gate::denies('complete_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $complete_level->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyCompleteLevelRequest $request)
    {
        CompleteLevel::whereIn('id', request('ids'))->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
