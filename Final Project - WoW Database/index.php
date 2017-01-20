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

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<!-- DISPLAY WOW CHARACTERS section -->
<div class="container marginBottom"> <!-- CONTAINER TO WRAP ENTIRE HTML -->

    <!-- World of Warcraft and database image logos -->
    <div class="row">
        <div class="col-md-6 col-lg-6">  
            <img src="imgs/logo.jpg" id="logo"/>
        </div>
        <div class="col-md-6 col-lg-6">  
            <img src="imgs/logoDb.jpg" id="logoDb" height="125px" width="450px"/>
        </div>
    </div>
    <!-- end img logos -->

    <div class="addMarginTop">

        <!-- table to display all characters in the database currently -->
    	<table class="table table-hover">

    		<h3 class="labels">Wow Characters</h3>
            <thead>
    		  <tr>
    			<td>Display Name</td>
    			<td>Class</td>
    			<td>Race</td>
    			<td>Homeland</td>
    		  </tr>
            </thead>

            <!-- PHP to filter through the characters and display them in a table format -->
    		<?php
    		if(!($stmt = $mysqli->prepare("SELECT characters.dname, characters.class, characters.race, zones.name FROM characters INNER JOIN zones ON characters.homeland = zones.id"))){
    			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    		}

    		if(!$stmt->execute()){
    			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    		}
    		if(!$stmt->bind_result($dname, $class, $race, $homeland)){
    			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    		}
            // loop until there are no more results
    		while($stmt->fetch()){
     			echo "<tr>\n<td>\n" . $dname . "\n</td>\n<td>\n" . $class . "\n</td>\n<td>\n" . $race . "\n<td>\n<td>\n" . $homeland . "\n</td>\n</tr>";
    		}
    		$stmt->close();
    		?>

    	</table>
    </div>


<!-- Div for Filtering the WoW Characters in the database by their homeland -->
<div class="addMarginTop">
    <h3 class="labels">Filter by Homeland</h3>
    <!-- Form that redirects to filter.php when the submit button is clicked -->
    <form class="form-inline" method="post" action="filter.php">
        <div class="form-group">

            <!-- allow user to select the homeland from the different zones that they want to search by -->
			<select class="form-control" name="Homeland">

                <!-- below php allows user to specify a homeland based on the values of the zones table -->
                <!-- This will be used to allow the user to  -->
                <?php
                    if(!($stmt = $mysqli->prepare("SELECT id, name FROM zones"))){
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }
                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($id, $zname)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                     // loop until there are no more results
                    while($stmt->fetch()){
                        echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                    }
                    $stmt->close();
                ?>

                </select>
		      <button class="btn btn-primary" type="submit" value ="Run Filter"/>Run Filter</button>
        </div>
	</form>
</div>


<!-- Display all of the current WoW Bosses in the database to the user -->
<div class="addMarginTop">
		<h3 class="labels">WoW Bosses</h3>
        <table class="table table-hover">
            <thead>
    		  <tr>
    			 <td>Name</td>
    			 <td>Homeland</td>
    		  </tr>
            </thead>

        <!-- retrieves the boss name, and zone name that are in the bosses and zones table. They are joined together -->
        <!-- so that all bosses will be displayed with their homeland in a table format -->
		<?php
    		if(!($stmt = $mysqli->prepare("SELECT bosses.name, zones.name FROM bosses INNER JOIN zones ON bosses.homeland = zones.id"))){
    			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    		}

    		if(!$stmt->execute()){
    			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    		}
    		if(!$stmt->bind_result($name, $homeland)){
    			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    		}
            // loop until there are no more results
    		while($stmt->fetch()){
     			echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $homeland . "\n</td>\n</tr>";
    		}
    		$stmt->close();
		?>

	</table>
</div>

<!-- Add Character section -->
<div class="addMarginTop">
    <h3 class="labels">Add Character</h3>
    <!-- Form that redirects to addCharacters.php when the submit button is clicked -->
	<form class="form-inline" method="post" action="addCharacters.php"> 		
		  <div class="form-group">
            <!-- allow user to enter display name for character -->
			<p>Display Name: <input class="form-control"type="text" name="DisplayName" /></p>
          </div>

          <div class="form-group">
            <!-- allow user to select class (based off all the classes in game) -->
			<p>Class: <select class="form-control" name="Class">  
				<option value="Death Knight">Death Knight</option>
				<option value="Druid">Druid</option>
				<option value="Hunter">Hunter</option>
				<option value="Mage">Mage</option>
				<option value="Paladin">Paladin</option>
				<option value="Priest">Priest</option>
				<option value="Rogue">Rogue</option>
				<option value="Shaman">Shaman</option>
				<option value="Warlock">Warlock</option>
				<option value="Warrior">Warrior</option>
			</select></p>
        </div>

        <div class="form-group">
            <!-- allow user to select race (predetermined choices from game) -->
			<p>Race: <select class="form-control" name="Race"> 
			    <option value="Draenei">Draenei</option>
				<option value="Dwarf">Dwarf</option>
				<option value="Gnome">Gnome</option>
				<option value="Human">Human</option>
				<option value="Night Elf">Night Elf</option>
				<option value="Worgen">Worgen</option>
				<option value="Pandaren">Pandaren</option>
				<option value="Blood Elf">Blood Elf</option>
				<option value="Goblin">Goblin</option>
				<option value="Orc">Orc</option>
				<option value="Tauren">Tauren</option>
				<option value="Troll">Troll</option>
				<option value="Undead">Undead</option>
			</select></p>
        </div>
        <div class="form-group">

			<p>Homeland: <select class="form-control" name="Homeland">

            <!-- php to get the results of all the zones so the user can select from values in the table -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, name FROM zones"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            ?>
            <!--
            	<option value="1">Deathknell</option>
			-->

            </select></p>
        </div>
        <div class="form=group">
            <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
		    <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>

        </div>
	</form>
</div>



<!-- Add boss selection allows user to enter a text input to specify a new boss to add to the bosses table -->
<div class="addMarginTop">
    <h3 class="labels">Add Boss</h3>
    <!-- Form that redirects to filter.php when the submit button is clicked -->
	<form class="form-inline" method="post" action="addBosses.php"> 
        <div class="form-group">
			
			<p>Name: <input class="form-control" type="text" name="BossName" /></p>
        </div>
        <div class="form-group">
			<p>Homeland: <select class="form-control" name="Homeland">
            
            <!-- php below allows user to specify which zone they want to choose -->
            <!-- this will be a drop down menu based on values in the zones table -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, name FROM zones"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            ?>
         
            </select></p>
        </div>
        <div class="form-group">
            <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
		    <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div>
	</form>
</div>




<!-- This portion allows the user to add skill from the skills table to a character in the characters table -->
<div class="addMarginTop">
    <h3 class="labels">Add Character Skill</h3>
    <!-- Form that redirects to addChSkills.php when the submit button is clicked -->
	<form class="form-inline" method="post" action="addChSkills.php"> 

		<div class="form-group">
			
			<p>Character: <select class="form-control" name="DisplayName">
            
            <!-- php below allows user to specify which character they want to choose -->
            <!-- this will be a drop down menu based on values in the characters table -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, dname FROM characters"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            ?>

            </select></p>

        </div>

        <div class="form-group">
			<p>Skill: <select class="form-control" name="SkillName">
            
            <!-- php retrieves the skill name so the user can specify which one they want -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, name FROM skills"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            
            ?>
            
            </select></p>
        </div>
       
        <div class="form-group">
              <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
		      <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
          </div>
	</form>
</div>



<!-- Add boss skill section allows the user to add a skill from the skills table to a boss from the bosses table -->
<div class="addMarginTop">
    <h3 class="labels">Add Boss Skill</h3>
    <!-- Form will redirect user to addBossSkills.php on submit -->
	<form class="form-inline" method="post" action="addBoSkills.php"> 
		<div class="form-group">			
			<p>Character: <select class="form-control" name="BossName">

            <!-- php retrieves the names of the bosses to the select so the user can specify  -->
            <!-- the boss they would like to add the skill to -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, name FROM bosses"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            ?>

            </select></p>
        </div>

        <div class="form-group">
			<p>Skill: <select class="form-control" name="SkillName">

            <!-- php retreives the values in the skills table so that the user can specify  -->
            <!-- what they want to add to the boss skill -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, name FROM skills"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
                ?>

            </select></p>
        </div>
        <div class="form-group">
              <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
		      <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div>
	</form>
</div>


<!-- Add character mount section allows user to add a mount from mounts table to a character from characters table -->
<div class="container addMarginTop">
    <h3 class="labels">Add Character Mount</h3>
    <!-- Form will redirect user to addOwns.php on submit -->
	<form class="form-inline" method="post" action="addOwns.php"> 
		<div class="form-group">
			
			<p>Character: <select class="form-control" name="DisplayName">

            <!-- php gets all the characters from the table and displays them for the user to select -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, dname FROM characters"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            ?>

            </select></p>
        </div>
        <div class="form-group">
			<p>Mount: <select class="form-control" name="MountName">

            <!-- php shows all the mounts from the mounts table so the user can select which one to add to a specific character -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, name FROM mounts"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
                ?>
            </select></p>
        </div>
        <div class="form-group">
                <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
              <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div>
	</form>
</div>


<!-- add reports to sectioon allows user to add a guild member or guild leader from the characters table -->
<div class="addMarginTop">
    <h3 class="labels">Add Reports To</h3>
    <!-- Form will redirect user to addReports.php on submit -->
	<form class="form-inline" method="post" action="addReports.php"> 

		<div class="form-group">
			
			<p>Guild Member: <select class="form-control" name="MemberName">
            
            <!-- php here allows the user to select a name from the characters section. These -->
            <!-- values will be returned and put into the selection box that the user can specify -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, dname FROM characters"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            ?>
            </select></p>
        </div>
        <div class="form-group">
			<p>Guild Leader: <select class="form-control" name="LeaderName">

            <!-- php portion allows user to select a name from the characters from the select box -->
            <!-- These values are taken from the characters table and inserted to the select portion of the form specified. -->
            <?php
                if(!($stmt = $mysqli->prepare("SELECT id, dname FROM characters"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    echo '<option value=" '. $id . ' "> ' . $zname . '</option>\n';
                }
                $stmt->close();
            ?>
            </select></p>
        </div>
        <div class="form-group">                
              <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
              <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div>
        
	</form>
</div>


<!-- Add Zone allows the user to add a zone by text input and then submit it to the database -->
<div class="addMarginTop">
    <h3 class="labels">Add Zone</h3>
    <!-- Form will redirect user to addZones.php on submit -->
	<form class="form-inline" method="post" action="addZones.php"> 
	   <div class="form-group">
			<p>Name: <input class="form-control" type="text" name="ZoneName" /></p>
        </div>
        <div class="form-group">
              <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->              
              <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div>		
	</form>
</div>



<!-- Add Mount portion allows the user to add a mount by text input and then submit it to the database -->
<div class="addMarginTop">
    <h3 class="labels">Add Mount</h3>
    <!-- Form will redirect user to addMounts.php on submit -->
	<form class="form-inline" method="post" action="addMounts.php"> 
        <div class="form-group">
			<p>Name: <input type="text" name="MountName" /></p>
       </div>
		<div class="form-group">
              <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div>  
	</form>
</div>


<!-- Add a new skill section where the user can specify a skill for a character or boss -->
<div class="addMarginTop">
    <h3 class="labels">Add Skill</h3>
    <!-- Form will redirect user to addSkills.php on submit -->
	<form class="form-inline" method="post" action="addSkills.php"> 
        <div class="form-group">
			<p>Name: <input type="text" name="SkillName" /></p>
        </div>
		<div class="form-group">
              <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
              <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div> 
	</form>
</div>



<!-- Delete character portion allows user to specify a character they want to delete. (Typed input) -->
<div class="addMarginTop">
    <h3 class="labels">Delete Character</h3>
    <!-- Form will redirect user to deleteCharacters.php on submit -->
	<form class="form-inline" method="post" action="deleteCharacters.php"> 
        <div class="form-group">
			
			<p>Display Name: <input class="form-control" type="text" name="DisplayName" /></p>

			   <?php
                // select
                if(!($stmt = $mysqli->prepare("SELECT id, name FROM zones"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $zname)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                // loop until there are no more results
                while($stmt->fetch()){
                    /*echo '<option value=" '. $id . ' "> ' . $zname . '</option>';*/
                }
                $stmt->close();
            ?>

       </div>
		<div class="form-group">
              <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
              <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div> 

	</form>
</div>


<!-- Delete Boss portion allows the user to specify a box by text input and then submit it to be deleted. -->
<div class="addMarginTop">
    <h3 class="labels">Delete Boss</h3>
    <!-- Form will redirect user to deleteBosses.php on submit -->
	<form class="form-inline" method="post" action="deleteBosses.php"> 
		<div class="form-group">
			<p>Name: <input class="form-control" type="text" name="BossName" /></p>

               <!-- php selects the id a name from the zones based on input and send it to the correct .php doc to finish the query. -->
			   <?php
                    if(!($stmt = $mysqli->prepare("SELECT id, name FROM zones"))){
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }
                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($id, $zname)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    // loop until there are no more results
                    while($stmt->fetch()){
                        /*echo '<option value=" '. $id . ' "> ' . $zname . '</option>';*/
                    }
                $stmt->close();
            ?>

        </div>

		<div class="form-group">
              <!-- submit button will send the user to the confirmation page (.php) that is associated with these elements -->
              <button class="btn btn-primary" type="submit" value ="Submit"/>Submit</button>
        </div> 

	</form>

</div>

</div><!-- END CONTAINER DIV -->
</body>
</html>