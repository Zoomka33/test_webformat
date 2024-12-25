<?php

declare(strict_types=1);

namespace B1\Service;

use Imagick;

/**
 * Пример использования:
 *
 * $imageProcessing = new ImageProcessing();
 * $imageProcessing->convertAndResize('liter.jpg');
*/
class ImageProcessing
{
    /**
     * Максимальная ширина изображения
     */
    protected const MAX_WIDTH_IMAGE = 1920;

    /**
     * Форматы изображения доступные для загрузки
     */
    public static array $allowFormats = [
        'png',
        'jpg',
        'jpeg'
    ];

    private Imagick $imagick;

    /**
     * Имя файла
     * @var string
     */
    private string $fileName;

    public function __construct()
    {
        $this->imagick = new \Imagick();
    }

    /**
     * Ресайз и конвертация изображения в webp
     *
     * @param string $inputImagePath
     * Относительный путь к изображению (относительно DOCUMENT_ROOT).
     * Может быть внешним, те по ссылке.
     * Путь к изображению вместе с названием (знаю, логично)
     *
     * @param string $outputImagePath
     * Относительный путь к изображению (относительно DOCUMENT_ROOT) сохраняемого файла.
     * Путь к изображению без его имени и формата
     *
     * @param int $quality Качество сжатия, оптимально стоит 80
     * @return string Путь до сохраненного изображения с указанием имени и формата (относительно DOCUMENT_ROOT)
     * @throws \ImagickException
     */
    public function resizeAndConvert(string $inputImagePath, string $outputImagePath = '', int $quality = 80): string
    {
        if (!empty($this->fileName)) {
            $fileName = $this->fileName;
        } else {
            $fileName = md5(uniqid(more_entropy: true)) . '.webp';
        }

        $this->imagick->readImage($inputImagePath);

        $width = $this->imagick->getImageWidth();
        $height = $this->imagick->getImageHeight();

        if ($width >= self::MAX_WIDTH_IMAGE) {
            $ratio = round(self::MAX_WIDTH_IMAGE / $width * 100);
            $width = self::MAX_WIDTH_IMAGE;
            $height = intval(round($height * $ratio / 100));
            $this->imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
        }

        $this->imagick->setImageFormat('WEBP');
        $this->imagick->setImageCompressionQuality($quality);

        $outputFilePath = $outputImagePath . $fileName;
        $this->imagick->writeImage($outputFilePath);

        $this->imagick->clear();

        return $outputFilePath;
    }

    /**
     * Ресайз изображения без конвертации
     *
     * @param string $inputImagePath
     * Абсоллютный путь к изображениюю. Может быть внешним, те по ссылке.
     * Путь к изображению вместе с названием (знаю, логично)
     *
     * @param string $outputFilePath
     * Абсоллютный путь к изображению. Путь к изображению без его имени и формата
     *
     * @param int $maxWidth Максимальная ширина изображения. Берем из константы MAX_WIDTH_IMAGE
     * @return bool True в случае успеха или исключение в случае провала
     * @throws \ImagickException
     */
    public function resizeImage(
        string $inputImagePath,
        string $outputFilePath,
        int $maxWidth = self::MAX_WIDTH_IMAGE
    ): bool
    {
        $this->imagick->readImage($inputImagePath);
        $ratio = round($maxWidth / $this->imagick->getImageWidth() * 100);
        $resizeHeight = intval(round($this->imagick->getImageHeight() * $ratio / 100));
        $format = '.' . pathinfo($inputImagePath, PATHINFO_EXTENSION);
        $fileName = pathinfo($inputImagePath, PATHINFO_FILENAME);
        $this->imagick->resizeImage($maxWidth, $resizeHeight, Imagick::FILTER_LANCZOS, 1);

        return $this->imagick->writeImage($outputFilePath . $fileName . $format);
    }

    /**
     * Генерация "lazy-load" изображения. Предполагается, что на входе будет webp после ресайза
     *
     * @param string $inputImagePath
     * Относительный путь к изображению (относительно DOCUMENT_ROOT).
     * Внешним быть не может, тк ждем подготовленное изображение
     * Путь к изображению вместе с названием (знаю, логично)
     *
     * @return string
     * @throws \ImagickException
     */
    public function lazyLoadImage(string $inputImagePath): string
    {
        $inputImagePath = $_SERVER['DOCUMENT_ROOT'] . $inputImagePath;
        $this->imagick->readImage($inputImagePath);
        $width = $this->imagick->getImageWidth();
        $this->imagick->blurImage(0, $width / 50);
        $this->imagick->setImageCompressionQuality(0);
        $explodedFilePath = explode('.webp', $inputImagePath);
        $outputFilePath = $explodedFilePath[0] . '-placeholder.webp';
        $this->imagick->writeImage($outputFilePath);
        $this->imagick->clear();

        return $outputFilePath;
    }

    /**
     * Установка имени файла
     *
     * @param string $fileName Имя файла
     * @return void
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }
}
