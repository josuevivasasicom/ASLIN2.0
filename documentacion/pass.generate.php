
<?php
/* function pass_hash($pass){
    $opciones = [ 'nocuinino' => 12 ];
    $hash = password_hash($pass, PASSWORD_BCRYPT, $opciones);
    return $hash;
}

$pass= pass_hash("Jsusabgns&957");

echo $pass; */

class Api
{

	/* private $host = "localhost";
	private $username = "u934929740_cma_us";
	private $password = "eT5]kWoNh";
	private $database = "u934929740_cma"; */

    private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "0cma";
	
    private $table = "usuarios";
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

    public function user(){

    	$result = $this->connection->prepare('SELECT * FROM '.$this->table.' ');

    	$result->execute();

    	$num_rowse = $result->rowCount();
        echo "dsds<br>";
    	if ($num_rowse>0) {
     

    		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    			
                echo "gener(".$row['id'].",".$row['nombre'].','.$row['email'].')<br>';
    		}
    	}

    	
    } 

    public function areaUpdate($ids, $nombre, $hash, $mail,$password){

		
		echo $nombre."<br>";
        echo $mail."<br>";
        echo $password."<br>";

        echo "<br>";
        echo "******************************++++++<br>";
       try {

            $result = $this->connection->prepare('UPDATE usuarios  SET pass=? WHERE id=?');

            $result->execute(array($hash, $ids));
            

        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();

        } 
		
    	
    }    
}


//$new->area($ar);

//$new->user();ddd


function keyFunc($ids, $nombre, $mail, $key){
    $opciones = [ 'nocuinino' => 12 ];
    $hash = password_hash($key, PASSWORD_BCRYPT, $opciones);
   // print_r($hash);

   $new = new Api();
   $new->areaUpdate($ids, $nombre, $hash, $mail, $key);
}




keyFunc(1, "Lic. Ángelica Lorena", "direccion.sp@cmabogados.mx", "Jsusabgns&957");
keyFunc(2, "sistemas", "sistemas@asicom.com", 'mrsa$pow2376');
keyFunc(3, "Lic. María Teresa", "siniestros@cmabogados.mx", 'mratr$pow2376');
keyFunc(4, "Lic. Claudia Fernanda", "fernanda@cmabogados.mx", 'fercldia$dpow3766');
keyFunc(5, "Lic. Jesús", "jesus@cmabogados.mx", 'js$pow2376');
keyFunc(6, "Lic. Jerlene Hessel", "jerlene@cmabogados.mx", 'jrlmaa$pow2394');
keyFunc(7, "Lic. Victor Hugo", "victor@cmabogados.mx", 'vrhgo$pow8265');
keyFunc(8, "Lic. José Gerardo", "gerardo@cmabogados.mx", 'grjse$pow2399');
keyFunc(9, "Lic. Yessica Yordana", "direccion.penal@cmabogados.mx", 'yessyrd$pow1092');
keyFunc(10, "Lic. Mara Ellin", "mara@cmabogados.mx", 'mracma$pow9465');
keyFunc(11, "Lic. Magda", "magda@cmabogados.mx", 'gdamx$pow7593');
keyFunc(12, "Lic. Marcos", "marcos@cmabogados.mx", 'mrcscmamx$pow4251');
keyFunc(13, "Lic. Adriana", "adriana@cmabogados.mx", 'adusig$pow2684');
keyFunc(14, "Lic. Sergio Arturo", "sergio@cmabogados.mx", 'serartmx$pow2087');
keyFunc(15, "Lic. Jorge Antonio", "antonio@cmabogados.mx", 'ntomxcms$pow2764');
keyFunc(16, "Lic. David", "rs@gmail.com", 'hirone1290');


/* function preprint($param", " $name='parametro: ',$exit=false){
    echo "<pre> in $name <br>";
    print_r( $param );
    echo ":out</pre><br>";
    if($exit) exit();
}cd 
function keyFunc($key,$mail){
    $opciones = [ 'nocuinino' => 12 ];
    $hash = password_hash($key, PASSWORD_BCRYPT, $opciones);
    print_r($hash);
    preprint($hash,$mail);
}



keyFunc('Jsusabgns&957a',  'jesus@cmabogados.mx');
keyFunc('@cMA2022b',  'siniestros@cmabogados.mx');
keyFunc('@cMA2022C',  'fernanda@cmabogados.mx');
keyFunc('@cMA2022D',  'direccion.sp@cmabo');
keyFunc('@cMA2022E',  'jerlene@cmabogados.mx');
keyFunc('@cMA2022F',  'victor@cmabogados.mx');
keyFunc('@cMA2022g',  'gerardo@cmabogados.mx');
keyFunc('@cMA2022h',  'direccion.penal@cmabo');
keyFunc('@cMA2022i',  'mara@cmabogados.mx');
keyFunc('@cMA2022J',  'magda@cmabogados.mx');
keyFunc('@cMA2022K',  'marcos@cmabogados.mx');
keyFunc('@cMA2022L',  'adriana@cmabogados.mx');
keyFunc('@cMA2022m',  'sergio@cmabogados.mx');
keyFunc('@cMA2022n',  'antonio@cmabogados.mx'); */