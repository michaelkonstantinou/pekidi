<?php

namespace App\Services;

use App\Models\AbstractDeclarationOwnerAsset;
use App\Models\Declaration;
use App\Models\User;
use App\Types\OwnerType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

readonly class DeclarationAssetService
{
    public function __construct(private Declaration $declaration)
    {
    }

    public function create(FormRequest $request, OwnerType $owner, string $modelClassToInstantiate): JsonResponse
    {
        /** @var ?User $user */
        $user = auth()->user();
        if ($user === null || $this->declaration->user_id !== $user->id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $record = $modelClassToInstantiate::create($request->all() + [
            'declaration_id' => $this->declaration->id,
            'owner' => $owner,
            ]);

        return response()->json($record);
    }

    public function update(FormRequest $request, OwnerType $owner, AbstractDeclarationOwnerAsset $asset): JsonResponse
    {
        if ($this->validateAccess($asset, $owner) === false) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $asset->update($request->all());

        return response()->json($asset);
    }

    public function destroy(OwnerType $owner, AbstractDeclarationOwnerAsset $asset): JsonResponse
    {
        if ($this->validateAccess($asset, $owner) === false) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $isDeleted = $asset->delete() === true;

        return $isDeleted ? response()->json() : response()->json([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Returns whether the user has access to this instance
     * The validation ensures that:
     * 1. A user is authenticated
     * 2. The user has access to the declaration form
     * 3. The asset instance belongs to the declaration used
     * 4. The asset's owner is the owner provided
     *
     * @param AbstractDeclarationOwnerAsset $asset
     * @param OwnerType $owner
     * @return bool
     */
    public function validateAccess(AbstractDeclarationOwnerAsset $asset, OwnerType $owner): bool
    {
        /** @var ?User $user */
        $user = auth()->user();
        return !($user === null ||
            $this->declaration->user_id !== $user->id ||
            $asset->declaration_id !== $this->declaration->id ||
            $asset->owner->value !== $owner->value);
    }
}
