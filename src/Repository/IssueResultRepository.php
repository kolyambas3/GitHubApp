<?php

namespace App\Repository;

use App\Entity\IssueResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IssueResult>
 *
 * @method IssueResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method IssueResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method IssueResult[]    findAll()
 * @method IssueResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IssueResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IssueResult::class);
    }

    public function add(IssueResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(IssueResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}