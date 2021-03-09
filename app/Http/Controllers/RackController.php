<?php

namespace App\Http\Controllers;

use App\Forms\RackForm;
use App\Models\Hardware;
use App\Models\Rack;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\DataTables;

class RackController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = Rack::query();

        return DataTables::of($query)->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rack.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RackForm::class, [
           'method' => 'POST',
           'url'    => route('rack.store'),
        ]);

        return view('rack.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RackForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $rack = Rack::create($attributes);

        return redirect()->route('rack.index')->with('success', __('app.rack_successfully_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param Rack $rack
     * @return \Illuminate\Http\Response
     */
    public function show(Rack $rack)
    {
        return view('rack.show', compact('rack'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Rack $rack
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Rack $rack, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RackForm::class, [
            'method' => 'PUT',
            'url'    => route('rack.update', $rack),
            'model'  => $rack
        ]);

        return view('rack.edit', compact('form'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Rack $rack)
    {
        $form = $formBuilder->create(RackForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $rack->update($attributes);

        return redirect()->route('rack.index')->with('success', __('app.rack_successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
