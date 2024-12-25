<?php

declare(strict_types=1);

namespace App\V1\Service;

use App\V1\Helper\HttpHelper;
use App\V1\Helper\ImageHelper;
use Bitrix\Iblock\Elements\ElementFirstScreenTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

class MainPageService
{
    /**
     *
     * @return array
     */
    public static function getFirstScreen(): array
    {
        $data = ElementFirstScreenTable::getList([
            'order' => [
                'SORT' => 'ASC'
            ],
            'select' => [
                'NAME',
                'PREVIEW_TEXT',
                'BUTTON_TEXT.VALUE',
                'BUTTON_LINK.VALUE',
                'ICON',
                'IBLOCK_SECTION_ID',
                'SECTION'
            ],
            'filter' => [
                '=ACTIVE' => 'Y',
                'SECTION.CODE' => LANGUAGE_CODE,
            ],
            'runtime' => [
                'SECTION' => [
                    'data_type' => \Bitrix\Iblock\SectionTable::class,
                    'reference' => [
                        '=this.IBLOCK_SECTION_ID' => 'ref.ID',
                    ]
                ]
            ]

        ])->fetch();

        if ($data['IBLOCK_ELEMENTS_ELEMENT_FIRST_SCREEN_ICON_VALUE']) {
            $filePath = \CFile::GetPath($data['IBLOCK_ELEMENTS_ELEMENT_FIRST_SCREEN_ICON_VALUE']);
            $data['IMAGE_SRC'] = HttpHelper::getSiteProtocolAndDomain() . $filePath;
            $data['IMAGE_PLACEHOLDER_SRC'] = HttpHelper::getSiteProtocolAndDomain() . ImageHelper::getPlaceholderPathByWebpImagePath($filePath);
        }

        return $data;
    }
}
