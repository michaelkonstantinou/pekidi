<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", [\App\Http\Controllers\AuthUserController::class, "getUser"])->middleware("auth:sanctum");
