<?php

namespace App\V1\Interface;

interface FormatterInterface
{
    /**
     * Форматирует данные
     *
     * @param array $data Массив с данными
     * @return array Отформатированный массив с данными
     */
    public static function formatting (array $data): array;
}