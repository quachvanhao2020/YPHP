<?php
namespace YPHP\Factory;
use YPHP\ContainerFactoryInterface;
use YPHP\CacheInject;
use YPHP\FilterInputInterface;
use YPHP\SortingInputInterface;
use YPHP\EntityInterface;

abstract class BaseEntityFactory implements ContainerFactoryInterface{
    
    use CacheInject;
    /**
     * 
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return EntityInterface.
     */
    public abstract function get($id);

    /**
     * @param int $first
     * @param string $after
     * @param int $last
     * @param string $before
     * @param FilterInputInterface $filter
     * @param SortingInputInterface $sort
     * @return bool
     */
    public abstract function list(int $first = 0,string $after = "",int $last = -1,string $before = "",FilterInputInterface $filter = null,SortingInputInterface $sort = null);

    /**
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public abstract function has($id);

        /**
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public abstract function delete($id);

    /**
     * @param string $id Identifier of the entry to look for.
     * @param EntityInterface $entity
     * @return bool
     */
    public abstract function update($id,$entity);
}