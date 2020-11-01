<?php

use YPHP\Attribute;
use YPHP\AttributeFilter;
use YPHP\EntityFertilityFinal;
use YPHP\Storage\AttributeStorage;
use YPHP\Storage\EntityFertilityStorage;

require_once "vendor/autoload.php";

$e1 = new EntityFertilityFinal(1);
$e1->setAttributes(new AttributeStorage([
    new Attribute(11),
]));

$e2 = new EntityFertilityFinal(2);

$e2->setAttributes(new AttributeStorage([
    new Attribute(11),
    new Attribute(22),
]));

$st = new EntityFertilityStorage([
    $e1,$e2,
]);

$filter = new AttributeFilter();
$filter->setAttributes(new AttributeStorage([
    new Attribute(11),
    new Attribute(22),
]));

$filter->filter($st);

var_dump($st);

var_dump($filter);