<?php
$servername = "localhost";
$username = "ossnuser";
$password = "password-here";
$dbname = "ossndb";
$userId = $argv[1];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "select first_name,last_name, email from ossn_users where guid=$userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "Email: " . $row["email"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
	$email= $row["email"];
        $fname= $row["first_name"];
        $lname= $row["last_name"];    
}
} else {
    echo "0 results";
}

$arr= array($email,$fname,$lname);
return $arr;
//echo  $arr[1];
$conn->close();
?>
