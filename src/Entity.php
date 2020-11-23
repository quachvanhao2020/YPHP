<?php
namespace YPHP;

class Entity extends BaseEntity implements SerializableInterface
{
    use ContainerInject;

    public function uniqid(){
        $id = $this->getId();
        if(!$id){
            $id = uniqid();
        }
        return $id;
    }

    public function __debugInfo()
    {
        return arr($this);
    }

    public function __toString()
    {
        return (string)\json_encode($this->__toArray());
    }

    public function jsonSerialize() {
        return $this->__toArray();
    }
    
    public function destroy(){}

}