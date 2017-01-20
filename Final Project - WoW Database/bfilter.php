<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","kniffina-db","RLCR5syYqMvYp4Cn","kniffina-db");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css" />

</head>
<body>

<div class="container" id="bfilterPage">
	<div>
		<table class="table table-hover">
			<thead>
				<h3 class="labels">WoW Characters</h3>
				<tr>
					<td>Name</td>
					<td>Homeland</td>
				</tr>
			</thead>

			<?php
				//get the bosses name and zone by the following query.
				if(!($stmt = $mysqli->prepare("SELECT bosses.name, zones.name FROM bosses INNER JOIN zones ON bosses.homeland = zones.id WHERE zones.id = ?"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				//post the data
				if(!($stmt->bind_param("i",$_POST['Homeland']))){
		                    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		                }
		                
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($name, $homeland)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				//with the data that has been fetched, create a table with all the values until the
				//while loop has no more bosses to filter through.
				while($stmt->fetch()){
		 			echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $homeland . "\n</td>\n</tr>";
				}
				$stmt->close();
			?>
		</table>
	</div>

	<!-- button that will take you make to the main index page on clicking -->
	<button class="btn btn-success mainpageLink" href="http://web.engr.oregonstate.edu/~kniffina/340db/index.php">Back to Main Page</button>

</div>

</body>
</html>