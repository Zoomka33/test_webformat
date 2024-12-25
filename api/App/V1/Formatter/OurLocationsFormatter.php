<?php

namespace App\V1\Formatter;

use App\V1\Interface\FormatterInterface;

class OurLocationsFormatter implements FormatterInterface
{

    /**
     * @inheritDoc
     */
    public static function formatting(array $data): array
    {
        foreach ($data as $ourLocation) {
            $formattedOurLocations[] = [
                'id' => (int)$ourLocation['ID'],
                'name' => $ourLocation['NAME'],
                'sort' => (int)$ourLocation['SORT'],
                'image' => $ourLocation['IMAGES'],
                'description' => $ourLocation['IBLOCK_ELEMENTS_ELEMENT_OUR_LOCATIONS_LOCATION_DESCRIPTION_VALUE'],
            ];
        }

        return $formattedOurLocations ?? [];
    }
}