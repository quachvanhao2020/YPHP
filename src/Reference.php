<?php
namespace YPHP;

use YPHP\EntityFertility;
use LaminasShare\Storage\ReferenceStorage;

class Reference extends EntityFertility{
    const OBJECT = "object";
    /**
     * @var object
     */
    protected $object;

    public function __toArray(){
        return array_merge([
            self::OBJECT => $this->getObject(),
        ],parent::__toArray());
    }
    
    public function ___construct($object)
    {
        parent::__construct(get_class($object));
        $this->object = $object;
    }

    /**
     * Get the value of object
     *
     * @return  object
     */ 
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set the value of object
     *
     * @param  object  $object
     *
     * @return  self
     */ 
    public function setObject(object $object)
    {
        $this->object = $object;

        return $this;
    }

        /**
     * Set the value of childrens
     *
     * @param  \LaminasShare\Storage\ReferenceStorage  $childrens
     *
     * @return  self
     */ 
    public function setChildrens($childrens = null)
    {
        return parent::setChildrens($childrens);
    }
}