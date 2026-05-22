<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Throwable $e, $request) {

            if ($request->is('api/*')) {

                // Tangani ValidationException (dari FormRequest)
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'status'  => 'error',
                        'data'    => $e->errors(),
                        'message' => 'Validasi gagal.',
                    ], 422);
                }

                // Tangani semua exception lainnya
                return response()->json([
                    'status'  => 'error',
                    'data'    => null,
                    'message' => $e->getMessage(),
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
            }
        });

    })->create();