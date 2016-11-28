<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<form action="" method="post" id="sportSubscibeForm">
<select name="sportList" form = "sportSubscibeForm">

<?php
$servername = "localhost";
$username = "root";
$password = "";

try{
	$conn = new PDO("mysql:host=$servername;dbname=pickupsports", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	$sportRows = $conn->prepare("SELECT * FROM sports");
	$sportRows->execute();
	
	while($row=$sportRows->fetch(PDO::FETCH_ASSOC)){
		$id = $row['id'];
		$name = $row['sport'];
		echo "<option value=".$id.">".$name."</option>";
	}	
	
}
catch(PDOException $e)
{
	echo $e->getMessage();
}

?>
</select>
<input name="subscribeButton" type = "submit" value="subscribe">
<input name="showButton" type = "submit" value="Show Subsciptions">
</form>

<?php
##handling button click


if(isset($_POST['subscribeButton'])){
	try{
		
		$sqlInsert = $conn->prepare("INSERT INTO subscriptions(userID, sportID) VALUES (?, ?)");
		$sqlInsert->execute(array($_SESSION['userID'], $_POST['sportList']));
		echo "Subscription Added<br>";
	}	
	catch(PDOException $e){
		echo "You have already subscibed for the sport selected.<br>";
	}
}

if(isset($_POST['showButton'])){
	try{
		$sqlQuery = $conn->prepare("SELECT * FROM subscriptions WHERE userID=?");
		$sqlQuery->execute(array($_SESSION['userID']));
		
		echo "<table>";
		echo "<tr>";
			echo "<th>Sport </th>";
			echo "<th>Manage</th>";
		echo "</tr>";
		while($row = $sqlQuery->fetch(PDO::FETCH_ASSOC)){
			$sportID = $row['sportID'];
			$sqlInner = $conn->prepare("SELECT * FROM sports WHERE id=?");
			$sqlInner->execute(array($sportID));
			$row = $sqlInner->fetch(PDO::FETCH_ASSOC);
			$sportName = $row['sport'];

			echo "<tr>";
				echo "<td>".$sportName."</td>";
				echo "<td><form action='' method='post' id='unsubscribeForm'><input type='hidden' name='sportID' value=".$sportID."><input type='submit' name='unsubscribeButton' value='Un-Subscribe'></form></td>";
			echo "</tr>";
						
		}
		echo "</table>";
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}

if(isset($_POST['unsubscribeButton'])){
	#echo $_POST['sportID']."<br>";
	$sqlDelete = $conn->prepare("DELETE FROM subscriptions WHERE userID=? AND sportID=?");
	$sqlDelete->execute(array($_SESSION['userID'], $_POST['sportID']));
}
$conn = null;
?>
<br><br>
<form action="userHome.php" method="post" id="backForm">
<button type="submit" form="backForm" value="submit">Back To Profile</button>
</form>
</body>
</html>