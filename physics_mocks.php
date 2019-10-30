<?php
session_start();
$_SESSION["st"]="";
$_SESSION["QL"]=0;
#setting zero for the return page after test so can attempt test again
$_SESSION["Noq"]=0;
if (!isset($_SESSION["login"])||$_SESSION["login"]!=1)
{
	include('reset.php');
	header('Location: login.php');
}

$conn = new mysqli("localhost", "root","", "aNalyser");
if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

$sql ="select * from mocks_asso_users_test, mocks_test where mocks_asso_users_test.test_no=mocks_test.test_no and uname='".$_SESSION["uname"]."' and status='A' order by mocks_test.test_no";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{
	echo "<table border=1><tr><th>Test No<th>Description<th>Action";
	while($row = mysqli_fetch_assoc($result))
	{
		
		echo "<tr  valign=top><td>".$row["test_no"]."<td>".$row["title"]."<BR><B>Allowed from ".$row["start_date"]." to ".$row["end_date"]."</B><BR>".$row["parameters"]."<BR>";


		$param=explode(';',$row["parameters"]);
		for($i=0;$i<count($param);$i=$i+1)
		{
			$str=explode(':',$param[$i]);
			if(strcmp($str[0],"TL")==0)
			{
				$_SESSION["TL"]=$str[1];
				if($str[1]!=0)
					echo "Total Time=".$str[1]."<BR>";
				else
					echo "Total time=-----<BR>";		
			}
			else if(strcmp($str[0],"QL")==0)
			{
				$_SESSION["QL"]=$str[1];
				if($str[1]!=0)
					echo "Total Questions=".$str[1]."<BR>";
				else
					echo "Total Questions=-----<BR>";		
			}
			else if(strcmp($str[0],"NOA")==0)
			{
				$_SESSION["NOA"]=$str[1];
				if($str[1]!=0)
					echo "No of Attempts=".$str[1]."<BR>";
				else
					echo "No of Attempts=-----<BR>";		
			}
			else if(strcmp($str[0],"CON")==0)
			{
				$_SESSION["CON"]=$str[1];
				if($str[1]!=0)
					echo "Continuation Allowed=".$str[1]."<BR>";
				else
					echo "Continuation Allowed=-----<BR>";		
			}
			else if(strcmp($str[0],"BCK")==0)
			{
				$_SESSION["BCK"]=$str[1];
				if($str[1]!=0)
					echo "Reattempt Allowed=".$str[1]."<BR>";
				else
					echo "Reattempt Allowed=-----<BR>";		
			}
		}

		$date1=date_create($row["end_date"]);
		$date2=date_create(date("Y-m-d"));
		$diff=date_diff($date2,$date1);
		$ed=$diff->format("%R%a");
		if($ed<0) echo "TEST ENDED<BR>";
				

		$date1=date_create($row["start_date"]);
		$date2=date_create(date("Y-m-d"));
		$diff=date_diff($date2,$date1);
		$sd=$diff->format("%R%a");
		if($sd<=0) echo "TEST STARTED<BR>";
		
		$status=-1;
		if($sd<=0 && $ed>=0) $status=1;	
		else 	if($ed<=0) $status=0;

		if($status==1)
			if (isset($_SESSION["BCK"])) echo "<td><h1><a href=give_physics_test_BCK.php?tno=".$row["test_no"]."&ql=".$_SESSION["QL"].">Click HERE to START</a></h1>";
			else echo "<td><h1><a href=give_physics_test.php?tno=".$row["test_no"]."&ql=".$_SESSION["QL"].">Click HERE to START</a></h1>";
		else if($status==0)
		echo "<td><B>Test OVER</b>";

		#displaying scores
		$sql2 ="select mocks_users_ans.op_no as ua, mocks_a.op_no as a, attempt, mocks_a.sr_no as q from mocks_users_ans, mocks_a where mocks_users_ans.q_sr_no=mocks_a.sr_no and uname='".$_SESSION["uname"]."' and test_no=".$row["test_no"]." order by mocks_users_ans.attempt,mocks_users_ans.q_sr_no";
		$result2 = mysqli_query($conn, $sql2);
		$curr_attempt=-1;
		$c_cnt=0;
		$w_cnt=0;
		$na_cnt=0;
		if (mysqli_num_rows($result2) > 0) 
		{
			echo "<B><U><I>RESULTS</B></u></i><BR><BR>";
			while($row2 = mysqli_fetch_assoc($result2))
			{
				if($curr_attempt!=-1 && $curr_attempt!=$row2["attempt"])
				{
					echo "<B>Attempt ".$curr_attempt."</B><BR>correct =".$c_cnt.", wrong=".$w_cnt.", Not attempted=".$na_cnt."<BR>";
					if($c_cnt/($c_cnt+$w_cnt+$na_cnt*1.0)*100>=80) echo "PASS";
					else echo "FAIL";
					if($status==0)
						echo " <a href='the_analyst.php?test_no=".$row["test_no"]."' target=_black>Analysis</a>";
					$c_cnt=0; $w_cnt=0; $na_cnt=0;
					echo "<HR>";
				}
				if ($curr_attempt!=$row2["attempt"]) 
				{
					$curr_attempt=$row2["attempt"];
				}
				if($row2["ua"]==0) ++$na_cnt;
				else if($row2["a"]==$row2["ua"]) ++$c_cnt;
				else if($row2["a"]!=$row2["ua"]) 
				{ 
					++$w_cnt; 
					#echo "incorrect=".$row2["q"]."<BR>";
				}
				//echo "ans=".$row2["a"]." yours is ".$row2["ua"]." attempt= ".$row2["attempt"]."<BR>";	
			}
			if($curr_attempt!=-1) 
			{
				echo "<B>Attempt ".$curr_attempt."</B><BR>correct =".$c_cnt.", wrong=".$w_cnt.", Not attempted=".$na_cnt."<BR>";
				if($c_cnt/($c_cnt+$w_cnt+$na_cnt*1.0)*100>=80) echo "PASS";
				else echo "FAIL";
				if($status==0)
					echo " <a href='the_analyst.php?test_no=".$row["test_no"]."' target=_black>Analysis</a>";
			}
		}

	}
} 
else {	echo "No Mocks Test Scheduled";}
$conn->close();
