<?php

namespace Vendor\SitemapGenerator\Interface;

interface SitemapFormatterInterface
{
    /**
     * Форматирует массив данных карты сайта в нужный формат.
     *
     * @param array $urls Массив страниц сайта
     * @return string Сформатированное содержимое
     */
    public function format(array $urls): string;
}
