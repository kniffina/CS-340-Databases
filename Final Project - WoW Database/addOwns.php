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


    <script src="script.js"></script>

</head>
<body>

	<div class="container filters">
		<div>

			<?php
			//Turn on error reporting
			ini_set('display_errors', 'On');
			//Connects to the database
			$mysqli = new mysqli("oniddb.cws.oregonstate.edu","kniffina-db","RLCR5syYqMvYp4Cn","kniffina-db");

			if($mysqli->connect_errno){
				echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}

			//insert the mount and character into the owns table based on user input.
			if(!($stmt = $mysqli->prepare("INSERT INTO owns (mount_id, char_id) VALUES (?,?)"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!($stmt->bind_param("ii",$_POST['MountName'], $_POST['DisplayName']))){
			    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
			    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} else {
			    echo "Added " . $stmt->affected_rows . " row to characters mount.";
			}
			?>

			
		</div>
	
		<!-- button that will take you make to the main index page on clicking -->
		<button class="btn btn-success mainpageLink" href="http://web.engr.oregonstate.edu/~kniffina/340db/index.php">Back to Main Page</button>

	</div>

</body>
</html>