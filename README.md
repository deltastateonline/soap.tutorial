# Implementing a SOAP API with PHP Part 1

Table of contents

1. [Introduction](#introduction)
2. [Refactoring API](Part2.md)
3. [Generating WSDL file](Part2.md)

## Introduction <a name="introduction"></a>

I recently had to implement some integration with one of our partners, who use SOAP.

It had been a while since I worked on SOAP, so I tried refreshing my knowledge, but had a lot of problems getting all the information I needed in one place so I decided to create these notes.


### Creating a SOAP Endpoint

The endpoint is the URL where your service can be accessed by a client application. To inspect the WSDL you just add ?wsdl to the web service endpoint URL.

We shall be building a simple books catalog service, which can be integrated with using a php and python soap client.

#### Requirements

In PHP , to get a SOAP API working you need

- PHP 7+
- Enable extension=php_soap.dll in your php.ini file

I have decided to use the php internal server for this tutorial.  A server can be started by using,

```shell
php -S localhost:8091
```

A simple server file can be created as follows ``` server.php ```

```php
<?php
    ini_set("soap.wsdl_cache_enabled", "0");    
    class BookService{
        
        private $_books = NULL;

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
    $class = "BookService";
    
    $wsdl = NULL;

    // initialize SOAP Server
    $server=new SoapServer($wsdl,[	
        'uri'=>"http://localhost:8091/server.php"
    ]);

    $server->setClass($class);

    // start handling requests
    $server->handle();
?>
```

Next we shall create a client file ```client.php```to make request to the soap endpoint.

```php
<?php
// Request Model
class Book
{
    public $name;
    public $year;
}

class Client{

    public $instance = NULL;


    public function __construct()
    {
        $params = array(
            'location'=>'http://localhost:8091/server.php?wsdl',
            'uri' =>  'urn://localhost:8091/server.php?wsdl'  ,
            'trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE    );
        $this->instance =  new SoapClient(NULL, $params);       
    }

    public function getBookYr($id_array){
        return $this->instance->__soapCall('bookYear', $id_array);
    }

    public function getBookDetails($book){
        return $this->instance->__soapCall('bookDetails', [$book]);
    }

}

$client = new Client;
$bookId = array("5409");

// create instance and set a book name
$book =new Book();
$book->name='Rust Development';

try{
    echo "Booking Year\t: " , $client->getBookYr($bookId),"\n";
    echo "Booking Details\t: " ,$client->getBookDetails($book),"\n";
    echo "Done\n";
}catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
```

```shell
C:\Development\soap.tutorial> php .\client.php
Booking Year    : 2011
Booking Details : {"id":"98777","name":"Rust Development","year":2020,"price":"32.09"}
Done
```

This tutorial show you that this is quite simple to get up and running.

However this implementation is quite naive and quite unstructured. It is virtaully impossible to make SOAP request to from a python client with the endpoint in its current state.

However the php client will work in its current state as shown.

In the part 2, we shall refactor the server code to make use of php autoloading features.

[Implementing a SOAP API with PHP Part 2 - Refactoring API](Part2.md)
