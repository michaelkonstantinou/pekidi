<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationFamilyMemberRequest;
use App\Http\Requests\DeclarationRealEstateRequest;
use App\Http\Requests\DeclarationStore;
use App\Models\Declaration;
use App\Models\DeclarationFamilyMember;
use App\Models\DeclarationRealEstate;
use App\Models\User;
use App\Types\OwnerType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class UserDeclarationRealEstateController
{
    public function index(Declaration $declaration, OwnerType $owner): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json($declaration->realEstatesOfOwner($owner));
    }

    /**
     * Returns all available data for user's Declaration (including associated table data)
     * Requires the user to be authenticated and own the given declaration
     *
     * @param Declaration $declaration
     * @return JsonResponse
     */
    public function show(Declaration $declaration, OwnerType $owner): JsonResponse
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
     * Validates the user's input and creates a new Declaration Family Member for the authenticated user and the given
     * declaration object
     * Returns unauthorized if the user is not logged in or the declaration object does not belong to the authed user
     *
     * @param DeclarationRealEstateRequest $request
     * @return JsonResponse
     */
    public function store(DeclarationRealEstateRequest $request, Declaration $declaration, OwnerType $owner): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $record = DeclarationRealEstate::create($request->all() + ['declaration_id' => $declaration->id, 'owner' => $owner]);

        return response()->json($record);
    }

    /**
     * Validates the user's input and updated the given Declaration for the authenticated user
     * Returns unauthorized if the user is not logged in or the user does not own the given declaration
     *
     * @param DeclarationRealEstateRequest $request
     * @return JsonResponse
     */
    public function update(DeclarationRealEstateRequest $request, Declaration $declaration, OwnerType $owner, DeclarationRealEstate $realEstate): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id || $realEstate->declaration_id !== $declaration->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $realEstate->update($request->all());

        return response()->json($realEstate);
    }

    public function destroy(Declaration $declaration, OwnerType $owner, DeclarationRealEstate $realEstate): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id || $realEstate->declaration_id !== $declaration->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $isDeleted = $realEstate->delete() === true;

        return $isDeleted ? response()->json() : response()->json([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
