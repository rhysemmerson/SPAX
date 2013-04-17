<?php

namespace Spax\Impl;

/**
 * Description of Attribute
 *
 * @author New user
 */
class Attribute {

    private $localName;
    private $qName;
    private $uri;
    private $type;

    function __construct($localName, $qName, $uri, $type) {
        $this->localName = $localName;
        $this->qName = $qName;
        $this->uri = $uri;
        $this->type = $type;
    }

    public function getLocalName() {
        return $this->localName;
    }

    public function setLocalName($localName) {
        $this->localName = $localName;
    }

    public function getQName() {
        return $this->qName;
    }

    public function setQName($qName) {
        $this->qName = $qName;
    }

    public function getUri() {
        return $this->uri;
    }

    public function setUri($uri) {
        $this->uri = $uri;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

}

?>
