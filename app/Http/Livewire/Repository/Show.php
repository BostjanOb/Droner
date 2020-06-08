<?php

namespace App\Http\Livewire\Repository;

use App\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public $repo;
    public $builds;

    public function queue()
    {
        $this->authorize('view', $this->repo);

        try {
            $this->repo->newBuild();
            $this->loadBuilds();

            $this->dispatchBrowserEvent('toast', [
                'title'   => 'New build successfully queued',
                'type'    => 'success',
                'timeout' => 2000,
            ]);
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

            $this->dispatchBrowserEvent('toast', [
                'title'   => 'Build send to Drone CI',
                'type'    => 'success',
                'timeout' => 2000,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toast', [
                'title'   => $e->getMessage(),
                'type'    => 'error',
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
        $this->authorize('view', $repo);
        $this->repo = $repo;

        $this->loadBuilds();
    }

    public function render()
    {
        return view('livewire.repository.show');
    }
}
