<?php
namespace YPHP;
use YPHP\StorageInterface;

trait CacheInject{
            /**
     * @var bool
     */
    protected $force = false;
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
    public function setCache(StorageInterface $cache = null)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Get the value of force
     *
     * @return  bool
     */ 
    public function getForce()
    {
        if(!$this->force) $this->force = false;
        return $this->force;
    }

    /**
     * Set the value of force
     *
     * @param  bool  $force
     *
     * @return  self
     */ 
    public function setForce(bool $force = null)
    {
        $this->force = $force;

        return $this;
    }
}