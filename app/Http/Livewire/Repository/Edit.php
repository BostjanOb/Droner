<?php

namespace App\Http\Livewire\Repository;

use App\Repository;
use Livewire\Component;

class Edit extends Component
{
    public $repo;

    public bool $active;
    public int $threshold;

    public function save()
    {
        $data = $this->validate([
            'active'    => ['required', 'boolean'],
            'threshold' => ['required', 'integer'],
        ]);

        $this->repo->update($data);
    }

    public function mount(Repository $repo)
    {
        $this->repo = $repo;
        $this->active = $repo->active;
        $this->threshold = $repo->threshold;
    }

    public function render()
    {
        return view('livewire.repository.edit');
    }
}
