<?php

declare(strict_types=1);

namespace B1\Helper;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

class IBlockHelper
{
    /**
     * Метод получения id информационного блока, по его символьному коду.
     *
     * @param string $iblockCode Символьный код инфоблока
     * @return int
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getIblockIdByCode(string $iblockCode): int
    {
        return (int)IblockTable::getList([
            'filter' => ['CODE' => $iblockCode],
            'select' => ['ID'],
            'cache' => ['ttl' => 60 * 60 * 24 * 30], //месяц
        ])->fetch()['ID'];
    }

    public static function getCodeById(int $id): string
    {
        return (string)IblockTable::getList([
            'select' => ['CODE'],
            'filter' => ['ID' => $id],
            'cache' => ['ttl' => 60 * 60 * 24 * 30], //месяц
            'limit' => 1,
        ])->fetch()['CODE'];
    }
}
