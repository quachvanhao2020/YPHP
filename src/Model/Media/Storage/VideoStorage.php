<?php
namespace YPHP\Model\Media\Storage;

use YPHP\ArrayObject;
use YPHP\Model\Media\Video;
use YPHP\Model\Media\Storage\Iterator\VideoIterator;

class VideoStorage extends ArrayObject{

            /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return VideoIterator
     */
    public function getIterator()
    {
        return new VideoIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  Video[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

                    /**
     * Set the value of storage
     *
     * @param  Video[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}