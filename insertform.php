<?php
$username = $_POST['username'];
$password = $_POST['password'] ;
$gender = $_POST['gender'] ;
$email = $_POST['email'] ;
$phoneCode = $_POST['phoneCode'] ;
$phone = $_POST['phone'] ;

if (!empty($username) || !empty($password) || !empty($gender) || !empty($email) || !empty($phoneCode) || !empty($phone)){
	$host = "localhost";
	$dbUsername = "root" ;
	$dbPassword = "" ;
	$dbname = "form" ;

	//create connection
	$connection = new mysqli($host, $dbUsername, $dbPassword, $dbname);

	if (mysqli_connect_error()){
		die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error()) ;
	}
	else {
		$select = "SELECT email FROM student WHERE email = ? Limit 1" ;
		$insert = "INSERT INTO student (name, password, gender, email, phoneCode, phone) VALUES (?,?,?,?,?,?)";
		

		//Prepare state
		$stmt = $connection->prepare($select) ;
		$stmt->bind_param("s", $email) ;
		$stmt->execute();
		$stmt->bind_result($email) ;
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if ($rnum==0) {
			$stmt->close();

			$stmt = $connection->prepare($insert);
			$stmt->bind_param("ssssii", $username, $password, $gender, $email, $phoneCode, $phone) ;
			$stmt->execute();
			echo "New record inserted successfully" ;
		} else {
			echo "Someone already registered using this email" ;
		}
		$stmt->close();
		$connection->close();
	}

} else {
	echo "All field are required" ;
	die() ;
}
?>