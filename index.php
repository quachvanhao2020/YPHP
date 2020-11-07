<?php

use YPHP\EntityFertility;
use YPHP\EntityStatusEnum;

require_once "vendor/autoload.php";

$entity = new EntityFertility("22");
$entity->setDateCreated(new DateTime("2020-11-06 12:00:00.000000"));
$entity->setStatus(EntityStatusEnum::FREEZE);
$json = json_encode($entity,JSON_PRETTY_PRINT);

$entity = \tran($json,EntityFertility::class); 

var_dump($json);var_dump($entity);