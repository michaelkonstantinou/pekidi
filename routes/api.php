<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\UserDeclarationAdditionalAssetController;
use App\Http\Controllers\UserDeclarationBusinessController;
use App\Http\Controllers\UserDeclarationController;
use App\Http\Controllers\UserDeclarationDebtController;
use App\Http\Controllers\UserDeclarationDepositController;
use App\Http\Controllers\UserDeclarationFamilyMemberController;
use App\Http\Controllers\UserDeclarationInvestmentController;
use App\Http\Controllers\UserDeclarationOverviewController;
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
    Route::resource('/user/declarations/{declaration}/{owner}/businesses', UserDeclarationBusinessController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/{owner}/deposits', UserDeclarationDepositController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/{owner}/investments', UserDeclarationInvestmentController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/{owner}/additional-assets', UserDeclarationAdditionalAssetController::class)->except(['edit', 'create']);
    Route::resource('/user/declarations/{declaration}/{owner}/debts', UserDeclarationDebtController::class)->except(['edit', 'create']);
    Route::get('/user/declarations/{id}/overview', [UserDeclarationOverviewController::class, 'show']);
});



