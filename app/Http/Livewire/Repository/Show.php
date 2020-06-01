<?php

namespace App\Http\Livewire\Repository;

use App\Repository;
use Livewire\Component;

class Show extends Component
{
    public $repo;

    public function mount(Repository $repo)
    {
        $this->repo = $repo;
    }

    public function render()
    {
        return view('livewire.repository.show');
    }
}
