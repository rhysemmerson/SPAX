<?php

namespace Spax\Impl;

use Spax\ContentHandler;
use Spax\SpaxNotImplementedException;
use Spax\XmlReader as XmlReaderInterface;

/**
 * <p>A default implementation of XmlReader</p>
 *
 * @author Rhys
 */
class XmlReader implements XmlReaderInterface {

    /**
     * Prefixed namespaes
     * 
     * @var spax\impl\Namespaces 
     */
    protected $namespaces;

    /**
     * Default namespaces
     * 
     * @var spax\impl\Namespaces 
     */
    protected $defaultNamespaces;

    /**
     * in order to trigger the endPrefixMapping event the element a
     * prefix is assigned on has to be identified. 
     */
    protected $nsElements = array();
    public $array = array();
    public $parse_error = false;
    private $parser;
    private $pointer;
    private $contentHandler;

    public function __construct() {
        $this->namespaces = new Namespaces();
        $this->defaultNamespaces = new Namespaces();
        $this->pointer = & $this->array;
        $this->parser = xml_parser_create("UTF-8");
        xml_set_object($this->parser, $this);
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($this->parser, "startElement", "endElement");
        xml_set_character_data_handler($this->parser, "cdata");
    }

    public function parse($input) {
        $this->getContentHandler()->startDocument();

        $handle = fopen($input, 'r') or die('Cannot open file:  ' . $input);

        while (($buffer = fread($handle, 4096)) != false) {
            $final = (strlen($buffer) < 4095);
            $this->parse_error = xml_parse($this->parser, ltrim($buffer), $final) ? false : true;
        }

        fclose($handle);
        $this->getContentHandler()->endDocument();
    }

    /**
     * 
     * @param type $parser
     * @param type $tag
     * @param type $attributes
     */
    private function startElement($parser, $tag, $attributes) {
        $attrs = new ArrayAttributes();
        $localName = $qName = $tag;
        $uri = '';

        // analyze attributes first to grab any namespaces
        // we'll merge all ns's on this element with the others
        $namespaces = new Namespaces();
        $nsElement = false;
        foreach ($attributes as $key => $value) {
            $attrLocalName = $attrQName = $key;
            $attrUri = '';

            $matches = array();
            if (preg_match_all('|^(.*):(.*)$|i', $key, $matches)) {
                if ($matches[1][0] === 'xmlns') {
                    // Prefixed namespace decl

                    if (array_key_exists($qName, $this->nsElements) && !$nsElement)
                        $this->nsElements[$qName]++;
                    else
                        $this->nsElements[$qName] = 0;

                    $nsElement = true;

                    $namespaces->add($matches[2][0], $value, $qName, $this->nsElements[$qName]);

                    // startPrefixMapping($prefix, $uri)
                    $this->getContentHandler()->startPrefixMapping($matches[2][0], $value);
                } elseif (($ns = $this->namespaces->getByPrefix($matches[1][0])) != null)
                    $attrUri = $ns->uri;

                $attrQName = $matches[1][0];
                $attrLocalName = $matches[2][0];
            } elseif ($key === 'xmlns') {
                // Default namespaces decl
                if (array_key_exists($qName, $this->nsElements) && !$nsElement)
                    $this->nsElements[$qName]++;
                else
                    $this->nsElements[$qName] = 0;

                $nsElement = true;
                $this->defaultNamespaces->add("", $value, $qName, $this->nsElements[$qName]);

                // startPrefixMapping('', $uri);
                $this->getContentHandler()->startPrefixMapping('', $value);
            }

            $attrs->addAttribute($attrQName, $attrLocalName, $attrUri, 'CDATA');
        }

        if ($nsElement) // there's namespaces on this element
            $this->namespaces->merge($namespaces);

        if (array_key_exists($qName, $this->nsElements) && !$nsElement)
            $this->nsElements[$qName]++;
        else
            $this->nsElements[$qName] = 0;

        $matches = array();
        if (preg_match_all('|^(.*):(.*)$|i', $tag, $matches)) {
            if (($ns = $this->namespaces->getByPrefix($matches[1][0])) != null)
                $uri = $ns->uri;
            // TODO: else throw exception unknown namespace
            $localName = $matches[2][0];
        } else {
            $ns = $this->defaultNamespaces->top();
            if (isset($ns))
                $uri = $ns->uri;
        }
        $this->getContentHandler()->startElement($uri, $localName, $qName, $attrs);
    }

    private function endElement($parser, $tag) {
        $localName = $qName = $tag;
        $uri = '';

        $matches = array();
        if (preg_match_all('|^(.*):(.*)$|i', $tag, $matches)) {
            $ns = $this->namespaces->getByPrefix($matches[1][0]);
            if ($ns != null)
                $uri = $ns->uri;
            $localName = $matches[2][0];
        } else {
            $defaultNs = $this->defaultNamespaces->top();
            if (isset($defaultNs))
                $uri = $defaultNs->uri;
        }

        $this->getContentHandler()->endElement($uri, $localName, $qName);

        if (array_key_exists($qName, $this->nsElements)) {
            $endNamespaces = $this->namespaces->getByElement($qName, $this->nsElements[$qName]);

            $defaultNs = $this->defaultNamespaces->top();
            if (isset($defaultNs) && $defaultNs->element == $tag && $defaultNs->index == $this->nsElements[$qName]) {
                $endNamespaces []= $this->defaultNamespaces->pop();
            }
            $this->nsElements[$qName]--;
            if ($this->nsElements[$qName] === -1)
                unset($this->nsElements[$qName]);
        }

        if (isset($endNamespaces)) {
            foreach ($endNamespaces as $ns) {
                $this->getContentHandler()->endPrefixMapping($ns->prefix); // exiting a namespace context
            }
        }
    }

    /**
     * 
     * @todo Test for ignoreable whitespace
     * 
     * @param type $parser
     * @param type $cdata
     */
    private function cdata($parser, $cdata) {
        /*
         * if (isIgnoreableWhitespace) {
         *      $this->getContentHandler()->ignoreableWhitespace();
         * }
         */
        $this->getContentHandler()->characters($cdata);
    }

    public function getContentHandler() {
        return $this->contentHandler;
    }

    public function getDTDHandler() {
        throw new SpaxNotImplementedException();
    }

    public function getEntityResolver() {
        throw new SpaxNotImplementedException();
    }

    public function getErrorHandler() {
        throw new SpaxNotImplementedException();
    }

    public function getFeature($name) {
        throw new SpaxNotImplementedException();
    }

    public function getProperty($name) {
        throw new SpaxNotImplementedException();
    }

    public function setContentHandler(ContentHandler $handler) {
        $this->contentHandler = $handler;
    }

    public function setDTDHandler($handler) {
        throw new SpaxNotImplementedException();
    }

    public function setEntityResolver($resolver) {
        throw new SpaxNotImplementedException();
    }

    public function setErrorHandler($handler) {
        throw new SpaxNotImplementedException();
    }

    public function setFeature($name, $value) {
        throw new SpaxNotImplementedException();
    }

    public function setProperty($name, $value) {
        throw new SpaxNotImplementedException();
    }

}

?>
