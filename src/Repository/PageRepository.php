<?php

namespace App\Repository;

use App\Entity\Page;
use App\Service\HashidsHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    /**
     * @var HashidsHelper
     */
    private $hashidsHelper;

    public function __construct(RegistryInterface $registry, HashidsHelper $hashidsHelper)
    {
        parent::__construct($registry, Page::class);
        $this->hashidsHelper = $hashidsHelper;
    }

    public function findByHashid(string $hashid): ?Page
    {
        $id = $this->hashidsHelper->decodePostId($hashid);

        return $this->find($id);
    }

}
