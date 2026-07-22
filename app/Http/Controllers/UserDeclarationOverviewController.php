<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeclarationOverviewResource;
use App\Models\Declaration;
use App\Services\DeclarationTotalService;
use Illuminate\Http\JsonResponse;
use function Pest\Laravel\json;

class UserDeclarationOverviewController
{
    public function show(int $id): JsonResponse
    {
        $service = new DeclarationTotalService($id);

        return (new DeclarationOverviewResource($service->declarationUnderReview()))->response();
    }
}
