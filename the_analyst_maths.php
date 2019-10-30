
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



<?php
session_start();
$test_no=$_GET["test_no"];
echo " Analysis of test Number ".$test_no." for user, ".$_SESSION["uname"]."<BR>";



#displaying scores
		$conn = new mysqli("localhost", "root","", "aNalyser");
		if ($conn->connect_error)
				die("Connection failed: " . $conn->connect_error);
		$sql2 ="select mocks_users_ans_maths.op_no as ua, mocks_a_maths.op_no as a, attempt, mocks_a_maths.sr_no as q, quest from mocks_users_ans_maths, mocks_a_maths, mocks_q_maths where mocks_q_maths.sr_no= mocks_users_ans_maths.q_sr_no and  mocks_users_ans_maths.q_sr_no=mocks_a_maths.sr_no and uname='".$_SESSION["uname"]."' and test_no=".$test_no." order by mocks_users_ans_maths.attempt,mocks_users_ans_maths.q_sr_no";
		#echo "<BR>".$sql2."<BR>";
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
					echo "</table>";	
					echo"correct =".$c_cnt.", wrong=".$w_cnt.", Not attempted=".$na_cnt."<BR>";
					
					if($c_cnt/($c_cnt+$w_cnt+$na_cnt*1.0)*100>=80) echo "PASS";
					else echo "FAIL";
?>
					    <script type="text/javascript">

      					// Load the Visualization API and the corechart package.
      					google.charts.load('current', {'packages':['corechart']});		
					google.charts.setOnLoadCallback(drawChart<?php echo $curr_attempt?>);
					   function drawChart<?php echo $curr_attempt?>() {

  							      // Create the data table.
							        var data = new google.visualization.DataTable();
     								   data.addColumn('string', 'TYPE');
     								   data.addColumn('number', 'VALUE');
        							data.addRows([
 							         ['Correct', <?php echo $c_cnt; ?>],
 							         ['Wrong', <?php echo $w_cnt; ?>],
 							         ['Not Attempted', <?php echo $na_cnt; ?>]
							        ]);

  					      // Set chart options
  					      var options = {'title':'Breakup by THE ANALYST','width':400,'height':300};

					        // Instantiate and draw our chart, passing in some options.
				       	 	var chart = new google.visualization.PieChart(document.getElementById('chart_div<?php echo $curr_attempt?>'));
        					chart.draw(data, options);
      					}
					 </script>

				    <!--Div that will hold the pie chart-->
				    <div id="chart_div<?php echo $curr_attempt?>"></div>
<?php					
					$c_cnt=0; $w_cnt=0; $na_cnt=0;
					echo "<HR>";
				}
				if ($curr_attempt!=$row2["attempt"]) 
				{
					$curr_attempt=$row2["attempt"];
				}	
				if($c_cnt==0 && $w_cnt==0 && $na_cnt==0)
					echo "<B>Attempt ".$curr_attempt."</B><BR><table border=1><th>Question<th>Your ans<th>Actual ans";
				if($row2["ua"]==0)
					$bg="gold";
				else if($row2["a"]==$row2["ua"])
					$bg="0x3366CC";
				else if($row2["a"]!=$row2["ua"])
					$bg="crimson"; 

				echo "<tr><td>".$row2["quest"];
				$sql3 ="select * from mocks_o_maths where sr_no=".$row2["q"]." order by op_no";
				#echo $sql3;
				$result3 = mysqli_query($conn, $sql3);
				while($row3 = mysqli_fetch_assoc($result3))
				{
					echo "<BR>(".$row3["op_no"].") ".$row3["option"];
				}

				echo "<td bgcolor=".$bg."><font color=white>".$row2["ua"]."</font><td><font color=black>".$row2["a"]."</font>";
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
				echo "</table>";echo "<B>Attempt ".$curr_attempt."</B><BR>correct =".$c_cnt.", wrong=".$w_cnt.", Not attempted=".$na_cnt."<BR>";
				if($c_cnt/($c_cnt+$w_cnt+$na_cnt*1.0)*100>=80) echo "PASS";
				else echo "FAIL";
				echo "</table>";
?>
				    <script type="text/javascript">
      					// Load the Visualization API and the corechart package.
      					google.charts.load('current', {'packages':['corechart']});		
					google.charts.setOnLoadCallback(drawChart<?php echo $curr_attempt?>);
					   function drawChart<?php echo $curr_attempt?>() {

  							      // Create the data table.
							        var data = new google.visualization.DataTable();
     								   data.addColumn('string', 'TYPE');
     								   data.addColumn('number', 'VALUE');
        							data.addRows([
 							         ['Correct', <?php echo $c_cnt; ?>],
 							         ['Wrong', <?php echo $w_cnt; ?>],
 							         ['Not Attempted', <?php echo $na_cnt; ?>]
							        ]);

  					      // Set chart options
  					      var options = {'title':'Breakup by THE ANALYST','width':400,'height':300};

					        // Instantiate and draw our chart, passing in some options.
				       	 	var chart = new google.visualization.PieChart(document.getElementById('chart_div<?php echo $curr_attempt?>'));
        					chart.draw(data, options);
      					}
					 </script>

				    <!--Div that will hold the pie chart-->
				    <div id="chart_div<?php echo $curr_attempt?>"></div>

<?php
				
			}
		}
$conn->close();

?>