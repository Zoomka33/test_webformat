<?php

declare(strict_types=1);

namespace App\V1\Controller;

use Slim\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractController
{
    /**
     * Метод преобразует массив данных в json
     * @param ResponseInterface $response
     * @param array $data
     * @return ResponseInterface
     */
    protected function toJsonResponse(ResponseInterface $response, array $data): ResponseInterface
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    protected function getJsonFromRequest(Request $request): array
    {
        return json_decode($request->getBody()->getContents(), true);
    }
}
