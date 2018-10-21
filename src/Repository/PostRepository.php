<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\HashidsHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private $hashidsHelper;

    public function __construct(RegistryInterface $registry, HashidsHelper $hashidsHelper)
    {
        parent::__construct($registry, Post::class);

        $this->hashidsHelper = $hashidsHelper;
    }

    public function findByHashid(string $hashid): ?Post
    {
        $id = $this->hashidsHelper->decodePostId($hashid);

        return $this->find($id);
    }

    public function findPrevious(Post $post): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id < :id')
            ->setParameter('id', $post->getId())
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findNext(Post $post): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id > :id')
            ->setParameter('id', $post->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
