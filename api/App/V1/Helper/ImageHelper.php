<?php

namespace App\V1\Helper;

class ImageHelper
{
    /**
     * Получение значения пути для placeholder изображения по значению пути основного webp изображения
     * Пример: /upload/webp/5d4/dbmfswaglsigltzug54rsh8pnoh77rzn.webp =>
     * /upload/webp/5d4/dbmfswaglsigltzug54rsh8pnoh77rzn-placeholder.webp"
     *
     * По факту добавляет постфикс -placeholder в конце имени файла перед форматом файла (.webp)
     * @param $imagePath
     * @return string
     */
    public static function getPlaceholderPathByWebpImagePath($imagePath): string
    {
        $explodedPath = explode('.webp', $imagePath);

        return $explodedPath[0] . '-placeholder.webp';
    }
}