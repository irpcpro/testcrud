<?php

namespace App\Exceptions;

use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

    protected function prepareJsonResponse($request, Throwable $e)
    {
        if(!isset($this->convertExceptionToArray($e)['message']) || $this->convertExceptionToArray($e)['message'] == ""){
            if($e instanceof AccessDeniedHttpException){
                $message = "user can't authorize to this request.";
            }else{
                $message = "something went wrong.";
            }
        }else{
            $message = $this->convertExceptionToArray($e)['message'];
        }
        $error_code = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        $response = new ResponseFactoryController(false, $message, [], $error_code);
        return response()->json($response->get(), $error_code);
    }

}
