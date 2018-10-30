<?php


namespace App\EventSubscriber;


use App\Entity\Page;
use Cocur\Slugify\Slugify;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class PageSlugSubscriber implements EventSubscriber
{

    public function getSubscribedEvents(): array
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->index($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args): void
    {
        $page = $args->getObject();

        if ($page instanceof Page) {

            $pageTitle = $page->getTitle();

            $slugify = new Slugify();
            $slugify->activateRuleSet('turkish');

            if (null !== $pageTitle && '' !== $pageTitle) {
                $page->setSlug(
                    $slugify->slugify($pageTitle)
                );
            }
        }
    }

}