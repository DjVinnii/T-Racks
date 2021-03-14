<?php

namespace App\Http\Controllers;

use App\Forms\PortForm;
use App\Models\Port;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\DataTables;

class PortController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = Port::query();

        return DataTables::of($query)
            ->editColumn('hardware_id', function (Port $port) {
                return $port->hardware->name;
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
        return view('port.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PortForm::class, [
           'method' => 'POST',
           'url'    => route('port.store'),
        ]);

        return view('port.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PortForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $port = Port::create($attributes);

        return redirect()->route('port.index')->with('success', __('app.port_successfully_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param Port $port
     * @return \Illuminate\Http\Response
     */
    public function show(Port $port)
    {
        return view('port.show', compact('port'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Port $port
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Port $port, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PortForm::class, [
           'method' => 'PUT',
           'url'    => route('port.update', $port),
           'model'  => $port,
        ]);

        return view('port.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @param Port $port
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Port $port)
    {
        $form = $formBuilder->create(PortForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $port->update($attributes);

        return redirect()->route('port.index')->with('success', __('app.port_successfully_updated'));
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
