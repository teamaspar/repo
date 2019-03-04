<?php

namespace MotogpBundle\Repository;

/**
 * SponsorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SponsorRepository extends \Doctrine\ORM\EntityRepository
{

    public function findColor()
    {
        return $this->createQueryBuilder('s')
            ->where('s.bn != true')
            ->andWhere('s.enabled = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBN()
    {
        return $this->createQueryBuilder('s')
            ->where('s.bn = true')
            ->andWhere('s.enabled = true')
            ->getQuery()
            ->getResult()
            ;
    }


    public function getColorByModality($modality)
    {
        return $this->createQueryBuilder('s')
            ->join('s.modalities', 'm')
            ->where('m.id = :modality')
            ->andWhere('s.enabled = true')
            ->andWhere('s.bn != true')
            ->setParameter('modality', $modality->getId())
            ->orderBy('s._order', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getBNByModality($modality)
    {
        return $this->createQueryBuilder('s')
            ->join('s.modalities', 'm')
            ->where('m.id = :modality')
            ->andWhere('s.bn = true')
            ->andWhere('s.enabled = true')
            ->setParameter('modality', $modality->getId())
            ->orderBy('s._order', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getColorByModalityAndLevel($modality, $level)
    {
        return $this->createQueryBuilder('s')
            ->join('s.modalities', 'm')
            ->where('m.id = :modality')
            ->andWhere('s.enabled = true')
            ->andWhere('s.bn != true')
            ->andWhere('s.level = :level')
            ->setParameter('modality', $modality->getId())
            ->setParameter('level', $level)
            ->orderBy('s._order', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getBNByModalityAndLevel($modality, $level)
    {
        return $this->createQueryBuilder('s')
            ->join('s.modalities', 'm')
            ->where('m.id = :modality')
            ->andWhere('s.bn = true')
            ->andWhere('s.enabled = true')
            ->andWhere('s.level = :level')
            ->setParameter('modality', $modality->getId())
            ->setParameter('level', $level)
            ->orderBy('s._order', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
