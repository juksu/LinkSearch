<?php include "php/foobar.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf8">
	<link rel="stylesheet" href="css/example.css"> <!-- TODO -->
	<link rel="javascript" href="js/test.js"> <!-- TODO -->
	<title>Link Analyzer</title>
</head>
<body>
	
	<!-- <header></header> -->
	<main>
		
		<div class="divform">
			<form id="foobar" action="./index.php" method="get">
				<label for="urlinput">URL</label>
				<input type="text" id="urlinput" name="urlinput" size="50" required pattern="^\S*$"></input> <!-- pattern="^\S*$" does not allow space in input -->
				<button>search links</button>
			</form>
		</div>
		
		<div class="results">
			<?php 
				if( isset($_GET["urlinput"]) )
				{
					echo "<div>show the input: ";
					echo $_GET["urlinput"];
					echo "</div>";
				}
			?>
		</div>
		
		<div>
			<?php connectDB() ?>
		</div>
		
	</main>
	<!-- <footer></footer> -->


</body>
</html>
