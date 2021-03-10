<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class HardwareTypeForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' => 'required',
                'label' => __('app.name'),
            ])
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
