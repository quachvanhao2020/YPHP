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