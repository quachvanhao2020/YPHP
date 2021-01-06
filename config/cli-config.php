<?php
use YPHP\Orm;
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(Orm::getEntityManager());
