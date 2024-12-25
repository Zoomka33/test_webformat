<?php

namespace App\V1\Formatter;

use App\V1\Interface\FormatterInterface;

class LegalInformationFormatter implements FormatterInterface
{

    /**
     * @inheritDoc
     */
    public static function formatting(array $data): array
    {
        foreach ($data as $section) {
            $elements = [];
            foreach ($section['ELEMENTS'] as $item) {
                $elements[] = [
                    'id' => $item['ID'],
                    'name' => $item['NAME'],
                ];
            }
            $formattedSections[] = [
                'name' => $section['NAME'],
                'elements' => $elements,
            ];
        }

        return $formattedSections ?? [];
    }

    public static function formattingOnce(array $data): array
    {
        return [
            'id' => $data['ID'],
            'name' => $data['NAME'],
            'text' => $data['DETAIL_TEXT'],
            'documentSrc' => $data['DOCUMENT_SRC'],
        ];
    }
}
