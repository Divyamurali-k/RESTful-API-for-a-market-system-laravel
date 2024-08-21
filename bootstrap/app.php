<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
// use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        using: function () {
            Route::middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            $modelName = strtolower(class_basename($e->getModel()));
            return response()->json([
                'error' => "No {$modelName} found with the specified identifier."
            ], 404);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'error' => 'Unauthenticated.'
            ], 401);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return response()->json([
                'error' => 'The specified method for the request is invalid.'
            ], 405);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'error' => 'The specified URL cannot be found.'
            ], 404);
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getStatusCode());
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            // You might want to handle different SQL error codes here
            if ($e->errorInfo[1] == 1451) { // Foreign key constraint fails
                return response()->json([
                    'error' => 'Cannot remove this resource permanently. It is related to another resource.'
                ], 409);
            }

            // Handle other SQL exceptions as needed
            return response()->json([
                'error' => 'Database query error.'
            ], 500);
        });


        // Default handling for other exceptions
        $exceptions->render(function (Throwable $e, Request $request) {
            if (config('app.debug')) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }

            if (app()->environment('production') && app()->bound('sentry') && app('sentry')->shouldReport($e)) {
                app('sentry')->captureException($e);
            }

            return response()->json([
                'error' => 'Unexpected Exception. Try again later.'
            ], 500);
        });
    })
    ->create();
