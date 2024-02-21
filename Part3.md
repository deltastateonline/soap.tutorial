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

The wsdl file can now be specified in the server constructor as follows

```php
<?php
ini_set("soap.wsdl_cache_enabled", "0");
require_once __DIR__ . "/vendor/autoload.php";

$class = "Bookcatalog\BookService";
$wsdl = "book.wsdl";


// initialize SOAP Server
$server=new SoapServer($wsdl,[
    'uri'=>"http://localhost:8091/server.php"
]);

$server->setClass($class);

// start handling requests
$server->handle();
```

To be able to generate a fully functional wsdl file however, the BookService class has to be fully annotated before the file is generated.

## Annotations

- @soap : On all methods that have to be exposed.
- @param : On input paramters.
- @return : On return types.
- @var : On fields in an input or output class definition.


The ```BookService.php``` is now defined as follows

```php
<?php
namespace Bookcatalog;

class BookService
{
 public function __construct(){
        $this->_books  = [
            ['id'=>'5409' , 'name'=>'Programming for Dummies','year'=>2011,'price'=>'12.09'],
            ['id'=>'2311','name'=>'Project Management 101','year'=>2017,'price'=>'20.09'],
            ['id'=>'98777','name'=>'Rust Development','year'=>2020,'price'=>'32.09'],
        ];
    }

 /**
  * @soap
  * @param integer $id
  * @return integer  
  */
    public function bookYear($id){
  
        $bookYear = "";
        foreach($this->_books as $bk){
            if($bk['id']==$id)
                return $bk['year']; // book found
        }

        return $bookYear; // book not found
    }

 /**
  * @soap
  * @param Bookcatalog\Book $book
  * @return string  
  */
 public function bookDetails($book){  
    foreach($this->_books as $bk){
        if($bk['name']==$book->name)
            return json_encode($bk);
    }
    return ""; // book not found
 }
}
```

Because an input parameter $book is been used, a definition is needed for it. Also the definition for the class has to be fully qualified.

```Book.php``` is defined as follows

```php
<?php
namespace Bookcatalog;

class Book
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $year;
}
```
[Implementing a SOAP API with PHP Part 4 - Using Python](Part4.md)

[Implementing a SOAP API with PHP Part 1](README.md)
