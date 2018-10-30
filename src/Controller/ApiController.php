<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Post;
use App\Repository\PageRepository;
use App\Repository\PostRepository;
use App\Service\HashidsHelper;
use App\Service\PageResponseHelper;
use App\Service\PageService;
use App\Service\PostResponseHelper;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/posts", name="api_get_posts", methods={"GET"})
     *
     * @param PostRepository $postRepo
     * @param PostResponseHelper $postResponseHelper
     * @return JsonResponse
     */
    public function getPosts(PostRepository $postRepo, PostResponseHelper $postResponseHelper): JsonResponse
    {
        $posts = array_map(function (Post $post) use ($postResponseHelper) {
            return $postResponseHelper->preparePostForList($post);
        },
            $postRepo->findBy(
                [],
                [
                    'id' => 'DESC'
                ],
                10
            )
        );

        return $this->json([
            'items' => $posts
        ]);
    }

    /**
     * @Route("/api/posts/{hashid}", name="api_get_post", methods={"GET"})
     * @Route("/api/pages/{hashid}", name="api_get_page", methods={"GET"})
     *
     * @param string $hashid
     * @param PostService $postService
     * @param PageService $pageService
     * @param HashidsHelper $hashidsHelper
     * @return JsonResponse
     */
    public function getContent(
        string $hashid,
        PostService $postService,
        PageService $pageService,
        HashidsHelper $hashidsHelper
    ): JsonResponse
    {

        [$type, $id] = $hashidsHelper->decodeTypeAndId($hashid);

        $data = [];

        if($type === $hashidsHelper::POST) {
            $data = $postService->getPost($id);
        } else if($type === $hashidsHelper::PAGE) {
            $data = $pageService->getPage($id);
        }

        return $this->json([
            'data' => $data
        ]);
    }

    /**
     * @Route("/api/pages", methods={"GET"})
     *
     * @param PageRepository $pageRepository
     * @param PageResponseHelper $pageResponseHelper
     * @return JsonResponse
     */
    public function getPages(PageRepository $pageRepository, PageResponseHelper $pageResponseHelper): JsonResponse
    {
        $pages = array_map(function (Page $page) use ($pageResponseHelper) {
            return $pageResponseHelper->preparePageForList($page);
        },
            $pageRepository->findBy(
                [],
                [
                    'id' => 'DESC'
                ],
                10
            )
        );

        return $this->json([
            'items' => $pages
        ]);
    }

}
