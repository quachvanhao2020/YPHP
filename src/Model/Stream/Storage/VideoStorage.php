<?php
namespace YPHP\Model\Stream\Storage;

use YPHP\ArrayObject;
use YPHP\Model\Stream\Video;
use YPHP\Model\Stream\Storage\Iterator\VideoIterator;

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
     * @param  \YPHP\Model\Stream\Video[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}