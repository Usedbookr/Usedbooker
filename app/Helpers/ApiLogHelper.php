<?php

namespace App\Helpers;

use App\Models\ApiLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiLogHelper
{
  
    public static function log(
        Request $request,
        string $module,
        string $service,
        float $startTime,
        string $status = 'success',
        int $httpStatus = 200,
        $requestPayload = null,
        $responsePayload = null,
        ?string $referenceType = null,
        $referenceId = null,
        ?string $errorMessage = null
    ): void {
        try {

 
            if ($request->attributes->get('_api_log_written', false)) {
                return;
            }

            $requestPayload = self::sanitizePayload($requestPayload);
            $responsePayload = self::sanitizePayload($responsePayload);

            if (is_array($requestPayload) || is_object($requestPayload)) {
                $requestPayload = json_encode(
                    $requestPayload,
                    JSON_UNESCAPED_UNICODE |
                    JSON_UNESCAPED_SLASHES |
                    JSON_PARTIAL_OUTPUT_ON_ERROR
                );
            }

            if (is_array($responsePayload) || is_object($responsePayload)) {
                $responsePayload = json_encode(
                    $responsePayload,
                    JSON_UNESCAPED_UNICODE |
                    JSON_UNESCAPED_SLASHES |
                    JSON_PARTIAL_OUTPUT_ON_ERROR
                );
            }

            $requestPayload = self::limitPayload($requestPayload);
            $responsePayload = self::limitPayload($responsePayload);
            $errorMessage = self::limitPayload($errorMessage, 10000);

   
            ApiLog::create([

                'module'            => $module,

                'service'           => $service,

                'request_type'      => $request->method(),

                'endpoint'          => $request->path(),

                'ip_address'        => $request->ip(),

                'request_url'       => $request->fullUrl(),

                'user_agent'        => self::limitPayload(
                    $request->userAgent(),
                    2000
                ),

                'reference_type'    => $referenceType,

                'reference_id'      => $referenceId,

                'request_payload'   => $requestPayload,

                'response_payload'  => $responsePayload,

                'http_status'       => $httpStatus,

                'execution_time_ms' => round(
                    (microtime(true) - $startTime) * 1000
                ),

                'status'            => $status,

                'error_message'     => $errorMessage,

            ]);


            $request->attributes->set('_api_log_written', true);

        } catch (Throwable $logException) {

     
            Log::error('API Log Insert Failed', [

                'module' => $module,

                'service' => $service,

                'logging_error' => $logException->getMessage(),

                'original_error' => $errorMessage,

                'url' => $request->fullUrl(),

                'ip' => $request->ip(),

            ]);
        }
    }

    private static function sanitizePayload($payload)
    {
        if (is_object($payload)) {
            $payload = json_decode(
                json_encode($payload),
                true
            );
        }

        if (!is_array($payload)) {
            return $payload;
        }

        $sensitiveKeys = [

            'password',
            'password_confirmation',
            'current_password',

            '_token',

            'token',
            'api_token',
            'access_token',
            'refresh_token',
            'bearer_token',

            'secret',
            'client_secret',

            'card_number',
            'card_no',
            'card_cvv',
            'cvv',

            'expiry',
            'expiry_date',

            'razorpay_signature',
            'razorpay_payment_id',

            'authorization',

        ];

        foreach ($payload as $key => $value) {

            if (in_array(
                strtolower((string) $key),
                $sensitiveKeys,
                true
            )) {

                $payload[$key] = '********';

                continue;
            }

            if (is_array($value) || is_object($value)) {
                $payload[$key] = self::sanitizePayload($value);
            }
        }

        return $payload;
    }

    private static function limitPayload(
        $value,
        int $maxLength = 50000
    ) {
        if ($value === null) {
            return null;
        }

        $value = (string) $value;

        if (mb_strlen($value) <= $maxLength) {
            return $value;
        }

        return mb_substr($value, 0, $maxLength)
            . '... [TRUNCATED]';
    }
}