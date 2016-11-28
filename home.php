
<!DOCTYPE html>
<html>
<head>

</head>
<body>
<h1>Welcome - Pick Up Sports</h1>
<form action="" method="POST" id="loginForm">
	<input type="text" name="username" placeholder="username"><br><br>
	<input type="password" name="password" placeholder="password"><br><br>
	<input type="submit" name="loginButton" value="LOGIN">	
</form>
<br><br>
<form action="" method="POST" id="registerForm">
	<input type="text" name="username" placeholder="username"><br><br>
	<input type="text" name="firstname" placeholder="first name"><br><br>
	<input type="text" name="lastname" placeholder="last name"><br><br>
	<input type="text" name="email" placeholder="email"><br><br>
	<input type="password" name="password" placeholder="password"><br><br>
	<input type="submit" name="registerButton" value="REGISTER">	
</form>

<?php

$servername = "localhost";
$username = "root";
$password = "";

try{
	$conn = new PDO("mysql:host=$servername;dbname=pickupsports", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	if(isset($_POST['loginButton'])){
		##navigate to user Profile Page
		$usernameUser = $_POST['username'];
		$passwordUser = $_POST['password'];
		
		$sqlQuery = $conn->prepare("SELECT * FROM users WHERE username=?");
		$sqlQuery->execute(array($usernameUser));
		$row = $sqlQuery->fetch(PDO::FETCH_ASSOC);
		$passwordDB = $row['password'];
		$id = $row['id'];
		if($passwordUser==$passwordDB){
			session_start();
			
			$_SESSION['user']=$usernameUser;			
			$_SESSION['userID']=$id;
		
			header("Location: /PickUpSports/userHome.php");
		}
		else{
			echo "Invalid Credentials!!<br>";
		}
	}

	if(isset($_POST['registerButton'])){
		##Insert Into DateBase
		$username = $_POST['username'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		
		$sqlInsert = $conn->prepare("INSERT INTO users(username, firstname, lastname, email, password, hostedEvents, attendedEvents, registerDate) 
						VALUES(?, ?, ?, ?, ?, ?, ?, NOW())");
		$sqlInsert->execute(array($username, $firstname, $lastname, $email, $password, 0, 0));
		echo "User ".$username." Registered!!<br>";		
	}
}
catch(PDOException $e){
	echo $e->getMessage();
}
?>



</body>
</html>