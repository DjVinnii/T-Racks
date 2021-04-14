<?php

namespace App\Http\Controllers;

use App\Forms\LocationForm;
use App\Models\Location;
use App\Models\Row;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\DataTables;

class LocationController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = Location::query();

        return DataTables::of($query)
            ->addColumn('rows', function (Location $location) {
                return $location->rows->count();
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rackspace.location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(LocationForm::class, [
           'method' => 'POST',
           'url'    => route('location.store'),
        ]);

        return view('rackspace.location.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(LocationForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        Location::create($attributes);

        return redirect()->route('location.index')->with('success', __('app.location_successfully_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view('rackspace.location.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Location $location
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(LocationForm::class, [
            'method' => 'PUT',
            'url'    => route('location.update', $location),
            'model'  => $location
        ]);

        return view('rackspace.location.edit', compact('form'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @param Location $location
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Location $location)
    {
        $form = $formBuilder->create(LocationForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $location->update($attributes);

        return redirect()->route('location.index')->with('success', __('app.location_successfully_updated'));
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
