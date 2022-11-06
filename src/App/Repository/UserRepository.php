<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /** @return array */
    public function findByLastAttendance(): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'attendance_id');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('user_id', 'user_id');
        $rsm->addScalarResult('entered_at', 'entered_at');
        $rsm->addScalarResult('exited_at', 'exited_at');


        $query = $this->getEntityManager()->createNativeQuery('SELECT u.*, a.*
            FROM app_user AS u
            INNER JOIN attendance AS a ON a.id = (
                SELECT id
                FROM attendance AS a2
                WHERE a2.user_id = u.id
                ORDER BY id DESC
                LIMIT 1
        )', $rsm);

        return $query->getResult();

    }

    /** @return array */
    public function findByDate(\DateTime $date): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('user_id', 'id');
        $rsm->addScalarResult('entered_at', 'entered_at');
        $rsm->addScalarResult('exited_at', 'exited_at');
        $rsm->addScalarResult('description', 'description');

        $dateYear = (int)$date->format('Y');
        $dateMonth = (int)$date->format('m');
        $dateDay = (int)$date->format('d');

        $query = $this->getEntityManager()->createNativeQuery('SELECT u.*, a.*
            FROM app_user AS u
            LEFT JOIN attendance AS a ON a.id = (
                SELECT id
                FROM attendance AS a2 WHERE a2.user_id = u.id AND
                YEAR(a2.entered_at) =  :y AND MONTH(a2.entered_at) = :m AND DAY(a2.entered_at) = :d
                LIMIT 1
        )', $rsm);

        // $query = $this->getEntityManager()->createNativeQuery('SELECT a.*, u.*
        //     FROM attendance AS a  INNER JOIN app_user AS u ON u.id = (
        //         SELECT id FROM app_user AS u2 Where u2.id = a.user_id   
        //         )
        //     WHERE YEAR(a.entered_at) =  :y AND MONTH(a.entered_at) = :m AND DAY(a.entered_at) = :d
            
        // ', $rsm);
        $query->setParameters(new ArrayCollection([
            new Parameter('y', $dateYear),
            new Parameter('m', $dateMonth),
            new Parameter('d', $dateDay)
        ]));

        return $query->getResult();

    }



    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
