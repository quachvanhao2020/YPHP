<?php
namespace YPHP;
use YPHP\Storage\AttributeStorage;
use ArrayAccess;

class AttributeFilter implements FilterInputInterface{

    /**
     * @var AttributeStorage
     */
    protected $attributes;


    /**
     * @param AttributeStorage $result
     * @return mixed
     */
    function filter(ArrayAccess &$result){
        foreach ($result as $key => $value) {
            if($value instanceof EntityFertilityFinal){
                $attributes = $value->getAttributes();
                if(!($attributes instanceof AttributeStorage) || !$this->checkAttributes($attributes)){
                    unset($result[$key]);
                };
            }
        }
        return $result;
    }

    public function checkAttributes(AttributeStorage $attributes){
        $attributes->indexing();
        foreach ($this->getAttributes() as $key => $value) {
            if(!isset($attributes[$key])){
                return false;
            }
        }
        return true;
    }

    /**
     * Get the value of attributes
     *
     * @return  AttributeStorage
     */ 
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @param  AttributeStorage  $attributes
     *
     * @return  self
     */ 
    public function setAttributes(AttributeStorage $attributes)
    {
        $attributes->indexing();

        $this->attributes = $attributes;

        return $this;
    }
}