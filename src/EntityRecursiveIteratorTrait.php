<?php
namespace YPHP;
use YPHP\EntityInterface;
use YPHP\EntityFertility;

trait EntityRecursiveIteratorTrait{


    /**
     * Parent container
     *
     * @var EntityFertility
     */
    protected $parent;


    /**
     * Contains sub children
     *
     * @var array
     */
    protected $children = [];

    /**
     * An index that contains the order in which to iterate children
     *
     * @var array
     */
    protected $index = [];


    public function addChildren(EntityInterface $entity,bool $takeParent = true)
    {
        $id = $entity->getId();
        if (array_key_exists($id, $this->index)) {
            return $this;
        }
        $this->children[$id] = $entity;
        $this->index[$id] = true;
        if($entity instanceof EntityFertility && $takeParent){
            $entity->setParent($this);
        }
        return $this;
    }

    /**
     * Returns a child page matching $property == $value, or null if not found
     *
     * @param  string $property        name of property to match against
     * @param  mixed  $value           value to match property against
     * @return EntityFertility  matching page or null
     */
    public function find(string $id)
    {
        $iterator = new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $entity) {
            if($entity instanceof EntityInterface && $entity->getId() == $id){
                return $entity;
            }
        }
        return;
    }


    /**
     * Returns an array representation of all children in container
     *
     * @return array
     */
    public function toArray()
    {
        $children   = [];
        $indexes = array_keys($this->index);
        foreach ($indexes as $hash) {
            $children[] = $this->children[$hash]->toArray();
        }
        return $children;
    }

    // RecursiveIterator interface:

    /**
     * Returns current page
     *
     * Implements RecursiveIterator interface.
     *
     * @return EntityFertility current page or null
     * @throws Exception\OutOfBoundsException  if the index is invalid
     */
    public function current()
    {
        current($this->index);
        $id = key($this->index);
        if(!is_array($this->children)){
            $this->children = [];
        }
        if (!isset($this->children[$id])) {
            //throw new \Exception('Corruption detected in container; ');
            return;
        }
        return $this->children[$id];
    }

    /**
     * Returns hash code of current page
     *
     * Implements RecursiveIterator interface.
     *
     * @return string  hash code of current page
     */
    public function key()
    {
        return key($this->index);
    }

    /**
     * Moves index pointer to next page in the container
     *
     * Implements RecursiveIterator interface.
     *
     * @return void
     */
    public function next()
    {
        next($this->index);
    }

    /**
     * Sets index pointer to first page in the container
     *
     * Implements RecursiveIterator interface.
     *
     * @return void
     */
    public function rewind()
    {
        reset($this->index);
    }

    /**
     * Checks if container index is valid
     *
     * Implements RecursiveIterator interface.
     *
     * @return bool
     */
    public function valid()
    {
        return current($this->index) !== false;
    }

    /**
     * Proxy to haschildren()
     *
     * Implements RecursiveIterator interface.
     *
     * @return bool  whether container has any children
     */
    public function hasChildren()
    {
        return $this->valid() && $this->current()->children;
    }

    /**
     * Returns the child container.
     *
     * Implements RecursiveIterator interface.
     *
     * @return EntityFertility|array
     */
    public function getChildren()
    {
        $hash = key($this->index);

        if (isset($this->children[$hash])) {
            return $this->children[$hash];
        }

        return $this->children;
    }

    // Countable interface:

    /**
     * Returns number of children in container
     *
     * Implements Countable interface.
     *
     * @return int  number of children in the container
     */
    public function count()
    {
        return count($this->index);
    }

    /**
     * Get parent container
     *
     * @return  EntityFertility
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent container
     *
     * @param  EntityFertility  $parent  Parent container
     *
     * @return  self
     */ 
    public function setParent(EntityFertility $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

}