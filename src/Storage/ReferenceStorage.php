<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\ReferenceIterator;
use YPHP\Reference;

class ReferenceStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return ReferenceIterator
     */
    public function getIterator()
    {
        return new ReferenceIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  Reference[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\Reference[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}