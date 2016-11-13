<?php	
	include "LinkSearch.php";
	include "DatabaseIO.php";


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
		}
	}
?>
