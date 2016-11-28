<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
	#echo "Hello ".$_SESSION['user']."!!!<br>";
	#echo "Hello ".$_SESSION['userID']."!!!<br>";

$servername = "localhost";
$username = "root";
$password = "";
try{
	$conn = new PDO("mysql:host=$servername;dbname=pickupsports", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	echo "Hello ".$_SESSION['user']."!!<br>";
	$sqlQuery = $conn->prepare("SELECT * FROM users WHERE id=?");
	$sqlQuery->execute(array($_SESSION['userID']));
	$user = $sqlQuery->fetch(PDO::FETCH_ASSOC);
	$hosted = $user['hostedEvents'];
	$attended = $user['attendedEvents'];
	$score = $hosted*10 + $attended*5;
	echo "Your score is: ".$score."<br>";

}
catch(PDOException $e){
	echo $e->getMessage();
}		
?>
<br><br>
<form action="createEvent.php" method="post">
<input type="submit" name = "createEvent" value="Create An Event">
</form>

<br><br>
<form action="searchEvent.php" method="post">
<input type="submit" name = "searchevents" value="Search Events">
</form>

<br><br>
<form action="attendingEvents.php" method="post">
<input type="submit" name = "attendedingEvents" value="Attending Events">
</form>

<br><br>
<form action="hostingEvents.php" method="post">
<input type="submit" name = "hostingEvents" value="My Events">
</form>


<br><br>
<form action="subscribeEvents.php" method="post">
<input type="submit" name = "subscribeEvents" value="Manage Subscriptions">
</form>

<br><br>
<form action="userWall.php" method="post">
<input type="submit" name = "userWall" value="My Wall">
</form>

<br><br>
<form action="leaderBoard.php" method="post">
<input type="submit" name = "leaderBoard" value="Leader Board">
</form>

<br><br>
<form action="logout.php" method="post" id="logout">
<button type="submit" form = "logout" value="submit">Logout</button>
</form>

</body>
</html>