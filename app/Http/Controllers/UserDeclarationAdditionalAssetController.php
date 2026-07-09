<?php

namespace App\Http\Controllers;


use App\Http\Requests\DeclarationAdditionalAssetRequest;
use App\Models\Declaration;
use App\Models\DeclarationAdditionalAsset;
use App\Models\User;
use App\Services\DeclarationOwnerPositionService;
use App\Types\OwnerType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserDeclarationAdditionalAssetController
{
    public function index(Declaration $declaration, OwnerType $owner): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null || $user->id !== $declaration->user_id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json($declaration->additionalAssetsOfOwner($owner));
    }

    /**
     * Validates the user's input and creates a new DeclarationAdditionalAsset for the authenticated user and the given
     * declaration object
     * Returns unauthorized if the user is not logged in or the declaration object does not belong to the authed user
     *
     * @param DeclarationAdditionalAssetRequest $request
     * @param Declaration $declaration
     * @param OwnerType $owner
     * @return JsonResponse
     */
    public function store(DeclarationAdditionalAssetRequest $request, Declaration $declaration, OwnerType $owner): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->create($request, $owner, DeclarationAdditionalAsset::class);
    }

    /**
     * Validates the user's input and updated the given Declaration for the authenticated user
     * Returns unauthorized if the user is not logged in or the user does not own the given declaration
     *
     * @param DeclarationAdditionalAssetRequest $request
     * @param Declaration $declaration
     * @param OwnerType $owner
     * @param DeclarationAdditionalAsset $asset
     * @return JsonResponse
     */
    public function update(DeclarationAdditionalAssetRequest $request, Declaration $declaration, OwnerType $owner, DeclarationAdditionalAsset $asset): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->update($request, $owner, $asset);
    }

    public function destroy(Declaration $declaration, OwnerType $owner, DeclarationAdditionalAsset $asset): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->destroy($owner, $asset);
    }
}
