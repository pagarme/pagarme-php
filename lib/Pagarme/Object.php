<?php

namespace Pagarme;

class Object implements \ArrayAccess, \Iterator
{
    protected $_attributes;

    protected $_unsavedAttributes;

    private $_position;

    public function __construct($response = array())
    {
        $this->_attributes = array();
        $this->_unsavedAttributes = new Set();
        $this->_position = 0;

        $this->refresh($response);
    }

    public function __set($key, $value)
    {
        if (empty($key)) {
            throw new Exception('Cannot store invalid key');
        }

        $this->_attributes[$key] = $value;
        $this->_unsavedAttributes->add($key);
    }

    public function __isset($key)
    {
        return isset($this->_attributes[$key]);
    }

    public function __unset($key)
    {
        unset($this->_attributes[$key]);
        $this->_unsavedAttributes->remove($key);
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->_attributes)) {
            return $this->_attributes[$key];
        } else {
            return null;
        }
    }

    public function __call($name, $arguments)
    {
        $var = Util::fromCamelCase(substr($name,3));

        if (!strncasecmp($name, 'get', 3)) {
            return $this->$var;    
        } else if (!strncasecmp($name, 'set',3)) {
            $this->$var = $arguments[0];
            return;
        }
        
        throw new Exception('Unknown method: ' . $name);
    }

    public function rewind()
    {
        $this->_position = 0;
    }

    public function current()
    {
        return $this->_attributes[$this->key()];
    }

    public function key()
    {
        $keys = $this->keys();

        if (isset($keys[$this->_position])) {
            return $keys[$this->_position];
        }
    }

    public function next()
    {
        ++$this->_position;
    }

    public function valid()
    {
        $keys = $this->keys();
        return isset($keys[$this->_position]);
    }

    public function offsetSet($key, $value)
    {
        $this->$key = $value;
    }

    public function offsetGet($key)
    {
        return $this->$key;
    }

    public function offsetExists($key)
    {
        return array_key_exists($key, $this->_attributes);
    }

    public function offsetUnset($key)
    {
        unset($this->$key);
    }

    public function keys()
    {
        return array_keys($this->_attributes);    
    }

    public function unsavedarray()
    {
        $arr = array();

        foreach ($this->_unsavedAttributes->toarray() as $a) {
            $arr[$a] = $this->_attributes[$a] instanceof Object
                       ? $this->_attributes[$a]->unsavedarray()
                       : $this->_attributes[$a];
        }

        return $arr;
    }

    public static function build($response, $class = null)
    {
        $class = null === $class ? get_class() : $class;

        return new $class($response);
    }

    public function refresh($response)
    {
        $removed = array_diff(array_keys($this->_attributes), array_keys($response));        

        foreach ($removed as $k) {
            unset($this->$k);
        }

        foreach ($response as $key => $value) {
            $this->_attributes[$key] = Util::convertToPagarMeObject($value);    
            $this->_unsavedAttributes->remove($key);
        }

        return $this->_attributes;
    }

    public function serializeParameters()
    {
        $params = array();

        if ($this->_unsavedAttributes) {
            foreach ($this->_unsavedAttributes as $k) {
                $params[$k] = null === $this->{$k} ? $this->{$k} : '';
            }
        }

        return $params;
    }

    protected function _lsb($method)
    {
        $class = get_class($this);
        $args = array_slice(func_get_args(), 1);
        return call_user_func_array(array($class, $method), $args);
    }
    protected static function _scopedLsb($class, $method)
    {
        $args = array_slice(func_get_args(), 2);
        return call_user_func_array(array($class, $method), $args);
    }

    public function __toJSON()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode($this->__toarray(true), JSON_PRETTY_PRINT);
        }

        return json_encode($this->__toarray(true));
    }

    public function __toString()
    {
        return $this->__toJSON();
    }

    public function __toarray($recursive = false)
    {
        if ($recursive) {
            return Util::convertPagarMeObjectToarray($this->_attributes);
        }

        return $this->_attributes;
    }
}