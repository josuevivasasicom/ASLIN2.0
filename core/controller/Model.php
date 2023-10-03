<?php
/**
 *  @elmm Model almacena rutinas para los modelos.
 * */ 

class Model {

	public function Model(){
		
	}

	public static function exists($modelname){
		$fullpath = self::getFullpath($modelname);
		$found=false;
		if(file_exists($fullpath)){
			$found = true;
		}
		return $found;
	}

	public static function getFullpath($modelname){
		return Core::$root."core/app/model/".$modelname.".php";
	}

	public static function many_assoc_flecha($query){
		$cnt = 0;
		$array = [];
		while($r = $query->fetch_assoc()){
			$array[$cnt] = [];
			$cnt2=1;
			foreach ($r as $key => $v) {
				if($cnt2>0){ 
					$array[$cnt]->$key = $v;
				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
	}

	//funcion para excel
	public static function many_assoc_excel($query){
		$cnt = 0;
		$array = [];

		while($r = $query->fetch_assoc()){
			$array[$cnt] = [];
			$cnt2=1;
			foreach ($r as $key => $v) {
				if($cnt2>0){ 
					$array[$cnt][$key] = $v;
					if($key == "descripcionHechos" || $key == 'DESCRICIÓN DE LOS HECHOS'){

						// $temp = '!𝓔𝓼𝓽𝓪 𝓮𝓼 𝓵𝓪 𝓬𝓪𝓼𝓪 𝓺𝓾𝓮 𝓫𝓾𝓼𝓬𝓪𝓼, 𝓪𝓰𝓮𝓷𝓭𝓪 𝓾𝓷𝓪 𝓿𝓲𝓼𝓲𝓽𝓪 𝔂𝓪!';
						$temp = urldecode($v);
						// $temp = iconv('UTF-8', 'ASCII//TRANSLIT', $temp);
						$temp = strip_tags($temp);
						$temp = html_entity_decode($temp);
						// $temp = htmlspecialchars_decode($temp);

						$array[$cnt][$key] = $temp;
					}

						/* 	
						$orig = "I'll \"walk\" the <b>dog</b> now";

						$a = htmlentities($orig);

						$b = html_entity_decode($a);

						echo $a; // I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now

						echo $b; // I'll "walk" the <b>dog</b> now
						*/

				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
	}

	/**
	 * @param $query : no necesita modelo, ALERT!! puede ser peligroso.
	 */
	public static function many_assoc($query){
		$cnt = 0;
		$array = [];
		/* echo "<pre>";
		print_r($query);
		echo "<pre>"; */
		
		while($r = $query->fetch_assoc()){
			$array[$cnt] = [];
			$cnt2=1;
			foreach ($r as $key => $v) {
				if($cnt2>0){ 
					$array[$cnt][$key] = $v;
				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
	}
	public static function many_assoc_bk($query,$aclass){
		$cnt = 0;
		$array = array();
		/* echo "<pre>";
		print_r($query);
		echo "<pre>"; */
		
		while($r = $query->fetch_assoc()){
			$array[$cnt] = new $aclass;
			$cnt2=1;
			foreach ($r as $key => $v) {
				if($cnt2>0 && $cnt2%2==0){ 
					$array[$cnt]->$key = $v;
				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
	}

	public static function many($query,$aclass){
		$cnt = 0;
		$array = array();
		/* echo "<pre>";
		print_r($query);
		echo "<pre>"; */
		
		while($r = $query->fetch_array()){
			$array[$cnt] = new $aclass;
			$cnt2=1;
			foreach ($r as $key => $v) {
				if($cnt2>0 && $cnt2%2==0){ 
					$array[$cnt]->$key = $v;
				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
    }
    
	public static function one($query,$aclass){
		$cnt = 0;
		$found = null;
		$data = new $aclass;
		while($r = $query->fetch_array()){
			$cnt=1;
			foreach ($r as $key => $v) {
				if($cnt>0 && $cnt%2==0){ 
					$data->$key = $v;
				}
				$cnt++;
            }
            
			$found = $data;
			break;
		}
		return $found;
	}

	public static function unsetOne($query,$sql=''){
			$cnt = 0;
			$found = null;
			$data = [];
			// core::preprint($query,'query???');
			// core::preprint($sql,'sql???');
			while($r = $query->fetch_assoc()){ //* fetch_assoc , fetch_array
				$cnt=1;
				foreach ($r as $key => $v) {
					/* if($cnt>0 && $cnt%2==0){ 
						$data[] = $v;
					} */
					$data[$key] = $v;
					$cnt++;
				}
				
				$found = $data;
				break;
			}
			return $found;
	}

}

?>