<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationFamilyMemberRequest;
use App\Http\Requests\DeclarationRealEstateRequest;
use App\Http\Requests\DeclarationStore;
use App\Http\Requests\DeclarationVehicleRequest;
use App\Models\Declaration;
use App\Models\DeclarationFamilyMember;
use App\Models\DeclarationRealEstate;
use App\Models\DeclarationVehicle;
use App\Models\User;
use App\Services\DeclarationOwnerPositionService;
use App\Types\OwnerType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class UserDeclarationVehicleController
{
    public function index(Declaration $declaration, OwnerType $owner): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null || $user->id !== $declaration->user_id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json($declaration->vehiclesOfOwner($owner));
    }

    /**
     * Validates the user's input and creates a new DeclarationVehicle for the authenticated user and the given
     * declaration object
     * Returns unauthorized if the user is not logged in or the declaration object does not belong to the authed user
     *
     * @param DeclarationVehicleRequest $request
     * @return JsonResponse
     */
    public function store(DeclarationVehicleRequest $request, Declaration $declaration, OwnerType $owner): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->create($request, $owner, DeclarationVehicle::class);
    }

    /**
     * Validates the user's input and updated the given Declaration for the authenticated user
     * Returns unauthorized if the user is not logged in or the user does not own the given declaration
     *
     * @param DeclarationVehicleRequest $request
     * @return JsonResponse
     */
    public function update(DeclarationVehicleRequest $request, Declaration $declaration, OwnerType $owner, DeclarationVehicle $vehicle): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->update($request, $owner, $vehicle);
    }

    public function destroy(Declaration $declaration, OwnerType $owner, DeclarationVehicle $vehicle): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->destroy($owner, $vehicle);
    }
}
