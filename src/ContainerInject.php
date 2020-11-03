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

    /**
     * @return string
     */
    public abstract function uniqid();

    public static function theClass(){
        return static::class;
    }

    public function instance(){
        if($container = $this->getContainer()){
            $entity = null;
            if($container instanceof ManagerFactory){
                if($this instanceof Entity){
                    $entity = $container->_get(SysEntity::entityTo($this));
                }
            }else{
                $entity = $container->get($this->uniqid());
            }
            if($entity instanceof Entity && get_class($entity) == self::theClass()){
                if($this instanceof Entity){
                    \tran($entity->__toArray(),$this);
                }
            }
        }
    }

    public function save(){
        if($container = $this->getContainer()){
            if($this instanceof Entity){
                if($container instanceof ManagerFactory){
                    return $container->_update(SysEntity::entityTo($this),$this);
                }
                return $container->update($this->uniqid(),$this);
            }  
        }
    }

}