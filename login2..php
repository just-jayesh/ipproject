<?php
session_start();
if (!isset($_SESSION["login"]))
$_SESSION["login"] = 0;
else if($_SESSION["login"]==1)
header('Location: welcome.php');
if(isset($_POST["uname"]))
{
	$.ajax({
             url:'fetch_page.php',
             data:{'uname':$_POST['uname']},
             type:'post',
             success:function(data,status){
                 data=JSON.parse(data);
		 if(data.uname!=Null){
			$_SESSION['uname']=$_POST['uname'];
		 	header('Location: welcome.php');
		 }
             }
});
}
else { echo "Invalid login"; $login=0;}
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