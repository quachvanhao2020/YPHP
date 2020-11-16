<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\EntityIterator;
use YPHP\Entity;

class EntityStorage extends ArrayObject implements EntityStorageInterface{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return EntityIterator
     */
    public function getIterator()
    {
        return new EntityIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  Entity[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\Entity[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}