# Implementing a SOAP API with PHP - Python Client

With a minium amount of searching for the phrase "soap python", one of the top rated tutorial I found was [Working with SOAP based Web Service using Python](https://medium.com/@ayushi21095/working-with-soap-based-web-service-using-python-8f532195bc6c).

It is quite straight forward to get a client for our endpoint up and running.

```python
import sys
from zeep import Client

import logging

logging.basicConfig(format='%(levelname)s : %(message)s',
                    level=logging.INFO)


def main(argv):

    wsdl = "http://localhost:8091/server.php?wsdl"

    client1 = Client(wsdl)

    request_data = {'id':'5409'}
    response=client1.service.bookYear(**request_data)
    logging.info(f"Response  {response}")  

    # book = Book('Test 2', None)  
    book = {
        'name':'Rust Development',
        'year': 2020
    } 

    response=client1.service.bookDetails(book=book)
    logging.info(f"Response {response}")  


if __name__ == "__main__":
    # execute only if 
    # run as a script
    main(sys.argv[1:])


```

The script is executed as follows.

```bash
(.venv) PS C:\Development\python.soap> python .\client.py
INFO : Response  2011
INFO : Response {"id":"98777","name":"Rust Development","year":2020,"price":"32.09"}
(.venv) PS C:\Development\python.soap> 

```

This seems quite simple now, however it took me about while to get the solution to work mainly because I did not intially create a valid wsdl file.
This resulted with no response been produced or an invalid response.

I hope this helps someone trying to wrap their head around working with SOAP. Although SOAP is quite old and is been superceed by REST and GRPC, there are still some systems out there that can only be integrated with via SOAP.

[Implementing a SOAP API with PHP Part 1](README.md)
