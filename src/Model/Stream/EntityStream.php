<?php
namespace YPHP\Model\Stream;
use YPHP\Entity;
use Psr\Http\Message\StreamInterface;
use YPHP\Stream;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * \@ORM\InheritanceType("JOINED") 
 * @ORM\InheritanceType("SINGLE_TABLE") 
 * @ORM\DiscriminatorColumn(name="dtype", type="string")
 * @ORM\DiscriminatorMap({"stream" = "YPHP\Model\Stream\EntityStream","image" = "YPHP\Model\Stream\Image", "video" = "YPHP\Model\Stream\Video"})
 * @ORM\Table(name="streams")
 */
class EntityStream extends Entity{
    const STREAM = "stream";

    /**
     * 
     * @ORM\Id
     * @ORM\Column(type="string",name="id")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Doctrine\ORM\Id\UuidGenerator")
     * @var string
     */
    protected $id;

    public function __toArray() {
        return array_merge(parent::__toArray(),[
            self::STREAM => $this->getStream(),
        ]);
    }

    /**
     * @ORM\Embedded(class = "YPHP\Stream")
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
        if(!$this->stream) $this->stream = new Stream();
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