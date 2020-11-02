<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\EntityFertilityIterator;
use YPHP\EntityFertility;

class EntityFertilityStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return EntityFertilityIterator
     */
    public function getIterator()
    {
        return new EntityFertilityIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  EntityFertility[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\EntityFertility[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}