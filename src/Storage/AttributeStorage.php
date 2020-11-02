<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\AttributeIterator;
use YPHP\Attribute;

class AttributeStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return AttributeIterator
     */
    public function getIterator()
    {
        return new AttributeIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  Attribute[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\Attribute[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}