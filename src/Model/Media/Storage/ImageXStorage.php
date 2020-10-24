<?php
namespace YPHP\Model\Media\Storage;

use YPHP\ArrayObject;
use YPHP\Model\Media\ImageX;
use YPHP\Model\Media\Storage\Iterator\ImageXIterator;

class ImageXStorage extends ArrayObject{

            /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return ImageXIterator
     */
    public function getIterator()
    {
        return new ImageXIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  ImageX[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

                    /**
     * Set the value of storage
     *
     * @param  ImageX[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}