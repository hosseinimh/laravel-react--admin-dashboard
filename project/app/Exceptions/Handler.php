<?php

namespace App\Exceptions;

use App\Constants\ErrorCodes;
use App\Constants\Theme;
use App\Jobs\HandleErrorJob;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json(['_result' => '0', '_error' => $exception->getResponse()->getContent(), '_errorCode' => ErrorCodes::FORM_INPUT_INVALID], 200);
        }

        if ($exception instanceof AuthenticationException || $exception instanceof TokenMismatchException) {
            if ($request->expectsJson()) {
                return response()->json(['_result' => '0', '_error' => __('user.not_authorized'), '_errorCode' => ErrorCodes::USER_NOT_AUTHORIZED], 200);
            }

            return redirect(Theme::LOGIN_URL);
        }

        HandleErrorJob::dispatch($exception->__toString());

        if ($request->expectsJson()) {
            return response()->json(['_result' => '0', '_error' => __('general.server_error'), '_errorCode' => ErrorCodes::SERVER_ERROR], 200);
        }

        return redirect(Theme::BASE_URL);
    }
}
