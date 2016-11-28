<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<form action="" method="POST" id="eventCreationForm">
Event Created by : <?php echo $_SESSION['user'];?><br><br>
Sport : <select name="sports">
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

Number of Participants Required : <input type = "text" name = "partCount"/><br><br>

Description : <textarea name="desc" form = "eventCreationForm"></textarea><br><br>

Address : (Street Address) <input type="text" name="streetAddr"/><br><br>

(City) <input type="text" name="city"/> (State) <input type="text" name="state"/><br><br>

(Zip Code) <input type="text" name="zip"/> (Country) <input type="text" name="country"/><br><br>
<br>

Date of Event: <input type="date" name="date"/><br><br>

Time of Event: <input type="time" name="time"/><br><br>

<input type="submit" name="create" value="Create Event">

</form>

<br><br>
<form action="userHome.php" method="post" id="backForm">
<button type="submit" form="backForm" value="submit">Back To Profile</button>
</form>


<?php
if(isset($_POST['create'])){
	
	$user = $_SESSION['userID'];
	$sport = $_POST['sports'];
	$count = $_POST['partCount'];
	$desc = $_POST['desc'];
	$street = $_POST['streetAddr'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$country = $_POST['country'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	
	$sqlEventInsert	= $conn->prepare("INSERT INTO events(user, sport, count, description, street, city, state, zipcode, country, date, time) 
						VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$sqlEventInsert->execute(array($user, $sport, $count, $desc, $street, $city, $state, $zip, $country, $date, $time));
	echo "Event Created<br>";

	$sqlUpdate = $conn->prepare("UPDATE users SET hostedEvents=hostedEvents+? WHERE id=?");
	$sqlUpdate->execute(array(1, $user));
}

$conn = null;
?>
</body>
</html>