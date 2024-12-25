<?php

declare(strict_types=1);

namespace App\V1\Service;

use App\V1\Helper\HttpHelper;
use App\V1\Helper\ImageHelper;
use Bitrix\Iblock\Elements\ElementOurLocationsTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

class OurLocationsService
{
    /**
     * Получение всех локаций
     *
     * @return array
     */
    public static function getAllOurLocations(): array
    {
        $ourLocations = ElementOurLocationsTable::getList([
            'order' => [
                'SORT' => 'ASC'
            ],
            'select' => [
                'ID',
                'NAME',
                'SORT',
                new Entity\ExpressionField(
                    'IMAGES',
                    'GROUP_CONCAT(%s)',
                    'IMAGE.VALUE'
                ),
                new Entity\ExpressionField(
                    'IMAGE_DESCRIPTIONS',
                    'GROUP_CONCAT(%s)',
                    'IMAGE.DESCRIPTION'
                ),
                'LOCATION_DESCRIPTION.VALUE',
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ]
        ])->fetchAll();

        // Преобразование идентификаторов файлов и описаний в массивы
        foreach ($ourLocations as &$location) {
            if (!empty($location['IMAGES'])) {
                $imageIds = explode(',', $location['IMAGES']);
                $imageDescriptions = explode(',', $location['IMAGE_DESCRIPTIONS']);

                $location['IMAGES'] = array_map(function ($fileId, $description) {
                    $filePath = \CFile::GetPath($fileId);
                    return [
                        'src' => HttpHelper::getSiteProtocolAndDomain() . $filePath,
                        'placeholderSrc' => HttpHelper::getSiteProtocolAndDomain() . ImageHelper::getPlaceholderPathByWebpImagePath($filePath),
                        'description' => $description
                    ];
                }, $imageIds, $imageDescriptions);
            }
        }

        return $ourLocations;
    }
}