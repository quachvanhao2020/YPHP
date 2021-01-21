<?php
declare(strict_types=1);
namespace YPHP;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Hydrator\HydratorInterface;

trait StorageHydratorTrait{

    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var StrategyInterface[]
     */
    protected $strategys = [];

    /**
     * @return object
     */
    protected function hydrate(array $data,object $object){
        $object = \hydrate($data,$object,$this->hydrator,true,$this->hydrator,$this::getStrategys($this->hydrator));
        return $object;
    }

    /**
     * @return array
     */
    protected function extract(object $object,int $depth = 1){
        return \hydrator_extract($object,$this->hydrator,true,$this::getStrategys($this->hydrator),$depth);
    }

    /**
     * Get the value of cache
     *
     * @return  StorageInterface
     */ 
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Set the value of cache
     *
     * @param  StorageInterface  $cache
     *
     * @return  self
     */ 
    public function _setCache(StorageInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Get the value of hydrator
     *
     * @return  HydratorInterface
     */ 
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * Set the value of hydrator
     *
     * @param  HydratorInterface  $hydrator
     *
     * @return  self
     */ 
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }

    /**
     * Get the value of strategys
     *
     * @return  StrategyInterface[]
     */ 
    public static abstract function getStrategys(HydratorInterface $hydrator);

}