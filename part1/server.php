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