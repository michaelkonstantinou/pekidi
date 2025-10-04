<?php

use App\Http\Controllers\AuthUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", [AuthUserController::class, "getUser"]);
});

Route::post("/user/upload-profile-picture", [AuthUserController::class, "uploadProfilePicture"]);

