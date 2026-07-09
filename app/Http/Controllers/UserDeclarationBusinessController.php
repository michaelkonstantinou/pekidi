<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationBusinessRequest;
use App\Models\Declaration;
use App\Models\DeclarationBusiness;
use App\Models\User;
use App\Services\DeclarationOwnerPositionService;
use App\Types\OwnerType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserDeclarationBusinessController
{
    public function index(Declaration $declaration, OwnerType $owner): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null || $user->id !== $declaration->user_id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json($declaration->businessesOfOwner($owner));
    }

    /**
     * Validates the user's input and creates a new DeclarationVehicle for the authenticated user and the given
     * declaration object
     * Returns unauthorized if the user is not logged in or the declaration object does not belong to the authed user
     *
     * @param DeclarationBusinessRequest $request
     * @return JsonResponse
     */
    public function store(DeclarationBusinessRequest $request, Declaration $declaration, OwnerType $owner): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->create($request, $owner, DeclarationBusiness::class);
    }

    /**
     * Validates the user's input and updated the given Declaration for the authenticated user
     * Returns unauthorized if the user is not logged in or the user does not own the given declaration
     *
     * @param DeclarationBusinessRequest $request
     * @return JsonResponse
     */
    public function update(DeclarationBusinessRequest $request, Declaration $declaration, OwnerType $owner, DeclarationBusiness $business): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->update($request, $owner, $business);
    }

    public function destroy(Declaration $declaration, OwnerType $owner, DeclarationBusiness $business): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->destroy($owner, $business);
    }
}
