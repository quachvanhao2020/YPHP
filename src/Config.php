<?php
namespace YPHP;
use YPHP\Storage\AttributeStorage;

class Config extends EntityLife{
    const ATTRIBUTES = "attributes";

        /**
     * @var AttributeStorage
     */
    protected $attributes;

    public function __toArray(){
        return array_merge([
            self::ATTRIBUTES => $this->getAttributes(),
        ],parent::__toArray());
    }
    /**
     * Get the value of attributes
     *
     * @return  AttributeStorage
     */ 
    public function getAttributes()
    {
        if(!$this->attributes) $this->attributes = new AttributeStorage();

        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @param  AttributeStorage  $attributes
     *
     * @return  self
     */ 
    public function setAttributes(?AttributeStorage $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }
}