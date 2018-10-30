<?php

namespace App\Service;

use App\Entity\Page;
use Cocur\Slugify\SlugifyInterface;

class PageResponseHelper
{

    /**
     * @var SlugifyInterface
     */
    private $slugify;
    /**
     * @var HashidsHelper
     */
    private $hashidsHelper;

    public function __construct(SlugifyInterface $slugify, HashidsHelper $hashidsHelper)
    {
        $this->slugify = $slugify;
        $this->hashidsHelper = $hashidsHelper;
    }

    /**
     * @param Page $page
     * @return array
     */
    public function preparePageForList(Page $page): array
    {
        $slug = $this->slugify->slugify($page->getTitle());

        $hashid = $this->hashidsHelper->encodePageId($page->getId());

        return [
            'id' => $hashid,
            'slug' => $slug,
            'title' => $page->getTitle(),
        ];
    }

    /**
     * @param Page $page
     * @return array
     */
    public function preparePageForShow(Page $page): array
    {

        $slug = $this->slugify->slugify($page->getTitle());

        $hashid = $this->hashidsHelper->encodePostId($page->getId());

        return [
            'id' => $hashid,
            'slug' => $slug,
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ];
    }
}