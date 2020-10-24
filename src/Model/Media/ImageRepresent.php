<?php
namespace YPHP\Model\Media;

use YPHP\Entity;
use YPHP\Model\Media\Storage\ImageStorage;

class ImageRepresent extends Entity{

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
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @param  ImageStorage  $images
     *
     * @return  self
     */ 
    public function setImages(ImageStorage $images)
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
        return $this->logo;
    }

    /**
     * Set the value of logo
     *
     * @param  Image  $logo
     *
     * @return  self
     */ 
    public function setLogo(Image $logo)
    {
        $this->logo = $logo;

        return $this;
    }
}