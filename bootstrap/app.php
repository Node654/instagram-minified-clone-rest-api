<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            if ($e->getPrevious() instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return responseFailed(getModelNotFoundMessage($e->getPrevious()->getModel()), 404);
            }

            return responseFailed($e->getMessage(), 404);
        });
    })->create();
