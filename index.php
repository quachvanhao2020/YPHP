<?php

use YPHP\EntityStatistical;
use YPHP\Filter\StatisticalFilter;
use YPHP\Storage\EntityStatisticalStorage;

require_once "vendor/autoload.php";

$d = new DateTime('2011-01-01');
$d1 = new DateTime('2011-01-03');

$s = new EntityStatisticalStorage([
    (new EntityStatistical())->setDateCreated($d),
    (new EntityStatistical())->setDateCreated($d1),
]);

$filter = new StatisticalFilter;
$filter->setDateStart($d);
$dd = clone $d;
//$filter->setDateEnd($dd->modify("+1 day"));

$filter->filter($s);

var_dump($s);
