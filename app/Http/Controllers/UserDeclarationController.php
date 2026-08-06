<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationStore;
use App\Http\Resources\DeclarationResource;
use App\Models\Declaration;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserDeclarationController
{
    public function index(): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json(DeclarationResource::collection($user->declarations()->orderByDesc('id')->get()));
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
            return response()->json(new DeclarationResource($declaration));
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

    public function destroy(Declaration $declaration): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $response = $declaration->delete();
            return response()->json($response);

        } catch (Exception $e) {
        }

        return response()->json([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Fetch and return the latest user declaration for a user
     *
     * @return JsonResponse
     */
    public function last(): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $lastUserDeclaration = Declaration::lastForUser($user);

        return response()->json(new DeclarationResource($lastUserDeclaration));
    }

    /**
     * Deep copies the provided Declaration and deep copies all its relation instances as well
     * Returns the newly created (copied) Declaration
     *
     * @param Declaration $declaration
     * @return JsonResponse
     */
    public function copy(Declaration $declaration): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $newDeclaration = $declaration->copy();
            return response()->json(new DeclarationResource($newDeclaration));
        } catch (Throwable $e) {
            Log::error("Failed to copy declaration\n".$e);
        }

        return response()->json([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
