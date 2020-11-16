<?php
namespace YPHP\Model\Media;
use YPHP\Entity;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\StreamInterface;

class EntityMedia extends Entity{
    const STREAM = "stream";

    public function __toArray() {
        return array_merge(parent::__toArray(),[
            self::STREAM => $this->getStream(),
        ]);
    }

        /**
     * @var StreamInterface
     */
    protected $stream;

        /**
     * Get the value of stream
     *
     * @return  StreamInterface
     */ 
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the value of stream
     *
     * @param  StreamInterface  $stream
     *
     * @return  self
     */ 
    public function setStream(StreamInterface $stream = null)
    {
        $this->stream = $stream;

        return $this;
    }
}