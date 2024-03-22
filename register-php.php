<?php
if (isset($_POST['submit']))
 {
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) &&
isset($_POST['gender']) && isset($_POST['phoneCode']) && isset($_POST['phone']) && isset($_POST['country']))
 {

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$phoneCode = $_POST['phoneCode'];
$phone = $_POST['phone'];
$country = $_POST['country'];

//database conection

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
$Insert = "INSERT INTO register(username, email, password, gender ,phoneCode, phone,country) values(?, ?, ?, ?, ?, ?,?)";

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
$stmt->bind_param("ssssiis",$username, $email, $password, $gender, $phoneCode, $phone, $country);
if ($stmt->execute()) {
	//echo "Registered successfully please login";
 ?>
	<center><br><br><h2>Registered successfully please login</h2>
 </center>
 <?php
include("login.html");

}
else {
echo $stmt->error;
}
}
else {
	?>
	<center><br><br><h2>Already a registered email,So please login</h2>
 </center>
 <?php
include("login.html");
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