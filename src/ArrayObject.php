<?php
namespace YPHP;

use YPHP\BaseArrayObject;

class ArrayObject extends BaseArrayObject implements SerializableInterface {

    const STORAGE = "storage";
    const __CLASS = "__class";
    /**
     * @var array
     */
    protected $storage = [];

    public function __toString()
    {
        return \json_encode($this->__toArray());
    }

    public function __toStd(){
        return (object)$this->__toArray();
    }
    
    public function __toArray() {
        return [
            self::STORAGE => $this->getStorage(),
            self::__CLASS => get_class($this),
        ];
    }

    public function __arrayTo($array){
        $storage = @$array[self::STORAGE];
        if(is_array($storage)){
            foreach ($storage as $key => $value) {
                if(is_iterable($value)){
                    $value = \obj_to($value);
                }
                $storage[$key] = $value;
            }
            return $this->setStorage($storage);
        }
        $this->setStorage($array);
    }

    public function jsonSerialize() {
        return $this->__toArray();
    }

    /**
     * Constructor
     *
     * @param array  $input
     * @param int    $flags
     * @param string $iteratorClass
     */
    public function __construct($input = [], $flags = self::STD_PROP_LIST, $iteratorClass = 'ArrayIterator')
    {
        $this->setFlags($flags);
        if(is_array($input)) $this->__arrayTo($input);
        $this->setIteratorClass($iteratorClass);
        $this->protectedProperties = array_keys(get_object_vars($this));
    }

    public function instances(){
        foreach ($this->storage as $value) {
            if($value instanceof Entity){
                $value->instance();
            }
        }
    }

     /**
     * Sort the entries by keys using a user-defined comparison function
     *
     * @param  callable $function
     * @return void
     */
    public function tryKeep($function,$unset = false)
    {
        $storage = new self();
        if (is_callable($function)) {
            foreach ($this->getStorage() as $key => $value) {
                if(!$function($value)){
                    if($unset) unset($this->storage[$key]);
                }else{
                    $storage->append($value);
                }
            }
        }
        return $storage;
    }

    public function indexing(){
        foreach ($this->storage as $key => $value) {
            if($value instanceof Entity){
                $this->storage[$value->getId()] = $value;
                unset($this->storage[$key]);
            }
        }
        return $this;
    }

    public function merge(self $storage){
       return $this->setStorage(array_merge($storage->getStorage(),$this->getStorage()));
    }

    public function clear(){
        return $this->setStorage([]);
    }

    /**
     * Get the value of storage
     *
     * @return  array
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @param  array  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        if(!empty($storage)) {
            $this->storage = $storage;
        }
        return $this;
    }

    /**
     * Appends the value
     *
     * @param  mixed $value
     * @return void
     */
    public function prepend($value)
    {
        array_unshift($this->storage,$value);
    }

}