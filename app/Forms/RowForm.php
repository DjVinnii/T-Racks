<?php

namespace App\Forms;

use App\Models\Location;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

class RowForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' => 'required',
                'label' => __('app.name'),
            ])
            ->add('location_id', 'select', [
                'choices'     => Arr::pluck(Location::all(), 'name', 'id'),
                'empty_value' => __('app.select_location'),
                'rules'       => 'required',
                'label'       => __('app.location'),
            ])
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
