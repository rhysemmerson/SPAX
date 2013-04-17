<?php

namespace Spax;

interface Attributes {

    /**
     * Look up the index of an attribute by XML qualified (prefixed) name.
     * 
     * @param type $qName
     * @return int The index of the attribute, or -1 if it does not appear in the list.
     */
    public function getIndex($qName);
    
    /**
     * Look up the index of an attribute by Namespace name.
     * 
     * @param string $uri
     * @param string $localName
     * 
     * @return int The index of the attribute, or -1 if it does not appear in the list.
     */
    public function getIndexByNamespace($uri, $localName);

    /**
     * Return the number of attributes in the list.
     * 
     * @return int The number of attributes in the list
     */
    public function getLength();

    /**
     * Look up an attribute's local name by index.
     * 
     * @param int $index
     * 
     * @return The local name of the attribute.
     */
    public function getLocalName($index);

    /**
     * Look up an attribute's XML qualified (prefixed) name by index.
     * 
     * @param int $index
     * 
     * @return The qualified name of the attribute.
     */
    public function getQName($index);

    /**
     * Look up an attribute's type by index or qualified name.
     * <p>
     * The attribute type is one of the strings "CDATA", "ID", "IDREF", "IDREFS", "NMTOKEN", "NMTOKENS", "ENTITY", "ENTITIES", or "NOTATION" (always in upper case).
     * </p>
     * 
     * @param string|int $key The qualified name or index of the attribute.
     * 
     * @return The type of the attribute.
     */
    public function getType($key);
    
    /**
     * Look up an attribute's type by Namespace name.
     * 
     * <p>
     * The attribute type is one of the strings "CDATA", "ID", "IDREF", "IDREFS", "NMTOKEN", "NMTOKENS", "ENTITY", "ENTITIES", or "NOTATION" (always in upper case).
     * </p>
     * 
     * @param string $uri
     * @param string $localName
     * 
     * @return The type of the attribute.
     */
    public function getTypeByNamespace($uri, $localName);

    /**
     * Look up an attribute's Namespace URI by index.
     * 
     * @param int $index
     */
    public function getUri($index);

    /**
     * Get the value of an attribute by index or qualified name.
     * 
     * @param int|string $key The index or qualified name of the attribute
     */
    public function getValue($key);
    
    /**
     * Get the value of an attribute by local name and namespace
     * 
     * @param string $uri the uri of the namespace
     * @param string $localname the local name of the attribute
     */
    public function getValueByNamespace($uri, $localname);
}