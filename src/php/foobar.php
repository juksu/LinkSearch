<?php
	function parseINIDB()
	{
		$ini_array = parse_ini_file("/home/fuchsy/Documents/config/db.ini.php");
		
		return $ini_array["dbaccess"];
	}
	
	function connectDB()
	{
		
		$dbaccess = parseINIDB();
		
		//~ print_r( $dbaccess );
		
		$conn = new mysqli($dbaccess["address"], $dbaccess["username"], $dbaccess["password"], $dbaccess["database"]);
		
		if( $conn->connect_error )
		{
			die( "Connection failed: " . $conn->connect_error);
		}
		echo "Connected successfully<br>";
		
		
		//TODO: prevent SQL injection!
		//~ $stmt = $conn->prepare( "SELECT * FROM url" );
		
		//~ $stmt->execute();
		
		//~ $result = $stmt->get_result();
		
		$result = $conn->query("SELECT * FROM url" );
		
		while( $row = $result->fetch_assoc() )
		{
			echo $row[ "address" ] . "<br>";
		}
		
		echo "Query?<br>";
		
		//~ return $conn;
		
		$conn->close();
	}
	
	
	function getSourceCode( $targetURL )
	{
		
		
	}
?>
