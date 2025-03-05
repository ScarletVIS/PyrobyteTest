<?php

namespace Vendor\SitemapGenerator\Formats;

use Vendor\SitemapGenerator\Interface\SitemapFormatterInterface;

class JsonSitemapFormatter implements SitemapFormatterInterface
{
    public function format(array $urls): string
    {
        return json_encode($urls, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
