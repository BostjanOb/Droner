<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    public string $icon;
    public int $size;

    public function __construct(string $icon, int $size)
    {
        $this->icon = $icon;
        $this->size = $size;
    }

    public function render()
    {
        return view('components.icon');
    }
}
