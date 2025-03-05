<?php

require_once __DIR__ . '/vendor/autoload.php';

use Vendor\SitemapGenerator\SitemapGenerator;
use Vendor\SitemapGenerator\Exceptions\InvalidDataException;
use Vendor\SitemapGenerator\Exceptions\FileWriteException;
use Vendor\SitemapGenerator\Exceptions\UnsupportedFormatException;

$urls = [
    [
        'loc' => 'https://site.ru/',
        'lastmod' => '2020-12-14',
        'priority' => 1.0,
        'changefreq' => 'hourly'
    ],
    [
        'loc' => 'https://site.ru/news',
        'lastmod' => '2020-12-10',
        'priority' => 0.5,
        'changefreq' => 'daily'
    ],
    [
        'loc' => 'https://site.ru/about',
        'lastmod' => '2020-12-07',
        'priority' => 0.1,
        'changefreq' => 'weekly'
    ]
];

try {
    // Создаем объект генератора карты сайта
    $generator = new SitemapGenerator('xml', __DIR__ . '/sitemaps/sitemap.xml');
    
    // Генерируем файл
    $generator->generate($urls);

    echo "Карта сайта успешно создана!";
} catch (InvalidDataException | FileWriteException | UnsupportedFormatException $e) {
    echo "Ошибка: " . $e->getMessage();
}
