<?php

namespace Vendor\SitemapGenerator;

use Vendor\SitemapGenerator\Interface\SitemapFormatterInterface;
use Vendor\SitemapGenerator\Exceptions\InvalidDataException;
use Vendor\SitemapGenerator\Exceptions\FileWriteException;
use Vendor\SitemapGenerator\Exceptions\UnsupportedFormatException;
use Vendor\SitemapGenerator\Formats\XmlSitemapFormatter;
use Vendor\SitemapGenerator\Formats\CsvSitemapFormatter;
use Vendor\SitemapGenerator\Formats\JsonSitemapFormatter;

class SitemapGenerator
{
    private SitemapFormatterInterface $formatter;
    private string $filePath;

    /**
     * Конструктор генератора карты сайта.
     *
     * @param string $format Формат файла (xml, csv, json)
     * @param string $filePath Путь для сохранения
     * @throws UnsupportedFormatException
     */
    public function __construct(string $format, string $filePath)
    {
        $this->filePath = $filePath;

        $this->formatter = match ($format) {
            'xml' => new XmlSitemapFormatter(),
            'csv' => new CsvSitemapFormatter(),
            'json' => new JsonSitemapFormatter(),
            default => throw new UnsupportedFormatException("Формат '{$format}' не поддерживается."),
        };
    }

    /**
     * Генерация файла Sitemap
     *
     * @param array $urls
     * @throws InvalidDataException|FileWriteException
     */
    public function generate(array $urls): void
    {
        if (!$this->validate($urls)) {
            throw new InvalidDataException("Некорректные данные.");
        }

        $directory = dirname($this->filePath);
        if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_writable($directory)) {
            throw new FileWriteException("Не удалось создать директорию: {$directory}");
        }

        $content = $this->formatter->format($urls);

        if (file_put_contents($this->filePath, $content) === false) {
            throw new FileWriteException("Ошибка записи файла: {$this->filePath}");
        }
    }

    /**
     * Валидация данных
     */
    private function validate(array $urls): bool
    {
        foreach ($urls as $url) {
            if (!isset($url['loc'], $url['lastmod'], $url['priority'], $url['changefreq'])) {
                return false;
            }
        }
        return true;
    }
}
