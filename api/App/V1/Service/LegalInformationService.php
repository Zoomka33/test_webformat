<?php

declare(strict_types=1);

namespace App\V1\Service;

use App\V1\Helper\HttpHelper;
use B1\Helper\IBlockHelper;
use Bitrix\Iblock\Elements\ElementLegalInformationTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

class LegalInformationService
{
    /**
     *
     * @return array
     */
    public static function getListDocuments(): array
    {
        [$ids,$sections] = static::getIncludeSections();

        $documents = ElementLegalInformationTable::getList([
            'order' => [
                'SORT' => 'ASC'
            ],
            'select' => [
                'ID',
                'NAME',
                'SORT',
                'IBLOCK_SECTION_ID',
            ],
            'filter' => [
                '=ACTIVE' => 'Y',
                'IBLOCK_ID' => IBlockHelper::getIblockIdByCode('legal_information'),
                'IBLOCK_SECTION_ID' => $ids,
            ],
        ])->fetchAll();

        foreach ($documents as $document) {
            $sections[$document['IBLOCK_SECTION_ID']]['ELEMENTS'][] = $document;
        }

        return $sections;
    }

    public static function getById(int $id): bool|array
    {
        $document = ElementLegalInformationTable::getList([
            'select' => [
                'ID',
                'NAME',
                'DOCUMENT',
                'DETAIL_TEXT',
            ],
            'filter' => [
                '=ACTIVE' => 'Y',
                'ID' => $id
            ],
        ])->fetch();

        $fileId = $document['IBLOCK_ELEMENTS_ELEMENT_LEGAL_INFORMATION_DOCUMENT_VALUE'];
        if ($fileId) {
            $filePath = \CFile::GetPath($fileId);
            $document['DOCUMENT_SRC'] = HttpHelper::getSiteProtocolAndDomain() . $filePath;
        }

        return $document;
    }

    private static function getIncludeSections(): array
    {
        $langParentSec = \Bitrix\Iblock\SectionTable::getList([
            'order' => ['LEFT_MARGIN'=>'ASC'],
            'select' => [
                '*'
            ],
            'filter' => [
                'IBLOCK_ID' => IBlockHelper::getIblockIdByCode('legal_information'),
                'CODE' => LANGUAGE_CODE,
            ],
            'cache' => [
                'ttl' => '86400'
            ]
        ])->fetch();

        $sections = \Bitrix\Iblock\SectionTable::getList([
            'order' => ['LEFT_MARGIN'=>'ASC'],
            'select' => [
                '*'
            ],
            'filter' => [
                'IBLOCK_ID' => IBlockHelper::getIblockIdByCode('legal_information'),
                '>LEFT_MARGIN' => $langParentSec['LEFT_MARGIN'],
                '<RIGHT_MARGIN' => $langParentSec['RIGHT_MARGIN']
            ],
            'cache' => [
                'ttl' => '86400'
            ]
        ])->fetchAll();

        $ids = [];
        $formattedSections = [];
        foreach ($sections as $section) {
            $ids[] = $section['ID'];
            $formattedSections[$section['ID']] = [
                'ID' => $section['ID'],
                'NAME' => $section['NAME'],
                'ELEMENTS' => [],
            ];
        }
        return [
            $ids,
            $formattedSections,
        ];
    }
}
