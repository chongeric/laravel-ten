<?php

namespace App\Exceptions;

use App\Enums\ResponseEnum;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use ApiResponse;
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
        $exception = "";
        // 如果是生产环境则返回500
        if (!config('app.debug')) {
            //单独记录系统的错误日志
            Log::channel('system')->error($exception);
            //直接返回错误
//            return $this->fail(ResponseEnum::SYSTEM_GLOBAL_ERROR);
        }
        // 请求类型错误异常抛出
        if ($exception instanceof MethodNotAllowedHttpException) {
            $this->throwBusinessException(ResponseEnum::CLIENT_METHOD_HTTP_TYPE_ERROR);
        }
        // 参数校验错误异常抛出
        if ($exception instanceof ValidationException) {
            $this->throwBusinessException(ResponseEnum::CLIENT_PARAMETER_ERROR);
        }
        // 路由不存在异常抛出
        if ($exception instanceof NotFoundHttpException) {
            $this->throwBusinessException(ResponseEnum::CLIENT_NOT_FOUND_ERROR);
        }

        // 自定义错误异常抛出
        if ($exception instanceof BusinessException) {
//            return response()->json([
//                'status'  => 'fail',
//                'code'    => $exception->getCode(),
//                'message' => $exception->getMessage(),
//                'data'    => null,
//                'error'  => null,
//            ]);
        }
//        return parent::render($request, $exception);
    }
}
