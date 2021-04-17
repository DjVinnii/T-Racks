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
        $rack_unit = null;
        $rack_id   = null;
        $unit_no   = null;
        $front     = false;
        $interior  = false;
        $back      = false;
        $racks     = [];

        if($this->model != null)
        {
            if ($this->model->rackUnits->first() != null)
            {
                $rack_unit = $this->model->rackUnits->first();
                $rack_id   = $rack_unit->rack_id;
                $unit_no   = $rack_unit->unit_no;
            }

            if (!$this->model->rackUnits->where('position', 0)->isEmpty())
                $front = true;

            if (!$this->model->rackUnits->where('position', 1)->isEmpty())
                $interior = true;

            if (!$this->model->rackUnits->where('position', 2)->isEmpty())
                $back = true;
        }

        foreach (Rack::all() as $rack)
        {
            $racks[$rack->id] = $rack->row->location->name . ' - ' . $rack->row->name . ' - ' . $rack->name;
        }

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
            ->add('rack_id', 'select', [
                'choices'     => $racks,
                'selected'    => $rack_id,
                'empty_value' => __('app.select_rack'),
                'label'       => __('app.rack'),
            ])
            ->add('unit_no', 'number', [
                'value' => $unit_no,
                'label' => __('app.unit_no'),
            ])
            ->add('front', 'checkbox', [
                'value' => 1,
                'checked' => $front,
                'label' => __('app.front'),
            ])
            ->add('interior', 'checkbox', [
                'value' => 1,
                'checked' => $interior,
                'label' => __('app.interior'),
            ])
            ->add('back', 'checkbox', [
                'value' => 1,
                'checked' => $back,
                'label' => __('app.back'),
            ])
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
