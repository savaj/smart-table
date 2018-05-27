<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "cruddemo";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}

	function Queryrun($query) {
		$result = mysqli_query($this->conn,$query);
		return $result;
	}

	function numRows($query) {
		$result = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}

	function executeUpdate($query) {
        $result = mysqli_query($this->conn,$query);        
		return $result;		
    }
    
    function executeinsert($query) {
    	$result = mysqli_query($this->conn,$query);        
		return $result;	
    }
}
?>