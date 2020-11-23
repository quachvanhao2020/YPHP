<?php
use YPHP\Entity;
use YPHP\Translation;
use YPHP\TranslationService;
use YPHP\ArrayObject;
use YPHP\Mapper;
use YPHP\SEOEntity;
use YPHP\EntityFertility;
use YPHP\Filter\AwareSEOInterface;

function std($object){
    return $object->__toStd();
}
function arr($object){
    if(method_exists($object,"__toArray")){
        return $object->__toArray();
    }
    if($object instanceof Entity){
        $array = $object->__toArray();
        foreach ($array as $key => $value) {
            if($value instanceof ArrayObject){
                //$array[$key] = $value->__toArray();
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
function tran($current,$target = null,$value = null){
    $result = null;
    if(!$value) $value = $current;
    if(is_object($current)){
        if(get_class($current) == $target){
            return $current;
        }
    }
    if($target){
        if($current instanceof Entity){
            if($target instanceof Entity && get_class($current) == get_class($target)){
                $target->__arrayTo($current->__toArray());
            }
            $translation = new Translation(get_class($current),$target);
            $translation->setCurrentEntity($value);
            $result = TranslationService::getInstance()->translate($translation,null);
            return $result;
        }
        if(is_string($current)){
            $translation = new Translation($current,$target);
            $translation->setCurrentEntity($value);
            $result = TranslationService::getInstance()->translate($translation,null);
            if($result) return $result;
        }
        $translation = new Translation(gettype($current),$target);
        $translation->setCurrentEntity($value);
        $result = TranslationService::getInstance()->translate($translation,null);
        if($result) return $result;
    }
    if(is_string($current)){
        $current = \json_decode($current);
    }
    if(is_array($current)){
        $current = \array_to_object($current);
    }
    if($current instanceof \stdClass){
        if($target == null){
            if(isset($current->__class)){
                $target = $current->__class;
            }else{
                $target = \stdClass::class;
            }
        }
        if(is_string($target)){
            if (class_exists($target)) {
                $target = new $target(); 
            }else return;
        }
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
        if($entity instanceof AwareSEOInterface){
            $keys = $entity->getSEOEntity()->getKeywords();
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
function time_elapsed_string($datetime,$full = false,$locate = "en_GB") {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        $v = "<tran>".$v."</tran>";
        if ($diff->$k) {
            if($locate == "en_GB"){
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            }else{
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            }
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return ($string ? implode(', ', $string) . ' <tran>ago' : '<tran>just_now')."</tran>";
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function iterable_walk_recursive(iterable $iterable,callable $callable){
    foreach ($iterable as $key => $value) {
        $callable($key,$value);
        if(is_iterable($value)){
            iterable_walk_recursive($value,$callable);
        }
    }
}
function blobParentEntity($entity,callable $callable){
    $callable($entity);
    if($entity instanceof EntityFertility){
        if($entity->getParent() instanceof Entity){
            blobParentEntity($entity->getParent(),$callable);
        }
    }
}
function parse_form_data(&$data){
    (array_walk_lazy($data,function($key,&$value){
        if(is_only_number_key($value)){
            $value = \array_values(array_merge_self($value));
            return $value;
        }
    }));
    return $data;
}
function array_walk_lazy(&$array,callable $callable){
    foreach ($array as $key => &$value) {
        if(is_callable($callable)){
            $callable($key,$value);
        }
        if(is_array($value)){
            \array_walk_lazy($value,$callable);
        }
    }
}
function is_only_number_key($array){
    if(!is_array($array)) return;
    foreach ($array as $key => $value) {
       if(!is_numeric($key)) return false;
    }
    return true;
}
function array_merge_self(array $arr){
    $_firstKey = null;
    $_key = null;
    foreach ($arr as $key => $value) {
        $firstKey = array_key_first($value);
        if(!$_firstKey) $_firstKey = $firstKey;
        if($_firstKey){
            if($firstKey == $_firstKey){
                $_key = $key;
            }else{
                $arr[$_key] = array_merge($arr[$_key],$value);
                unset($arr[$key]);
            }
        }
    }
    return $arr;
}
function array_map_recursive($callback, $array)
{
  $func = function ($item) use (&$func, &$callback) {
    return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
  };

  return array_map($func, $array);
}