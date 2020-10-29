<?php
namespace YPHP\Model\Media;

class ImageX extends Image{

    const THUMB = "thumb";
    /**
     * @var Image
     */
    protected $thumb;

    public function __toArray() {
        return array_merge(parent::__toArray(),[
            self::THUMB => $this->getThumb(),
        ]);
    }

    /**
     * Get the value of thumb
     *
     * @return  Image
     */ 
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set the value of thumb
     *
     * @param  Image  $thumb
     *
     * @return  self
     */ 
    public function setThumb(Image $thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }
}