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
		
		
		//TODO all nice and fine to see if it works but this section is not supposed to be in this function
		if( !( $stmt = $conn->prepare( "SELECT * FROM url WHERE address = ?" ) ) )
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		else
			echo "Prepare successful<br>";
		
		$in = "abc.com";
		
		if( !( $stmt-> bind_param( "s", $in ) ) )
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		else
			echo "Binding successful<br>";
		
		$stmt->execute();
		
		$result = $stmt->get_result();
		
		while( $row = $result->fetch_assoc() )
		{
			echo $row[ "address" ] . "<br>";
		}
		
		//~ return $conn;
		
		//~ $conn->close();
	}
	
	
	function getSourceCode( $targetURL )
	{
		echo "do something";
		
	}
?>
