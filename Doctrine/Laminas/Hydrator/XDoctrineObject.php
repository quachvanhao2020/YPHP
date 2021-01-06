<?php
namespace Doctrine\Laminas\Hydrator;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Laminas\Hydrator\Filter\FilterProviderInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Inflector;

class XDoctrineObject extends DoctrineObject{
    
    /**
     * @var Inflector
     */
    protected $inflector;
    /**
     * @var Inflector
     */
    protected $_inflector;

    /**
     * @param ObjectManager $objectManager The ObjectManager to use
     * @param bool $byValue If set to true, hydrator will always use entity's public API
     * @param Inflector|null $inflector
     */
    public function __construct(ObjectManager $objectManager, $byValue = true, Inflector $inflector = null)
    {
        $this->_inflector = $inflector ?? InflectorFactory::create()->build();
        parent::__construct($objectManager,$byValue,$inflector);
    }

    public function getFieldNames($fieldNames = []){
        $metadata = $this->metadata;
        $fieldNames = empty($fieldNames) ? \array_merge($metadata->getFieldNames(), $metadata->getAssociationNames()) : $fieldNames;
        $fieldNames = \array_flip($fieldNames);
        $fieldNames = array_index_value($fieldNames);
        return $fieldNames;
    }

        /**
     * Extract values from an object using a by-value logic (this means that it uses the entity
     * API, in this case, getters)
     *
     * @param  object $object
     * @throws RuntimeException
     * @return array
     */
    protected function extractByValue($object,$fieldNames = [])
    {
        //var_dump($object);
        $fieldNames = empty($fieldNames) ? $this->getFieldNames() : $fieldNames;
        $methods = get_class_methods($object);
        $filter = $object instanceof FilterProviderInterface
            ? $object->getFilter()
            : $this->filterComposite;
        $data = [];
        foreach ($fieldNames as $fieldName => $value) {
            if ($filter && ! $filter->filter($fieldName)) {
                //continue;
            }

            $getter = 'get' . $this->_inflector->classify($fieldName);
            $isser = 'is' . $this->_inflector->classify($fieldName);

            $dataFieldName = $this->computeExtractFieldName($fieldName);
            if(is_array($value)){
                $_object = $object->$getter();
                $data[$dataFieldName] = $this->extractByValue($_object,$value);
                continue;
            };
            if (in_array($getter, $methods)) {
                $data[$dataFieldName] = $this->extractValue($fieldName, $object->$getter(), $object);
            } elseif (in_array($isser, $methods)) {
                $data[$dataFieldName] = $this->extractValue($fieldName, $object->$isser(), $object);
            } elseif (substr($fieldName, 0, 2) === 'is'
                && ctype_upper(substr($fieldName, 2, 1))
                && in_array($fieldName, $methods)) {
                $data[$dataFieldName] = $this->extractValue($fieldName, $object->$fieldName(), $object);
            }

            // Unknown fields are ignored
        }

        return $data;
    }
}