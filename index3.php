<?php
require_once "vendor/autoload.php";
use YPHP\Entity;
use YPHP\Model\Media\Image;

$entity = new Image(222);
$entity = arr($entity);
$entity = tran($entity,Image::class);
var_dump($entity);