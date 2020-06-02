<?php

namespace App\Http\Livewire\Repository;

use App\Repository;
use Livewire\Component;

class Show extends Component
{
    public $repo;
    public $builds;

    public function queue()
    {
        $this->repo->newBuild();
        $this->loadBuilds();
    }

    public function forceSend($id)
    {
        $this->repo->builds()
            ->findOrFail($id)
            ->sendToDrone(true);

        $this->loadBuilds();
    }

    private function loadBuilds()
    {
        $this->builds = $this->repo->builds()->latest()->get();
    }

    public function mount(Repository $repo)
    {
        $this->repo = $repo;

        $this->loadBuilds();
    }

    public function render()
    {
        return view('livewire.repository.show');
    }
}
