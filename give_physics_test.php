<?php
session_start();
if(isset($_GET["ql"]))
	 $_SESSION["QL"]=$_GET["ql"];
#echo "test no=".$_GET["tno"]."<BR>";
#echo "Username: ".$_SESSION["uname"]."<BR>";
#echo "timelimit=".$_SESSION["TL"]."<BR>";
if ($_SESSION["TL"]<>0)
{
	date_default_timezone_set('Asia/Calcutta'); 
	$_SESSION["type"]=",A,";
	if($_SESSION["st"]=="")
	{
		$_SESSION["st"]=date("h:i:sa");
	}
 	echo "Stared on ".$_SESSION["st"]."<BR>Now ".date("h:i:sa")."<BR>";
	$start_time = strtotime($_SESSION["st"]);
	$now_time = strtotime(date("h:i:sa"));
	echo round(abs($now_time - $start_time) / 60,2). " minute UP<BR>";
	if(round(abs($now_time - $start_time) / 60,2)>$_SESSION["TL"])
	{
		header('Location: physics_mocks.php');
	}
}
else
{
	$_SESSION["type"]=",M,";
}
	
echo "Questionlimit=".$_SESSION["QL"]."<BR>";
#echo "Number of attempts=".$_SESSION["NOA"]."<BR>";
#echo "Continuation allowed =".$_SESSION["TL"]."<BR>";
#echo "fetching all question of test no 1.....<BR>";

$conn = new mysqli("localhost", "root","", "aNalyser");
if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

#random ordering of all available questions START
$sql ="select sr_no from mocks_q where status='A' and type like '%".$_SESSION["type"]."%' and sr_no in (select sr_no from mocks_asso_mocks_q_test where test_no=".$_GET["tno"].")";
#echo $sql."<BR>";
$result = mysqli_query($conn, $sql);
$sr_no=array();
if (!isset($_GET["qno"]))
{
	###########	
	$_SESSION["qlist"]="";
	if (mysqli_num_rows($result) > 0) 
	{
		$n=mysqli_num_rows($result);
		for($i=0;$i<mysqli_num_rows($result);$i++)
			$sr_no[$i]=0;
		while($row = mysqli_fetch_assoc($result))
		{
			while(1)
			{
				$i=rand(0,$n-1);
				if($sr_no[$i]==0) 
				{
					$sr_no[$i]=$row["sr_no"];
					#echo "slot $i assigned quest no ".$sr_no[$i]."<BR>";
					break;
				}
			}
		}
		for($i=0;$i<$n;$i++)
		{
			$_SESSION["qlist"]=$_SESSION["qlist"].",".$sr_no[$i];
		}
		#echo "<BR>Question list is ".$_SESSION["qlist"]."<BR>";
		#random ordering of all available questions ENDS
	}

}
if (!isset($_GET["qno"]))
{
	#get attempt number	
	$_SESSION["attempt"]=1;
	$sql_ ="select max(attempt) as ma from mocks_users_ans where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"];
	$result_ = mysqli_query($conn, $sql_);
		
	if (mysqli_num_rows($result_) > 0) 
	{
		if($row_ = mysqli_fetch_assoc($result_))
			$_SESSION["attempt"]=$row_["ma"]+1;			
	}
#echo "<h1>attempt=".$_SESSION["attempt"]."</h1>";	

}
else
{
	#insert current qno ans in table and get next qno
	$cqno=$_GET["qno"];
	if(!isset($_GET["ans"]))
		$cans=0;
	else
		$cans=$_GET["ans"];
	$_SESSION["Noq"]++;
	echo "Questions attempted=".$_SESSION["Noq"]."<BR>";
	#echo "submitting for test no ".$_GET["tno"]." quest number ".$cqno." answer = ".$cans."<BR>";
	#sql update here
	$sql="update mocks_users_ans set op_no=".$cans.", ans_date_time=sysdate() where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"]." and attempt=".$_SESSION["attempt"]." and q_sr_no=".$cqno;
		if (mysqli_query($conn, $sql)){
			#echo "UPDATE successful";
		}
		else 
			echo "Update Error: " . $sql . "<br>" . mysqli_error($conn);
		
	if ($_SESSION["Noq"]==$_SESSION["QL"])
	{
		$conn->close();
		header('Location: physics_mocks.php');
	}
}
#echo "old qlist is ".$_SESSION["qlist"]."<BR>";
if (strpos($_SESSION["qlist"],",",1)===false)
{
	#echo "hi";
	$qno=$_SESSION["qno"]=substr($_SESSION["qlist"],1);
	if (strlen(strstr($_SESSION["qlist"],",".$qno))>0)
			$_SESSION["qlist"]="";
}
else
{
	$qno=$_SESSION["qno"]=substr($_SESSION["qlist"],1,strpos($_SESSION["qlist"],",",1)-1);
	if (strlen(strstr($_SESSION["qlist"],",".$qno.","))>0)
		$_SESSION["qlist"]=substr($_SESSION["qlist"],strpos($_SESSION["qlist"],",",1));
}

#echo "<BR>NEW Question list is ".$_SESSION["qlist"]."<BR>";
#echo $qno.".......<BR><BR>";


$sql ="select * from mocks_q where sr_no=".$qno;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{
	//while($row = mysqli_fetch_assoc($result))
	if($row = mysqli_fetch_assoc($result))
	{
		echo $row["sr_no"]." : ".$row["quest"]."<BR>";
		$selected_q_no=$row["sr_no"];
		#get the option of the selected_q_no
		$sql ="select * from mocks_o where sr_no=".$selected_q_no." order by op_no";
		$result2= mysqli_query($conn, $sql);
		echo "<form action=give_physics_test.php method=get><input type=hidden name=tno value=".$_GET["tno"]."><input type=hidden name=qno value=".$qno.">";
		while($row2 = mysqli_fetch_assoc($result2))
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=ans value=".$row2["op_no"].">(".$row2["op_no"].") ".$row2["option"]."<BR>";
		}
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value='Submit Answer'></form>";
		echo "<HR>";		
		$sql="select max(id) as c from mocks_users_ans";
		$result3=mysqli_query($conn, $sql);
		$row3 = mysqli_fetch_assoc($result3);
		if($row3["c"]>0) 
			$id=$row3["c"]+1;
		else
			$id=1;
		#echo "id=".$id;

		$sql="delete from mocks_users_ans where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"]." and attempt=".$_SESSION["attempt"]." and ans_date_time=0000-00-00";
		#echo $sql."<BR>";
		if (mysqli_query($conn, $sql))
		{
			#echo "New record creating successfully";
		}
		else
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);

		$conn->close();
		$conn = new mysqli("localhost", "root","", "aNalyser");
		if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
		$sql="insert into mocks_users_ans (id,uname, test_no, attempt,q_sr_no, start_date_time) values (".$id.",'".$_SESSION["uname"]."',".$_GET["tno"].",".$_SESSION["attempt"].",".$qno.",sysdate())";
		#echo "ISNERTING....".$sql;
		if (mysqli_query($conn, $sql))
		{
			#echo "New record created successfully";
		}
		else 
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
$conn->close();


?>