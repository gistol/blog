<?php


namespace App\Service;


use App\Repository\PostRepository;

class PostService
{

    /**
     * @var PostRepository
     */
    private $postRepo;
    /**
     * @var PostResponseHelper
     */
    private $postResponseHelper;

    public function __construct(PostRepository $postRepo, PostResponseHelper $postResponseHelper)
    {
        $this->postRepo = $postRepo;
        $this->postResponseHelper = $postResponseHelper;
    }

    /**
     * @param int $id
     * @return array|bool
     */
    public function getPost(int $id)
    {
        $post = $this->postRepo->find($id);

        if (!$post) {
            return false;
        }

        // =============================================================================================================

        $previousPost = $this->postRepo->findPrevious($post);
        $nextPost = $this->postRepo->findNext($post);

        // =============================================================================================================

        $data = $this->postResponseHelper->preparePostForShow($post);
        $data['previousPost'] = $previousPost === null ? null : $this->postResponseHelper->preparePostForList($previousPost);
        $data['nextPost'] = $nextPost === null ? null : $this->postResponseHelper->preparePostForList($nextPost);

        return $data;
    }

}