<?php
namespace YPHP\Model\Media;
use YPHP\Model\Media\Storage\ImageStorage;

class Image360 extends ImageX{

    /**
     * 
     *
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
}