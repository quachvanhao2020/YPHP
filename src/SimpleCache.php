<?php
namespace YPHP;

class SimpleCache implements StorageInterface{

    public function getKeys(){
        return [];
    }

    protected $filePath;

    /**
     * @var array
     */
    protected $storage = [];

    public function __construct()
    {
        $path = __DIR__."/cache.json";
        $this->filePath = $path;
        if(!file_exists($path)){
            touch($path);
        }
        $this->storage = json_decode(\file_get_contents($this->filePath),JSON_OBJECT_AS_ARRAY);
    }

    public function __destruct()
    {
        \file_put_contents($this->filePath,json_encode($this->getStorage(),JSON_PRETTY_PRINT));
    }

        /**
     * Set options.
     *
     * @param array|Traversable|Adapter\AdapterOptions $options
     * @return StorageInterface Fluent interface
     */
    public function setOptions($options){}

    /**
     * Get options
     *
     * @return Adapter\AdapterOptions
     */
    public function getOptions(){}

    /* reading */

    /**
     * Get an item.
     *
     * @param  string  $key
     * @param  bool $success
     * @param  mixed   $casToken
     * @return mixed Data on success, null on failure
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function getItem($key, & $success = null, & $casToken = null){
        if(!$this->hasItem($key)) throw new \Exception("Error Processing Request", 1);
        return $this->getStorage()[$key]; 
    }

    /**
     * Get multiple items.
     *
     * @param  array $keys
     * @return array Associative array of keys and values
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function getItems(array $keys){}

    /**
     * Test if an item exists.
     *
     * @param  string $key
     * @return bool
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function hasItem($key){
        return array_key_exists($key,$this->getStorage());
    }

    /**
     * Test multiple items.
     *
     * @param  array $keys
     * @return array Array of found keys
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function hasItems(array $keys){}

    /**
     * Get metadata of an item.
     *
     * @param  string $key
     * @return array|bool Metadata on success, false on failure
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function getMetadata($key){}

    /**
     * Get multiple metadata
     *
     * @param  array $keys
     * @return array Associative array of keys and metadata
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function getMetadatas(array $keys){}

    /* writing */

    /**
     * Store an item.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function setItem($key, $value){
        if($value instanceof Entity){
            $key = (string)SysEntity::entityTo($value);
        }
        $this->storage[$key] = \object_to_array($value);
        return true;
    }

    /**
     * Store multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Array of not stored keys
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function setItems(array $keyValuePairs){}

    /**
     * Add an item.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function addItem($key, $value){}

    /**
     * Add multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Array of not stored keys
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function addItems(array $keyValuePairs){}

    /**
     * Replace an existing item.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function replaceItem($key, $value){}

    /**
     * Replace multiple existing items.
     *
     * @param  array $keyValuePairs
     * @return array Array of not stored keys
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function replaceItems(array $keyValuePairs){}

    /**
     * Set an item only if token matches
     *
     * It uses the token received from getItem() to check if the item has
     * changed before overwriting it.
     *
     * @param  mixed  $token
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \YPHP\Exception\ExceptionInterface
     * @see    getItem()
     * @see    setItem()
     */
    public function checkAndSetItem($token, $key, $value){}

    /**
     * Reset lifetime of an item
     *
     * @param  string $key
     * @return bool
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function touchItem($key){}

    /**
     * Reset lifetime of multiple items.
     *
     * @param  array $keys
     * @return array Array of not updated keys
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function touchItems(array $keys){}

    /**
     * Remove an item.
     *
     * @param  string $key
     * @return bool
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function removeItem($key){}

    /**
     * Remove multiple items.
     *
     * @param  array $keys
     * @return array Array of not removed keys
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function removeItems(array $keys){}

    /**
     * Increment an item.
     *
     * @param  string $key
     * @param  int    $value
     * @return int|bool The new value on success, false on failure
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function incrementItem($key, $value){}

    /**
     * Increment multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Associative array of keys and new values
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function incrementItems(array $keyValuePairs){}

    /**
     * Decrement an item.
     *
     * @param  string $key
     * @param  int    $value
     * @return int|bool The new value on success, false on failure
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function decrementItem($key, $value){}

    /**
     * Decrement multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Associative array of keys and new values
     * @throws \YPHP\Exception\ExceptionInterface
     */
    public function decrementItems(array $keyValuePairs){}

    /* status */

    /**
     * Capabilities of this storage
     *
     * @return Capabilities
     */
    public function getCapabilities(){}

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
    public function setStorage(array $storage)
    {
        $this->storage = $storage;

        return $this;
    }
}