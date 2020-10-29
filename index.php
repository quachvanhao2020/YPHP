<?php
require_once "vendor/autoload.php";
use YPHP\Entity;
use YPHP\EntityFactory;
use YPHP\EntityFertility;
use YPHP\EntityFertilityEnum;
use YPHP\Mapper;
use YPHP\SimpleCache;

$map = new Mapper();
$entity = new Entity("abcd");
$fa = new EntityFactory();
$fa->setCache(new SimpleCache());
$fa->update("abcd",$entity);

$entity->setContainer($fa);
$entity->instance();
var_dump($entity);
return;
/** @var EntityFertility */
$entity = tran($entity,EntityFertility::class);
$entity->setStatus(EntityFertilityEnum::ACTIVE);
$entity = arr($entity);
$entity = $map->map((object)$entity,new EntityFertility());
var_dump($entity);
