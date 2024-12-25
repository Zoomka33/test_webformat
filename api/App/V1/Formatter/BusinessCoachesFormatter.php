<?php

namespace App\V1\Formatter;

use App\V1\Interface\FormatterInterface;

class BusinessCoachesFormatter implements FormatterInterface
{

    /**
     * @inheritDoc
     */
    public static function formatting(array $data): array
    {
        foreach ($data as $coach) {
            $formattedCoaches[] = [
                'id' => (int)$coach['ID'],
                'name' => $coach['NAME'],
                'sort' => (int)$coach['SORT'],
                'image' => $coach['IMAGE_SRC'],
                'placeholderSrc' => $coach['IMAGE_PLACEHOLDER_SRC'],
                'imageAlt' => $coach['IBLOCK_ELEMENTS_ELEMENT_BUSINESS_COACHES_IMAGE_DESCRIPTION'],
                'description' => $coach['IBLOCK_ELEMENTS_ELEMENT_BUSINESS_COACHES_COACH_DESCRIPTION_VALUE'],
                'jobTitle' => $coach['IBLOCK_ELEMENTS_ELEMENT_BUSINESS_COACHES_JOB_TITLE_VALUE'],
            ];
        }

        return $formattedCoaches ?? [];
    }
}