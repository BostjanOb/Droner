<?php

namespace App\Http\Controllers;

use App\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        return JsonResource::make(
            Repository::where('token', $request->bearerToken())
                ->with(['builds' => fn($q) => $q->latest()->limit(5)])
                ->firstOrFail()
        );
    }

    public function store(Request $request)
    {
        return JsonResource::make(
            Repository::where('token', $request->bearerToken())
                ->firstOrFail()
                ->newBuild()
        );
    }
}
