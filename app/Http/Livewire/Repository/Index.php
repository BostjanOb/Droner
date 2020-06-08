<?php

namespace App\Http\Livewire\Repository;

use App\Jobs\SyncRepositories;
use App\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    use AuthorizesRequests;

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
        $this->repositories = \Auth::user()
            ->repositories()
            ->with(['latestBuild'])
            ->orderBy('active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function activate($id)
    {
        $repo = Repository::findOrFail($id);

        $this->authorize('update', $repo);

        $repo->fill([
            'active'    => true,
            'threshold' => 5,
        ]);

        if ($repo->active) {
            $repo->user_id ??= \Auth::id();
            $repo->token ??= hash('sha256', Str::random(80));
        }

        $repo->save();

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
