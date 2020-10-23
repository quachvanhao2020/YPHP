<?php
use YPHP\Entity;
use YPHP\EntityFactory;

require_once "vendor/autoload.php";

$entity = new Entity("abc");
$entity->setContainer(new EntityFactory());
$entity->instance();

var_dump($entity);