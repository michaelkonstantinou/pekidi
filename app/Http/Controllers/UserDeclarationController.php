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

    /**
     * Returns all available data for user's Declaration (including associated table data)
     * Requires the user to be authenticated and own the given declaration
     *
     * @param Declaration $declaration
     * @return JsonResponse
     */
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

    /**
     * Validates the user's input and creates a new Declaration for the authenticated user
     * Returns unauthorized if the user is not logged in
     *
     * @param DeclarationStore $request
     * @return JsonResponse
     */
    public function store(DeclarationStore $request): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $declaration = Declaration::createForUser($user, $request->name);

        return response()->json($declaration);
    }

    /**
     * Validates the user's input and updated the given Declaration for the authenticated user
     * Returns unauthorized if the user is not logged in or the user does not own the given declaration
     *
     * @param DeclarationStore $request
     * @return JsonResponse
     */
    public function update(DeclarationStore $request, Declaration $declaration): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $declaration->update($request->all());

        return response()->json($declaration);
    }
}
