<?php

/**
 * @see       https://github.com/laminas/laminas-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-hydrator/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Laminas\Hydrator\Strategy;

use DateTime;
use DateTimeInterface;
use DateTimeZone;

use function get_class;
use function gettype;
use function is_object;
use function is_string;
use function preg_replace;
use function sprintf;

final class DateTimeArrayFormatterStrategy implements StrategyInterface
{
    /**
     * Format to use during hydration.
     *
     * @var array
     */
    private $format;

    /**
     * @param bool $dateTimeFallback try to parse with DateTime when createFromFormat fails
     * @throws Exception\InvalidArgumentException for invalid $format values
     */
    public function __construct(
        array $format = []
    ) {
        $this->format           = $format;
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
        if ($value instanceof DateTimeInterface) {
            //return $value;
            $value = [
                'date' => $value->format('Y-m-d H:i:s'),
                'timezone' => $value->getTimezone()->getName(),
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
        if ($value === '' || $value === null || $value instanceof DateTimeInterface) {
            return $value;
        }

        if (! is_array($value)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Unable to hydrate. Expected null, string, or DateTimeInterface; %s was given.',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
        $value = new DateTime($value['date'],new DateTimeZone($value['timezone']));
        return $value;
    }
}
