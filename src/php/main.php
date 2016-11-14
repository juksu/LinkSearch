<?php	
	include "LinkSearch.php";
	include "DatabaseIO.php";


	function getDomainName( $url )
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
			$domainName = substr( $url, $dnStart );
		else
			$domainName = substr( $url, $dnStart, $dnStop - $dnStart );
		
		echo "<p>domain name is: $domainName</p>";
		
		return $domainName;
	}
	
	function getUrlScheme( $url )
	{
		$dnStop = 0;
		if( strpos( $url, "https://" ) === 0 )
			$dnStop = 8;

		else if( strpos( $url, "http://" ) === 0 )
			$dnStop = 7;

		// including the dot
		if( strpos( $url, "www" ) !== false )
			$dnStop += 4;
		
		$urlScheme = substr( $url, 0, $dnStop );
		
		echo "<p>url scheme name is: $urlScheme</p>";
		
		return $urlScheme;
	}
	
	
	function printOutput( $url, $linkList )
	{
		$internalString = "<div id=\"internalResult\"><h2>Internal Links</h2><ul>";
		$externalString = "<div id=\"externalResult\"><h2>External Links</h2><ul>";

		$domainName = getDomainName( $url );
		$urlScheme = getUrlScheme( $url );

		$pattern = "/www|http|https/";
		
		for( $id = 0; $id < count( $linkList ); $id++ )
		{
			$eval = preg_match( $pattern, $linkList[$id] );
			$domainNameContained = strpos( $linkList[$id], $domainName );
			
			// consider everything that does start with www, http or https
			// and does not contain the home address (after www, http or https) as external link
			if( $eval === 1 && $domainNameContained === false )
				$externalString .= "<li><a href=\"" . $linkList[$id] . "\">" . $linkList[$id] . "</a></li>";
			else			
				if( $domainNameContained !== false ) 	//TODO: to be even more precise if urlScheme is contained should be checked also
					$internalString .= "<li><a href=\"" . $linkList[$id] . "\">" . $linkList[$id] . "</a></li>";
				else
					$internalString .= "<li><a href=\"" . $urlScheme . $domainName . "/" . $linkList[$id] . "\">" . $linkList[$id] . "</a></li>";	
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
			// print html source
			// TODO only for debug
			//~ echo "<p>" . $htmlSource . "</p>";
			
			$linksearch = new LinkSearch();
			$linksearch->setTargetURL( $targetURL );
			$linksearch->extractLinksFromSourceCode( $htmlSource );
			
			$dbIO = new DatabaseIO();
			//$dbIO->saveLinkList( $linksearch->targetURL, $linksearch->linkList );
			
			$foo = $dbIO->getLinkListFromDB( "abc.com" );
			
			//~ print_r( $foo );
			
			//~ echo "<p>linkList in main ";
			//~ print_r( $linksearch->getLinkList() );
			//~ eche "</p>";
			
			$dbIO->writeLinkListToDB( $linksearch->getTargetURL(), $linksearch->getLinkList() );
			
			//TODO print links
			// consider everything that does start with www, http, https, ftp or ftps 
			// and does not contain the home address (after www, http,...) as external link
			// use regular expressions
			
			// build two strings
			
			//~ $pattern = "/<a\s+.*?href=[\"\']?([^\"\']*\.[^\"\']*)[\"\'][^>]*>.*?<\/a>/i";
			//~ $pattern = "/<a\s+.*?href=[\"\']?([^\"\']*\.[^\"\']*)[\"\'][^>]*>.*?<\/a>/i";
				
			//~ preg_match( $pattern, $subject, $match );
				
				// matches is a 2-dimensional array with the links in the second dimension.
			//~ $this->linkList = $matches[1];
			
			printOutput( $linksearch->getTargetURL(), $linksearch->getLinkList() );
		}
	}
	

	
?>
