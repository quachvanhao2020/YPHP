<?php
namespace YPHP;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Id\UuidGenerator;

abstract class BaseEntity implements EntityInterface{
    const __ID = "-1";
    const ID = "id";
    const __CLASS = "__class";

    /**
     * 
     * @ORM\Id
     * @ORM\Column(type="string",name="id")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Doctrine\ORM\Id\UuidGenerator")
     * @var string
     */
    protected $id;
    /**
     * 
     *
     * @var string
     */
    protected $class;

    public function __construct(string $id = null)
    {
        if(!$id) $id = self::__ID;
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
        if(!$this->id) $this->id = uniqid();
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
        if(!$this->class) $this->class = get_class($this);
        return $this->class;
    }

    /**
     * Set the value of class
     *
     * @param  string  $class
     *
     * @return  self
     */ 
    public function setClass(string $class = null)
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