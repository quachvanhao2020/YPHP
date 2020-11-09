<?php

use YPHP\Entity;
use YPHP\EntityFertility;
use YPHP\EntityStatusEnum;

require_once "vendor/autoload.php";

$null = new Entity(333);
$null->setId();