<?php
namespace YPHP;

class EntityFertility extends EntityLife implements \Countable,\RecursiveIterator,\ArrayAccess{
    use EntityRecursiveIteratorTrait;
    const PARENT = "parent";
    const CHILDREN = "children";

    public function __construct(string $id = null)
    {
        parent::__construct($id);
        $this->children = [];
    }
    

    public function getIterator() {
        return $this->getChildren();
    }


    public function __toArray(){
        return array_merge([
            self::PARENT => $this->getParent(),
            self::CHILDREN => $this->getChildren(),
        ],parent::__toArray());
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setParent(@$array[self::PARENT]);
    }

        /**
     * Returns whether the requested key exists
     *
     * @param  mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->children[$key]);
    }

    /**
     * Returns the value at the specified key
     *
     * @param  mixed $key
     * @return mixed
     */
    public function &offsetGet($key)
    {
        $ret = null;
        if (! $this->offsetExists($key)) {
            return $ret;
        }
        $ret =& $this->children[$key];

        return $ret;
    }

    /**
     * Sets the value at the specified key to value
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->children[$key] = $value;
    }

    /**
     * Unsets the value at the specified key
     *
     * @param  mixed $key
     * @return void
     */
    public function offsetUnset($key)
    {
        if ($this->offsetExists($key)) {
            unset($this->children[$key]);
        }
    }

}