<?php

namespace App\Forms;

use App\Models\Hardware;
use App\Models\Port;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

class PortForm extends Form
{
    public function buildForm()
    {
        $remote_ports = [];
        $ports = Port::all();

        foreach ($ports as $port)
        {
            $remote_ports[$port->id] = $port->hardware->name . ' - ' . $port->name;
        }

        $this
            ->add('name', 'text', [
                'rules' => 'required',
                'label' => __('app.name'),
            ])
            ->add('hardware_id', 'select', [
                'choices'     => Arr::pluck(Hardware::all(), 'name', 'id'),
                'empty_value' => __('app.select_hardware'),
                'rules'       => 'required',
                'label'       => __('app.hardware'),
            ])
            ->add('mac_address', 'text', [
                'label' => __('app.mac_address')
            ])
            ->add('remote_port', 'select', [
                'choices'     => $remote_ports,
                'empty_value' => __('app.select_remote_port'),
                'label'       => __('app.remote_port'),
            ])
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
