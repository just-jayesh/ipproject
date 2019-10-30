<?php
session_start();
if (!isset($_SESSION["login"]))
	$_SESSION["login"] = 0;
else if($_SESSION["login"]==1)
	header('Location: welcome.php'); 
if(isset($_POST["uname"]))
{
$conn = new mysqli("localhost", "root","", "aNalyser");
if ($conn->connect_error)
die("Connection failed: " . $conn->connect_error);

echo "hi ";
$sql = "SELECT * FROM users where uname='".$_POST["uname"]."' and pwd='".$_POST["pwd"]."' and status='A'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{
	while($row = mysqli_fetch_assoc($result))
		echo "Welcome, " . $row["uname"]. "<br>";
	$_SESSION["login"]=1;
	$_SESSION["uname"]=$_POST["uname"];
	header('Location: welcome.php');
	
} 
else {	echo "Invalid login"; $login=0;}
$conn->close();
}

if (!$_SESSION["login"])
{
echo "<form method=post action=login.php>";
echo "<table>";
echo "<tr align=center><td colspan=2 bgcolor=orange>Login</td></tr>";
echo "<tr><td>Username<td><input type=text name=uname></tr>";
echo "<tr><td>Password<td><input type=password name=pwd></tr>";
echo "<tr align=center bgcolor=green><td><input type=reset value=Clear>";
echo "<td><input type=submit value=Login>";
echo "</form>";
}
?>