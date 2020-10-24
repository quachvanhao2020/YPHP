<?php
namespace YPHP\Model\Media;
use YPHP\Model\Media\Storage\ImageStorage;

class Image360 extends Image{

    /**
     * 
     *
     * @var ImageStorage
     */
    protected $childs;

    /**
     * Get the value of childs
     *
     * @return  ImageStorage
     */ 
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Set the value of childs
     *
     * @param  ImageStorage  $childs
     *
     * @return  self
     */ 
    public function setChilds(ImageStorage $childs)
    {
        $this->childs = $childs;

        return $this;
    }
}