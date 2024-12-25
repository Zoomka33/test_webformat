<?php

namespace App\V1\Controller;

use App\V1\DTO\FeedbackForm\RequestHelpDTO;
use App\V1\Helper\ResponseHelper;
use App\V1\Service\Crm\FeedbackForm;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FeedbackFormController extends AbstractController
{
    public function helpRequest(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $json = $this->getJsonFromRequest($request);
            $dto = RequestHelpDTO::createFromArray($json);
            $result = FeedbackForm::sendRequestHelp($dto);
            $responseData = ResponseHelper::createSuccessResponse($result);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }

}
