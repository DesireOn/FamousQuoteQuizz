<?php

namespace App\Repository;

use App\Entity\AnsweredQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnsweredQuestion>
 *
 * @method AnsweredQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnsweredQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnsweredQuestion[]    findAll()
 * @method AnsweredQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnsweredQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnsweredQuestion::class);
    }

    public function save(AnsweredQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AnsweredQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
