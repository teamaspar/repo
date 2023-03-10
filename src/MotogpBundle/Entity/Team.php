<?php

namespace MotogpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MotogpBundle\Entity\Traits\ContentTrait;
use MotogpBundle\Entity\Traits\HasQuotationImageTrait;
use MotogpBundle\Entity\Traits\InModalitiesTrait;
use MotogpBundle\Entity\Traits\InRiderTeamTrait;
use MotogpBundle\Entity\Traits\InRiderTrait;
use MotogpBundle\Entity\Traits\InTeamCategoryTrait;
use MotogpBundle\Entity\Traits\HasMediaTrait;


/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="MotogpBundle\Repository\TeamRepository")
 */
class Team
{
   use
       ContentTrait,
       InTeamCategoryTrait,
       InRiderTeamTrait,
       InRiderTrait,
       InModalitiesTrait,
       HasQuotationImageTrait,
       HasMediaTrait;

   /**
    * @var string
    *
    * @ORM\Column(type="string", nullable=false)
    */
   private $country;

   /**
    * @return string
    */
   public function getCountry()
   {
      return $this->country;
   }

   /**
    * @param string $country
    */
   public function setCountry($country)
   {
      $this->country = $country;
   }


   public function getFullName() {
      return $this->name;
   }
   
}

