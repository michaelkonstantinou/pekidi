<?php

use App\Http\Middleware\LocaleHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::middleware(LocaleHandler::class)->group(function () {
    Route::post('/switch-language/{locale}', function($locale) {
        if (!in_array($locale, config('app.available_locales'))) {
            return response()->json([], JsonResponse::HTTP_BAD_REQUEST);
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return response()->json();
    });

    Route::get('/{any?}', function () {
        return view('index');
    })->where('any', '.*');
});

