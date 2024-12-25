<?php

namespace App\V1\Controller;

use App\V1\Formatter\StatisticsFormatter;
use App\V1\Helper\ResponseHelper;
use App\V1\Service\StatisticsService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class StatisticsController extends AbstractController
{
    public function getStatisticBlock(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $statistics = StatisticsService::getStatisticsBlock();
            $statisticsFormatted = StatisticsFormatter::formatting($statistics);
            $responseData = ResponseHelper::createSuccessResponse($statisticsFormatted);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }

}
