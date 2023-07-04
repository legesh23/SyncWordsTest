<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, \Exception|Throwable $e)
    {
        if ($request->wantsJson()) {
            $response = [
                'errors' => 'Sorry, something went wrong.',
                'message' => $e->getMessage()
            ];

            if ($e instanceof ValidationException) {
                return parent::render($request, $e);
            }

            $status = $this->isHttpException($e) ? $e->getStatusCode() : $e->status;

            return response()->json($response, $status);
        }

        return parent::render($request, $e);
    }
}
