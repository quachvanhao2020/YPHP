<?php
namespace YPHP;

abstract class BaseEntity implements EntityInterface{
    const ID = "id";
    const __CLASS = "__class";

    /**
     * 
     *
     * @var string
     */
    protected $id;
    /**
     * 
     *
     * @var string
     */
    protected $class;

    public function __construct($id = null)
    {
        $this->setId($id);
        $this->class = get_class($this);
    }

    /**
     * Get the value of id
     *
     * @return  string
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  string  $id
     *
     * @return  self
     */ 
    public function setId(string $id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of class
     *
     * @return  string
     */ 
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the value of class
     *
     * @param  string  $class
     *
     * @return  self
     */ 
    public function setClass(string $class = "")
    {
        $this->class = $class;

        return $this;
    }

    public function __toStd(){
        return (object)$this->__toArray();
    }

    public function __toArray()
    {
        return [
            self::ID => $this->getId(),
            self::__CLASS => $this->getClass(),
        ];
    }

    public function __arrayTo($array)
    {
        $this->setId(@$array[self::ID]);
        $this->setClass(@$array[self::__CLASS]);
    }
}