<?php
namespace Pagarme;

use Exception;

use Pagarme\Set as PagarmeSet,
    Pagarme\Object as PagarmeObject,
    Pagarme\Util as PagarmeUtil;

/**
 * Class Object
 * @package Pagarme
 */
class Object implements \ArrayAccess, \Iterator
{

    protected $_attributes;
    protected $_unsavedAttributes;
    private   $_position;

    /**
     * @param array $response
     */
    public function __construct($response = array())
    {
        $this->_attributes        = Array();
        $this->_unsavedAttributes = new PagarmeSet();
        $this->_position          = 0;

        $this->refresh($response);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     * @throws Exception
     */
    public function __set($key, $value)
    {
        if ($key == "")
            throw new Exception('Cannot store invalid key');


        $this->_attributes[$key] = $value;
        $this->_unsavedAttributes->add($key);

        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->_attributes[$key]);
    }

    /**
     * @param $key
     * @return $this
     */
    public function __unset($key)
    {
        unset($this->_attributes[$key]);
        $this->_unsavedAttributes->remove($key);

        return $this;
    }

    /**
     * @param $key
     * @return array|null
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->_attributes))
            return $this->_attributes[$key];

        else
            return null;

    }

    /**
     * @param $name
     * @param $arguments
     * @return array|null
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        $var = Util::fromCamelCase(substr($name, 3));
        if (! strncasecmp($name, 'get', 3))
            return $this->$var;

        else if (! strncasecmp($name, 'set', 3))
            $this->$var = $arguments[0];

        else
            throw new \Exception('Metodo inexistente ' . $name);

    }

    /**
     * @return $this
     */
    public function rewind()
    {
        $this->_position = 0;

        return $this;
    }

    /**
     * @return array
     */
    public function current()
    {
        return $this->_attributes[$this->key()];
    }

    /**
     * @return mixed
     */
    public function key()
    {
        $keys = $this->keys();

        if (isset($keys[$this->_position]))
            return $keys[$this->_position];

    }

    /**
     * @return $this
     */
    public function next()
    {
        ++$this->_position;

        return $this;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $keys = $this->keys();

        return isset($keys[$this->_position]);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function offsetSet($key, $value)
    {
        $this->$key = $value;

        return $this;
    }

    /**
     * @param mixed $key
     * @return array|null
     */
    public function offsetGet($key)
    {
        return $this->$key;
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->_attributes);
    }

    /**
     * @param mixed $key
     * @return $this
     */
    public function offsetUnset($key)
    {
        unset($this->$key);

        return $this;
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->_attributes);
    }

    /**
     * @return array
     */
    public function unsavedArray()
    {
        $arr = array();

        foreach ($this->_unsavedAttributes->toArray() as $a)
            if ($this->_attributes[$a] instanceof PagarmeObject)
                $arr[$a] = $this->_attributes[$a]->unsavedArray();

            else
                $arr[$a] = $this->_attributes[$a];

        return $arr;
    }

    /**
     * @param $response
     * @param null $class
     * @return mixed
     */
    public static function build($response, $class = null)
    {
        if (! $class)
            $class = get_class();

        $obj = new $class($response);

        return $obj;
    }

    /**
     * @param $response
     * @return array
     */
    public function refresh($response)
    {
        $removed = array_diff(array_keys($this->_attributes), array_keys($response));

        foreach ($removed as $k)
            unset($this->$k);


        foreach ($response as $key => $value) {
            $this->_attributes[$key] = PagarmeUtil::convertToPagarMeObject($value);
            $this->_unsavedAttributes->remove($key);
        }

        return $this->_attributes;
    }

    /**
     * @return array
     */
    public function serializeParameters()
    {
        $params = array();
        if ($this->_unsavedAttributes)
            foreach ($this->_unsavedAttributes as $k) {
                $v = $this->$k;
                if ($v === null)
                    $v = '';

                $params[$k] = $v;
            }


        return $params;
    }

    /**
     * @param $method
     * @return mixed
     */
    protected function _lsb($method)
    {
        $class = get_class($this);
        $args  = array_slice(func_get_args(), 1);

        return call_user_func_array(array($class, $method), $args);
    }

    /**
     * @param $class
     * @param $method
     * @return mixed
     */
    protected static function _scopedLsb($class, $method)
    {
        $args = array_slice(func_get_args(), 2);

        return call_user_func_array(array($class, $method), $args);
    }

    /**
     * @return string
     */
    public function __toJSON()
    {
        if (defined('JSON_PRETTY_PRINT'))
            return json_encode($this->__toArray(true), JSON_PRETTY_PRINT);

        else
            return json_encode($this->__toArray(true));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->__toJSON();
    }

    /**
     * @param bool|false $recursive
     * @return array
     */
    public function __toArray($recursive = false)
    {
        if ($recursive)
            return PagarmeUtil::convertPagarMeObjectToArray($this->_attributes);

        else
            return $this->_attributes;
    }

}
