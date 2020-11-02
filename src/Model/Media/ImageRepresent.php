<?php
namespace YPHP\Model\Media;

use YPHP\Entity;
use YPHP\Model\Media\Storage\ImageStorage;

class ImageRepresent extends Entity{
    
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
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @param  \YPHP\Model\Media\Storage\ImageStorage  $images
     *
     * @return  self
     */ 
    public function setImages($images = [])
    {
        if($images == null || is_array($images)) $images = new ImageStorage($images);

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
    public function setLogo(Image $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }
}