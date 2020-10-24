<?php
namespace YPHP\Model\Html;

class Element{

    /** @var string */
    protected $inner;


    /**
     * Get the value of inner
     */ 
    public function getInner()
    {
        return $this->inner;
    }

    /**
     * Set the value of inner
     *
     * @return  self
     */ 
    public function setInner($inner)
    {
        $this->inner = $inner;

        return $this;
    }
}