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