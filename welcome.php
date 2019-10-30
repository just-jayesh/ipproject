<head>
	<script>
		function logout()
		{	
			alert("GOOD BYE!!");
			window.location.href="logout.php";
		}
	</script>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION["login"])||$_SESSION["login"]!=1)
{
	include('reset.php');
	header('Location: login.php');
}

echo "<table border=1 width=100% >";
echo "<tr><td bgcolor=black><font color=silver>Welcome, ".$_SESSION["uname"]."</font></td><td width=20%><button onClick='logout()'>Logout</button></td></tr>";
echo "<tr align=center><td><a href='physics_mocks.php'>Physics Tests</a></td></tr>";
echo "<tr align=center><td><a href='chem_mocks.php'>Chemistry Tests</a></td></tr>";
echo "<tr align=center><td><a href='maths_mocks.php'>Mathematics Tests</a></td></tr>";
echo "<tr align=center><td><a href='combo_mocks.php'>Combo Tests</a></td></tr>";
?>