<?php

namespace App\Http\Controllers;

use App\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RepositoryController extends Controller
{
    public function index()
    {
        return JsonResource::collection(
            \Auth::user()
                ->repositories()
                ->with(['builds' => fn($q) => $q->latest()->limit(1)])
                ->orderBy('active', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate()
        );
    }

    public function show(Repository $repository)
    {
        $this->authorize('view', $repository);

        return JsonResource::make($repository);
    }

    public function update(Repository $repository, Request $request)
    {
        $this->authorize('update', $repository);

        $data = $request->validate([
            'threshold' => ['required', 'integer', 'min:1'],
            'active'    => ['required', 'boolean'],
        ]);

        $repository->fill($data);

        if ($repository->active) {
            $repository->user_id ??= \Auth::id();
            $repository->token ??= hash('sha256', Str::random(80));
        }

        $repository->save();

        return JsonResource::make($repository);
    }

    public function destroy(Repository $repository)
    {
        $this->authorize('delete', $repository);

        $repository->update([
            'user_id'   => null,
            'threshold' => null,
            'token'     => null,
            'active'    => false,
        ]);

        return response()->noContent();
    }
}
