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
		header('Location: maths_mocks.php');
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
$sql ="select sr_no from mocks_q_maths where status='A' and type like '%".$_SESSION["type"]."%' and sr_no in (select sr_no from mocks_asso_mocks_q_test_maths where test_no=".$_GET["tno"].")";
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
#		echo "<BR>Question list is ".$_SESSION["qlist"]."<BR>";
		#random ordering of all available questions ENDS
	}

}
if (!isset($_GET["qno"]))
{
	#get attempt number	
	$_SESSION["attempt"]=1;
	$sql_ ="select max(attempt) as ma from mocks_users_ans_maths where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"];
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
	{
			$sql_a="select op_no from mocks_users_ans_maths where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"]." and attempt=".$_SESSION["attempt"]." and q_sr_no=".$cqno;
			$result22= mysqli_query($conn, $sql_a);
			if($row22 = mysqli_fetch_assoc($result22))
			{
				$cans=$row22["op_no"];
			}
			else $cans=0;
	}
	else
		$cans=$_GET["ans"];
	#sql update here
	$sql="update mocks_users_ans_maths set op_no=".$cans.", ans_date_time=sysdate() where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"]." and attempt=".$_SESSION["attempt"]." and q_sr_no=".$cqno;
		if (mysqli_query($conn, $sql)){
			if ($cans!=0) echo "ANSWER recorded successfully <BR>";
		}
		else 
			echo "Update Error: " . $sql . "<br>" . mysqli_error($conn);

}

#echo "showquest=".isset($_GET["showquest"])."<BR>";
if (isset($_GET["showquest"]))
{
	$qno=$_GET["qno"];
	$sql ="select * from mocks_q_maths where sr_no=".$qno;
	
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) 
	{

		if($row = mysqli_fetch_assoc($result))
		{
			$sql_a="select op_no from mocks_users_ans_maths where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"]." and attempt=".$_SESSION["attempt"]." and q_sr_no=".$qno;
			#echo $sql_a."<BR>";
			$result22= mysqli_query($conn, $sql_a);
			$prev_ans=0;
			if($row22 = mysqli_fetch_assoc($result22))
			{
			#	echo "...".$row22["op_no"]."....<BR>";
				$prev_ans=$row22["op_no"];
			}
			#echo "prev_ans=".$prev_ans."<Br>";

			echo $row["quest"]."<BR>";
			$selected_q_no=$row["sr_no"];
			#get the option of the selected_q_no
			$sql ="select * from mocks_o_maths where sr_no=".$selected_q_no." order by op_no";
			$result2= mysqli_query($conn, $sql);
			echo "<form action=give_maths_test_BCK.php method=get><input type=hidden name=tno value=".$_GET["tno"]."><input type=hidden name=qno value=".$qno.">";
			$op_cnt=0;
			while($row2 = mysqli_fetch_assoc($result2))
			{
				$op_cnt++;
				if ($op_cnt==$prev_ans)
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=ans value=".$row2["op_no"]." checked>(".$row2["op_no"].") ".$row2["option"]."<BR>";
				else
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=ans value=".$row2["op_no"].">(".$row2["op_no"].") ".$row2["option"]."<BR>";
			}
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value='Submit Answer'></form>";
			echo "<HR>";		
			$sql="select max(id) as c from mocks_users_ans_maths";
			$result3=mysqli_query($conn, $sql);
			$row3 = mysqli_fetch_assoc($result3);
			if($row3["c"]>0) 
				$id=$row3["c"]+1;
			else
				$id=1;
			#echo "id=".$id;

			$sql="delete from mocks_users_ans_maths where uname='".$_SESSION["uname"]."' and test_no=".$_GET["tno"]." and attempt=".$_SESSION["attempt"]." and (q_sr_no=".$qno." or ans_date_time=0000-00-00)";
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
			$sql="insert into mocks_users_ans_maths (id,uname, test_no, attempt,q_sr_no, start_date_time) values (".$id.",'".$_SESSION["uname"]."',".$_GET["tno"].",".$_SESSION["attempt"].",".$qno.",sysdate())";
			#echo "ISNERTING....".$sql;
			if (mysqli_query($conn, $sql))
			{
				#echo "New record created successfully";
			}
			else 
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}
#adding qno buttons

#echo $_SESSION["qlist"]."<BR>";
$quest=explode(',',$_SESSION["qlist"]);

if(isset($_SESSION["QL"]))
{
	for($i=1;$i<=$_SESSION["QL"];$i++)
	{
		if ($i%10==0) echo "<BR>";
		echo "<a href='give_maths_test_BCK.php?tno=".$_GET["tno"]."&qno=$quest[$i]&showquest=1'>".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
}

$conn->close();
?>