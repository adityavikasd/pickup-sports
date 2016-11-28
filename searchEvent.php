<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<form action="" method="post">
Username: <input type="text" name="usernameSearch"><br><br>
Sport: <select name="sportSearch">
	<option value="0">None</option>
<?php
$servername = "localhost";
$username = "root";
$password = "";
try{
	$conn = new PDO("mysql:host=$servername;dbname=pickupsports", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sports = $conn->prepare("SELECT * FROM sports");
	$sports->execute();
	while($row = $sports->fetch(PDO::FETCH_ASSOC)){
		$sportName = $row['sport'];
		$id = $row['id'];
		echo "<option value=".$id.">".$sportName."</option>";
	}
}
catch(PDOException $e){
	echo $e->getMessage();
}
?>
</select><br><br>
<input type="submit" name="search" value="Search Events">
</form>


<?php

try{
	
	if(isset($_POST['search'])){
		$username1 = $_POST['usernameSearch'];
		$sqlQuery = $conn->prepare("SELECT * FROM users WHERE username=?");
		$sqlQuery->execute(array($_POST['usernameSearch']));
		$row = $sqlQuery->fetch(PDO::FETCH_ASSOC);
		$userid = $row['id'];
		$sportid = $_POST['sportSearch'];

		if($sportid==0 && !empty($username1)){
			echo "empty sport and selected user<br>";		
			echo $userid."<br>";

			$sqlQuery = $conn->prepare("SELECT * FROM events WHERE user=?");
			$sqlQuery->execute(array($userid));

		}
		elseif(empty($username1) && $sportid!=0){
			echo "empty user and selected sport<br>";	
			$sqlQuery = $conn->prepare("SELECT * FROM events WHERE sport=?");
			$sqlQuery->execute(array($sportid));

		}
		elseif(!empty($username1) && $sportid!=0){
			echo "selected user and sport<br>";
			$sqlQuery = $conn->prepare("SELECT * FROM events WHERE user=? and sport=?");
			$sqlQuery->execute(array($userid, $sportid));
			
		}
		else{
			echo "empty user and sport<br>";
			$sqlQuery = $conn->prepare("SELECT * FROM events");
			$sqlQuery->execute();
		}
		
	
		echo "<table>";
		echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Organizer Username</th>";
			echo "<th>Sport</th>";
			echo "<th>Participants Required</th>";
			echo "<th>Description</th>";
			echo "<th>Street Address</th>";
			echo "<th>City</th>";
			echo "<th>Date</th>";
			echo "<th>Time</th>";
			echo "<th>Manage Event</ths>";		
		echo "</tr>";
		while($row = $sqlQuery->fetch(PDO::FETCH_ASSOC)){
			$eventID = $row['id'];
			$userID = $row['user'];
			$sportID = $row['sport'];
			$partCount = $row['count'];
			$desc = $row['description'];
			$street = $row['street'];
			$city = $row['city'];
			$state = $row['state'];
			$date = $row['date'];
			$time = $row['time'];
			#echo $sportID."<br>";
			$sqlQuery2 = $conn->prepare("SELECT username FROM users WHERE id=?");
			$sqlQuery2->execute(array($userID));
			$row1 = $sqlQuery2->fetch(PDO::FETCH_ASSOC);
			$usernameDB = $row1['username'];

			$sqlQuery3 = $conn->prepare("SELECT sport FROM sports WHERE id=?");
			$sqlQuery3->execute(array($sportID));
			$row2 = $sqlQuery3->fetch(PDO::FETCH_ASSOC);
			$sportnameDB = $row2['sport'];

			echo "<tr>";
				echo "<td>".$eventID."</td>";				
				echo "<td>".$usernameDB."</td>";
				echo "<td>".$sportnameDB."</td>";
				echo "<td>".$partCount."</td>";
				echo "<td>".$desc."</td>";
				echo "<td>".$street."</td>";
				echo "<td>".$city."</td>";
				echo "<td>".$date."</td>";
				echo "<td>".$time."</td>";
				echo "<td><form action='' method='post' id='markingForm'><input type='hidden' name='eventID' value=".$eventID."><input type='submit' name='attendEventButton' value='Attend'></form></td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	if(isset($_POST['attendEventButton']))
	{
		
		echo $_POST['eventID']."<br>";
		echo $_SESSION['userID']."<br>";
		
		$sqlQuery = $conn->prepare("SELECT count FROM events WHERE id=?");
		$sqlQuery->execute(array($_POST['eventID']));
		$row = $sqlQuery->fetch(PDO::FETCH_ASSOC);
		$partCount = $row['count'];
		
		if($partCount<=0){
			echo "The event has reached its subscription Limit. Sorry!!<br>";
		}
		else{
			$sqlInsert = $conn->prepare("INSERT INTO userEvents(userID, eventID) VALUES(?, ?)");
			$sqlInsert->execute(array($_SESSION['userID'], $_POST['eventID']));
		
			$sqlUpdate = $conn->prepare("UPDATE users SET attendedEvents=attendedEvents+? WHERE id=?");
			$sqlUpdate->execute(array(1, $_SESSION['userID']));

			$sqlUpdate2 = $conn->prepare("UPDATE events SET count=count-? WHERE id=?");
			$sqlUpdate2->execute(array(1, $_POST['eventID']));
		}
	}	

	
}
catch(PDOException $e)
{
	echo $e->getMessage();
}

$conn = null;

?>
<form action="userHome.php" method="post" id="backForm">
<button type="submit" form="backForm" value="submit">Back To Profile</button>
</form>
</body>
</html>