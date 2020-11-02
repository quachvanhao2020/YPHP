<?php
namespace YPHP\Model\Media;
use YPHP\Model\Media\Storage\ImageStorage;

class Image360 extends ImageX{

    const IMAGES = "images";

    public function __toArray() {
        return array_merge(parent::__toArray(),[
            self::IMAGES => $this->getImages(),
        ]);
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setImages(@$array[self::IMAGES]);
    }
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
     * @param  \YPHP\Model\Media\Storage\ImageStorage  $images
     *
     * @return  self
     */ 
    public function setImages($images)
    {
        if($images == null || is_array($images)) $images = new ImageStorage($images);

        $this->images = $images;

        return $this;
    }
}