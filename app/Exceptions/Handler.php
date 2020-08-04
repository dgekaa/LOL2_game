<?php

namespace App\Exceptions;

use App\Models\Log;
use Exception;
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if(!method_exists($exception,'getRefId')) {
            $log = new Log;
            $log->type = 'error';
            $log->data = $exception->__toString();
            $log->save();

            $refId = $log->id;
        } else {
            $refId = $exception->getRefId();
        }

        if ($request->ajax() || $request->wantsJson()) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
                'refId' => $refId
            ];

            return response()->json($response, $exception->getCode() ? $exception->getCode() : 500);
        }

        return parent::render($request, $exception);
    }
}
