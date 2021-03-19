<?php

namespace App\Http\Controllers;

use App\Forms\Ipv4NetworkForm;
use App\Models\Ipv4Network;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\Facades\DataTables;

class Ipv4NetworkController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = Ipv4Network::query();

        return DataTables::of($query)
            ->editColumn('network', function (Ipv4Network $ipv4Network) {
                return $ipv4Network->network . '/' . $ipv4Network->mask;
            })
            ->addColumn('capacity', function (Ipv4Network $ipv4Network) {
                return pow(2, (32 - $ipv4Network->mask));
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
        return view('ipv4.network.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(Ipv4NetworkForm::class, [
           'method' => 'POST',
           'url'    => route('ipv4_network.store'),
        ]);

        return view('ipv4.network.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(Ipv4NetworkForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $hardwareType = Ipv4Network::create($attributes);

        return redirect()->route('ipv4_network.index')->with('success', __('app.ipv4_network_successfully_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param Ipv4Network $ipv4Network
     * @return \Illuminate\Http\Response
     */
    public function show(Ipv4Network $ipv4Network)
    {
        return view('ipv4.network.show', compact('ipv4Network'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ipv4Network $ipv4Network
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Ipv4Network $ipv4Network, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(Ipv4NetworkForm::class, [
           'method' => 'PUT',
           'url'    => route('ipv4_network.update', $ipv4Network),
           'model'  => $ipv4Network,
        ]);

        return view('ipv4.network.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @param Ipv4Network $ipv4Network
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Ipv4Network $ipv4Network)
    {
        $form = $formBuilder->create(Ipv4NetworkForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $ipv4Network->update($attributes);

        return redirect()->route('ipv4_network.index')->with('success', __('app.ipv4_network_successfully_updated'));
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
