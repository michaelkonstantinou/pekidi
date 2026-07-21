<?php

namespace App\Http\Controllers;


use App\Http\Requests\DeclarationDebtRequest;
use App\Models\Declaration;
use App\Models\DeclarationDebt;
use App\Models\User;
use App\Services\DeclarationOwnerPositionService;
use App\Types\OwnerType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserDeclarationDebtController
{
    public function index(Declaration $declaration, OwnerType $owner): JsonResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null || $user->id !== $declaration->user_id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json($declaration->debtsOfOwner($owner));
    }

    /**
     * Validates the user's input and creates a new DeclarationDebt for the authenticated user and the given
     * declaration object
     * Returns unauthorized if the user is not logged in or the declaration object does not belong to the authed user
     *
     * @param DeclarationDebtRequest $request
     * @param Declaration $declaration
     * @param OwnerType $owner
     * @return JsonResponse
     */
    public function store(DeclarationDebtRequest $request, Declaration $declaration, OwnerType $owner): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->create($request, $owner, DeclarationDebt::class);
    }

    /**
     * Validates the user's input and updated the given Declaration for the authenticated user
     * Returns unauthorized if the user is not logged in or the user does not own the given declaration
     *
     * @param DeclarationDebtRequest $request
     * @param Declaration $declaration
     * @param OwnerType $owner
     * @param DeclarationDebt $debt
     * @return JsonResponse
     */
    public function update(DeclarationDebtRequest $request, Declaration $declaration, OwnerType $owner, DeclarationDebt $debt): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->update($request, $owner, $debt);
    }

    public function destroy(Declaration $declaration, OwnerType $owner, DeclarationDebt $debt): JsonResponse
    {
        $service = new DeclarationOwnerPositionService($declaration);

        return $service->destroy($owner, $debt);
    }
}
