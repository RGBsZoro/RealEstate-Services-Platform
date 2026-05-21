<?php

use App\Http\Middleware\ApiLocalization;
use App\Http\Middleware\EnsureHasApprovedBusinessAccount;
use App\Http\Middleware\WebLocalization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;


return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    channels: __DIR__ . '/../routes/channels.php',
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
      'role' => RoleMiddleware::class,
      'permission' => PermissionMiddleware::class,
      'role_or_permission' => RoleOrPermissionMiddleware::class,
      'hasApprovedBusinessAccount' => EnsureHasApprovedBusinessAccount::class,
    ]);

    $middleware->web([
      'WebLocalization' => WebLocalization::class,
    ]);

    $middleware->api([
      'ApiLocalization' => ApiLocalization::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (\Throwable $e, Request $request) {

      if ($request->is('api/*') || $request->expectsJson()) {

        if ($e instanceof ValidationException) {
          return errorResponse($e->getMessage(), $e->errors(), 422);
        }

        if ($e instanceof AuthenticationException) {
          return errorResponse(__('Unauthenticated.'), [], 401);
        }

        if ($e instanceof AuthorizationException || $e instanceof UnauthorizedException) {
          return errorResponse(__('You do not have the required authorization.'), [], 403);
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
          return errorResponse(__('Resource not found.'), [], 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
          return errorResponse(__('HTTP Method not allowed for this route.'), [], 405);
        }

        if ($e instanceof ThrottleRequestsException) {
          return errorResponse(__('Too many requests, please slow down.'), [], 429);
        }

        if ($e instanceof HttpException) {
          return errorResponse($e->getMessage() ?: __('Something went wrong.'), [], $e->getStatusCode());
        }

        $message = config('app.debug') ? $e->getMessage() : __('Internal Server Error. Please try again later.');

        return errorResponse($message, [], 500);
      }
    });
  })->create();
