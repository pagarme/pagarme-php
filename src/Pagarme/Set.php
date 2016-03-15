<?php
namespace Pagarme;

/**
 * Class Set
 * @package Pagarme
 */
class Set implements \Iterator
{

    private $_values;
    private $_orderedValues;
    private $_position;


    /**
     * @param array $members
     */
    public function __construct(array $members = array())
    {
        $this->_values        = Array();
        $this->_position      = 0;
        $this->_orderedValues = Array();

        foreach ($members as $m):
            if (! isset($this->_values[$m]))
                $this->_orderedValues[] = $m;

            $this->_values[$m] = true;
        endforeach;
    }

    /**
     * @param $member
     * @return bool
     */
    public function includes($member)
    {
        return isset($this->_values[$member]);
    }

    /**
     * @param $member
     * @return $this
     */
    public function add($member)
    {
        $this->_values[$member] = true;

        return $this;
    }

    /**
     * @param $member
     */
    public function remove($member)
    {
        unset($this->_values[$member]);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_keys($this->_values);
    }

    /**
     *
     */
    public function rewind()
    {
        $this->_position = 0;
    }

    /**
     * @return array
     */
    public function current()
    {
        return $this->_orderedValues[$this->_position];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * @return int
     */
    public function next()
    {
        return ++$this->_position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->_orderedValues[$this->_position]);
    }
}
