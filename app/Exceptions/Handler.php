<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
        'current_password',
        'password',
        'password_confirmation',
    ];
    
    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $e
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
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
        $request_uri = $request->getRequestUri();
        if (mb_strpos($request_uri, '/api/') === 0) {
            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                dd($exception->validator->errors());
            }
            
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->json([
                    'meta' => [
                        'status' => 404,
                        'msg' => 'Not Found!',
                    ]
                ], 404);
            }
            
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                return response()->json([
                    'meta' => [
                        'status' => $exception->getStatusCode(),
                        'msg' => $exception->getMessage(),
                    ]
                ], $exception->getStatusCode());
            }
    
            return response()->json([
                'meta' => [
                    'status' => $exception->getCode(),
                    'msg' => $exception->getMessage()
                ]
            ], 500);
        }
        
        return parent::render($request, $exception);
    }
}
