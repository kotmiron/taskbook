<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findLatest(int $page = 1, $sorting = "status"): Pagerfanta
    {

        if ($sorting !== null) {
            switch ($sorting) {
                case "name":
                    $sorting = "u.username";
                    break;
                case "email":
                    $sorting = "u.email";
                    break;
                case "status":
                    $sorting = "t.status";
                    break;
            }
        }

        $qb = $this->createQueryBuilder('t')
            ->addSelect('u')
            ->leftJoin('t.user', 'u')
            ->orderBy($sorting, 'ASC');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Task::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

}
