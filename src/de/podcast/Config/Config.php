<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 21.11.15
 * Time: 12:49
 */

namespace de\podcast\config;

class Config implements \Iterator
{

    private $aVal;

    function __construct()
    {
        $this->aVal = array();
    }

    function __get($name)
    {
        if (array_key_exists($name, $this->aVal)) {
            return $this->aVal[$name];
        }

        return null;
    }

    function __set($name, $value)
    {
        $this->aVal[$name] = $value;
    }

    function __isset($name)
    {
        return array_key_exists($name, $this->aVal);
    }

    function __unset($name)
    {
        if (array_key_exists($name, $this->aVal)) {
            unset($this->aVal[$name]);
        }
    }

    function __toString()
    {
        $ret = "";
        foreach ($this->aVal as $key => $value) {
            $ret .= " $key";
        }
        return $ret;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return current($this->aVal);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->aVal);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->aVal);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->aVal);
    }
}