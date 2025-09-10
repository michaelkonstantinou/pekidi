<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

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
}
