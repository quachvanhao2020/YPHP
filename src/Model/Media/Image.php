<?php
namespace YPHP\Model\Media;

use YPHP\Entity;

class Image extends Entity {

    const SRC = "src";
    const ALT = "alt";
    const WIDTH = "width";
    const HEIGHT = "height";

    public function __toArray() {
        return array_merge(parent::__toArray(),[
            self::SRC => $this->getSrc(),
            self::ALT => $this->getAlt(),
            self::WIDTH => $this->getWidth(),
            self::HEIGHT => $this->getHeight(),
        ]);
    }

        /**
     * 
     *
     * @var string
     */
    protected $src;

        /**
     * 
     *
     * @var string
     */
    protected $alt;

            /**
     * 
     *
     * @var int
     */
    protected $width;

                /**
     * 
     *
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
    public function setSrc(string $src)
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
}