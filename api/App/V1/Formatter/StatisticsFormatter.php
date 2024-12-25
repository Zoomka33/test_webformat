<?php

namespace App\V1\Formatter;

use App\V1\Interface\FormatterInterface;

class StatisticsFormatter implements FormatterInterface
{

    /**
     * @inheritDoc
     */
    public static function formatting(array $data): array
    {
        foreach ($data as $statistic) {
            $formattedOurLocations[] = [
                'title' => $statistic['IBLOCK_ELEMENTS_ELEMENT_STATISTICS_TITLE_VALUE'],
                'description' => $statistic['IBLOCK_ELEMENTS_ELEMENT_STATISTICS_DESCRIPTION_VALUE'],
            ];
        }

        return $formattedOurLocations ?? [];
    }
}
