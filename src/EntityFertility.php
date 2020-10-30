<?php
namespace YPHP;
use YPHP\EntityFertilityEnum as EntityStatus;
use YPHP\Storage\EntityStorage;
use YPHP\Storage\EntityFertilityStorage;
use DateTime;

class EntityFertility extends Entity{
    const NAME = "name";
    const STATUS = "status";
    const PARENT = "parent";
    const CHILDRENS = "childrens";
    const DATECREATED = "dateCreated";
    const REF = "ref";
    const NOTE = "note";

        /**
     * 
     *
     * @var string
     */
    protected $name;

            /**
     * 
     *
     * @var string
     */
    protected $node;

    /**
     * 
     *
     * @var EntityStatus
     */
    protected $status;
    /**
     * 
     *
     * @var string
     */
    protected $ref;
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

    /**
     * 
     *
     * @var DateTime
     */
    protected $dateCreated;

    public function __toArray(){
        return array_merge([
            self::NAME => $this->getName(),
            self::STATUS => $this->getStatus(),
            self::NOTE => $this->getNode(),
            self::CHILDRENS => $this->getChildrens(),
            self::PARENT => $this->getParent(),
            self::REF => $this->getRef(),
            self::DATECREATED => $this->getDateCreated(),
        ],parent::__toArray());
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setName(@$array[self::NAME]);
        $this->setStatus(@$array[self::STATUS]);
        $this->setNode(@$array[self::NOTE]);
        $this->setChildrens(@$array[self::CHILDRENS]);
        $this->setParent(@$array[self::PARENT]);
        $this->setRef(@$array[self::REF]);
        $dateCreated = @$array[self::DATECREATED];
        if($dateCreated instanceof \DateTime){
            
        }else if(is_string($dateCreated)){
            $dateCreated = @\DateTime::createFromFormat('Y-m-d H:i:s',$dateCreated);
        }
        $this->setDateCreated($dateCreated);
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
        return $this->childrens;
    }

    /**
     * Set the value of childrens
     *
     * @param  EntityFertilityStorage  $childrens
     *
     * @return  self
     */ 
    public function setChildrens($childrens = [])
    {
        if($childrens == null || is_array($childrens)) $childrens = new EntityFertilityStorage($childrens);
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

    /**
     * Get the value of ref
     *
     * @return  string
     */ 
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set the value of ref
     *
     * @param  string  $ref
     *
     * @return  self
     */ 
    public function setRef(string $ref = null)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get the value of dateCreated
     *
     * @return  DateTime
     */ 
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set the value of dateCreated
     *
     * @param  DateTime  $dateCreated
     *
     * @return  self
     */ 
    public function setDateCreated(DateTime $dateCreated = null)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  string
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  string  $status
     *
     * @return  self
     */ 
    public function setStatus(string $status = null)
    {
        if(!EntityStatus::isValidValue($status)) $status = EntityStatus::VIRUS;
        $this->status = $status;
        return $this;
    }

    /**
     * Get the value of node
     *
     * @return  string
     */ 
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set the value of node
     *
     * @param  string  $node
     *
     * @return  self
     */ 
    public function setNode(string $node = null)
    {
        $this->node = $node;

        return $this;
    }
}