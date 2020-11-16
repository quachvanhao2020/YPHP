<?php
namespace YPHP\Storage;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use Serializable;

interface EntityStorageInterface extends IteratorAggregate, ArrayAccess, Serializable, Countable{

}