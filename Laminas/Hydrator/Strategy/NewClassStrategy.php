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
     * @param bool $dateTimeFallback try to parse with DateTime when createFromFormat fails
     * @throws Exception\InvalidArgumentException for invalid $format values
     */
    public function __construct(AbstractHydrator $hydrator) 
    {
        $this->hydrator = $hydrator;
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
        if(is_array($value)) return $value;
        if($value instanceof BaseEntity){
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
        $extract = $this->extract($value);
        $class = @$extract["class"];
        if($class === null) $class = Entity::class;
        if ($value === '' || $value === null || !class_exists($class)) {
            return $value;
        }
        $value = new $class();
        return $this->hydrator->hydrate($extract,$value);
    }
}
