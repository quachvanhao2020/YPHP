<?php
namespace YPHP;

class Attribute extends EntityFertility{

    const KEY = "key";
    const VALUE = "value";
    const STRATEGY = "strategy";

    public function __toArray()
    {
        return array_merge(parent::__toArray(),[
            self::KEY => $this->getKey(),
            self::VALUE => $this->getValue(),
            self::STRATEGY => $this->setStrategy()
        ]);
    }

    public function __arrayTo($array)
    {
        $this->setKey(@$array[self::KEY]);
        $this->setValue(@$array[self::VALUE]);
        $this->setStrategy(@$array[self::STRATEGY]);
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
    protected $strategy;

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
    public function setKey(string $key = null)
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
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }


    /**
     * Get the value of strategy
     *
     * @return  string
     */ 
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * Set the value of strategy
     *
     * @param  string  $strategy
     *
     * @return  self
     */ 
    public function setStrategy(string $strategy = null)
    {
        $this->strategy = $strategy;

        return $this;
    }
}