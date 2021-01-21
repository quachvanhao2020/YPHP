<?php
declare(strict_types=1);
namespace Laminas\Hydrator\Strategy;

use YPHP\Entity;
use Laminas\Hydrator\AbstractHydrator;
use YPHP\BaseEntity;

final class NewClassStrategy implements StrategyInterface
{
    /**
     * Format to use during hydration.
     *
     * @var AbstractHydrator
     */
    private $hydrator;

        /**
     * Format to use during hydration.
     *
     * @var bool
     */
    protected $minimum;

    /**
     * @param bool $dateTimeFallback try to parse with DateTime when createFromFormat fails
     * @throws Exception\InvalidArgumentException for invalid $format values
     */
    public function __construct(AbstractHydrator $hydrator,bool $minimum = true) 
    {
        $this->hydrator = $hydrator;
        $this->minimum = $minimum;
    }

    /**
     * {@inheritDoc}
     *
     * Converts to date time string
     *
     * @param mixed|DateTimeInterface $value
     * @return mixed|string If a non-DateTimeInterface $value is provided, it
     *     will be returned unmodified; otherwise, it will be extracted to a
     *     string.
     */
    public function extract($value, ?object $object = null)
    {
        if(!isset($value)) return;
        if(is_array($value)) return $value;
        if($value instanceof BaseEntity && $this->minimum){
            return [
                "id" => $value->getId(),
                "class" => $value->getClass(),
            ];
        }
        return $this->hydrator->extract($value,$object);
    }

    /**
     * Converts date time string to DateTime instance for injecting to object
     *
     * {@inheritDoc}
     *
     * @param mixed|string $value
     * @return mixed|DateTimeInterface
     * @throws Exception\InvalidArgumentException if $value is not null, not a
     *     string, nor a DateTimeInterface.
     */
    public function hydrate($value,?array $data)
    {
        if(empty($value)) return;
        $extract = $this->extract($value);
        $class = isset($extract["class"]) ? $extract["class"] : @$extract["__class"];
        if($class === null) $class = Entity::class;
        if(isset($value["iterator_class"])) $class = EntityStorage::class;
        if ($value === '' || $value === null || !class_exists($class)) {
            return $value;
        }
        $value = new $class();
        return $this->hydrator->hydrate($extract,$value);
    }
}
