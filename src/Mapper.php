<?php
namespace YPHP;
use JsonMapper;
class Mapper extends JsonMapper{

    public function __construct()
    {
        $this->bStrictNullTypes = false;
        $this->bExceptionOnMissingData = false;
        $this->bRemoveUndefinedAttributes = true;
        $this->bExceptionOnUndefinedProperty = false;
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
        var_dump($class,$useParameter,$jvalue);
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
}