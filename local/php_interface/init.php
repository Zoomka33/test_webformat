<?php

include realpath(__DIR__ . '/../../../vendor/autoload.php');

use Symfony\Component\Dotenv\Dotenv;
use B1\Service\ImageProcessing;

const UPLOAD_WEBP_TMP_PATH = '';

/**
 * Срабатывает при сохранении фалйа. Метод CFile::SaveFile
 * Используется для перезвата изображения для последующей его ковертации в webp и ресайза.
 * ! Если вынести обработку в отдельный класс, то появляются дубли файлов в upload и записей в b_file !
 *
 * @param $arFile
 * @param $fileName
 * @param $module
 * @return void
 * @throws ImagickException
 */
function onFileSave(&$arFile, $fileName, $module): void
{
    $fileTmpName = explode('.', $fileName);

    $allowFormats = ImageProcessing::$allowFormats;

    if (in_array($fileTmpName[1], $allowFormats)) {
        // Обрабатываем и сохраняем файл
        $newFile = (new ImageProcessing())->resizeAndConvert($arFile['tmp_name'], UPLOAD_WEBP_TMP_PATH);

        if (!empty($newFile)) {
            // Сохраняем информацию о новом файле в базе данных
            $arFile = CFile::MakeFileArray($newFile, 'image/webp');
            $arFile['MODULE_ID'] = $module;
            $newFileId = CFile::SaveFile($arFile, 'webp/');
            $newFilePath = CFile::GetPath($newFileId);
            (new ImageProcessing())->lazyLoadImage($newFilePath);
        } else {
            // Обработка ошибки: файл не был создан
            // TODO: сделать логирование
        }
    }
}

/**
 * Событие "OnFileDelete" вызывается после удаления файла в методе CFile::Delete
 * Используется для удаления временной папки upload/webp/tmp/, а также для удаления
 * дубля записи о файле в таблице b_file. Дубль возникает из-за специфики работы БУС,
 * побороться с ним не получилось, сделано обходное решение.
 * ! Если вынести обработку в отдельный класс, то появляются дубли файлов в upload и записей в b_file !
 *
 * $fileSrcExploded[0] - название файла без формата
 * $fileSrcExploded[1] - формат файла, те .webp
 *
 * @param $arFields
 * @return void
 */
function onFileDelete($arFields): void
{
    $duplicate = CFile::GetByID($arFields['ID'] - 1)->fetch();

    $fileSrcExploded = explode('.', $_SERVER['DOCUMENT_ROOT'] . $arFields['SRC']);
    $lazyFileSrc = $fileSrcExploded[0] . '-placeholder.' . $fileSrcExploded[1];

    if (file_exists($lazyFileSrc)) {
        unlink($lazyFileSrc);
    }

    if ($duplicate['FILE_NAME'] === $arFields['FILE_NAME'] && $duplicate['FILE_SIZE'] === $arFields['FILE_SIZE']) {
        CFile::Delete($duplicate['ID']);
    }
    clearDirectory();
}

/**
 * Используется для очистки временной директории upload/webp/tmp/
 *
 * @return void
 */
function clearDirectory(): void
{
    $directoryPath = UPLOAD_WEBP_TMP_PATH;

    if (is_dir($directoryPath)) {
        $files = glob($directoryPath . '/*');
        foreach ($files as $file) {
            is_dir($file) ? clearDirectory($file) : unlink($file);
        }
    }
}

/**
 * Обработчики событий для конвертации и резайза изображений
 */
AddEventHandler("main", 'OnFileSave', 'onFileSave');
AddEventHandler("main", 'OnFileDelete', 'onFileDelete');

include_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/events.php';
define('LANGUAGE_CODE', $_COOKIE['LANGUAGE_ID']);

/**
 * Для парсинга переменных окружения
 * Переменные доступны в $_ENV и $_SERVER
 */
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../../.env');

