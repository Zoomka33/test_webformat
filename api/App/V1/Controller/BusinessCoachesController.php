<?php

namespace App\V1\Controller;

use App\V1\Formatter\BusinessCoachesFormatter;
use App\V1\Helper\ResponseHelper;
use App\V1\Service\BusinessCoachesService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class BusinessCoachesController extends AbstractController
{
    public function getCoaches(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $couches = BusinessCoachesService::getAllCoaches();
            $ourLocationsFormatted = BusinessCoachesFormatter::formatting($couches);
            $responseData = ResponseHelper::createSuccessResponse($ourLocationsFormatted);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }

}