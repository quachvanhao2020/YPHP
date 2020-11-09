<?php
namespace YPHP;

class Translation extends Entity{

    /**
     * @var string
     */
    protected $current;

        /**
     * @var Entity
     */
    protected $currentEntity;

        /**
     * @var string
     */
    protected $target;

        /**
     * @var callable
     */
    protected $callable;

    public function __construct(string $current = null,string $target = null,callable $callable = null)
    {
        $this->current = $current;
        $this->target = $target;
        $this->callable = $callable;
        $this->setId($current."_".$target);
    }

    /**
     * Get the value of target
     *
     * @return  string
     */ 
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set the value of target
     *
     * @param  string  $target
     *
     * @return  self
     */ 
    public function setTarget(string $target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get the value of callable
     *
     * @return  callable
     */ 
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * Set the value of callable
     *
     * @param  callable  $callable
     *
     * @return  self
     */ 
    public function setCallable(callable $callable)
    {
        $this->callable = $callable;

        return $this;
    }


    /**
     * Get the value of currentEntity
     *
     * @return  Entity
     */ 
    public function getCurrentEntity()
    {
        return $this->currentEntity;
    }

    /**
     * Set the value of currentEntity
     *
     * @param  Entity  $currentEntity
     *
     * @return  self
     */ 
    public function setCurrentEntity($currentEntity)
    {
        $this->currentEntity = $currentEntity;

        return $this;
    }
}