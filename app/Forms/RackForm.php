<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class RackForm extends Form
{
    public function buildForm()
    {
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
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
