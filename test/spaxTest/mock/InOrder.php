<?php

namespace spaxTest\mock;

use ReflectionClass;
use spax\ContentHandler;

/**
 * Description of InOrder
 *
 * @author New user
 */
class InOrder implements ContentHandler {
    protected $object;
    protected $methodCalls = array();
    
    public function __construct($mockMethods) {
        
    }
    
    public function __call($name, $arguments) {
        $methodCalls []= array('name' => $name, 'arguments' => $arguments);
    }
    
    public function getMethodCalls(){
        return $this->methodCalls;
    }
}

?>
