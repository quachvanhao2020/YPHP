<?php
namespace YPHP;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Orm{
    
    public static function getPaths(){
        return [
            __DIR__,
        ];
    }
    public static function getConnection(){
        return [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__.'/../data/db.sqlite',
        ];
    }
    public static function getEntityManager(){
        $config = Setup::createAnnotationMetadataConfiguration(Orm::getPaths(),true,null,null,false);
        $entityManager = EntityManager::create(Orm::getConnection(), $config);
        return $entityManager;
    }
}