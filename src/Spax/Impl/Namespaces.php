<?php

namespace Spax\Impl;

use ArrayIterator;
use ArrayObject;
use IteratorAggregate;
use Spax\SpaxInvalidArgumentException;

/**
 * Description of Namespaces
 *
 * @author New user
 */
class Namespaces implements IteratorAggregate {

    protected $data = array();

    public function __construct() {
        
    }

    public function add($prefix, $uri, $element, $index) {
        $namespace = new ArrayObject();
        $namespace->prefix = $prefix;
        $namespace->element = $element;
        $namespace->uri = $uri;
        $namespace->index = $index;

        $this->data [] = $namespace;

        return $namespace;
    }

    public function getByPrefix($prefix) {
        return $this->get($prefix, 'prefix');
    }

    public function getByUri($uri) {
        return $this->get($uri, 'uri');
    }

    public function getByElement($element, $index) {
        $namespaces = array();
        foreach ($this->data as $namespace)
            if ($namespace->element == $element && $namespace->index == $index)
                $namespaces [] = $namespace;

        return $namespaces;
    }

    public function top() {
        $length = count($this->data);
        if ($length > 0) {
            return $this->data[$length - 1];
        } else
            return null;
    }

    public function pop() {
        return array_pop($this->data);
    }

    public function get($value, $field) {
        if (!in_array($field, array('prefix', 'uri', 'element')))
            throw new SpaxInvalidArgumentException();

        foreach ($this->data as $namespace) {
            if ($namespace->{$field} == $value)
                return $namespace;
        }

        return null;
    }

    public function merge(Namespaces $namespaces) {
        $this->data = array_merge($this->data, $namespaces->data);
    }

    public function getIterator() {
        return new ArrayIterator($this->data);
    }

}

?>
