<?php

namespace App\Exceptions;

use Error;
use Exception;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return res(403, !empty($exception->getMessage()) ? $exception->getMessage() : 'Forbidden!');
        }

        if ($exception instanceof ModelNotFoundException) {
            return res(404, !empty($exception->getMessage()) ? $exception->getMessage() : 'Not Found!');
        }

        if ($exception instanceof Error) {
            return res(500, !empty($exception->getMessage()) ? $exception->getMessage() : 'An error has occurred!');
        }

        $statusCode = $exception->getStatusCode();
        if ($statusCode == 404) {
            return res(404, !empty($exception->getMessage()) ? $exception->getMessage() : 'Not Found!');
        }

        return res($statusCode, !empty($exception->getMessage()) ? $exception->getMessage() : 'An error has occurred!');
        return parent::render($request, $exception);
    }
}
