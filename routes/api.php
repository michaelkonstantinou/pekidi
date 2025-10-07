<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\UserDeclarationController;
use App\Http\Controllers\UserDeclarationFamilyMemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", [AuthUserController::class, "getUser"]);
    Route::post("/user/upload-profile-picture", [AuthUserController::class, "uploadProfilePicture"]);
    Route::resource('/user/declarations', UserDeclarationController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/family-members', UserDeclarationFamilyMemberController::class)->except(['edit', 'create']);
});



