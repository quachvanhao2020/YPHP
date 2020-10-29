<?php
namespace YPHP;
use YPHP\StorageInterface;

trait CacheInject{
    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * Get the value of cache
     *
     * @return  StorageInterface
     */ 
    public function getCache()
    {
        return $this->cache;
    }

    public static function theClass(){
        return static::class;
    }

    /**
     * Set the value of cache
     *
     * @param  StorageInterface  $cache
     *
     * @return  self
     */ 
    public function setCache(StorageInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }
}