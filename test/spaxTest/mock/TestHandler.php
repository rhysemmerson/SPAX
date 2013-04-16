<?php

namespace spaxTest\mock;

use spax\helper\DefaultHandler;

/**
 * This mock object records the method calls made against it. This
 * is important to test because the order of the calls imply the 
 * structure of the xml being parsed.
 *
 * It would be nice to integrate this with PHPUnit somehow.
 * 
 * @author Rhys Emmerson
 */
class TestHandler extends DefaultHandler {

    public $methodCalls = array();
    public $methodStack;
    private $mockMethods = array();

    /**
     * 
     * @param array $methods The methods to mock, if none given then all methods will be mocked
     */
    public function __construct($methods = array()) {

        foreach ($methods as $method)
            $this->mockMethods[] = 'spaxTest\\mock\\TestHandler::' . $method;
    }

    private function addToStack($name, $args) {
        if (count($this->mockMethods) === 0 || in_array($name, $this->mockMethods))
            array_push($this->methodCalls, array('name' => $name, 'arguments' => $args));
    }

    public function get($index) {
        return $this->methodCalls[$index];
    }

    public function characters($cdata) {
        $this->addToStack(__METHOD__, func_get_args());
    }

    public function endDocument() {
        $this->addToStack(__METHOD__, func_get_args());
    }

    public function endElement($uri, $localName, $qName) {
        $this->addToStack(__METHOD__, func_get_args());
    }

    public function startPrefixMapping($prefix, $uri) {
        $this->addToStack(__METHOD__, func_get_args());
    }

    public function endPrefixMapping($prefix) {
        $this->addToStack(__METHOD__, func_get_args());
    }

    public function startDocument() {
        $this->addToStack(__METHOD__, func_get_args());
    }

    public function startElement($uri, $localName, $qName, $atts) {
        $this->addToStack(__METHOD__, func_get_args());
    }

    public function toString() {
        $string = "";
        foreach ($this->methodCalls as $method) {
            $string .= $method['name'] . '(';
            foreach ($method['arguments'] as $key => $arg) {
                if (is_object($arg))
                    $arg = "Attributes";
                if ($key != 0)
                    $string .= ", $arg";
                else
                    $string .= $arg;
            }
        
        $string .= ")\n";
        }
        return $string;
    }

}

?>
