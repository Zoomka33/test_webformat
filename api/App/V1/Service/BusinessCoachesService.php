<?php

declare(strict_types=1);

namespace App\V1\Service;

use App\V1\Helper\HttpHelper;
use App\V1\Helper\ImageHelper;
use Bitrix\Iblock\Elements\ElementBusinessCoachesTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

class BusinessCoachesService
{
    /**
     * Получение всех бизнес-тренеров для слайдера
     *
     * @return array
     */
    public static function getAllCoaches(): array
    {
        $ourCoaches = ElementBusinessCoachesTable::getList([
            'order' => [
                'SORT' => 'ASC'
            ],
            'select' => [
                'ID',
                'NAME',
                'SORT',
                'IMAGE',
                'COACH_DESCRIPTION.VALUE',
                'JOB_TITLE.VALUE',
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ]
        ])->fetchAll();

        foreach ($ourCoaches as &$coach) {
            $filePath = \CFile::GetPath($coach['IBLOCK_ELEMENTS_ELEMENT_BUSINESS_COACHES_IMAGE_VALUE']);
            $coach['IMAGE_SRC'] = HttpHelper::getSiteProtocolAndDomain() . $filePath;
            $coach['IMAGE_PLACEHOLDER_SRC'] = HttpHelper::getSiteProtocolAndDomain() . ImageHelper::getPlaceholderPathByWebpImagePath($filePath);
        }
        return $ourCoaches;
    }
}