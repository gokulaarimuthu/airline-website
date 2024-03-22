<?php
if (isset($_POST['submit']))
 {
if (isset($_POST['username']) && isset($_POST['passengers']) && isset($_POST['email']) && isset($_POST['relationship']) && isset($_POST['sourcecountry']) && isset($_POST['desticountry']) && isset($_POST['fromd']) && isset($_POST['tod']))
 {

$username = $_POST['username'];
$passengers = $_POST['passengers'];
$email = $_POST['email'];
$relationship = $_POST['relationship'];
$sourcecountry = $_POST['sourcecountry'];
$desticountry = $_POST['desticountry'];
$fromd = $_POST['fromd'];
$tod = $_POST['tod'];
$fare=$_POST['passengers'];



$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "airlinesql";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
die('Could not connect to the database.');
}
else {
$Select = "SELECT email FROM booking WHERE email = ? LIMIT 1";
$Insert = "INSERT INTO booking(username, passengers, email, relationship, sourcecountry, desticountry, fromd, tod) values(?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($Select);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($resultEmail);
$stmt->store_result();
$stmt->fetch();
$rnum = $stmt->num_rows;

if ($rnum == 0) 
{
//echo "You are a new user,So please register";
$stmt->close();
$stmt = $conn->prepare($Insert);
$stmt->bind_param("sissssss",$username, $passengers, $email, $relationship, $sourcecountry, $desticountry, $fromd, $tod);
if ($stmt->execute()) 
{
include("confirmsql.html");
//echo "New record inserted sucessfully.";
}
else 
{
echo $stmt->error;
}
}
else{
$stmt->close();
$stmt = $conn->prepare($Insert);
$stmt->bind_param("sissssss",$username, $passengers, $email, $relationship, $sourcecountry, $desticountry, $fromd, $tod);
if ($stmt->execute()) 
{
include("confirmsql.html");
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
 $fare = $fare*40000;
?>
<!DOCTYPE html>
<html>
<body><br><br>
	<center>
<h3> <?php echo "The Customer name is : ",$username; ?> </h3>
<h3> <?php echo "Total number of passenger is : ",$passengers; ?> </h3>
<h3> <?php echo "The Customer relationship to the passengers is : ",$relationship; ?> </h3>
<h3> <?php echo "The Customer Source country is : ",$sourcecountry ?> </h3>
<h3> <?php echo "The Customer Destination country : ",$desticountry ?> </h3>
<h3> <?php echo "The total fare is : ",$fare; ?> </h3></center>
</body>
</html>