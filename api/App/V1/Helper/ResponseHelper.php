<?php

declare(strict_types=1);

namespace App\V1\Helper;

class ResponseHelper
{
    /**
     * Форматтер ответа на успешный запрос
     * @param array $data
     * @return array
     */
    public static function createSuccessResponse(mixed $data): array
    {
        return [
            'response' => true,
            'data' => $data
        ];
    }

    /**
     * Форматтер ответа на неуспешный вопрос
     * @param string $message
     * @param array $options
     * @return array
     */
    public static function createErrorResponse(string $message, array $options = []): array
    {
        $response = [
            'response' => false,
            'message' => $message
        ];

        if (!empty($options)) {
            $response = array_merge($response, $options);
        }

        return $response;
    }
}
