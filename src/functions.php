<?php

use YPHP\Entity;
use YPHP\Translation;
use YPHP\TranslationService;
use YPHP\ArrayObject;
function std($object){
    return $object->__toStd();
}
function arr($object){
    if($object instanceof Entity){
        $array = $object->__toArray();
        foreach ($array as $key => $value) {
            if($value instanceof ArrayObject){
                $array[$key] = $value->__toArray();
            }
        }
        return $array;
    }
    return (array)$object;
}
function obj_to($obj,$entity = null){
    if(!$entity){
        if(isset($obj["id"]) && isset($obj["__class"])){
            $class = $obj["__class"];
            $entity = new $class();
        }
    }
    if($entity instanceof Entity){
      if(is_string($obj)){
        $obj = \json_decode($obj,JSON_OBJECT_AS_ARRAY);
      }
      if(is_iterable($obj)){
          foreach ($obj as $key => $value) {
              if(isset($value["id"]) && isset($value["__class"])){
                  $class = $value["__class"];
                  $obj[$key] = \obj_to($value,new $class());
              }
          }
        $entity->__arrayTo($obj);
      }
    }
    return $entity;
}
function tran($current,$target){
    $result = null;
    if($current instanceof Entity){
        if($target instanceof Entity && get_class($current) == get_class($target)){
            $target->__arrayTo($current->__toArray());
        }
        $translation = new Translation(get_class($current),$target);
        $translation->setCurrentEntity($current);
        $result = TranslationService::getInstance()->translate($translation,null);
    }
    return $result;
}
function save($entity){
    if($entity instanceof Entity){
        return $entity->save();
    }
}

function destroy($entity){
    if($entity instanceof Entity){
        return $entity->destroy();
    }
}

function object_to_array($object){
    return \json_decode(\json_encode($object),true);
}

function array_to_object($array) {
    $obj = new \stdClass;
    foreach($array as $k => $v) {
       if(strlen($k)) {
          if(is_array($v)) {
             $obj->{$k} = array_to_object($v);
          } else {
             $obj->{$k} = $v;
          }
       }
    }
    return $obj;
}