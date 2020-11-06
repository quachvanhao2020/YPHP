<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\EntityLifeIterator;
use YPHP\EntityLife;

class EntityLifeStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return EntityLifeIterator
     */
    public function getIterator()
    {
        return new EntityLifeIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  EntityLife[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\EntityLife[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}