<?php

namespace MotogpBundle\Repository;

/**
 * CircuitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CircuitRepository extends \Doctrine\ORM\EntityRepository
{

    public function getCircuitsWithGalleryInModality($modality)
    {

        return $this->createQueryBuilder('c')
            ->leftJoin('c.galleries', 'g')
            ->where('g.modality = :modality')
            ->setParameter('modality', $modality->getId())
            ->orderBy('g.createdAt, g.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getCircuitsWithPostsInModality($modality)
    {

        return $this->createQueryBuilder('c')
            ->leftJoin('c.posts', 'g')
            ->where('g.modality = :modality')
            ->setParameter('modality', $modality->getId())
            ->orderBy('g.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getCircuitsWithDocumentsInModality($modality)
    {

        return $this->createQueryBuilder('c')
            ->leftJoin('c.modalities', 'm')
            ->leftJoin('c.posts', 'g')
            ->where('m.id = :modality')
            ->setParameter('modality', $modality->getId())
            ->orderBy('g.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getCircuitsWithGalleryInModalityAndYear($modality, $year)
    {

        $firstDay = new \DateTime('01-01-'.$year);
        $lastDay  =  new \DateTime('31-12-'.$year.' 23:59:59');

        return $this->createQueryBuilder('c')
            ->leftJoin('c.galleries', 'g')
            ->where('g.modality = :modality')
            ->andWhere('g.createdAt >= :start')
            ->andWhere('g.createdAt <= :end')
            ->setParameter('modality', $modality->getId())
            ->setParameter('start', $firstDay)
            ->setParameter('end', $lastDay)
            ->addOrderBy('g.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getCircuitsWithDocumentsInModalityAndYear($modality, $year)
    {

        $firstDay = new \DateTime('01-01-'.$year);
        $lastDay  =  new \DateTime('31-12-'.$year.' 23:59:59');

        return $this->createQueryBuilder('c')
            ->leftJoin('c.documents', 'g')
            ->leftJoin('g.modalities', 'm')
            ->where('m.id = :modality')
            ->andWhere('g.createdAt >= :start')
            ->andWhere('g.createdAt <= :end')
            ->setParameter('modality', $modality->getId())
            ->setParameter('start', $firstDay)
            ->setParameter('end', $lastDay)
            ->addOrderBy('g.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    
    public function getCircuitsWithPostsInModalityAndYear($modality, $year)
    {

        $firstDay = new \DateTime('01-01-'.$year);
        $lastDay  =  new \DateTime('31-12-'.$year.' 23:59:59');

        return $this->createQueryBuilder('c')
            ->leftJoin('c.posts', 'g')
            ->where('g.modality = :modality')
            ->andWhere('g.publishedAt >= :start')
            ->andWhere('g.publishedAt <= :end')
            ->setParameter('modality', $modality->getId())
            ->setParameter('start', $firstDay)
            ->setParameter('end', $lastDay)
            ->addOrderBy('g.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
