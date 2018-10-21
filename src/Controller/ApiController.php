<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\MarkdownHelper;
use App\Service\PostResponseHelper;
use Cocur\Slugify\SlugifyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
     *
     * @param string $hashid
     * @param PostRepository $postRepo
     * @param PostResponseHelper $postResponseHelper
     * @return JsonResponse
     */
    public function getPost(
        string $hashid,
        PostRepository $postRepo,
        PostResponseHelper $postResponseHelper
    ): JsonResponse
    {
        $post = $postRepo->findByHashid($hashid);

        if (!$post) {
            return $this->json([
                'error' => 'Yazı bulunamadı!'
            ]);
        }

        // =============================================================================================================

        $previousPost = $postRepo->findPrevious($post);
        $nextPost = $postRepo->findNext($post);

        // =============================================================================================================

        $data = $postResponseHelper->preparePostForShow($post);
        $data['previousPost'] = $previousPost === null ? null : $postResponseHelper->preparePostForList($previousPost);
        $data['nextPost'] = $nextPost === null ? null : $postResponseHelper->preparePostForList($nextPost);

        return $this->json([
            'data' => $data
        ]);
    }
}
