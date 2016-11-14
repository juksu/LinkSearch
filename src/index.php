<?php include "php/main.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf8">
	<link rel="stylesheet" href="css/style.css">
	<title>Link Search</title>
</head>
<body>
	<main>
		<div class="divform">
			<form id="foobar" action="index.php" method="get">
				<label for="urlinput">URL</label>
				<input type="text" id="urlinput" name="urlinput" size="50" required pattern="^\S*$"></input> <!-- pattern="^\S*$" does not allow space in input -->
				<button>Search for links</button>
			</form>
			<a href="about.html"><button>About</button></a>
			
		</div>
		
		<div class="results">
			<?php 
				if( isset($_GET["urlinput"]) )
				{
					echo "<h1 id=\"searchURL\">" . $_GET["urlinput"] . ":</h1>";
					echo "<div id=\"resultNav\"> "
							. "<p><a href=#internalResult>Internal Links</a></p>"
							. "<p><a href=#externalResult>External Links</a></p>"
							. "</div>";
					echo main( $_GET["urlinput"] );
				}
			?>
		</div>
	</main>
</body>
</html>
