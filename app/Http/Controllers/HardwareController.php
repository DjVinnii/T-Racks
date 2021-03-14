<?php

namespace App\Http\Controllers;

use App\Forms\HardwareForm;
use App\Models\Hardware;
use App\Models\RackUnit;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\Facades\DataTables;

class HardwareController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = Hardware::query();

        return DataTables::of($query)
            ->editColumn('hardware_type', function(Hardware $hardware) {
                return $hardware->HardwareType->name;
            })
            ->addColumn('rack', function(Hardware $hardware){
                return $hardware->rackUnits->first()->rack->name;
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
        return view('hardware.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(HardwareForm::class, [
           'method' => 'POST',
           'url'    => route('hardware.store'),
        ]);

        return view('hardware.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(HardwareForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $hardware = Hardware::create($attributes);

        if ($attributes['front'] == 1)
        {
            RackUnit::create([
                'rack_id'     => $attributes['rack_id'],
                'unit_no'     => $attributes['unit_no'],
                'hardware_id' => $hardware->id,
                'position'    => 0,
            ]);
        }

        if ($attributes['interior'] == 1)
        {
            RackUnit::create([
                'rack_id'     => $attributes['rack_id'],
                'unit_no'     => $attributes['unit_no'],
                'hardware_id' => $hardware->id,
                'position'    => 1,
            ]);
        }

        if ($attributes['back'] == 1)
        {
            RackUnit::create([
                'rack_id'     => $attributes['rack_id'],
                'unit_no'     => $attributes['unit_no'],
                'hardware_id' => $hardware->id,
                'position'    => 2,
            ]);
        }

        return redirect()->route('hardware.index')->with('success', __('app.hardware_successfully_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param Hardware $hardware
     * @return \Illuminate\Http\Response
     */
    public function show(Hardware $hardware)
    {
        return view('hardware.show', compact('hardware'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hardware $hardware
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Hardware $hardware, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(HardwareForm::class, [
            'method' => 'PUT',
            'url'    => route('hardware.update', $hardware),
            'model'  => $hardware,
        ]);

        return view('hardware.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @param Hardware $hardware
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Hardware $hardware)
    {
        $form = $formBuilder->create(HardwareForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $hardware->update($attributes);

        foreach($hardware->rackUnits as $rack_unit)
        {
            $rack_unit->delete();
        }

        if ($attributes['front'] == 1)
        {
            RackUnit::create([
                'rack_id'     => $attributes['rack_id'],
                'unit_no'     => $attributes['unit_no'],
                'hardware_id' => $hardware->id,
                'position'    => 0,
            ]);
        }

        if ($attributes['interior'] == 1)
        {
            RackUnit::create([
                'rack_id'     => $attributes['rack_id'],
                'unit_no'     => $attributes['unit_no'],
                'hardware_id' => $hardware->id,
                'position'    => 1,
            ]);
        }

        if ($attributes['back'] == 1)
        {
            RackUnit::create([
                'rack_id'     => $attributes['rack_id'],
                'unit_no'     => $attributes['unit_no'],
                'hardware_id' => $hardware->id,
                'position'    => 2,
            ]);
        }

        return redirect()->route('hardware.index')->with('success', __('app.hardware_successfully_updated'));
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
