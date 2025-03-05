<?php

namespace Vendor\SitemapGenerator\Formats;

use Vendor\SitemapGenerator\Interface\SitemapFormatterInterface;

class XmlSitemapFormatter implements SitemapFormatterInterface
{
    public function format(array $urls): string
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $url) {
            $urlElement = $xml->addChild('url');
            $urlElement->addChild('loc', htmlspecialchars($url['loc'], ENT_XML1));
            $urlElement->addChild('lastmod', $url['lastmod']);
            $urlElement->addChild('priority', (string)$url['priority']);
            $urlElement->addChild('changefreq', $url['changefreq']);
        }

        return $xml->asXML();
    }
}
