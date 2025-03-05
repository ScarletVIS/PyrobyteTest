# Sitemap Generator

## Описание

Sitemap Generator - это PHP-библиотека для генерации карты сайта в форматах **XML, CSV и JSON**. Поддерживает валидацию входных данных и обработку ошибок.

## Возможности
- Генерация карты сайта в **XML, CSV, JSON**
- Создание директорий при отсутствии
- Исключения при ошибках (невалидные данные, ошибки записи в файл, неподдерживаемый формат)

## Установка

Библиотека доступна через **Composer**:
```sh
composer require vendor/sitemap-generator
```

## Использование

### **Пример кода**
```php
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
    ]
];

try {
    $generator = new SitemapGenerator('xml', __DIR__ . '/sitemaps/sitemap.xml');
    $generator->generate($urls);
    echo "Карта сайта успешно создана!";
} catch (InvalidDataException | FileWriteException | UnsupportedFormatException $e) {
    echo "Ошибка: " . $e->getMessage();
}
```

## Тестирование

Для запуска тестов используйте **PHPUnit**:
```sh
vendor/bin/phpunit tests
```

## Структура проекта

```
sitemap-generator/
├── src/
│   ├── SitemapGenerator.php
│   ├── Interface/
│   │   ├── SitemapFormatterInterface.php
│   ├── Formatters/
│   │   ├── XmlSitemapFormatter.php
│   │   ├── CsvSitemapFormatter.php
│   │   ├── JsonSitemapFormatter.php
│   ├── Exceptions/
│   │   ├── InvalidDataException.php
│   │   ├── FileWriteException.php
│   │   ├── UnsupportedFormatException.php
├── tests/
│   ├── SitemapGeneratorTest.php
│   ├── XmlSitemapFormatterTest.php
│   ├── CsvSitemapFormatterTest.php
│   ├── JsonSitemapFormatterTest.php
├── composer.json
├── README.md
├── .gitignore
├── LICENSE
```

## Лицензия

MIT License

