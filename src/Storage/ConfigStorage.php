<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\ConfigIterator;
use YPHP\Config;

class ConfigStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return ConfigIterator
     */
    public function getIterator()
    {
        return new ConfigIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  Config[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\Config[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}