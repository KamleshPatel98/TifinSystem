<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShowImage extends Component
{
    /**
     * Create a new component instance.
     */
    public $src;
    public $alt;
    public $width;
    public $height;
    public $class;
    public $style;
    public function __construct($src, $alt = null, $width = 40, $height = 40, $class = '', $style = '')
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->width = $width;
        $this->height = $height;
        $this->class = $class;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.show-image');
    }
}
