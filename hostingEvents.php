<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php

$servername = "localhost";
$username = "root";
$password = "";

try{
	$conn = new PDO("mysql:host=$servername;dbname=pickupsports", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sqlDisplay = $conn->prepare("SELECT * FROM events WHERE user = ? and date>=NOW()");
	$sqlDisplay->execute(array($_SESSION['userID']));
	
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
		#echo "<th>Manage Event</th>";
	echo "</tr>";
	
	while($row = $sqlDisplay->fetch(PDO::FETCH_ASSOC))
	{
		
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
			#echo "<td><form action='' method='post' id='markingForm'><input type='hidden' name='eventID' value=".$eventID."><input type='submit' name='attendEventButton' value='Attend'></form></td>";
		echo "</tr>";		
	}
	echo "</table>";

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