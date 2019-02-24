<?php

namespace App\Service;

use App\Entity\Post;
use Cocur\Slugify\SlugifyInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class PostResponseHelper
{
    private $uploaderHelper;

    private $slugify;

    private $markdownHelper;

    private $hashidsHelper;
    private $appTitle;

    public function __construct(
        UploaderHelper $uploaderHelper,
        SlugifyInterface $slugify,
        MarkdownHelper $markdownHelper,
        HashidsHelper $hashidsHelper,
        $appTitle
    )
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->slugify = $slugify;
        $this->markdownHelper = $markdownHelper;
        $this->hashidsHelper = $hashidsHelper;
        $this->appTitle = substr($appTitle, 1, -1); // deleting double quotes
    }

    public function preparePostForList(Post $post): array
    {
        $imagePath = $post->getImage() !== null ? $this->uploaderHelper->asset($post->getImage(), 'file') : '';
        $slug = $this->slugify->slugify($post->getTitle());

        $hashid = $this->hashidsHelper->encodePostId($post->getId());

        return [
            'id' => $hashid,
            'slug' => $slug,
            'title' => $post->getTitle(),

            'summary' => $post->getSummary(),

            'image' => $imagePath,
            'createdAt' => $post->getCreatedAt() === null ? '' : $post->getCreatedAt()->format('d.m.Y'),
            'updatedAt' => $post->getUpdatedAt() === null ? '' : $post->getUpdatedAt()->format('d.m.Y'),
        ];
    }

    public function preparePostForShow(Post $post): array
    {
        $imagePath = $post->getImage() !== null ? $this->uploaderHelper->asset($post->getImage(), 'file') : '';
        $slug = $this->slugify->slugify($post->getTitle());

        return [
            'id' => $post->getId(),
            'slug' => $slug,
            'title' => $post->getTitle() . ' - ' . $this->appTitle,

            'content' => $this->markdownHelper->transform($post->getContent()),

            'image' => $imagePath,
            'createdAt' => $post->getCreatedAt() === null ? '' : $post->getCreatedAt()->format('d.m.Y'),
            'updatedAt' => $post->getUpdatedAt() === null ? '' : $post->getUpdatedAt()->format('d.m.Y'),
        ];
    }
}