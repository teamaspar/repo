<?php

namespace MotogpBundle\Repository;

/**
 * RiderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RiderRepository extends \Doctrine\ORM\EntityRepository
{
    public function findInternalRiders()
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.riderTeam', 'rt')
            ->where('rt.main IS NOT NULL')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findHomeRiders()
    {
        return $this->createQueryBuilder('r')
            ->where('r.showInHome = true')
            ->orderBy('r._order','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getHomeRidersInModality($modality)
    {
        return $this->createQueryBuilder('r')
            ->where('r.showInHome = true')
            ->andWhere('r.modality = :modality')
            ->setParameter('modality', $modality->getId())
            ->orderBy('r._order','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getHomeRidersInModalitySlug($modality)
    {

        return $this->createQueryBuilder('r')
            ->innerJoin('r.modality', 'm')
            ->where('r.showInHome = true')
            ->andWhere('m.slug = :slug')
            ->setParameter('slug', $modality)
            ->orderBy('r._order','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getRidersInModality($modality)
    {

        return $this->createQueryBuilder('r')
            ->innerJoin('r.modality', 'm')
            ->andWhere('m.id = :id')
            ->setParameter('id', $modality)
            ->orderBy('r.name','ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    
}
