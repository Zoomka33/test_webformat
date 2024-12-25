<?php

declare(strict_types=1);

namespace App\V1\Service;

use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementReviewsTable;

Loader::includeModule('iblock');

class ReviewsService
{
    /**
     * Получение всех отзывов
     *
     * @param int $pageSize
     * @param int $pageNumber
     * @return array
     */
    public static function getAllReviews(int $pageSize = 10, int $pageNumber = 1): array
    {
        $totalRecords = self::getCountElementReviews();
        $offset = ($pageNumber - 1) * $pageSize;

        $records = ElementReviewsTable::getList([
            'order' => [
                'SORT' => 'ASC'
            ],
            'select' => [
                'ID',
                'NAME',
                'SORT',
                'FIRST_NAME.VALUE',
                'LAST_NAME.VALUE',
                'POSITION.VALUE',
                'COMPANY.VALUE',
                'REVIEW.VALUE'
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ],
            'limit' => $pageSize,
            'offset' => $offset
        ])->fetchAll();

        // Расчет данных для пагинации
        $totalPages = (int) ceil($totalRecords / $pageSize);
        $nextPage = ($pageNumber < $totalPages) ? $pageNumber + 1 : null;
        $prevPage = ($pageNumber > 1) ? $pageNumber - 1 : null;

        return [
            'reviews' => $records,
            'pagination' => [
                'totalRecords' => $totalRecords,
                'currentPage' => $pageNumber,
                'totalPages' => $totalPages,
                'nextPage' => $nextPage,
                'prevPage' => $prevPage,
            ]
        ];
    }

    /**
     * Получение одного отзыва по ID
     *
     * @param int $reviewId
     * @return array
     */
    public static function getById(int $reviewId): array
    {
        $review = ElementReviewsTable::getList([
            'order' => [
                'SORT' => 'ASC'
            ],
            'select' => [
                'ID',
                'NAME',
                'SORT',
                'FIRST_NAME.VALUE',
                'LAST_NAME.VALUE',
                'POSITION.VALUE',
                'COMPANY.VALUE',
                'REVIEW.VALUE'
            ],
            'filter' => [
                'ID' => $reviewId,
                '=ACTIVE' => 'Y'
            ]
        ])->fetchAll();

        return [
            'reviews' => $review
        ];
    }

    /**
     * Подсчет количества элементов
     *
     * @return int
     */
    private static function getCountElementReviews(): int
    {
         return ElementReviewsTable::getList([
            'filter' => [
                '=ACTIVE' => 'Y'
            ],
            'select' => ['ID'],
            'count_total' => true, // Учитываем общее количество
        ])->getSelectedRowsCount();
    }
}