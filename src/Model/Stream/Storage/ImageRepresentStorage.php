<?php
namespace YPHP\Model\Stream\Storage;

use YPHP\ArrayObject;
use YPHP\Model\Stream\ImageRepresent;
use YPHP\Model\Stream\Storage\Iterator\ImageRepresentIterator;

class ImageRepresentStorage extends ArrayObject{

            /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return ImageRepresentIterator
     */
    public function getIterator()
    {
        return new ImageRepresentIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  ImageRepresent[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

                    /**
     * Set the value of storage
     *
     * @param  \YPHP\Model\Stream\ImageRepresent[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}