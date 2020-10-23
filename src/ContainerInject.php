<?php
namespace YPHP;
use Psr\Container\ContainerInterface;

trait ContainerInject{
            /**
     * 
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Get the value of container
     *
     * @return  ContainerInterface
     */ 
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set the value of container
     *
     * @param  ContainerInterface  $container
     *
     * @return  self
     */ 
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    public abstract function uniqid();

    public static function theClass(){
        return static::class;
    }

    public function instance(){
        if($this->container){
            $container = $this->getContainer();
            $entity = $container->get($this->uniqid());
            if($entity instanceof Entity && get_class($entity) == self::theClass()){
                if($this instanceof Entity){
                    $this->__arrayTo($entity->__toArray());
                }
            }
        }
    }
}