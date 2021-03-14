<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RackDiagram extends Component
{

    public $rack;

    /**
     * Create a new component instance.
     *
     * @param $rack
     */
    public function __construct($rack)
    {
        $this->rack = $rack;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.rack-diagram');
    }
}
