<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\EntityStatisticalIterator;
use YPHP\EntityStatistical;

class EntityStatisticalStorage extends EntityStorage{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return EntityStatisticalIterator
     */
    public function getIterator()
    {
        return new EntityStatisticalIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  EntityStatistical[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\EntityStatistical[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}