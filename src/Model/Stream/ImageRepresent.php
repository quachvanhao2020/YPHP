<?php
namespace YPHP\Model\Stream;

use YPHP\Entity;
use YPHP\Model\Stream\Storage\ImageStorage;

class ImageRepresent extends EntityStream{
    
    const LOGO = "logo";
    const IMAGES = "images";

    public function __toArray() {
        return array_merge(parent::__toArray(),[
            self::LOGO => $this->getLogo(),
            self::IMAGES => $this->getImages(),
        ]);
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setLogo(@$array[self::LOGO]);
        $this->setImages(@$array[self::IMAGES]);
    }

    /**
     * @var Image
     */
    protected $logo;

        /**
     * @var ImageStorage
     */
    protected $images;

    /**
     * Get the value of images
     *
     * @return  ImageStorage
     */ 
    public function getImages()
    {
        if(!$this->images) $this->images = new ImageStorage();
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @param  ImageStorage  $images
     *
     * @return  self
     */ 
    public function setImages(?ImageStorage $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get the value of logo
     *
     * @return  Image
     */ 
    public function getLogo()
    {
        if(!$this->logo) $this->logo = new Image();
        return $this->logo;
    }

    /**
     * Set the value of logo
     *
     * @param  Image  $logo
     *
     * @return  self
     */ 
    public function setLogo(?Image $logo)
    {
        $this->logo = $logo;

        return $this;
    }
}