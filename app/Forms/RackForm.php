<?php

namespace App\Forms;

use App\Models\Row;
use Kris\LaravelFormBuilder\Form;

class RackForm extends Form
{
    public function buildForm()
    {

        $locations = [];
        $rows = Row::all();

        foreach ($rows as $row)
        {
            $locations[$row->id] = $row->location->name . ' - ' . $row->name;
        }

        $this
            ->add('name', 'text', [
                'rules' => 'required',
                'label' => __('app.name'),
            ])
            ->add('height', 'number', [
                'rules' => 'required',
                'label' => __('app.height'),
                'attr'  => ['min' => '0', 'step' => '1'],
            ])
            ->add('row_id', 'select', [
                'choices'     => $locations,
                'empty_value' => __('app.select_row'),
                'rules'       => 'required',
                'label'       => __('app.row'),
            ])
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
