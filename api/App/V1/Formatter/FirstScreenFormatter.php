<?php

namespace App\V1\Formatter;

use App\V1\Interface\FormatterInterface;

class FirstScreenFormatter implements FormatterInterface
{

    /**
     * @inheritDoc
     */
    public static function formatting(array $data): array
    {
        return [
            'name' => $data['NAME'],
            'text' => $data['PREVIEW_TEXT'],
            'buttonText' => $data['IBLOCK_ELEMENTS_ELEMENT_FIRST_SCREEN_BUTTON_TEXT_VALUE'],
            'buttonLink' => $data['IBLOCK_ELEMENTS_ELEMENT_FIRST_SCREEN_BUTTON_LINK_VALUE'],
            'icon' => $data['IMAGE_SRC'],
            'iconPlaceholder' => $data['IMAGE_PLACEHOLDER_SRC'],
        ];
    }
}
