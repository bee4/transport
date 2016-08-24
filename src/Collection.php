<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport
 */

namespace Bee4\Transport;

use ArrayAccess;
use Countable;
use ArrayIterator;

/**
 * Data collection implementation
 * @package Bee4\Transport
 */
class Collection implements ArrayAccess, Countable
{
    /**
     * Data collection as array
     * @var array
     */
    private $data;

    /**
     * Callback filter to be applied on all values
     * @var callable|null
     */
    private $valueFilter;

    /**
     * Callback filter to be applied on all keys
     * @var callable|null
     */
    private $keyFilter;

    /**
     * Build Collection
     * @param array         $data
     * @param callable|null $key
     * @param callable|null $value
     */
    public function __construct(array $data = [])
    {
        $this->data        = $data;
    }

    /**
     * Set the keyFilter callable
     * @param  callable $key
     * @return Collection
     */
    public function withKeyFilter(callable $key)
    {
        $this->keyFilter = $key;
        return $this;
    }

    /**
     * Set the valueFilter callable
     * @param  callable $value
     * @return Collection
     */
    public function withValueFilter(callable $value)
    {
        $this->valueFilter = $value;
        return $this;
    }

    /**
     * Build a new Collection from an existing array
     * @param  array  $data
     * @return Collection
     */
    public static function fromArray(array $data)
    {
        return new self($data);
    }

    /**
     * @see \Countable::count
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @see \ArrayAccess::offsetGet
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $offset = $this->key($offset);
        return isset($this->data[$offset])?$this->data[$offset]:null;
    }

    /**
     * @see \ArrayAccess::offsetSet
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $this->value($value);
        } else {
            $offset = $this->key($offset);
            $this->data[$offset] = $this->value($value);
        }
    }

    /**
     * @see \ArrayAccess::offsetExists
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return array_key_exists($this->key($offset), $this->data);
    }

    /**
     * @see \ArrayAccess::offsetUnset
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $offset = $this->key($offset);
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * Handle value to be used in the collection
     * @param  mixed $item
     * @return mixed The filtered value
     */
    protected function value($item)
    {
        return $this->handle(
            $item,
            $this->valueFilter
        );
    }

    /**
     * Handle key to be used in the collection
     * @param  mixed $item
     * @return mixed The filtered key
     */
    protected function key($item)
    {
        return $this->handle(
            $item,
            $this->keyFilter
        );
    }

    /**
     * Filter an item with a callback
     * @param  mixed         $item
     * @param  callable|null $filter
     * @return mixed
     */
    protected function handle($item, callable $filter = null)
    {
        if (null !== $filter) {
            return call_user_func($filter, $item);
        }
        return $item;
    }

    /**
     * Flush all items from the collection
     * @return Collection
     */
    public function flush()
    {
        $this->data = [];
        return $this;
    }

    /**
     * Transform the collection to a basic array
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @see \IteratorAggregate::getIterator
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}
