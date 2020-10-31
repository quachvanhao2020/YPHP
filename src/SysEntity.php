<?php
namespace YPHP;

class SysEntity extends BaseEntity{
    public function __construct($id,$class)
    {
        $this->id = $id;
        $this->class = $class;
    }
    public static function entityTo(EntityInterface $entity){
        return new self($entity->getId(),$entity->getClass());
    }
    public function __toString()
    {
        return $this->getClass()."-".$this->getId();
    }
    public static function __stringTo($string){
        $param = explode("-",$string);
        return new self($param[0],$param[1]);
    }
}