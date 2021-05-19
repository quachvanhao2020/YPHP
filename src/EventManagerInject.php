<?php
namespace YPHP;
use Laminas\EventManager\EventManager;

trait EventManagerInject{
    
    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * Get the value of eventManager
     *
     * @return  EventManager
     */ 
    public function getEventManager()
    {
        if(!$this->eventManager) $this->eventManager = new EventManager();
        return $this->eventManager;
    }

    /**
     * Set the value of eventManager
     *
     * @param  EventManager  $eventManager
     *
     * @return  self
     */ 
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
    }

    public function trigger($name){
        return $this->getEventManager()->trigger($name,null,$this);
    }
}