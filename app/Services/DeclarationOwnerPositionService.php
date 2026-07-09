<?php

namespace App\Services;

use App\Models\AbstractDeclarationOwnerPosition;
use App\Models\Declaration;
use App\Models\User;
use App\Types\OwnerType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

readonly class DeclarationOwnerPositionService
{
    public function __construct(private Declaration $declaration)
    {
    }

    /**
     * Creates a new instance of the model class provider and the FormRequest item
     * It appends the declaration's id and the given owner to the record instantiated
     *
     * @param FormRequest $request
     * @param OwnerType $owner
     * @param string $modelClassToInstantiate
     * @return JsonResponse
     */
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

    /**
     * Validates that the user can access this record and updates all values of the request item provided
     *
     * @param FormRequest $request
     * @param OwnerType $owner
     * @param AbstractDeclarationOwnerPosition $record
     * @return JsonResponse
     */
    public function update(FormRequest $request, OwnerType $owner, AbstractDeclarationOwnerPosition $record): JsonResponse
    {
        if ($this->validateAccess($record, $owner) === false) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $record->update($request->all());

        return response()->json($record);
    }

    /**
     * Deletes the given item (after validation of access)
     * @param OwnerType $owner
     * @param AbstractDeclarationOwnerPosition $record
     * @return JsonResponse
     */
    public function destroy(OwnerType $owner, AbstractDeclarationOwnerPosition $record): JsonResponse
    {
        if ($this->validateAccess($record, $owner) === false) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $isDeleted = $record->delete() === true;

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
     * @param AbstractDeclarationOwnerPosition $record
     * @param OwnerType $owner
     * @return bool
     */
    public function validateAccess(AbstractDeclarationOwnerPosition $record, OwnerType $owner): bool
    {
        /** @var ?User $user */
        $user = auth()->user();
        return !($user === null ||
            $this->declaration->user_id !== $user->id ||
            $record->declaration_id !== $this->declaration->id ||
            $record->owner->value !== $owner->value);
    }
}
