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
        if ($user === null) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json($declaration->vehiclesOfOwner($owner));
    }

    /**
     * Validates the user's input and creates a new Declaration Family Member for the authenticated user and the given
     * declaration object
     * Returns unauthorized if the user is not logged in or the declaration object does not belong to the authed user
     *
     * @param DeclarationVehicleRequest $request
     * @return JsonResponse
     */
    public function store(DeclarationVehicleRequest $request, Declaration $declaration, OwnerType $owner): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $record = DeclarationVehicle::create($request->all() + ['declaration_id' => $declaration->id, 'owner' => $owner]);

        return response()->json($record);
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
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id || $vehicle->declaration_id !== $declaration->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $vehicle->update($request->all());

        return response()->json($vehicle);
    }

    public function destroy(Declaration $declaration, OwnerType $owner, DeclarationVehicle $vehicle): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $declaration->user_id !== $user->id || $vehicle->declaration_id !== $declaration->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $isDeleted = $vehicle->delete() === true;

        return $isDeleted ? response()->json() : response()->json([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
