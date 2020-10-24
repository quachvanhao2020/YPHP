<?php
namespace YPHP\Model\Media\Storage;

use YPHP\ArrayObject;
use YPHP\Model\Media\Image;
use YPHP\Model\Media\Storage\Iterator\ImageIterator;

class ImageStorage extends ArrayObject{

            /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return ImageIterator
     */
    public function getIterator()
    {
        return new ImageIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  Image[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

                    /**
     * Set the value of storage
     *
     * @param  Image[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}