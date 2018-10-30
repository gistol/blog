<?php


namespace App\Service;


use App\Repository\PageRepository;

class PageService
{

    /**
     * @var PageRepository
     */
    private $pageRepo;
    /**
     * @var PageResponseHelper
     */
    private $pageResponseHelper;

    public function __construct(PageRepository $pageRepo, PageResponseHelper $pageResponseHelper)
    {
        $this->pageRepo = $pageRepo;
        $this->pageResponseHelper = $pageResponseHelper;
    }

    /**
     * @param int $id
     * @return array|bool
     */
    public function getPage(int $id)
    {
        $page = $this->pageRepo->find($id);

        if (!$page) {
            return false;
        }

        return $this->pageResponseHelper->preparePageForShow($page);

    }

}