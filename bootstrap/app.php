<?php

use App\Http\Middleware\SignatureMiddleware;
use App\Http\Middleware\TransformInput;
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

use App\Traits\ApiResponser;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        // using: function () {
        //     Route::middleware('api')
        //         ->group(base_path('routes/api.php'));

        //     Route::middleware('web')
        //         ->group(base_path('routes/web.php'));
        // }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'client.credentials' => CheckClientCredentials::class,
            'transform.input' => TransformInput::class,     
        ]);
        // $middleware->append(TransformInput::class);
        $middleware->group('web', [
            \App\Http\Middleware\SignatureMiddleware::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
        ]);
     
        $middleware->group('api', [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \App\Http\Middleware\SignatureMiddleware::class,
            // 'signature:X-Application-Name',
            //  'client.credentials',
            //  'transform.input' ,
            'throttle:50,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'errors' => $e->errors(),'code'=>'422'
            ], 422);
       
        });

        $exceptions->render(function (ValidationException $e, $request) {
            $errors = $e->validator->errors()->getMessages();
            
            if ($this->isFrontend($request)) {
                return $request->ajax() ? response()->json($errors, 422) : redirect()
                    ->back()
                    ->withInput($request->input())
                    ->withErrors($errors);
            }
            return response()->json($errors, 422);
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            $modelName = strtolower(class_basename($e->getModel()));
            return response()->json([
                'error' => "No {$modelName} found with the specified identifier.",'code'=>'404'
            ], 404);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'error' => 'Unauthenticated.','code'=>'401'
            ], 401);
            // if ($this->isFrontend($request)) {
            //     return redirect()->guest('login');
            // }
    
            // return $this->errorResponse('Unauthenticated.', 401);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),'code'=>'403'
            ], 403);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return response()->json([
                'error' => 'The specified method for the request is invalid.','code'=>'405'
            ], 405);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'error' => 'The specified URL cannot be found.','code'=>'404'
            ], 404);
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),'code'=> $e->getStatusCode()
            ], $e->getStatusCode());
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            // You might want to handle different SQL error codes here
            if ($e->errorInfo[1] == 1451) { // Foreign key constraint fails
                return response()->json([
                    'error' => 'Cannot remove this resource permanently. It is related to another resource.','code'=>'409'
                ], 409);
            }

            // Handle other SQL exceptions as needed
            return response()->json([
                'error' => 'Database query error.','code'=>'500'
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

     
        
        
    })->create();
    
    
    
