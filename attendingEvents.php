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
		echo "<th>Will Attend?</ths>";		
	echo "</tr>";

	$sqlOuter = $conn->prepare("SELECT * FROM userevents WHERE userID=?");
	$sqlOuter->execute(array($_SESSION['userID']));

	while($rowOuter = $sqlOuter->fetch(PDO::FETCH_ASSOC)){
		#$echo $rowOuter['userID']."    ".$rowOuter['eventID']."<br>";

		$sqlInner = $conn->prepare("SELECT * FROM events WHERE id=?");
		$sqlInner->execute(array($rowOuter['eventID']));
		while($row = $sqlInner->fetch(PDO::FETCH_ASSOC)){

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
				echo "<td><form action='' method='post' id='markingForm'><input type='hidden' name='eventID' value=".$eventID."><input type='submit' name='cancelEventButton' value='Cannot Attend'></form></td>";
			echo "</tr>";
			
		}
	}	

	echo "</table>";

	if(isset($_POST['cancelEventButton']))
	{
		$sqlRemove = $conn->prepare("DELETE FROM userEvents WHERE userID=? and eventID=?");
		$sqlRemove->execute(array($_SESSION['userID'], $_POST['eventID']));

		$sqlUpdate = $conn->prepare("UPDATE users SET attendedEvents=attendedEvents-? WHERE id=?");
		$sqlUpdate->execute(array(1, $_SESSION['userID']));

		$sqlUpdate2 = $conn->prepare("UPDATE events SET count=count+? WHERE id=?");
		$sqlUpdate2->execute(array(1, $_POST['eventID']));

		echo $_POST['eventID']."<br>";
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