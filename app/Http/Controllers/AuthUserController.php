<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class AuthUserController
{
    public function getUser(): JsonResponse
    {
        $authUser = auth()->user();
        if ($authUser === null) {
            return response()->json(status: 422);
        }

        return response()->json($authUser);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadProfilePicture(Request $request): JsonResponse
    {
        /** @var ?User $authUser */
        $authUser = auth()->user();
        if ($authUser === null) {
            return response()->json(status: 422);
        }

        // Save image
        $authUser->clearMediaCollection('avatar');
        $authUser->addMediaFromRequest('image')->toMediaCollection('avatar');

        return response()->json(status: 200);
    }
}
