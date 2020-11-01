<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\EntityFertilityFinalIterator;
use YPHP\EntityFertilityFinal;

class EntityFertilityFinalStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return EntityFertilityFinalIterator
     */
    public function getIterator()
    {
        return new EntityFertilityFinalIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  EntityFertilityFinal[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  EntityFertilityFinal[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}