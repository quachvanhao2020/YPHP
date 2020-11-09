<?php
namespace YPHP;
use YPHP\EntityFertilityEnum as EntityStatus;
use YPHP\Storage\EntityStorage;
use YPHP\Storage\EntityFertilityStorage;
use DateTime;

class EntityFertility extends EntityLife implements \IteratorAggregate{
    const PARENT = "parent";
    const CHILDRENS = "childrens";

    public function getIterator() {
        return $this->getChildrens();
    }
    /**
     * 
     *
     * @var Entity
     */
    protected $parent;
    /**
     * 
     *
     * @var EntityStorage
     */
    protected $childrens;

    public function __toArray(){
        return array_merge([
            self::CHILDRENS => $this->getChildrens(),
            self::PARENT => $this->getParent(),
        ],parent::__toArray());
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setChildrens(@$array[self::CHILDRENS]);
        $this->setParent(@$array[self::PARENT]);
    }

    public function jsonSerialize() {
        $array = $this->__toArray();
        $parent = $this->getParent();
        if($parent instanceof self){
            $parent = clone $parent;
            $parent->setChildrens([]);
            $array[self::PARENT] = $parent;
        }
        return $array;
    }

    /**
     * Get the value of childrens
     *
     * @return  EntityStorage
     */ 
    public function getChildrens()
    {
        if(!$this->childrens) $this->childrens = new EntityStorage();
        return $this->childrens;
    }

    /**
     * Set the value of childrens
     *
     * @param  \YPHP\Storage\EntityFertilityStorage  $childrens
     *
     * @return  self
     */ 
    public function setChildrens($childrens = null)
    {
        if(is_iterable($childrens)){
            foreach ($childrens as $key => $value) {
                if($value instanceof EntityFertility){
                    $value->setParent($this);
                }
            }
        }
        $this->childrens = $childrens;
        return $this;
    }

    /**
     * Get the value of parent
     *
     * @return  Entity
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @param  Entity  $parent
     *
     * @return  self
     */ 
    public function setParent($parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

}