<?php
namespace YPHP;

use DateTime;
use DateTimeZone;
use JsonMapper;
use ReflectionProperty;
use ReflectionMethod;

class Mapper extends JsonMapper{

    /**
     * @var callable
     */
    public $setPropertyCallable;

    public function __construct()
    {
        $this->bStrictNullTypes = false;
        $this->bExceptionOnMissingData = false;
        $this->bRemoveUndefinedAttributes = true;
        $this->bExceptionOnUndefinedProperty = false;
        $this->setPropertyCallable = function(&$object,$accessor,&$value){
            if($object instanceof DateTime){
                if($accessor instanceof ReflectionMethod){
                    $name = $accessor->getName();
                    if($name == "setTimezone"){
                        $value = new DateTimeZone($value);
                    }else if($name == "setDate"){
                        $object->modify($value);
                        return false;
                    }
                }
            }else{
            }
            return true;
        };
    }

        /**
     * Set a property on a given object to a given value.
     *
     * Checks if the setter or the property are public are made before
     * calling this method.
     *
     * @param object $object   Object to set property on
     * @param object $accessor ReflectionMethod or ReflectionProperty
     * @param mixed  $value    Value of property
     *
     * @return void
     */
    protected function setProperty(
        $object, $accessor, $value
    ) {
        if (!$accessor->isPublic() && $this->bIgnoreVisibility) {
            $accessor->setAccessible(true);
        }
        $setPropertyCallable = $this->setPropertyCallable;
        if(is_callable($setPropertyCallable)){
            if($setPropertyCallable($object,$accessor,$value) == false){
                return;
            }
        }
        if ($accessor instanceof ReflectionProperty) {
            $accessor->setValue($object, $value);
        } else {
            //setter method
            $accessor->invoke($object, $value);
        }
    }

    /**
     * Create a new object of the given type.
     *
     * This method exists to be overwritten in child classes,
     * so you can do dependency injection or so.
     *
     * @param string  $class        Class name to instantiate
     * @param boolean $useParameter Pass $parameter to the constructor or not
     * @param mixed   $jvalue       Constructor parameter (the json value)
     *
     * @return object Freshly created object
     */
    protected function createInstance(
        $class, $useParameter = false, $jvalue = null
    ) {
        if ($useParameter) {
            return new $class($jvalue);
        } else {
            $reflectClass = new \ReflectionClass($class);
            $constructor  = $reflectClass->getConstructor();
            if (null === $constructor
                || $constructor->getNumberOfRequiredParameters() > 0
            ) {
                return $reflectClass->newInstanceWithoutConstructor();
            }
            return $reflectClass->newInstance();
        }
    }

            /**
     * Get the mapped class/type name for this class.
     * Returns the incoming classname if not mapped.
     *
     * @param string $type   Type name to map
     * @param mixed  $jvalue Constructor parameter (the json value)
     *
     * @return string The mapped type/class name
     */
    protected function getMappedType($type, $jvalue = null)
    {

        $class = @$jvalue->__class;
        if($class) $type = $class;
        if (isset($this->classMap[$type])) {
            $target = $this->classMap[$type];
        } else if (is_string($type) && $type !== '' && $type[0] == '\\'
            && isset($this->classMap[substr($type, 1)])
        ) {
            $target = $this->classMap[substr($type, 1)];
        } else {
            $target = null;
        }
        if ($target) {
            if (is_callable($target)) {
                $type = $target($type, $jvalue);
            } else {
                $type = $target;
            }
        }
        return $type;
    }
}