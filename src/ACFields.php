<?php

namespace e02;

class ACFields
{
    protected $fields = [];

    public static function createFromFields($post_id = false, $format_value = true)
    {
        return new self(get_fields($post_id, $format_value) ?: []);
    }

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function all()
    {
        return $this->fields;
    }

    public function get($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }

        return null;
    }

    public function getAsObj($name)
    {
        $item = $this->get($name);

        return new self(is_array($item) ? $item : []);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->fields[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->fields[$name]);
    }
}
