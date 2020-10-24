<?php
namespace YPHP\Model\Html;

class A extends Element{

    /** @var string */

    protected $href;
    
    public function __construct($href = "")
    {
        $this->setHref($href);

        return $this;
    }

    /**
     * Get the value of href
     */ 
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Set the value of href
     *
     * @return  self
     */ 
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }
}