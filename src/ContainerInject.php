<?php
namespace YPHP;

use YPHP\ContainerFactoryInterface as ContainerInterface;

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

    public abstract function uniqid($force = false);

    public static function theClass(){
        return static::class;
    }

    public function instance(){
        if($container = $this->getContainer()){
            $entity = null;
            $id = $this->uniqid();
            if($container instanceof ManagerFactory){
                $entity = $container->_get($id);
            }else{
                $entity = $container->get($id);
            }
            if($entity instanceof Entity && get_class($entity) == self::theClass()){
                if($this instanceof Entity){
                    \tran($entity,$this);
                }
            }
        }
    }

    public function save(){
        if($container = $this->getContainer()){
            if($this instanceof Entity){
                if($container instanceof ManagerFactory){
                    return $container->_update($this->uniqid(),$this);
                }
                return $container->update($this->uniqid(),$this);
            }  
        }
    }

}