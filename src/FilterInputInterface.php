<?php
namespace YPHP;
use ArrayAccess;

interface FilterInputInterface{
        /**
     * @param ArrayAccess $result
     * @return mixed
     */
    function filter(ArrayAccess &$result);
}