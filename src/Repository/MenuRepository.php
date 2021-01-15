<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    /**
     * @return array Returns an array
     */
    
    public function findByRoles($searchJson)
    {
        return $this->createQueryBuilder('m')
            ->where("JSON_EXTRACT(r.role, :jsonPath) = :value ")
            ->setParameter('jsonPath', '$')
            ->setParameter('value', json_encode($searchJson))
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array Returns an array
     */
    
    public function findEntityList()
    {
        $entityList = $this->getEntityManager()->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
        
        return array_combine(array_values($entityList), array_values($entityList));
    }
   

    /*
    public function findOneBySomeField($value): ?Menu
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
