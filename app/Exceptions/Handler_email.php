<?php

namespace App\Exceptions;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
            //Get error message
            $error_message = $e->getMessage();

            //Get File
            $error_file = $e->getFile();

            //Get line number
            $error_line = $e->getLine();

            //get method, GET or POST
            $method = request()->method();

            //get full url including query string
            $full_url = request()->fullUrl();

            //get route name
            $route = "";

            
        });
    }
}
