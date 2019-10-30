
<!doctype html>
<html lang="en">
  <head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <script>
		function logout()
		{	

                         
 
alert("GOOD BYE!!");
			
			window.location.href="logout.php";
		}
	</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Top navbar example · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/navbar-static/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="navbar-top.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="#">Navlakhi Mock Test</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      
      
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Physics/Chemistry/Mathematics</a>
      </li>
    </ul>
    <ul>
        <li>
            <button onClick="logout()"type="button" class="btn btn-danger btn-lg" >LOGOUT</button>
        </li>
    </ul>
  </div>
</nav>
<div class="row">
        <div class="col-md-6">
                <div class="card mdb-color lighten-2 text-center z-depth-2">
                        <img class="card-img-top" src="p1.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Physics Mock Test</h5>
                        <p class="card-text">Mechanics/Dynamics/Optics/Electromagnetism/Modern Physics.</p>
                        <a href="physics_mocks.php" class="btn btn-primary">Start Test</a>
                      </div>
                    </div>
            </div>
        <div class="col-md-6">
            <div class="card mdb-color lighten-2 text-center z-depth-2">
                    <img class="card-img-top" src="c1.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Chemistry Mock Test</h5>
                    <p class="card-text">Organic/Inorganic/Physical.</p>
                    <a href="chem_mocks.php" class="btn btn-primary">Start Test</a>
                  </div>
                </div>
        </div>
</div>
<br>
<div class="row">
        <div class="col-md-6">
                <div class="card mdb-color lighten-2 text-center z-depth-2">
                        <img class="card-img-top" src="m1.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Mathematics Test</h5>
                        <p class="card-text">Algebra/Geometry/Calculas.</p>
                        <a href="maths_mocks.php" class="btn btn-primary">Start Test</a>
                      </div>
                    </div>
            </div>
        <div class="col-md-6">
            <div class="card mdb-color lighten-2 text-center z-depth-2">
                    <img class="card-img-top" src="s1.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Physics/Chemistry/Mathematics</h5>
                    <p class="card-text">Mock Test for PCM.</p>
                    <a href="combo_mocks.php" class="btn btn-primary">Start Test</a>
                  </div>
                </div>
        </div>

</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="/docs/4.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script></body>
</html>