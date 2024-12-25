<?php

namespace App\V1\Service;

use Bitrix\Iblock\Elements\ElementStatisticsTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

class StatisticsService
{

    public static function getStatisticsBlock(): array
    {
        return ElementStatisticsTable::getList([
            'order' => ['SORT' => 'ASC'],
            'select' => [
                'ID',
                'NAME',
                'SORT',
                'TITLE.VALUE',
                'DESCRIPTION.VALUE',
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ],
            'cache' => ['ttl' => 60 * 60 * 24 * 30],
        ])->fetchAll();
    }
}
