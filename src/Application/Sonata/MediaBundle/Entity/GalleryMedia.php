<?php

namespace Application\Sonata\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;
use MotogpBundle\Entity\Post;
use Doctrine\ORM\Mapping as ORM;

/**
 * This file has been generated by the SonataEasyExtendsBundle.
 *
 * @link https://sonata-project.org/easy-extends
 *
 * References:
 * @link http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 */
class GalleryMedia extends BaseMedia
{

    public function __construct()
    {
        $this->context        = 'gallery';
        $this->providerName   = 'sonata.media.provider.image';
        $this->providerStatus = 1;
        $this->providerReference = "reference";
        $this->providerMetadata = [];
        $this->enabled = true;
        $this->name           = 'gallery-image-'.(new \DateTime())->format('ymdms');
        $this->featured = false;
    }

    protected $rider;

    /**
     * @return mixed
     */
    public function getRider()
    {
        return $this->rider;
    }

    /**
     * @param mixed $rider
     */
    public function setRider($rider)
    {
        $this->rider = $rider;
    }


    private $owner;

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string
     */
    private $uploadFile;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $urlEN;

    /**
     * @var string
     */
    private $descriptionEN;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $titleEN;

    /**
     * @var integer
     */
    private $_order;


    /**
     * Get id.
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return Post
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param Post $post
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getUploadFile()
    {
        return $this->uploadFile;
    }

    /**
     * @param string $uploadFile
     */
    public function setUploadFile($uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getDescriptionEN()
    {
        return $this->descriptionEN;
    }

    /**
     * @param string $descriptionEN
     */
    public function setDescriptionEN($descriptionEN)
    {
        $this->descriptionEN = $descriptionEN;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->_order = $order;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitleEN()
    {
        return $this->titleEN;
    }

    /**
     * @param string $titleEN
     */
    public function setTitleEN($titleEN)
    {
        $this->titleEN = $titleEN;
    }

    /**
     * @return string
     */
    public function getUrlEN()
    {
        return $this->urlEN;
    }

    /**
     * @param string $urlEN
     */
    public function setUrlEN($urlEN)
    {
        $this->urlEN = $urlEN;
    }
    
}
