<?php

namespace App\Exceptions;

use App\Helpers\ApiLogHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
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
     * A list of the inputs that are never flashed
     * for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [

        'current_password',

        'password',

        'password_confirmation',

    ];

    protected function unauthenticated(
        $request,
        AuthenticationException $exception
    ) {

        if ($request->expectsJson()) {

            return response()->json([

                'status' => 401,

                'success' => false,

                'validationerror' => true,

                'message' => 'Unauthenticated',

            ], 401);
        }

        $guard = Arr::get(
            $exception->guards(),
            0
        );

        if ($guard === 'sanctum') {

            return response()->json([

                'status' => 401,

                'success' => false,

                'validationerror' => true,

                'message' => 'Unauthenticated',

            ], 401);
        }

        return parent::unauthenticated(
            $request,
            $exception
        );
    }

    public function register()
    {
        $this->reportable(function (Throwable $exception) {

            try {

                $request = request();

                if (!$request instanceof Request) {
                    return;
                }
                if ($request->attributes->get(
                    '_api_log_written',
                    false
                )) {
                    return;
                }
                if ($exception instanceof AuthenticationException) {
                    return;
                }
                $httpStatus = $this->getHttpStatusCode(
                    $exception
                );
                $requestPayload = $this->getSafeRequestPayload(
                    $request
                );

                $service = $request->route()
                    ? (
                        $request->route()->getName()
                        ?? 'Global Exception'
                    )
                    : 'Global Exception';

                $module = $request->is('api/*')
                    ? 'API'
                    : 'Application';

             
                ApiLogHelper::log(
                    $request,
                    $module,
                    $service,
                    microtime(true),
                    'failed',
                    $httpStatus,
                    $requestPayload,
                    null,
                    'exception',
                    get_class($exception),
                    $exception->getMessage()
                );

            } catch (Throwable $loggingException) {

        
                \Log::error(
                    'Global API Log Handler Failed',
                    [

                        'logging_error' =>
                            $loggingException->getMessage(),

                        'original_error' =>
                            $exception->getMessage(),

                        'url' =>
                            request()->fullUrl(),

                    ]
                );
            }
        });
    }


    private function getHttpStatusCode(
        Throwable $exception
    ): int {

        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        return 500;
    }


    private function getSafeRequestPayload(
        Request $request
    ): array {

        try {

            return [

                'query' => $request->query->all(),

                'request' => $request->except([

                    'password',

                    'password_confirmation',

                    'current_password',

                    '_token',

                    'token',

                    'api_token',

                    'access_token',

                    'refresh_token',

                    'card_number',

                    'card_no',

                    'cvv',

                    'card_cvv',

                    'expiry',

                    'expiry_date',

                    'razorpay_signature',

                    'razorpay_payment_id',

                ]),

            ];

        } catch (Throwable $exception) {

            return [];
        }
    }
}