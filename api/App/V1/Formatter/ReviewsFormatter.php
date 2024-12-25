<?php

namespace App\V1\Formatter;

use App\V1\Interface\FormatterInterface;

class ReviewsFormatter implements FormatterInterface
{

    public static function formatting(array $data): array
    {
        $formattedReviews['reviews'] = [];

        foreach ($data['reviews'] as $review) {
            $formattedReviews['reviews'][] = [
                'id' => (int)$review['ID'],
                'name' => $review['NAME'],
                'sort' => (int)$review['SORT'],
                'firstName' => $review['IBLOCK_ELEMENTS_ELEMENT_REVIEWS_FIRST_NAME_VALUE'],
                'lastName' => $review['IBLOCK_ELEMENTS_ELEMENT_REVIEWS_LAST_NAME_VALUE'],
                'position' => $review['IBLOCK_ELEMENTS_ELEMENT_REVIEWS_POSITION_VALUE'],
                'company' => $review['IBLOCK_ELEMENTS_ELEMENT_REVIEWS_COMPANY_VALUE'],
                'review' => $review['IBLOCK_ELEMENTS_ELEMENT_REVIEWS_REVIEW_VALUE']
            ];
        }

        $formattedReviews['pagination'] = $data['pagination'];

        return $formattedReviews ?? [];
    }
}