<?php include "php/main.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf8">
	<link rel="stylesheet" href="css/style.css">
	<title>Link Search</title>
</head>
<body>
	
	<!-- <header></header> -->
	<main>
		
		<div class="divform">
			<form id="foobar" action="./index.php" method="get">
				<label for="urlinput">URL</label>
				<input type="text" id="urlinput" name="urlinput" size="50" required pattern="^\S*$"></input> <!-- pattern="^\S*$" does not allow space in input -->
				<button>Search links</button>
			</form>
			<a href="./about.html"><button>About</button></a>
			
		</div>
		
		<div class="results">
			<?php 
				if( isset($_GET["urlinput"]) )
				{
					echo "<div>show the input: ";
					echo $_GET["urlinput"];
					echo main( $_GET["urlinput"] );
					echo "</div>";
				}
			?>
		</div>
	</main>
	<!-- <footer></footer> -->

</body>
</html>
