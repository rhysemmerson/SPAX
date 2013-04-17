<?php

namespace Spax;

interface ContentHandler {
    /**
     * Receive notification of character data.
     * 
     * @param string $ch
     */
    public function characters($ch);
    
    /**
     * Receive notification of the end of a document.
     */
    public function endDocument();
    
    /**
     * Receive notification of the end of an element.
     * 
     * @param string $uri
     * @param string $localName
     * @param string $qName
     */
    public function endElement($uri, $localName, $qName);
    
    /**
     * End the scope of a prefix-URI mapping.
     * 
     * @param string $prefix
     */
    public function endPrefixMapping($prefix);
    
    /**
     * Receive notification of ignorable whitespace in element content.
     * 
     * @param string $ch
     */
    public function ignoreableWhitespace($ch);
    
    /**
     * Receive notification of a processing instruction.
     * 
     * @param string $target
     * @param string $data
     */
    public function processingInstruction($target, $data);
    
    /**
     * Receive an object for locating the origin of SAX document events.
     * 
     * @param type $locator
     */
    public function setDocumentLocator($locator);
    
    /**
     * Receive notification of a skipped entity.
     * 
     * @param string $name
     */
    public function skippedEntity($name);
    
    /**
     * Receive notification of the beginning of a document.
     * 
     * 
     */
    public function startDocument();
    
    /**
     * Receive notification of the beginning of an element.
     * 
     * eg. 
     * 
     * <code>
     * <xml xmlns:foo="http://foobar.com.au/fooxml">
     *      <foo:bar />
     * </xml>
     * </code>
     * 
     * <p>When startElement is called for <foo:bar /> the 
     * args will look like.</p>
     * 
     * <table>
     *  <tr>
     *      <th>uri</th><td>http://foobar.com.au/fooxml</td>
     *      <th>localName</th><td>bar</td>
     *      <th>qName</th><td>foo:bar</td>
     *  </tr>
     * </table>
     * 
     * @see http://sax.sourceforge.net/namespaces.html
     * 
     * @param string $uri The uri of the tag's namespace
     * @param string $localName The tag name
     * @param string $qName The qualified tag name with any prefixes present
     * @param type $atts The attributes of the tag
     */
    public function startElement($uri, $localName, $qName, $atts);
    
    /**
     * Begin the scope of a prefix-URI Namespace mapping.
     * 
     * @param string $prefix
     * @param string $uri
     */
    public function startPrefixMapping($prefix, $uri);
    
}