<?php

namespace App\Http\Controllers;

use App\Forms\RowForm;
use App\Models\Row;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\DataTables;

class RowController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = Row::query();

        return DataTables::of($query)
            ->editColumn('location_id', function (Row $row){
                return $row->location->name;
            })
            ->addColumn('racks', function (Row $row){
                return $row->racks->count();
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
        return view('rackspace.row.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RowForm::class, [
           'method' => 'POST',
           'url'    => route('row.store'),
        ]);

        return view('rackspace.row.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RowForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        Row::create($attributes);

        return redirect()->route('row.index')->with('success', __('app.row_successfully_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param Row $row
     * @return \Illuminate\Http\Response
     */
    public function show(Row $row)
    {
        return view('rackspace.row.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Row $row
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Row $row, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RowForm::class, [
            'method' => 'PUT',
            'url'    => route('row.update', $row),
            'model'  => $row
        ]);

        return view('rackspace.row.edit', compact('form'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @param Row $row
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Row $row)
    {
        $form = $formBuilder->create(RowForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $row->update($attributes);

        return redirect()->route('row.index')->with('success', __('app.row_successfully_updated'));
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
