<?php
define("DB_SERVER", "localhost");
define("DB_USER", "ossn_user");
define("DB_PASSWORD", "123");
define("DB_DATABASE", "ossn_db");
$connect = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql="INSERT INTO ossn_issues(comment) 
      VALUES('$_POST[comment]')";
//echo "Successfully Added!";
if ($connect->query($sql) == TRUE) 
{
    echo "Your issue has been recorded";
    echo "</br>";
    echo '<a href = "http://ec2-54-183-10-209.us-west-1.compute.amazonaws.com/ossn/home">Click to go back</a>';
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

?>

