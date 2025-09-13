<?php

namespace Maksb\Admin\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApiResponse
{
    /**
     * Success response template
     *
     * @param array $data
     * @return JsonResponse
     */
    public static function success(array $data = []): JsonResponse
    {
        $data['success'] = true;

        return response()->json($data, 200);
    }

    /**
     * Fail response template
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public static function fail(string $message, array $data = [], int $code = 200): JsonResponse
    {
        $data['success'] = false;
        $data['message'] = $message;

        return response()->json($data, $code);
    }

    /**
     * Response template when user failed auth
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function authFail(string $message = ''): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => false,
        ], 401);
    }

    /**
     * Response download file
     *
     * @param string $filePath
     * @return BinaryFileResponse
     */
    public static function download(string $filePath): BinaryFileResponse
    {
        return response()->download($filePath);
    }
}
