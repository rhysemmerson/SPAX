<?php

namespace Spax\Impl;

use Spax\Attributes as AttributesInterface;
use Spax\SpaxNotImplementedException;

/**
 * Description of Attributes
 *
 * @author Rhys
 */
class ArrayAttributes implements AttributesInterface {

    private $data;
    
    public function __construct($prototype = null) {
        $this->data = array();
    }

    public function addAttribute($qName, $localName, $uri, $type) {
        
        array_push($this->data, array(
            'localName' => $localName,
            'qName' => $qName,
            'uri' => $uri,
            'type' => $type
        ));
    }
    
    public function getLength() {
        return count($this->data);
    }

    public function getLocalName($index) {
        if (array_key_exists($index, $this->data)) {
            return $this->data[$index]['localName'];
        }

        return null;
    }

    public function getQName($index) {
        if (array_key_exists($index, $this->data)) {
            return $this->data[$index]['qName'];
        }

        return null;
    }

    public function getType($key) {
        if (is_int($key)) {
            if (array_key_exists($key, $this->data)) {
                return $this->data[$key]['type'];
            }
        } elseif (is_string($key)) { // qName
            foreach ($this->data as $i => $attr) {
                if ($attr['qName'] == strtolower($key)) {
                    return $attr['type'];
                }
            }
        }

        return null;
    }

    public function getTypeByNamespace($uri, $localName) {
        throw new SpaxNotImplementedException();
    }

    public function getUri($index) {
        if (array_key_exists($index, $this->data)) {
            return $this->data[$index]['uri'];
        }

        return null;
    }

    public function getValue($key) {
        if (is_int($key)) {
            if (array_key_exists($key, $this->data)) {
                return $this->data[$key]['value'];
            }
        } elseif (is_string($key)) { // qName
            foreach ($this->data as $i => $attr) {
                if ($attr['qName'] == strtolower($key)) {
                    return $attr['value'];
                }
            }
        }

        return null;
    }

    public function getValueByNamespace($uri, $localname) {
        throw new SpaxNotImplementedException();
    }

    public function getIndex($qName) {
        foreach ($this->data as $i => $attr) {
            if ($attr['qName'] == strtolower($qName)) {
                return $i;
            }
        }

        return -1;
    }

    public function getIndexByNamespace($uri, $localName) {
        throw new SpaxNotImplementedException();
    }

}

?>
