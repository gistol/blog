<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Service\HashidsHelper;
use Cocur\Slugify\SlugifyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SeoController extends AbstractController
{
    /**
     * @Route("/robots.txt", name="seo_robots_txt")
     */
    public function robotsTxt(): Response
    {
        $content = 'User-agent: *' . PHP_EOL . 'Disallow:';

        $response = new Response();
        $response
            ->setContent($content)
            ->headers->set('Content-Type', 'text/plain');

        return $response;
    }

    /**
     * @Route("/sitemap.xml", name="seo_sitemap")
     *
     * @param PostRepository $postRepo
     * @param SlugifyInterface $slugify
     * @param HashidsHelper $hashidsHelper
     * @return Response
     */
    public function sitemap(
        PostRepository $postRepo,
        SlugifyInterface $slugify,
        HashidsHelper $hashidsHelper
    ): Response
    {
        $sitemap = [];

        // Static Pages
        $sitemap[] = [
            'loc' => $this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        $sitemap[] = [
            'loc' => $this->generateUrl('contact', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        // Posts
        $posts = $postRepo->findAll();
        foreach ($posts as $index => $post) {

            $hashid = $hashidsHelper->encodePostId($post->getId());

            $sitemap[] = [
                // fixme
//                'loc' => $this->generateUrl(
//                    'home_get_post',
//                    [
//                        'id' => $post->getId(),
//                        'slug' => $slugify->slugify($post->getTitle()),
//                    ],
//                    UrlGeneratorInterface::ABSOLUTE_URL
//                ),
                'loc' => $this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL) .
                    $slugify->slugify($post->getTitle()) . '-' . $hashid,
                'lastmod' => $post->getUpdatedAt()->format(\DateTime::W3C),
            ];
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');

        return $this->render(
            'sitemap.xml.twig',
            [
                'sitemap' => $sitemap
            ],
            $response
        );
    }
}
