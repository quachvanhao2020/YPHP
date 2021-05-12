<?php
namespace YPHP;

class Bundle extends Entity{
    
    const OWNER = "owner";
    const TYPE = "type";
    const OBJECT = "object";

    /**
     * @var string
     */
    protected $owner;

        /**
     * @var string
     */
    protected $type;

        /**
     * @var mixed
     */
    protected $object;

    public function __construct(string $owner,$object,string $type = "")
    {
        $this->setOwner($owner)->setObject($object)->setType($type);
    }

    public function __toArray(){
        return array_merge([
            self::OWNER => $this->getOwner(),
            self::TYPE => $this->getType(),
            self::OBJECT => $this->getObject(),
        ],parent::__toArray());
    }

    /**
     * Get the value of owner
     *
     * @return  string
     */ 
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set the value of owner
     *
     * @param  string  $owner
     *
     * @return  self
     */ 
    public function setOwner(string $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return  string
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param  string  $type
     *
     * @return  self
     */ 
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of object
     *
     * @return  mixed
     */ 
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set the value of object
     *
     * @param  mixed  $object
     *
     * @return  self
     */ 
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }
}