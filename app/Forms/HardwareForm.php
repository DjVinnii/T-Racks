<?php

namespace App\Forms;

use App\Models\HardwareType;
use App\Models\Rack;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

class HardwareForm extends Form
{
    public function buildForm()
    {
//        $rack = null;
//
//        if($this->model != null)
//        {
//            $rack = $this->model->rackUnits->first()->rack_id;
//        }

        $this
            ->add('name', 'text', [
                'rules' => 'required',
                'label' => __('app.name'),
            ])
            ->add('hardware_type', 'select', [
                'choices'     =>  Arr::pluck(HardwareType::all(), 'name', 'id'),
                'empty_value' => __('app.select_hardware_type'),
                'rules'       => 'required',
                'label'       => __('app.hardware_type'),
            ])
            ->add('label', 'text', [
                'label' => __('app.label'),
            ])
            ->add('asset_tag', 'text', [
                'label' => __('app.asset_tag'),
            ])
//            ->add('rack', 'select', [
//                'choices'     =>  Arr::pluck(Rack::all(), 'name', 'id'),
//                'selected'       => $rack,
//                'empty_value' => __('app.select_rack'),
//                'label'       => __('app.rack'),
//            ])
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
