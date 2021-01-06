<?php
namespace YPHP\Model\Stream;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="images")
 */
class Image extends EntityStream{

    const SRC = "src";
    const ALT = "alt";
    const WIDTH = "width";
    const HEIGHT = "height";
    const THUMB = "thumb";

    /**
     * @ORM\ManyToOne(targetEntity="YPHP\Model\Stream\Image", inversedBy="children",cascade={"persist"})
     * @var Image
     */
    protected $thumb;

    public function __toArray() {
        return array_merge(parent::__toArray(),[
            self::SRC => $this->getSrc(),
            self::ALT => $this->getAlt(),
            self::WIDTH => $this->getWidth(),
            self::HEIGHT => $this->getHeight(),
            self::THUMB => $this->getThumb(),
        ]);
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setSrc(@$array[self::SRC]);
        $this->setAlt(@$array[self::ALT]);
        $this->setWidth(@$array[self::WIDTH]);
        $this->setHeight(@$array[self::HEIGHT]);
        $this->setThumb(@$array[self::THUMB]);
    }

    /**
     * 
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $src;

    /**
     * 
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $alt;

    /**
     * 
     * @ORM\Column(type="integer",nullable=true)
     * @var int
     */
    protected $width;

    /**
     * 
     *
     * @ORM\Column(type="integer",nullable=true)
     * @var int
     */
    protected $height;

    /**
     * Get the value of src
     *
     * @return  string
     */ 
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set the value of src
     *
     * @param  string  $src
     *
     * @return  self
     */ 
    public function setSrc(string $src = null)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get the value of alt
     *
     * @return  string
     */ 
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set the value of alt
     *
     * @param  string  $alt
     *
     * @return  self
     */ 
    public function setAlt(string $alt = null)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get the value of width
     *
     * @return  int
     */ 
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of width
     *
     * @param  int  $width
     *
     * @return  self
     */ 
    public function setWidth($width)
    {
        $width = $width ?: 0;

        $this->width = $width;

        return $this;
    }

    /**
     * Get the value of height
     *
     * @return  int
     */ 
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of height
     *
     * @param  int  $height
     *
     * @return  self
     */ 
    public function setHeight($height)
    {
        $height = $height ?: 0;

        $this->height = $height;

        return $this;
    }

    /**
     * Get the value of thumb
     *
     * @return  Image
     */ 
    public function getThumb()
    {
        //if(!$this->thumb) $this->thumb = new Image();
        return $this->thumb;
    }

    /**
     * Set the value of thumb
     *
     * @param  Image  $thumb
     *
     * @return  self
     */ 
    public function setThumb(Image $thumb = null)
    {
        $this->thumb = $thumb;

        return $this;
    }
}