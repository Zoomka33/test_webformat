<?php

namespace App\V1\Controller;

use App\V1\Controller\AbstractController;
use App\V1\Formatter\OurLocationsFormatter;
use App\V1\Formatter\ReviewsFormatter;
use App\V1\Helper\ResponseHelper;
use App\V1\Service\OurLocationsService;
use App\V1\Service\ReviewsService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ReviewsController extends AbstractController
{
    /**
     * Все отзывы
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getAllReviews(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $getParams = $request->getQueryParams();

            if ($getParams['page'] <= 0) {
                throw new Exception('Значение параметра page должно быть больше 0', 400);
            }

            if ($getParams['limit'] <= 0) {
                throw new Exception('Значение параметра limit должно быть больше 0', 400);
            }

            $reviews = ReviewsService::getAllReviews($getParams['limit'], $getParams['page']);
            $reviewsFormatted = ReviewsFormatter::formatting($reviews);
            $responseData = ResponseHelper::createSuccessResponse($reviewsFormatted);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode());
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }

    /**
     * Отзыв по ID
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getById(Request $request, Response $response, array $args): ResponseInterface
    {
        try {
            $reviewId = $args['id'];
            $review = ReviewsService::getById($reviewId);
            $reviewsFormatted = ReviewsFormatter::formatting($review);
            $responseData = ResponseHelper::createSuccessResponse($reviewsFormatted);
        } catch (\Throwable $exception) {
            $response = $response->withStatus($exception->getCode() ?? 500);
            $responseData = ResponseHelper::createErrorResponse($exception->getMessage());
        }

        return $this->toJsonResponse($response, $responseData);
    }
}