<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class Ipv4NetworkForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' => 'required',
                'label' => __('app.name'),
            ])
            ->add('network', 'text', [
                'rules' => 'required',
                'label' => __('app.network'),
            ])
            ->add('mask', 'number', [
                'rules' => 'required',
                'label' => __('app.mask'),
                'attr'  => ['min' => '0', 'step' => '1'],
            ])
            ->add('submit', 'submit', [
                'label' => __('app.save'),
            ]);
    }
}
