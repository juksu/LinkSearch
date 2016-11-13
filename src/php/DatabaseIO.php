<?php
	
	class DatabaseIO
	{
		//~ private $conn;
		
		private function parseINIDB()
		{
			$iniPath = parse_ini_file("iniPath.ini.php");
			
			//~ print_r( $iniPath );
			
			$iniArray = parse_ini_file( $iniPath["iniPath"] );
			
			return $iniArray["dbaccess"];
		}
		
		private function connectToDB()
		{
			$dbaccess = $this->parseINIDB();
			
			$conn = new mysqli($dbaccess["address"], $dbaccess["username"], $dbaccess["password"], $dbaccess["database"]);
			
			if( $conn->connect_error )
				return false;

			return $conn;
		}
		
		public function writeLinkListToDB( $sourceaddress, $linkList )
		{
			$conn;
			if( !( $conn = $this->connectToDB() ) )
				return false;
		
			// write urls
			if( $stmt = $conn->prepare( "INSERT INTO url (address) VALUES (?);" ) )
			{
				if( $stmt->bind_param( "s", $sourceaddress ) )
					$stmt->execute();
				else
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
					
				for( $id = 0; $id < count( $linkList ); $id++ )
				{
					if( $stmt->bind_param( "s", $linkList[$id] ) )
						$stmt->execute();
					else
						echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				$stmt->close();
			}
			else
				echo "Prepare failed: (" . $stmt->errno . ") " . $stmt->error;
			
			// write linksto
			if( $stmt = $conn->prepare( "INSERT INTO linksto (sourcepage, link) VALUES (?, ?)" ) )
			{
				for( $id = 0; $id < count( $linkList ); $id++ )
				{
					if( $stmt->bind_param( "ss", $sourceaddress, $linkList[$id] ) )
						$stmt->execute();
					else
						echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				$stmt->close();
			}
			else
				echo "Prepare failed: (" . $stmt->errno . ") " . $stmt->error;
			
			$conn->close();
		}
		
		public function getLinkListFromDB( $sourceurl )
		{
			if( !( $conn = $this->connectToDB() ) )
				return false;
			
			$restult;
			
			$linkList = [];
			if( $stmt = $conn->prepare( "SELECT * FROM linksto WHERE sourcepage = ?;" ) )
			{
				if( $stmt->bind_param( "s", $sourceurl ) )
					$stmt->execute();
				else
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;

				$result = $stmt->get_result();
				
				//~ print_r( $result );
				
				while( $row = $result->fetch_assoc() )
				{
					$linkList[] = $row["link"];
				}
				
				$result->free();
				$stmt->close();
				
				//~ echo "<p> bla";
				//~ print_r( $linkList );
				//~ echo "</p>";
			}
			else
				echo "Prepare failed: (" . $stmt->errno . ") " . $stmt->error;
			
			$conn->close();
			
			return $linkList;
		}
	}
?>	
