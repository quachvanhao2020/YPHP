<?php
namespace YPHP\Storage;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use Serializable;

interface EntityStorageInterface extends IteratorAggregate, ArrayAccess, Serializable, Countable{
    /**
     * Appends the value
     *
     * @param  mixed $value
     * @return void
     */
    function append($value);
}