<?php

namespace App\Http\Livewire\Repository;

use App\Jobs\SyncRepositories;
use App\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public $repositories;

    public function sync()
    {
        SyncRepositories::dispatch(Auth::user());
        $this->getRepositories();

        $this->dispatchBrowserEvent('toast', [
            'title'   => 'Sync completed',
            'type'    => 'success',
            'timeout' => 2000,
        ]);
    }

    private function getRepositories()
    {
        $this->repositories = Repository::with('latestBuild')->get();
    }

    public function activate($id)
    {
        $repo = Repository::findOrFail($id);

        $repo->update([
            'active'    => true,
            'threshold' => 5,
            'user_id'   => \Auth::id(),
            'token'     => hash('sha256', Str::random(80)),
        ]);

        return redirect()->route('repo.edit', ['repo' => $repo]);
    }

    public function mount()
    {
        $this->getRepositories();
    }

    public function render()
    {
        return view('livewire.repository.index');
    }
}
