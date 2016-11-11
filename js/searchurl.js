'use strict'

function searchLinks( sourcecode )
{
	var lastIndex = 0;
	
	var urlArray = new Array();
	
	while( lastIndex < sourcecode.lastIndexOf( "href=" ) )
	{
		lastIndex = sourcecode.indexOf( "href=", lastIndex );
		
		var urlEnd = sourcecode.indexOf( "\"", lastIndex + 6);
		urlArray.push( sourcecode.slice( lastIndex + 6, urlEnd ) );

	}
	
	return urlArray;
}

function searchurl()
{
	var targeturl = document.getElementById("targeturl").value;
	
	
	//TODO get sourcecode. Should be possible with ajax
	
	//only a test case
	var urlArray = searchLinks( "<a href=\"google.com\"> link </a>"  );
	
	var id = document.getElementById("output");
	
	// just print the first url for now
	id.innerHTML= urlArray[0];
}
