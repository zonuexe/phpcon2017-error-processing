<?php

namespace zonuexe\PhpCon2017\Feature;

/**
 * 機能
 *
 * @property-read string $key
 * @property-read bool   $value
 */
abstract class Feature
{
    /** @var string */
    private $key;

    /** @var mixed */
    private $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }

    private static function className($name)
    {
        return sprintf('\%s\Feature\%s',  __NAMESPACE__, $name);
    }
}
