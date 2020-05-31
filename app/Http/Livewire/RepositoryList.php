<?php

namespace App\Http\Livewire;

use App\Jobs\SyncRepositories;
use App\Repository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RepositoryList extends Component
{
    public $repositories;

    public function sync()
    {
        SyncRepositories::dispatch(Auth::user());

        $this->getRepositories();
    }

    private function getRepositories()
    {
        $this->repositories = Repository::with('latestBuild')->get();
    }

    public function mount()
    {
        $this->getRepositories();
    }

    public function render()
    {
        return view('livewire.repository-list');
    }
}
