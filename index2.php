<?php
require_once "vendor/autoload.php";
use YPHP\Entity;
use YPHP\EntityFactory;
use YPHP\EntityFertility;
use YPHP\EntityFertilityEnum;
use YPHP\EntityFertilityFactory;
use YPHP\ManagerFactory;
use YPHP\Mapper;
use YPHP\SimpleCache;
use YPHP\Storage\EntityFertilityStorage;
use YPHP\SysEntity;

$fm = new ManagerFactory();


$entity = new EntityFertility("Foo");
$entity2 = new EntityFertility("SonFoo");
$entity3 = new EntityFertility("SonFoo2");

$entity->setChildrens(new EntityFertilityStorage([
    $entity2,
    $entity3,
]));

$fa = new EntityFertilityFactory();
$fa->setCache(new SimpleCache());
$fm->setMap([
    EntityFertility::class => $fa,
    Entity::class => Entity::class,
]);

//$fm->update("Foo",$entity);

$sid = SysEntity::entityTo($entity);
/** @var EntityFertility */
$result = $fm->get($sid);

$result->setName("update2");
$result->getChildrens()[0]->setNote("hello");
//$result->setChildrens([]);
//var_dump($result);

$fm->update($sid,$result);

//$result = $fm->get($result->uniqid());

var_dump($result);