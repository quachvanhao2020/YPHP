<?php
namespace YPHP;
use YPHP\EntityFertility;

class EntityFertilityFactory implements ContainerFactoryInterface{
    
    use CacheInject;
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
        try {
            if($this->cache instanceof SimpleCache){
                $id = (string)new SysEntity($id,EntityFertility::class);
            }
            return \obj_to($this->getCache()->getItem($id),new EntityFertility());
        } catch (\Exception $ex) {
            //throw $th;
        }
        return new EntityFertility($id."-".uniqid());
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
        try {
            return $this->getCache()->setItem($id,$entity);
        } catch (\Exception $ex) {
            //throw $th;
        }
        return true;
    }
}