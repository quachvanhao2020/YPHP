<?php

use YPHP\SEOEntity;

require_once "vendor/autoload.php";

$e1 = new SEOEntity(0);
$e1->setKeywords(["e1","e11"]);

$e3 = new SEOEntity(3);
$e3->setKeywords(["e11","e1"]);

$e2 = new SEOEntity(1);
$e2->setKeywords(["e2","e12","e1"]);

$result = [];

search([$e1,$e3,["dd"=>$e2]],"e1",$result);

var_dump($result);