<?php

namespace App\V1\Controller;

use App\V1\Formatter\LegalInformationFormatter;
use App\V1\Helper\ResponseHelper;
use App\V1\Service\LegalInformationService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LegalInformationController extends AbstractController
{
    public function getList(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $sections = LegalInformationService::getListDocuments();
            $ourLocationsFormatted = LegalInformationFormatter::formatting($sections);
            $responseData = ResponseHelper::createSuccessResponse($ourLocationsFormatted);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }

    public function getById(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $document = LegalInformationService::getById($id);
            if ($document) {
                $document = LegalInformationFormatter::formattingOnce($document);
                $responseData = ResponseHelper::createSuccessResponse($document);
            } else {
                $response = $response->withStatus(404);
                $responseData = ResponseHelper::createErrorResponse('Not found');
            }
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }

}
