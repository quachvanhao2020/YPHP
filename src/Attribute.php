<?php
namespace YPHP;

class Attribute extends EntityFertility{

    const KEY = "key";
    const VALUE = "value";

    public function __toArray()
    {
        return array_merge(parent::__toArray(),[
            self::KEY => $this->getKey(),
            self::VALUE => $this->getValue(),
        ]);
    }

    public function __arrayTo($array)
    {
        $this->setKey(@$array[self::KEY]);
        $this->setValue(@$array[self::VALUE]);
    }

    /**
     * @var string
     */
    protected $key;

        /**
     * @var object
     */
    protected $value;

    /**
     * Get the value of key
     *
     * @return  string
     */ 
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the value of key
     *
     * @param  string  $key
     *
     * @return  self
     */ 
    public function setKey(string $key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return  object
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param  object  $value
     *
     * @return  self
     */ 
    public function setValue(object $value = null)
    {
        $this->value = $value;

        return $this;
    }
}