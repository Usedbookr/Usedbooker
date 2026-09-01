<?php

namespace App\Http\Middleware;

use App\Helpers\ApiLogHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiLogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        try {

            $response = $next($request);

            $httpStatus = $response->getStatusCode();

            $status = $httpStatus >= 200 && $httpStatus < 400
                ? 'success'
                : 'failed';

            $requestPayload = $this->getRequestPayload($request);

            $responsePayload = $this->getResponsePayload($response);

            $errorMessage = null;

            if ($httpStatus >= 400) {

                $errorMessage = $this->getErrorMessage(
                    $responsePayload,
                    $httpStatus
                );
            }

            $service = $request->route()
                ? ($request->route()->getName() ?? $request->path())
                : $request->path();

            $module = $request->is('api/*')
                ? 'API'
                : 'Application';

            
            ApiLogHelper::log(
                $request,
                $module,
                $service,
                $startTime,
                $status,
                $httpStatus,
                $requestPayload,
                $responsePayload,
                null,
                null,
                $errorMessage
            );

            return $response;

        } catch (Throwable $exception) {


            throw $exception;
        }
    }


    private function getRequestPayload(Request $request): array
    {
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
    }


    private function getResponsePayload(Response $response)
    {
        try {

            $content = $response->getContent();

            if (empty($content)) {
                return null;
            }

            $decoded = json_decode($content, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }

            return $content;

        } catch (Throwable $exception) {

            return null;
        }
    }

    private function getErrorMessage(
        $responsePayload,
        int $httpStatus
    ): string {

        if (is_array($responsePayload)) {

            if (!empty($responsePayload['message'])) {
                return (string) $responsePayload['message'];
            }

            if (!empty($responsePayload['error'])) {

                if (is_string($responsePayload['error'])) {
                    return $responsePayload['error'];
                }

                return json_encode($responsePayload['error']);
            }

            if (!empty($responsePayload['errors'])) {
                return json_encode($responsePayload['errors']);
            }
        }

        return 'HTTP Error: ' . $httpStatus;
    }
}