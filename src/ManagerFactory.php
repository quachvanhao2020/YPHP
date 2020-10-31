<?php
namespace YPHP;
use YPHP\SysEntity;

class ManagerFactory implements ContainerFactoryInterface{

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = (new self());
        }
        return self::$instance;
    }

    /**
     * 
     *
     * @var array
     */
    protected $mapEntity;

        /**
     * 
     *
     * @var array
     */
    protected $map;

        /**
     * Get the value of map
     *
     * @return  array
     */ 
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set the value of map
     *
     * @param  array  $map
     *
     * @return  self
     */ 
    public function setMap(array $map)
    {
        $this->map = $map;

        return $this;
    }

            /**
     * 
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return Entity.
     */
    public function get($id){
        $this->setMapEntity([]);
        if($id instanceof SysEntity)
        return $this->_get($id);
    }

        /**
     * 
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return Entity.
     */
    public function _get(SysEntity $sid){
        $id = (string)$sid;
        if(isset($this->mapEntity[$id])){
            $value = $this->mapEntity[$id];
            return $value;
        }
        $fa = $this->getMap()[$sid->getClass()];
        if(is_string($fa)){
            $fa = new $fa();
        }
        if($fa instanceof ContainerFactoryInterface){
            $entity = $fa->get($sid->getId());
            if($entity instanceof Entity){
                $container = $this;
                $entity->setContainer($container);
                $this->mapEntity[$id] = $entity;
                $array = arr($entity);
                array_walk_recursive($array, function($item, $key) use($container){
                    if($item instanceof Entity){
                        $item->setContainer($container);
                        $item->instance();
                    }
                });
                return $entity;
            }
        }
    }

            /**
     * @param int $first
     * @param string $after
     * @param int $last
     * @param string $before
     * @param FilterInputInterface $filter
     * @param SortingInputInterface $sort
     * @return bool
     */
    public function list(int $first = 0,string $after = "",int $last = -1,string $before = "",FilterInputInterface $filter = null,SortingInputInterface $sort = null){
        return [];
    }

    /**
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id){
        return true;
    }

        /**
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function delete($id){
        return true;
    }

        /**
     * @param string $id Identifier of the entry to look for.
     * @param EntityFertility $entity
     * @return bool
     */
    public function update($id,$entity){
        $this->setMapEntity([]);
        if($id instanceof SysEntity)
        return $this->_update($id,$entity);
    }

    /**
     * @param string $id Identifier of the entry to look for.
     * @param EntityFertility $entity
     * @return bool
     */
    public function _update(SysEntity $sid,$entity){
        $id = (string)$sid;
        if(isset($this->mapEntity[$id])){
            return true;
        }
        if($entity instanceof Entity){
            $class = get_class($entity);
            $fa = @$this->getMap()[$class];
            if(is_string($fa)){
                $fa = new $fa();
            }
            if($fa instanceof ContainerFactoryInterface){
                $container = $this;
                $fa->update($sid->getId(),$entity);
                $this->mapEntity[$id] = $entity;
                $array = arr($entity);
                array_walk_recursive($array, function($item, $key) use($container){
                    if($item instanceof Entity){
                        $item->setContainer($container);
                        $item->save();
                    }
                });
            }
        }
    }

    /**
     * Get the value of mapEntity
     *
     * @return  array
     */ 
    public function getMapEntity()
    {
        return $this->mapEntity;
    }

    /**
     * Set the value of mapEntity
     *
     * @param  array  $mapEntity
     *
     * @return  self
     */ 
    public function setMapEntity(array $mapEntity)
    {
        $this->mapEntity = $mapEntity;

        return $this;
    }
}