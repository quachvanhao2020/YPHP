<?php

use YPHP\Entity;
use YPHP\Translation;
use YPHP\TranslationService;

function std($object){
    return $object->__toStd();
}
function arr($object){
    return $object->__toArray();
}
function tran($current,$target){
    $result = null;
    if($current instanceof Entity){
        $translation = new Translation(get_class($current),$target);
        $translation->setCurrentEntity($current);
        $result = TranslationService::getInstance()->translate($translation,null);
    }
    return $result;
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