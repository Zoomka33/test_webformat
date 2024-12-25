<?php

namespace App\V1\Helper;

class HttpHelper
{
    /**
     * Получение значения протокола и домена сайта
     * Например: https://academyb1.ru
     *
     * @return string
     */
    public static function getSiteProtocolAndDomain(): string
    {
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }

        $domain = $_SERVER['SERVER_NAME'];

        return $protocol.$domain;
    }
}