<?php
if (isset($_POST['submit']))
 {
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['country']))
 {

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$country = $_POST['country'];

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "airlinesql";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
die('Could not connect to the database.');
}
else {
$Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
$Insert = "INSERT INTO login(username, email, password,country) values(?, ?, ?, ?)";

$stmt = $conn->prepare($Select);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($resultEmail);
$stmt->store_result();
$stmt->fetch();
$rnum = $stmt->num_rows;

if ($rnum == 0) 
{ ?>
	<center><br><br><h2>You are a new user,So please register</h2>
 </center>
 <?php
 //echo "You are a new user,So please register"; 
include("register.html");

}
else{
$stmt->close();
$stmt = $conn->prepare($Insert);
$stmt->bind_param("ssss",$username, $email, $password, $country);
if ($stmt->execute()) 
{
include("home.html");
//echo "New record inserted sucessfully.";
}
else 
{
echo $stmt->error;
}
}

$stmt->close();
$conn->close();
}
}
else {
echo "All field are required.";
die();
}
}
else {
echo "Submit button is not set";
}
?>