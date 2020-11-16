<?php
namespace YPHP;

class Attribute extends EntityFertility{

    const KEY = "key";
    const VALUE = "value";
    const STRINGVALUE = "stringValue";

    public function __toArray()
    {
        return array_merge(parent::__toArray(),[
            self::KEY => $this->getKey(),
            self::VALUE => $this->getValue(),
            self::STRINGVALUE => $this->getStringValue(),
        ]);
    }

    public function __arrayTo($array)
    {
        $this->setKey(@$array[self::KEY]);
        $this->setValue(@$array[self::VALUE]);
        $this->setStringValue(@$array[self::STRINGVALUE]);
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
     * @var string
     */
    protected $stringValue;

    /**
     * Get the value of key
     *
     * @return  string
     */ 
    public function getKey()
    {
        if(!$this->key) $this->key = "";
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
        if(!$this->value) $this->value = "";
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

        /**
     * Get the value of stringValue
     *
     * @return  string
     */ 
    public function getStringValue()
    {
        if(!$this->stringValue) $this->stringValue = "";

        return $this->stringValue;
    }

    /**
     * Set the value of stringValue
     *
     * @param  string  $stringValue
     *
     * @return  self
     */ 
    public function setStringValue(string $stringValue = null)
    {
        $this->stringValue = $stringValue;
        return $this;
    }
}