# Implementing a SOAP API with PHP - Generating WSDL

According to google
>WSDL is an XML format for describing network services as a set of endpoints operating on messages containing either document-oriented or procedure-oriented information. The operations and messages are described abstractly, and then bound to a concrete network protocol and message format to define an endpoint.

Having a wsdl definition is one of the requirements for using other programming langurages to interact with the end point.

We need to create a wsdl for the BookService.
There are a few php packages which can generate the wsdl, I found this
[PHP-Generate-WSDL-from-PHP-classes-code](https://www.phpclasses.org/package/3509-PHP-Generate-WSDL-from-PHP-classes-code.html)

It is quite simple to use as shown in the example code.

```php
<?php
require_once __DIR__ . "/vendor/autoload.php";

$class = "Bookcatalog\BookService";

$serviceURI = "http://localhost:8091";
$wsdlGenerator = new PHP2WSDL\PHPClass2WSDL($class, $serviceURI);


$wsdlGenerator->generateWSDL(true);
// Dump as string
$wsdlXML = $wsdlGenerator->dump();
// Or save as file
$wsdlXML = $wsdlGenerator->save('book.wsdl');

```
However this will generate the follwoing 

