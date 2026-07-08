<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\UserDeclarationController;
use App\Http\Controllers\UserDeclarationFamilyMemberController;
use App\Http\Controllers\UserDeclarationRealEstateController;
use App\Http\Controllers\UserDeclarationVehicleController;
use App\Http\Middleware\LocaleHandler;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth:sanctum", LocaleHandler::class])->group(function () {
    Route::get("/user", [AuthUserController::class, "getUser"]);
    Route::post("/user/upload-profile-picture", [AuthUserController::class, "uploadProfilePicture"]);
    Route::resource('/user/declarations', UserDeclarationController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/family-members', UserDeclarationFamilyMemberController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/{owner}/real-estates', UserDeclarationRealEstateController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/{owner}/vehicles', UserDeclarationVehicleController::class)->except(['edit', 'create']);
});



