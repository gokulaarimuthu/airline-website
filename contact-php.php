<?php
if (isset($_POST['submit']))
 {
if (isset($_POST['username']) && isset($_POST['email']) &&isset($_POST['gender']) && isset($_POST['message']))
 {
$username = $_POST['username'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$message = $_POST['message'];

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "airlinesql";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
die('Could not connect to the database.');
}
else {
$Select = "SELECT email FROM contact WHERE email = ? LIMIT 1";
$Insert = "INSERT INTO contact(username, email, gender, message) values(?, ?, ?, ?)";

$stmt = $conn->prepare($Select);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($resultEmail);
$stmt->store_result();
$stmt->fetch();
$rnum = $stmt->num_rows;

if ($rnum == 0) {
$stmt->close();
$stmt = $conn->prepare($Insert);
$stmt->bind_param("ssss",$username, $email, $gender, $message);
if ($stmt->execute()) {
include("contact.html");
//echo "New record inserted sucessfully.";
echo "Message Submitted";
}
else {
echo $stmt->error;
}
}
else {
	$stmt->close();
$stmt = $conn->prepare($Insert);
$stmt->bind_param("ssss",$username, $email, $gender, $message);
if ($stmt->execute()) {
include("contact.html");
echo "Message Submitted";
//echo "New record inserted sucessfully.";
}
else {
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