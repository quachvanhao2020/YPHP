<?php
namespace YPHP;

use ArrayAccess;

interface SortingInputInterface{

    /**
     * @param ArrayAccess $result
     * @return mixed
     */
    function sort(ArrayAccess &$result);
}