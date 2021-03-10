<?php

namespace App\Http\Controllers;

use App\Forms\Ipv6NetworkForm;
use App\Models\Ipv6Network;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\Facades\DataTables;

class Ipv6NetworkController extends Controller
{
    /**
     * Returns the datatable of the resource.
     */
    public function datatable()
    {
        $query = Ipv6Network::query();

        return DataTables::of($query)
            ->editColumn('network', function (Ipv6Network $ipv6Network) {
                return $ipv6Network->network . '/' . $ipv6Network->mask;
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
        return view('ipv6.network.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(Ipv6NetworkForm::class, [
           'method' => 'POST',
           'url'    => route('ipv6_network.store'),
        ]);

        return view('ipv6.network.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(Ipv6NetworkForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $hardwareType = Ipv6Network::create($attributes);

        return redirect()->route('ipv6_network.index')->with('success', __('app.ipv6_network_successfully_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param Ipv6Network $ipv6Network
     * @return \Illuminate\Http\Response
     */
    public function show(Ipv6Network $ipv6Network)
    {
        return view('ipv6.network.show', compact('ipv6Network'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ipv6Network $ipv6Network
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Ipv6Network $ipv6Network, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(Ipv6NetworkForm::class, [
           'method' => 'PUT',
           'url'    => route('ipv6_network.update', $ipv6Network),
           'model'  => $ipv6Network,
        ]);

        return view('ipv6.network.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormBuilder $formBuilder
     * @param Ipv6Network $ipv6Network
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Ipv6Network $ipv6Network)
    {
        $form = $formBuilder->create(Ipv6NetworkForm::class);

        if(!$form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $attributes = $form->getFieldValues();

        $ipv6Network->update($attributes);

        return redirect()->route('ipv6_network.index')->with('success', __('app.ipv6_network_successfully_updated'));
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
