<?php

namespace App\V1\Handler\Event;

use B1\Helper\IBlockHelper;

class Statistics
{

    public static function generateName(&$arFields)
    {
        $id = IblockHelper::getIblockIdByCode('statistics');
        if ($arFields['IBLOCK_ID'] == $id) {
            $props = $arFields['PROPERTY_VALUES'];

            $titleArray = array_shift($props);
            $title = array_shift($titleArray)['VALUE'];

            $descriptionArray = array_shift($props);
            $description = array_shift($descriptionArray)['VALUE'];

            $name = "$title $description";
            $arFields['NAME'] = $name;
            $arFields['CODE'] = \CUtil::translit($name, 'ru');
        }

    }
}
