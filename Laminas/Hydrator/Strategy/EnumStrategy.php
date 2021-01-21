<?php
declare(strict_types=1);

namespace Laminas\Hydrator\Strategy;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use YPHP\Enum;

use function get_class;
use function gettype;
use function is_object;
use function is_string;
use function preg_replace;
use function sprintf;

final class EnumStrategy implements StrategyInterface
{

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
        if ($value instanceof Enum) {
            $value = [
                "value" => $value->getValue(),
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
        if ($value === '' || $value === null || $value instanceof Enum) {
            return $value;
        }
        if (! is_array($value)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Unable to hydrate. Expected null, string, or DateTimeInterface; %s was given.',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
        $value = new Enum($value["value"]);
        return $value;
    }
}
