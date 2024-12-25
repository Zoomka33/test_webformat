<?php

namespace App\V1\Controller;

use App\V1\Controller\AbstractController;
use App\V1\Formatter\OurLocationsFormatter;
use App\V1\Helper\ResponseHelper;
use App\V1\Service\OurLocationsService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class OurLocationsController extends AbstractController
{
    /**
     * Все локации
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getOurLocations(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $ourLocations = OurLocationsService::getAllOurLocations();
            $ourLocationsFormatted = OurLocationsFormatter::formatting($ourLocations);
            $responseData = ResponseHelper::createSuccessResponse($ourLocationsFormatted);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }

}