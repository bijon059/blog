<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException as HTTPUnauthorizedException;
use Illuminate\Validation\ValidationException;
use library\libs\ApiResponse as ApiResponse;
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render( $request, Throwable $e ) {
        if ($request->wantsJson()) {   //add Accept: application/json in request
            return $this->handleApiException($request, $e);
        } else {
            return parent::render( $request, $e );
        }

    }
    private function handleApiException($request, Throwable $e)
    {
        Log::error($e->getMessage());
        $exceptionResponse=new ApiResponse();
        if($e instanceof AuthenticationException){
            $statusCode =  401;
        }elseif($e instanceof ValidationException){
            $statusCode =  403;
        }else {
            $statusCode = $this->isHttpException( $e ) ? $e->getStatusCode() : 500;
        }
        $isNoData=false;
        $exceptionResponse->setStatus(false,$statusCode);
        if ($e instanceof \Illuminate\Database\QueryException) {
            if (config('app.debug')) {
                addError($e->getMessage());
            }else{
                addError("E001:Internal server error");
            }
        }elseif ($e instanceof HTTPUnauthorizedException) {
            addError($e->getMessage());
            $isNoData=true;
        }
        else {
            addError( $e->getMessage() );
        }
        $response=[];
        if (config('app.debug')) {
            if($statusCode==500) {
                $response['class'] = get_class($e);
                $response['trace'] = $e->getTrace();
                $response['file']  = $e->getFile();
                $response['line']  = $e->getLine();
            }
        }
        if(!$isNoData) {
            $exceptionResponse->setData( $response );
        }
        return $exceptionResponse->display();
    }
}
