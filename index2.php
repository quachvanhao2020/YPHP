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

/** @var EntityFertility */
$result = $fm->get($entity->uniqid(true));

$result->setName("update");
//$result->getChildrens()[0]->setChildrens([]);
//$result->setChildrens([]);
//var_dump($result);

$fm->update($result->uniqid(),$result);

//$result = $fm->get($result->uniqid());

var_dump($result);