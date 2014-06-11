<?php
ini_set("display_errors", true);
date_default_timezone_get("America/Guyana");

class DBHandler{
	const HOST = "localhost";
	const DATABASE = "newsanalysis";
	const USER = "newsanalysis";
	const PASSWORD = "EaqquT9qQuNqCCVe";
	
	public static function connect(){
		$con = mysqli_connect(self::HOST, self::USER, self::PASSWORD, self::DATABASE) or die ("Database Connection Error");
		return $con;
	}
	
	public static function do_query($sql){
	$con = self::connect();

		$result = mysqli_query($con, $sql) or die (mysqli_error($con). ":" . mysqli_error($con));
		
		mysqli_close($con);
	
	return $result;
	
	}
	public static function do_transaction($queries = array()) {
		$con = self::connect();
		if($con) {
			
			
			//some simple checks...
			if($queries == NULL) return false;
			if(! is_array($queries)) return false;
			if(array_size($queries) == 0) return false;
			
			//and we begin..
			mysqli_query("BEGIN TRANSACTION");
			try {
				foreach($queries as $query) {
					$result = mysqli_query($query) or die(mysqli_error($con));
					if(!$result) throw new Exception();
				}
				mysqli_query("COMMIT");
				
			} catch(Exception $e) {
				mysqli_query("ROLLBACK");
			}
			mysqli_close($con);
		}
	}	
	
	}








	

?>