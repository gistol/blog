<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    private $markdownParser;

    private $cache;

    public function __construct(MarkdownParserInterface $markdownParser, AdapterInterface $cache)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
    }

    public function transform(string $text): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $item = $this->cache->getItem('markdown_' . md5($text));

        if (!$item->isHit()) {
            $item->set($this->markdownParser->transformMarkdown($text));
            $this->cache->save($item);
        }

        return $item->get();
    }
}