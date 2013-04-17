<?php

namespace Spax;

interface XmlReader {

    /**
     * Return the current content handler.
     * 
     * @return \spax\ContentHandler
     */
    public function getContentHandler();

    /**
     * Return the current DTD handler.
     */
    public function getDTDHandler();

    /**
     * Return the current entity resolver.
     */
    public function getEntityResolver();

    /**
     * Return the current error handler.
     */
    public function getErrorHandler();

    /**
     * Look up the value of a feature flag.
     * 
     * @param string $name
     */
    public function getFeature($name);

    /**
     * Look up the value of a property.
     * 
     * @param string $name
     */
    public function getProperty($name);

    /**
     * Parse an XML document.
     * 
     * @param mixed $input
     */
    public function parse($input);

    /**
     * Allow an application to register a content event handler.
     * 
     * @param type $handler
     */
    public function setContentHandler(\spax\ContentHandler $handler);

    /**
     * Allow an application to register a DTD event handler.
     * 
     * @param type $handler
     */
    public function setDTDHandler($handler);

    /**
     * Allow an application to register an entity resolver.
     * 
     * @param type $resolver
     */
    public function setEntityResolver($resolver);

    /**
     * Allow an application to register an error event handler.
     * 
     * @param type $handler
     */
    public function setErrorHandler($handler);

    /**
     * Set the value of a feature flag.
     * 
     * @param type $name
     * @param type $value
     */
    public function setFeature($name, $value);

    /**
     * Set the value of a property.
     * 
     * @param type $name
     * @param type $value
     */
    public function setProperty($name, $value);
}