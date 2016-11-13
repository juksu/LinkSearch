<?php
	class LinkSearch
	{
		private $targetURL;
		private $linkList = [];
		
		public function setTargetURL( $targetURL )
		{
			$this->targetURL = $targetURL;
		}
		
		public function getTargetURL()
		{
			return $this->targetURL;
		}
		
		public function setLinkList( $linkList )
		{
			$this->linkList = $linkList;
		}
		
		public function getLinkList()
		{
			return $this->linkList;
		}
		
		// pass the sourcecode by reference
		public function extractLinksFromSourceCode( &$sourcecode )
		{
			// to exclude links commonly defined within head (e.g. stylesheets) set offset to the beginning of the body element
			$offset = stripos( $sourcecode, "<body" );
			
			if( $offset === false )
			{
				echo "<p>Body element not found</p>";
			}
			else
			{
				// use regular expressions to find <a ... >
				//~ $subject = "PHP <a href=\"foo.com\"></a> web scripting language of <a title=\"bladila\" href=\"bar.html\"></a> choice using php <a href=\"www.google.com/index.html\" ></a>.";
				$subject = $sourcecode;
				
				// pattern: <a element start
				//		+ at least one whitespace 
				//		+ 0 or more characters
				//		+ href= (attribute)
				// 		+ quotationmarks (double or single) marking the start of the address attribute
				//		+ capture the string between the quotationmarks, 
				//				this string is not allowed to have any quotationmarks and 
				//				requires at least one point (url or fileextension)
				//		+ quotationmarks (double or single) marking the end of the address attribute
				// 		+ 0 or more characters not containing >
				//		+ >
				//		+ 0 or more characters (element content)
				//		+ </a>
				//		all case insensitive and least greedy string
				// 		it can be safely assumed that the address will contain at least one dot, either because of the url or file extension
				//		Limitations: this pattern could make problems if quotationmarks are used in the address.
				// 		Also notice because a . in the address is required it excludes links to bookmarks on the same page 
				//			for example: <a href="#example">...
				$pattern = "/<a\s+.*?href=[\"\']?([^\"\']*\.[^\"\']*)[\"\'][^>]*>.*?<\/a>/i";
				
				preg_match_all( $pattern, $subject, $matches, PREG_PATTERN_ORDER, $offset );
				
				// matches is a 2-dimensional array with the links in the second dimension.
				$this->linkList = $matches[1];
				
				//~ echo "<p> linkList: ";
				//~ print_r( $this->linkList );
				//~ echo "</p>";
			}
		}
		
		
	}
?>
