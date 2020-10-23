<?php

function std($object){
    return $object->__toStd();
}

function arr($object){
    return $object->__toArray();
}