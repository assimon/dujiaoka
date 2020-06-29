<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PayPal\Exception\PayPalConnectionException;

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
        if ($exception instanceof AppException) {
            $tpl = config('app.shtemplate') . '/errors/error';
            return response()->view($tpl, ['title' => '(╥╯^╰╥)出错啦~', 'content' => $exception->getMessage(), 'url' => ""]);
        }
        if ($exception instanceof PayPalConnectionException) {
            $tpl = config('app.shtemplate') . '/errors/error';
            return response()->view($tpl, ['title' => '(╥╯^╰╥)出错啦~', 'content' => 'paypal回调参数异常', 'url' => ""]);
        }
        return parent::render($request, $exception);
    }
}
