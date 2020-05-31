<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RepositoryEdit extends Component
{
    public $repository;

    public function render()
    {
        return view('livewire.repository-edit');
    }
}
