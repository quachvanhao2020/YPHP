<?php
require_once "vendor/autoload.php";
use YPHP\Entity;
use YPHP\EntityFactory;
use YPHP\EntityFertility;
use YPHP\EntityFertilityEnum;
use YPHP\Mapper;
$map = new Mapper();
$entity = new Entity("abc");
$entity->setContainer(new EntityFactory());
$entity->instance();
/** @var EntityFertility */
$entity = tran($entity,EntityFertility::class);
$entity->setStatus(EntityFertilityEnum::ACTIVE);
$entity = arr($entity);
$entity = $map->map((object)$entity,new EntityFertility());
var_dump($entity);
