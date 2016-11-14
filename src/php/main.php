<?php	
	include "LinkSearch.php";
	include "DatabaseIO.php";

	function getSourceHostName( $url )
	{
		$dnStart = 0;
		if( strpos( $url, "https://" ) === 0 )
			$dnStart = 8;
		else if( strpos( $url, "http://" ) === 0 )
			$dnStart = 7;
			
		if( strpos( $url, "www" ) !== false )
			$dnStart += 4;

		$dnStop = strpos( $url, "/", $dnStart );
		
		if( $dnStop === false )
			$hostName = substr( $url, $dnStart );
		else
			$hostName = substr( $url, $dnStart, $dnStop - $dnStart );
		
		//~ echo "<p>host name is: $hostName</p>";
		
		return $hostName;
	}
	
	function getSourceProtocol( $url )
	{
		$protEnd = 0;
		if( strpos( $url, "https://" ) === 0 )
			$protEnd = 8;

		else if( strpos( $url, "http://" ) === 0 )
			$protEnd = 7;

		// uncomment if www should be included
		// including the dot
		//~ if( strpos( $url, "www" ) !== false )
			//~ $protEnd += 4;
		
		$protocol = substr( $url, 0, $protEnd );
		
		//~ echo "<p>url scheme name is: $protocol</p>";
		
		return $protocol;
	}
	
	
	function printOutput( $url, $linkList )
	{
		$internalString = "<div id=\"internalResult\"><h2>Internal Links</h2><ul>";
		$externalString = "<div id=\"externalResult\"><h2>External Links</h2><ul>";

		$hostName = getSourceHostName( $url );
		$protocol = getSourceProtocol( $url );

		$pattern = "/www|http|https/";
		
		for( $id = 0; $id < count( $linkList ); $id++ )
		{
			$eval = preg_match( $pattern, $linkList[$id] );
			$hostNameContained = strpos( $linkList[$id], $hostName );
			
			// consider everything that does start with www, http or https
			// 		and does not contain the home address (after www, http or https) as an external link
			if( $eval === 1 && $hostNameContained === false )
				$externalString .= "<li><a href=\"" . $linkList[$id] . "\">" . $linkList[$id] . "</a></li>";
			else			
				if( $hostNameContained !== false ) 	//TODO: to be even more precise if protocol is contained should be checked also
					$internalString .= "<li><a href=\"" . $linkList[$id] . "\">" . $linkList[$id] . "</a></li>";
				else
					$internalString .= "<li><a href=\"" . $protocol . $hostName . "/" . $linkList[$id] . "\">" . $linkList[$id] . "</a></li>";	
		}
		
		$internalString .= "</ul></div>";
		$externalString .= "</ul></div>";
		
		echo $internalString;
		echo $externalString;
	}
	

	function main( $targetURL )
	{	
		// get the html source code 
		// IMPORTANT: in order for this to work allow_url_fopen in php.ini has to be allowed.
		$htmlSource = file_get_contents( $targetURL );
		
		if( !( $htmlSource ) )
		{
			echo "<p>Could not open file. Please check the url and make sure the protocol (e.g. http) is included</p>";
			return false;
		}
		else
		{
			$linksearch = new LinkSearch();
			$linksearch->setTargetURL( $targetURL );
			$linksearch->extractLinksFromSourceCode( $htmlSource );
			
			$dbIO = new DatabaseIO();
			
			$dbIO->writeLinkListToDB( $linksearch->getTargetURL(), $linksearch->getLinkList() );
			
			printOutput( $linksearch->getTargetURL(), $linksearch->getLinkList() );
		}
	}
	
?>
