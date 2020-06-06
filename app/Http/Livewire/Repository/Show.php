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
        try {
            $this->repo->newBuild();
            $this->loadBuilds();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toast', [
                'title'   => $e->getMessage(),
                'type'    => 'error',
                'timeout' => 2000,
            ]);

            return;
        }
    }

    public function forceSend($id)
    {
        try {
            $this->repo->builds()
                ->findOrFail($id)
                ->sendToDrone(true);

            $this->loadBuilds();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toast', [
                'title'   => $e->getMessage(),
                'type'    => 'success',
                'timeout' => 2000,
            ]);
        }
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
