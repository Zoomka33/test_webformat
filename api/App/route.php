<?php

declare(strict_types=1);

use App\V1\Controller\FeedbackFormController;
use App\V1\Controller\OurLocationsController;
use Slim\Routing\RouteCollectorProxy;
use App\V1\Controller\MainPageController;
use App\V1\Controller\BusinessCoachesController;
use App\V1\Controller\StatisticsController;
use App\V1\Controller\ReviewsController;
use App\V1\Controller\LegalInformationController;

/** @var $app */

$app->group('/v1', function (RouteCollectorProxy $group) {
    $group->group('/feedback-form', function (RouteCollectorProxy $group) {
        $group->post('/help-request/', FeedbackFormController::class . ':helpRequest');
    });
    $group->get('/our-locations/', OurLocationsController::class . ':getOurLocations');
    $group->get('/first-screen/', MainPageController::class . ':getFirstScreen');
    $group->get('/business-coaches/', BusinessCoachesController::class . ':getCoaches');
    $group->get('/statistics/', StatisticsController::class . ':getStatisticBlock');
    $group->get('/reviews/', ReviewsController::class . ':getAllReviews');
    $group->get('/reviews/{id}/', ReviewsController::class . ':getById');
    $group->group('/pages', function (RouteCollectorProxy $group) {
        $group->group('/legal-information', function (RouteCollectorProxy $group) {
            $group->get('/list', LegalInformationController::class . ':getList');
            $group->get('/get', LegalInformationController::class . ':getById');
        });
    });
});
