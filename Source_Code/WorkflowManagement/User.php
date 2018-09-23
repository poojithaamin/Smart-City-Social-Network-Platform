<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

//init ossnwall

function getUserDetails($input)
{
$servername = "localhost";
$username = "ossnuser";
$password = "abcd";
$dbname = "ossndb";
$userId = $input;

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

return array($email,$fname,$lname);
//return $arr;
//echo  $arr[1];
$conn->close();


}

$OssnWall = new OssnWall;

//poster guid and owner guid is same as user is posting on its own wall
$OssnWall->owner_guid = ossn_loggedin_user()->guid;
$OssnWall->poster_guid = ossn_loggedin_user()->guid;

//check if users is not posting on its own wall then change wallowner
$owner = input('wallowner');
if (isset($owner) && !empty($owner)) {
    $OssnWall->owner_guid = $owner;
}

//walltype is user
$OssnWall->name = 'user';


//getting some inputs that are required for wall post
$post = input('post');
$friends = input('friends');
$location = input('location');
$privacy = input('privacy');

//validate wall privacy 
$privacy = ossn_access_id_str($privacy);
if (!empty($privacy)) {
    $access = input('privacy');
} else {
    $access = OSSN_FRIENDS;
}
if ($OssnWall->Post($post, $friends, $location, $access)) {
		if(ossn_is_xhr()) {
				$guid = $OssnWall->getObjectId();
				$get  = $OssnWall->GetPost($guid);
				if($get) {
						$get = ossn_wallpost_to_item($get);
						ossn_set_ajax_data(array(
								'post' => ossn_wall_view_template($get)
						));
				}
		}
		//no need to show message on success.
		//3.x why not? $arsalanshah
		$depname =  shell_exec("php /var/www/html/smartcity/components/OssnWall/actions/wall/post/Parse.php '".$post."'");
		list($email,$first_name,$last_name) =  getUserDetails($owner);
                if ($depname == "Police Department"){
				shell_exec("php /var/www/html/smartcity/components/OssnWall/actions/wall/post/AWSPoliceCreateCase.php '".$depname."' '".$post."' '".$first_name."' '".$last_name."' '".$email."'");
				}
                elseif ($depname == "AnimalCare Department"){
                shell_exec("php /var/www/html/smartcity/components/OssnWall/actions/wall/post/AWSAnimalCareCreateCase.php '".$depname."' '".$post."' '".$first_name."' '".$last_name."' '".$email."'");
                }

		ossn_trigger_message(ossn_print('post:created'));
		redirect(REF);
} else {
    ossn_trigger_message(ossn_print('post:create:error'), 'error');
    redirect(REF);
}
