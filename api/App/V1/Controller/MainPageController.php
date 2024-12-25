<?php

namespace App\V1\Controller;

use App\V1\Formatter\FirstScreenFormatter;
use App\V1\Helper\ResponseHelper;
use App\V1\Service\MainPageService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class MainPageController extends AbstractController
{
    public function getFirstScreen(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $data = MainPageService::getFirstScreen();
            $result = FirstScreenFormatter::formatting($data);
            $responseData = ResponseHelper::createSuccessResponse($result);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }
}
