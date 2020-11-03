<?php
namespace YPHP\Filter;
use YPHP\Entity;
use YPHP\FilterInputInterface;
use ArrayAccess;

class EntityFilter extends Entity implements FilterInputInterface {
        /**
     * @param ArrayAccess $result
     * @return mixed
     */
    function filter(ArrayAccess &$result){
        return $result;
    }
}