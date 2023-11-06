<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('responseSuccess', function ($data, $message = 'OK') {
            return response()->json([
                'code' => ResponseAlias::HTTP_OK,
                'data' => $data,
                'message' => $message,
            ], ResponseAlias::HTTP_OK);
        });

        Response::macro('responseError', function ($message, $code = ResponseAlias::HTTP_BAD_REQUEST) {
            return response()->json([
                'code' => $code,
                'message' => $message,
            ], $code);
        });
    }
}
