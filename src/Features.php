<?php

namespace zonuexe\PhpCon2017;

/**
 * 機能
 *
 * @property-read string $key
 * @property-read bool   $value
 */
final class Features implements \IteratorAggregate, \ArrayAccess
{
    private static $KNOWN_FEATURES = [
        Feature\SetErrorReporting::class => ['E_ALL', 'E_ALL & ~E_NOTICE'],
        Feature\SetErrorHandler::class => [false, true],
        Feature\AddWhoopsHandler::class => ['', 'PrettyPageHandler'],
        Feature\TurnOnWhoops::class => [false, true],
    ];

    /** @var Feature\Feature[] */
    private $features;

    /**
     * @param Feature\Feature[]
     */
    private function __construct(array $features)
    {
        $a = [];
        foreach ($features as $f) {
            assert($f instanceof Feature\Feature);
            $a[] = $f;
        }

        $this->features = $a;
    }

    public function executeAll()
    {
        foreach ($this->features as $feature) {
            $feature->execute($this);
        }
    }

    /**
     * @return Features
     */
    public static function fromArray(array $source)
    {
        $features = [];

        foreach ($source as $key => $value) {
            $class = ltrim(self::className($key), '\\');
            if (isset(Features::$KNOWN_FEATURES[$class])) {
                $features[] = new $class($key, $value);
            }
        }

        return new Features($features);
    }

    public static function getAvailableValues()
    {
        $available_values = [];

        foreach (Features::$KNOWN_FEATURES as $class => $values) {
            $ns = explode('\\', $class);

            $available_values[array_pop($ns)] = $values;
        }

        return $available_values;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];

        foreach ($this->features as $f) {
            $ns = explode('\\', $f->key);
            $array[array_pop($ns)] = $f->value;
        }

        return $array;
    }

    /**
     * @return Features
     */
    public static function getDefaultFeatures()
    {
        return new Features(array_map(function ($class, $values) {
            $ns = explode('\\', $class);
            return new $class(array_pop($ns), $values[0]);
        }, array_keys(Features::$KNOWN_FEATURES), Features::$KNOWN_FEATURES));
    }

    // Private utilities

    private static function className($name)
    {
        return sprintf('\%s\Feature\%s',  __NAMESPACE__, $name);
    }


    // Methods implements for \IteratorAggregate

    public function getIterator()
    {
        return new \ArrayIterator($this->features);
    }

    // Methods implements for \ArrayAccess

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->features);
    }

    public function offsetGet ($offset)
    {
        if (array_key_exists($offset, $this->features)) {
            return $this->features[$offset];
        }

        throw new \OutOfBoundsException();
    }

    public function offsetSet($offset, $value)
    {
        if (array_key_exists($offset, $this->features)) {
            $this->features[$offset] = $value;
        }

        throw new \OutOfBoundsException();
    }

    public function offsetUnset($offset)
    {
        throw new \OutOfBoundsException();
    }
}
