<?php
	$conn = new mysqli("localhost", "root","", "aNalyser");
	if ($conn->connect_error)
		die("Connection failed: " . $conn->connect_error);

	echo "hi ";
	$sql = "SELECT * FROM users where uname='".$_POST["uname"]."' and pwd='".$_POST["pwd"]."' and 	status='A'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result))
			echo "Welcome, " . $row["uname"]. "<br>";
			$_SESSION["login"]=1;
			$_SESSION["uname"]=$_POST["uname"];
		}
	echo json_encode($row);
?>