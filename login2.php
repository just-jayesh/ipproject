
<?php
session_start();
if (!isset($_SESSION["login"]))
	$_SESSION["login"] = 0;
else if($_SESSION["login"]==1)
	header('Location: welcome2.php'); 
if(isset($_POST["uname"]))
{
$conn = new mysqli("localhost", "root","", "aNalyser");
if ($conn->connect_error)
die("Connection failed: " . $conn->connect_error);

$sql = "SELECT * FROM users where uname='".$_POST["uname"]."' and pwd='".$_POST["pwd"]."' and status='A'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{
	while($row = mysqli_fetch_assoc($result))
		echo "Welcome, " . $row["uname"]. "<br>";
	$_SESSION["login"]=1;
	$_SESSION["uname"]=$_POST["uname"];
	
	header('Location: welcome2.php');
	
} 
else {	echo "Invalid login"; $login=0;}
$conn->close();
}
?>
<html>
    <head>
        <title>Login Form</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/frontslide.css">
        
    </head>
    <body>
        <section class="container-fluid bg">
            <section class="row justify-content-center">
                <section class="col-12 col-sm-6 col-md-3">
                      <form action=login2.php method=post class="form-container">
                              <div class="form-group row">
                                <label for="text" class="col-sm-2 col-form-label"> Username </label>
                                  <div class="col-sm-11">
                                    <input type=text name=uname class="form-control" id="uname" placeholder="username">
                                  </div>
                              </div>
                              <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-11">
                                  <input type="password" name=pwd class="form-control" id="pass" placeholder="Password">
                                </div>
                              </div>
                          
                           
                              <div class="form-group row">
                                <div class="col-sm-9">
                                  <input type=submit class="btn btn-primary btn-block" value=LOGIN>
                                </div>
                              </div>
                            </form>
                </section>
            </section>

        </section>



          <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>







    </body>
</html> 
