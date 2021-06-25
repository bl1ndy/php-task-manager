<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $labels = Label::paginate();

        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        Gate::authorize('label_actions');

        $label = new label();

        return view('label.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLabelRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreLabelRequest $request)
    {
        $data = $request->validated();

        $label = new Label();
        $label->fill($data);
        $label->save();

        flash(__('messages.label.create.success'))->success();

        return redirect()
            ->route('labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label $label
     * @return \Illuminate\View\View
     */
    public function edit(Label $label)
    {
        Gate::authorize('label_actions');

        return view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLabelRequest  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateLabelRequest $request, Label $label)
    {
        $data = $request->validated();

        $label->fill($data);
        $label->save();

        flash(__('messages.label.update.success'))->success();

        return redirect()
            ->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Label $label)
    {
        if ($label->tasks->isNotEmpty()) {
            flash(__('messages.label.delete.fail'))->error();
        } else {
            $label->delete();
            flash(__('messages.label.delete.success'))->success();
        }

        return redirect()
            ->route('labels.index');
    }
}
