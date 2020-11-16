<?php
namespace YPHP;

class Enum extends BaseEnum implements \JsonSerializable {

    //const VALUE = "value";

    /**
     * @var string
     */
    protected $default;

    /**
     * @var string
     */
    protected $value;

    public function jsonSerialize(){
        return [
            "value" => $this->getValue()
        ];  
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function __construct(string $value = null)
    {
        $this->setValue($value);
    }

    /**
     * Get the value of value
     *
     * @return  string
     */ 
    public function getValue()
    {
        if(!$this->value) $this->value = $this->default;

        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param  string  $value
     *
     * @return  self
     */ 
    public function setValue(string $value = null)
    {
        if(!$value) $value = $this->default;

        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of default
     *
     * @return  string
     */ 
    public function getDefault()
    {
        return $this->default;
    }
}