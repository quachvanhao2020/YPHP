<?php
namespace YPHP;

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
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return Entity.
     */
    public function get($id){
        if(is_array($id)){
            foreach ($id as $key => $value) {
                $id[$key] = $this->get($value);
            }
            return $id;
        }
        if($id instanceof Entity){
            $id = $id->uniqid();
        }
        if(!is_string($id)) return $id;
        if(isset($this->mapEntity[$id])){
            $value = $this->mapEntity[$id];
            //var_dump($value);
            return $value;
        }
        $param = explode("-",$id);
        $fa = $this->getMap()[$param[0]];
        if(is_string($fa)){
            $fa = new $fa();
        }
        if($fa instanceof ContainerFactoryInterface){
            $entity = $fa->get($id);
            if($entity instanceof Entity){
                $this->mapEntity[$entity->uniqid()] = $entity;
                $array = arr($entity);
                //var_dump($array); return;

                foreach ($array as $key => $value) {
                    if($value instanceof ArrayObject){
                        $value = $value->getStorage();
                    }
                    if(is_array($value)){
                        $value = $this->get($value);
                    }
                    if($value instanceof Entity){
                        if(!isset($this->mapEntity[$value->uniqid()])){
                            $value = $this->get($value->uniqid());
                        }else{
                            $value = $this->mapEntity[$value->uniqid()];
                            //var_dump($value);
                        }
                    }
                    $array[$key] = $value;
                }
                $entity->__arrayTo($array);
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
    public function update(string $id,$entity){
        if($entity instanceof Entity){
            $class = get_class($entity);
            $fa = $this->getMap()[$class];
            if(is_string($fa)){
                $fa = new $fa();
            }
            if($fa instanceof ContainerFactoryInterface){
                $fa->update($entity->uniqid(),$entity);
            }
            $this->mapEntity[$entity->uniqid()] = $entity;
        }
        $array = arr($entity);
        foreach ($array as $key => $value) {
            if($value instanceof ArrayObject){
                $value = $value->getStorage();
            }
            if(is_array($value)){
                $this->update("arr",$value);
            }
            if($value instanceof Entity){
                if(!isset($this->mapEntity[$value->uniqid()])){
                    $this->update($value->getId(),$value);
                }
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