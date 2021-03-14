<?php

namespace App\Forms;

use App\Models\Hardware;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

class PortForm extends Form
{
    public function buildForm()
    {
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
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
