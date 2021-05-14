<?php
declare(strict_types=1);

namespace Laminas\Hydrator\Strategy;

use DateTimeInterface;
use YPHP\BaseEntity;
use YPHP\Storage\EntityStorage;

use function get_class;
use function gettype;
use function is_object;
use function sprintf;

final class StorageStrategy implements StrategyInterface
{
    /**
     * @var StrategyInterface
     */
    protected $innerStrategy;

    public function __construct(StrategyInterface $innerStrategy = null)
    {
        $this->innerStrategy = $innerStrategy;
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
        if ($value instanceof EntityStorage) {
            $ids = [];
            foreach ($value as $key => $value) {
                if($value instanceof BaseEntity) {
                    if($this->innerStrategy){
                        $ids[] = $this->innerStrategy->extract($value);
                    }else{
                        $ids[] = $value->getId();
                    }
                };
                if(is_string($value)){
                    $ids[] = $value;
                }
            }
            $value = [
                "ids" => implode(",",$ids),
                "class" => is_object($value) ? get_class($value) : $value,
            ];
        }
        return $value;
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
        if ($value === '' || $value === null || $value instanceof EntityStorage) {
            return $value;
        }

        if (! is_array($value)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Unable to hydrate. Expected null, string, or DateTimeInterface; %s was given.',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
        $ids = isset($value["ids"]) ? $value["ids"] : "";
        $class = isset($value["class"]) ? $value["class"] : EntityStorage::class;
        $ids = explode(",",$ids);
        if($this->innerStrategy){
            foreach ($ids as &$_value) {
                $_value = $this->innerStrategy->hydrate($_value,[]);
            }
        }
        $value = new $class($ids);
        return $value;
    }
}
