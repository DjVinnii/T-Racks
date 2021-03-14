<?php

namespace App\Http\Controllers;

use App\Forms\HardwareTypeForm;
use App\Models\HardwareType;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\Facades\DataTables;

class HardwareTypeController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = HardwareType::query();

        return DataTables::of($query)
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hardware.type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(HardwareTypeForm::class, [
            'method' => 'POST',
            'url'    => route('hardware_type.store'),
        ]);

        return view('hardware.type.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(HardwareTypeForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $hardwareType = HardwareType::create($attributes);

        return redirect()->route('hardware_type.index')->with('success', __('app.hardware_type_successfully_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param HardwareType $hardwareType
     * @return \Illuminate\Http\Response
     */
    public function show(HardwareType $hardwareType)
    {
        return view('hardware.type.show', compact('hardwareType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HardwareType $hardwareType
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(HardwareType $hardwareType, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(HardwareTypeForm::class, [
            'method' => 'PUT',
            'url'    => route('hardware_type.update', $hardwareType),
            'model'  => $hardwareType,
        ]);

        return view('hardware.type.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @param HardwareType $hardwareType
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, HardwareType $hardwareType)
    {
        $form = $formBuilder->create(HardwareTypeForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $hardwareType->update($attributes);

        return redirect()->route('hardware_type.index')->with('success', __('app.hardware_type_successfully_updated'));
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
