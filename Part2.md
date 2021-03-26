# Implementing a SOAP API with PHP Part 2 - Refactoring API

In this part, we shall simply refactor the code, by putting the logic to retrieve the book information in its own class.

This class shall be named ```BookService.php```. we shall define a ```composer.json``` to enable the file to be autoloaded.

```json
composer.json
{
    "autoload":{
        "psr-0":{
            "Bookcatalog":"libs"
        }
    }
}
```

BookService.php is now defined as follows.

```php
<?php
namespace Bookcatalog;

class BookService{
 public function __construct(){
        $this->_books  = [
            ['id'=>'5409' , 'name'=>'Programming for Dummies','year'=>2011,'price'=>'12.09'],
            ['id'=>'2311','name'=>'Project Management 101','year'=>2017,'price'=>'20.09'],
            ['id'=>'98777','name'=>'Rust Development','year'=>2020,'price'=>'32.09'],
        ];
    }

    public function bookYear($id){  
        $bookYear = "";
        foreach($this->_books as $bk){
            if($bk['id']==$id)
                return $bk['year']; // book found
            }

        return $bookYear; // book not found
    }

    public function bookDetails($book){  
        foreach($this->_books as $bk){
            if($bk['name']==$book->name)
                return json_encode($bk);
        }
        return ""; // book not found
    }

}
```

The server.php now becomes

```php
<?php
ini_set("soap.wsdl_cache_enabled", "0");
require_once __DIR__ . "/vendor/autoload.php";

$class = "Bookcatalog\BookService";
$wsdl = NULL;

// initialize SOAP Server
$server=new SoapServer($wsdl,[
    'uri'=>"http://localhost:8091/server.php"
]);

$server->setClass($class);

// start handling requests
$server->handle();
```

The reason we have refactored the bookService to its own namespace, is that we need to generate a .wsdl file from the class definition.

[Implementing a SOAP API with PHP Part 3 - Generate WSDL](Part3.md)
