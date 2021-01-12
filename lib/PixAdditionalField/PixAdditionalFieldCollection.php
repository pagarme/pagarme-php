<?php

namespace PagarMe\Sdk\PixAdditionalField;

class PixAdditionalFieldCollection implements \ArrayAccess, \Iterator, \Countable
{

    /**
     * @var array $fields
     */
    private $fields = [];

    /**
     * @var int $position
     */
    private $position = 0;

    public function offsetSet($offset, $value)
    {
        if (!$value instanceof PixAdditionalField) {
            throw new \InvalidArgumentException(
                "The value supplied is not a PixAdditionalField object",
                1
            );
        }

        if (is_null($offset)) {
            $this->fields[] = $value;
        } else {
            $this->fields[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->fields[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->fields[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->fields[$offset]) ? $this->fields[$offset] : null;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->fields[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->fields[$this->position]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->fields);
    }
}
