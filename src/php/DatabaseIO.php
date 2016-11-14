<?php
	
	class DatabaseIO
	{
		private function parseINIDB()
		{
			$iniPath = parse_ini_file("iniPath.ini.php");
			
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
					echo "<p>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
					
				for( $id = 0; $id < count( $linkList ); $id++ )
				{
					if( $stmt->bind_param( "s", $linkList[$id] ) )
						$stmt->execute();
					else
						echo "</p>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
				}
				$stmt->close();
			}
			else
				echo "<p>Prepare failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
			
			// write linksto
			if( $stmt = $conn->prepare( "INSERT INTO linksto (sourcepage, link) VALUES (?, ?)" ) )
			{
				for( $id = 0; $id < count( $linkList ); $id++ )
				{
					if( $stmt->bind_param( "ss", $sourceaddress, $linkList[$id] ) )
						$stmt->execute();
					else
						echo "<p>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
				}
				$stmt->close();
			}
			else
				echo "<p>Prepare failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
			
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
					echo "<p>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";

				$result = $stmt->get_result();
				
				//~ print_r( $result );
				
				while( $row = $result->fetch_assoc() )
				{
					$linkList[] = $row["link"];
				}
				
				$result->free();
				$stmt->close();
			}
			else
				echo "<p>Prepare failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
			
			$conn->close();
			
			return $linkList;
		}
	}
?>	
