<?php

namespace Vendor\SitemapGenerator\Formats;

use Vendor\SitemapGenerator\Interface\SitemapFormatterInterface;

class CsvSitemapFormatter implements SitemapFormatterInterface
{
    public function format(array $urls): string
    {
        $output = "loc;lastmod;priority;changefreq\n";
        foreach ($urls as $url) {
            $output .= "{$url['loc']};{$url['lastmod']};{$url['priority']};{$url['changefreq']}\n";
        }
        return $output;
    }
}
