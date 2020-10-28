<?php
namespace YPHP;
use Psr\Container\ContainerInterface;

interface ContainerFactoryInterface extends ContainerInterface{
    
        /**
     * @param int $first
     * @param string $after
     * @param int $last
     * @param string $before
     * @param FilterInputInterface $filter
     * @param SortingInputInterface $sort
     * @return mixed
     */
    function list(int $first = 0,string $after = "",int $last = -1,string $before = "",FilterInputInterface $filter = null,SortingInputInterface $sort = null);
    /**
     * @param string $id Identifier of the entry to look for.
     * @param Entity $entity
     * @return bool
     */
    function update(string $id,$entity);
        /**
     * @param string $id Identifier of the entry to look for.
     * 
     * @return bool
     */
    function delete(string $id);
}