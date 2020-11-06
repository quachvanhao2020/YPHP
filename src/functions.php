<?php
use YPHP\Entity;
use YPHP\Translation;
use YPHP\TranslationService;
use YPHP\ArrayObject;
use YPHP\Mapper;
use YPHP\SEOEntity;

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
    if(is_object($current)){
        if(get_class($current) == $target){
            return $current;
        }
    }
    if(is_string($current)){
        $translation = new Translation($current,$target);
        $result = TranslationService::getInstance()->translate($translation,null);
        if($result) return $result;
    }
    if($current instanceof Entity){
        if($target instanceof Entity && get_class($current) == get_class($target)){
            $target->__arrayTo($current->__toArray());
        }
        $translation = new Translation(get_class($current),$target);
        $translation->setCurrentEntity($current);
        $result = TranslationService::getInstance()->translate($translation,null);
        return $result;
    }
    if(is_string($current)){
        $current = \json_decode($current);
    }
    if(is_string($target)){
        if (class_exists($target)) {
            $target = new $target(); 
        }else return;
    }
    if(is_array($current)){
        $current = \array_to_object($current);
    }
    if($current instanceof \stdClass){
        $map = new Mapper();
        $result = $map->map($current,$target);
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
function search($entity,$key = "",&$result = []){
    /** @var SEOEntity $entity */
    if($entity instanceof Entity){
        if(method_exists($entity,"getKeywords")){
            $keys = $entity->getKeywords();
            $key = array_search($key, $keys);
            if($key!==false){
                array_push($result,$entity);
            }
        }
        $entity = arr($entity);
    }
    if(is_iterable($entity)){
        foreach ($entity as $value) {
            \search($value,$key,$result);
        }
    }
    return $result;
}