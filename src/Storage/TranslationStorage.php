<?php
namespace YPHP\Storage;

use YPHP\ArrayObject;
use YPHP\Storage\Iterator\TranslationIterator;
use YPHP\Entity;
use YPHP\Translation;

class TranslationStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return TranslationIterator
     */
    public function getIterator()
    {
        return new TranslationIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  \YPHP\Translation[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YPHP\Translation[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}