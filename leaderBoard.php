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
		echo "<th>RANK</th>";
		echo "<th>USERNAME</th>";
		echo "<th>SCORE</th>";
		echo "<th>EVENTS HOSTED</th>";
		echo "<th>EVENTS ATTENDED</th>";	
	echo "</tr>";
	
	$sqlDisplay = $conn->prepare("SELECT id, username, hostedEvents, attendedEvents, (hostedEvents*10+attendedEvents*5) AS score FROM users ORDER BY score DESC");
	$sqlDisplay->execute();
	$rank = 1;
	while($row = $sqlDisplay->fetch(PDO::FETCH_ASSOC))
	{
		$id = $row['id'];
		$username = $row['username'];
		$hosted = $row['hostedEvents'];
		$attended = $row['attendedEvents'];
		#$score = $hosted*10 + $attended*5;
		$score = $row['score'];
		echo "<tr>";
			echo "<td>$rank</td>";
			echo "<td>$username</td>";
			echo "<td>$score</td>";
			echo "<td>$hosted</td>";
			echo "<td>$attended</td>";
		echo "</tr>";
		$rank+=1;	 
		
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