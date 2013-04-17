Simple PHP API for XML
====

The aim of SPAX is to provide an lightweight, object oriented event driven XML API for PHP.

Why? The event driven XML API included in the SPL is not object oriented and only has partial 
namespace support.  The other SPL XML APIs are DOM style APIs which are slow and overkill in most
cases, this forces developers to implement crude and often brittle event logic over the top of these DOM APIs.

SPAX contains a non-validating PHP implementation which wraps XMLParser and should work in any 
environment.

Usage
----
To consume XML data you will need to create a class that implements Spax\ContentHandler. The easiest way to do
this is to extend Spax\Helper\DefaultHandler and override the methods you need.

    class MyHandler extends Spax\Helper\DefaultHandler {
        public $numElements = 0;

        // override
        public function startElement($uri, $localName, $qName, $atts) {
            // your logic goes here
            $this->numElements++;
            
            echo "start '" . $localName . "' and that makes " . $this->numElements . " element(s).";
        }

        public function characters($cdata) {
            echo "'$cdata'";
        }

        public function endElement($uri, $localName, $qName) {
            $this->numElements--;
            
            echo "end '" . $localName . "' and that makes " . $this->numElements . " element(s).";
        }
    }
    
You can then pass an instance of your handler class to an XmlReader like so. 

    $xmlReader = new XmlReader();
    $handler = new MyHandler();
    $xmlReader->setContentHandler($handler);

    $xmlReader->parse("c:/path/to/xmlfile.xml");

XML

    <html>
        <head>some content in head</head>
        <body>some content in body</body>
    </html>

Output

    start 'html' and that makes 1 open element(s).
    start 'head' and that makes 2 open element(s).
    'some content in head'
    end 'head' and that makes 1 open element(s). 
    start 'body' and that makes 2 open element(s).
    'some content in body'
    end 'body' and that makes 1 open element(s).
    end 'html' and that makes 0 open element(s).

0.0.1
----
The first version implements only the essentials.  Namespaces and attributes are fully supported however
the unit tests are incomplete so this is not a stable release.  The Parser will only accept a file path 
presently, accepting strings of xml is a high priority.
