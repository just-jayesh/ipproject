<?php
						$con = mysql_connect("127.0.0.1:3306","navla","007_abhi_");
						if (!$con)
  						{
  							die('Could not connect: ' . mysql_error());
  						}
	
						mysql_select_db("aNalyser", $con);
?>