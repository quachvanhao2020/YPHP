<?php
namespace YPHP;

class Entity extends BaseEntity implements SerializableInterface
{

    use ContainerInject;

    public function uniqid($force = false){
        //if(($this->container instanceof ManagerFactory) || $force){return $this->getClass()."-".$this->getId();}
        return $this->getId();
    }


    public function __debugInfo()
    {
        return arr($this);
    }

    public function __toString()
    {
        return \json_encode($this->__toArray());
    }

    public function jsonSerialize() {
        return $this->__toArray();
    }
    public function destroy(){}

}