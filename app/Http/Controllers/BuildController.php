<?php

namespace App\Http\Controllers;

use App\Build;
use App\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BuildController extends Controller
{
    public function index(Repository $repository)
    {
        $this->authorize('view', $repository);

        return JsonResource::collection(
            $repository->builds()->latest()->paginate()
        );
    }

    public function store(Repository $repository)
    {
        $this->authorize('view', $repository);

        return JsonResource::make($repository->newBuild());
    }
}
