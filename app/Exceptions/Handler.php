<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Asm89\Stack\CorsService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\OAuthServerException;
use League\OAuth2\Server\Exception\OAuthServerException as LeageException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    // private function isFrontend($request)
    // {
    //     return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    // }
}

