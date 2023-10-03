<?php

include "areas.php";
class Api
{

	private $host = "localhost";
	private $username = "u934929740_cma_us";
	private $password = "eT5]kWoNh";
	private $database = "u934929740_cma";
	
    private $table = "config_campos";
    private $responsedata = array();
    

    function __construct()
    {   
    	
    	$this->dbConnect();	
    }

    private function dbConnect()
    {

    	$this->connection = null;

    	try {

    		$this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);

    	} catch (PDOException $e) {

    		echo "Error: " . $e->getMessage();
    	}
    }

    public function resquest()		
    {
    	$this->_data_response = $this->responsedata;
	    //print_r($this->get_input);
    }

    public function area($ar){

		print_r($ar);
	
    	$result = $this->connection->prepare('SELECT * FROM '.$this->table.' ');

    	$result->execute();

    	$num_rowse = $result->rowCount();
        echo "dsds<br>";
    	if ($num_rowse>0) {
            echo "dsds<br>";

    		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    			$this->responsedata[] = $row;
    		}
    	}

    	$texto = strtolower($cadena);
         echo ucfirst($texto);


    	foreach ($ar as $key => $value) {
      
           // echo $value['valor']."</BR>";
            $texto = strtolower($value['valor']);
            // echo ucfirst($texto)."</BR>";

			echo "array( <br>";
			echo    'status';
			echo    '=><br>'; 
			echo 	$value['id']."<br>"; 
		    echo   "method =><br>"; 

			echo $value['valor'];
			//echo	 ucfirst($texto)."<br>";
			echo	")<br>"; 
		    /*echo "array( <br>";
				
			echo    'status';
			echo    '=><br>'; 
			echo 	$value['id']."<br>"; 

		    echo   "method =><br>"; 
				 
			echo	 $value['valor']."<br>";
			echo	")<br>"; */

    	}
    }

   

    public function areaUpdate($arr){

		foreach ($arr as $key => $value) {
		
			try {



				$result = $this->connection->prepare('UPDATE config_campos  SET valor=? WHERE id=?');

				$result->execute(array($value['valor'], $value['id']));
				
	
			} catch (PDOException $e) {
	
				echo "Error: " . $e->getMessage();
	
			}
		}

		echo "master +++++";
    	
    }    
}

$new = new Api();
//$new->area($ar);

$new->areaUpdate($ar);
