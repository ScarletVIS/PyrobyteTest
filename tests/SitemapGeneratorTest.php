<?php

use PHPUnit\Framework\TestCase;
use Vendor\SitemapGenerator\SitemapGenerator;
use Vendor\SitemapGenerator\Exceptions\InvalidDataException;
use Vendor\SitemapGenerator\Exceptions\FileWriteException;
use Vendor\SitemapGenerator\Exceptions\UnsupportedFormatException;
use Vendor\SitemapGenerator\Exceptions\DuplicateUrlException;

class SitemapGeneratorTest extends TestCase
{
    private string $testFilePathXml = __DIR__ . '/sitemaps/test_sitemap.xml';
    private string $testFilePathCsv = __DIR__ . '/sitemaps/test_sitemap.csv';
    private string $testFilePathJson = __DIR__ . '/sitemaps/test_sitemap.json';

    public function testThrowsExceptionForInvalidData()
    {
        $this->expectException(InvalidDataException::class);

        $urls = [
            ['loc' => 'https://site.ru/'] // Неполные данные
        ];

        $generator = new SitemapGenerator('xml', $this->testFilePathXml);
        $generator->generate($urls);
    }

    public function testThrowsExceptionForUnsupportedFormat()
    {
        $this->expectException(UnsupportedFormatException::class);

        $generator = new SitemapGenerator('txt', $this->testFilePathXml);
    }

    
    public function testThrowsExceptionForDuplicateUrls()
    {
        $this->expectException(DuplicateUrlException::class);

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
                'loc' => 'https://site.ru/',
                'lastmod' => '2020-12-14',
                'priority' => 1.0,
                'changefreq' => 'hourly'
            ] // Дублирующийся URL
        ];

        $generator = new SitemapGenerator('xml', $this->testFilePathCsv);
        $generator->generate($urls);
    }

    public function testGeneratesXmlSitemap()
    {
        $urls = [
            [
                'loc' => 'https://site.ru/',
                'lastmod' => '2020-12-14',
                'priority' => 1.0,
                'changefreq' => 'hourly'
            ]
        ];

        $generator = new SitemapGenerator('xml', $this->testFilePathXml);
        $generator->generate($urls);

        $this->assertFileExists($this->testFilePathXml);
    }

    public function testGeneratesCsvSitemap()
    {
        $urls = [
            [
                'loc' => 'https://site.ru/',
                'lastmod' => '2020-12-14',
                'priority' => 1.0,
                'changefreq' => 'hourly'
            ]
        ];

        $generator = new SitemapGenerator('csv', $this->testFilePathCsv);
        $generator->generate($urls);

        $this->assertFileExists($this->testFilePathCsv);
    }

    public function testGeneratesJsonSitemap()
    {
        $urls = [
            [
                'loc' => 'https://site.ru/',
                'lastmod' => '2020-12-14',
                'priority' => 1.0,
                'changefreq' => 'hourly'
            ]
        ];

        $generator = new SitemapGenerator('json', $this->testFilePathJson);
        $generator->generate($urls);

        $this->assertFileExists($this->testFilePathJson);
    }


    protected function tearDown(): void
    {
        foreach ([$this->testFilePathXml, $this->testFilePathCsv, $this->testFilePathJson] as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
