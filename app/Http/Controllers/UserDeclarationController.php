<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationStore;
use App\Models\Declaration;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDeclarationController
{
    public function index(): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json($user->declarations);
    }

    public function show(Declaration $declaration): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($declaration->user_id === $user->id) {
            return response()->json($declaration);
        }

        return response()->json([], JsonResponse::HTTP_FORBIDDEN);
    }

    public function store(DeclarationStore $request): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $declaration = Declaration::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'full_name' => $user->name,
            'born_at' => $user->born_at,
            'home_address' => $user->home_address,
            'national_id' => $user->national_id
        ]);

        return response()->json($declaration);
    }
}
