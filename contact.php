<?php session_start();
$login_user = $_SESSION['login_user'];
?>
<!DOCCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Contact</title>

    <!-- Bootstrap core CSS -->
	<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

	<link href="offcanvas.css" rel="stylesheet">


    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<!-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="text-light bg-dark">

<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Hoswoo's Website</a>
    <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		<li class="nav-item">
		  <a class="nav-link" aria-current="page" href="index.php">Home</a>
		</li>
		<li>
		  <a class="nav-link" aria-current="page" href="message-board/board.php">Message Board</a>
		</li>
		<li>
		  <a class="nav-link" aria-current="page" href="assetto_corsa/assetto_corsa.php">Assetto Corsa Mods</a>
		</li>
		<li>
		  <a class="nav-link" aria-current="page" href="ROM_pages/rom_pages.php">ROM Downloads</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" aria-current="page" href="portfolio.php">Portfolio</a>
		</li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contact.php">Contact</a>
        </li>
      </ul>
<?php 
	if (!isset($login_user)){
		echo <<<EOT
				<a class="btn-sm btn-primary me-2" href="message-board/login.php">Login</a>
				<a class="btn-sm btn-success" href="message-board/register.html">Register</a>
EOT;
	} else {
		echo <<<EOT
				<p>Logged in as <strong class="me-2">$login_user</strong> </p>
				<a class="btn-sm btn-danger" href="message-board/logout.php">Logout</a>
EOT;
	}
?>
    </div>
  </div>
</nav>

    <div class="container">

		<div class="starter-template">
			<h1>Contact Information</h1>
			<p class="lead"> If you would like to get in contact with me, please send me an email or leave me a voice mail.</p>
			<p><strong> Josh Ortiga </strong></p>
			<p><strong> Cell: 973-462-4663</strong> </p> 
			<a href="mailto:jao43@njit.edu">jao43@njit.edu</a>
			<br> <br> <br>
			<br> <a href="https://github.com/hosua"><img src="images/github-icon.png" style="width:42px;height:42px;"></a>
			<a href="https://github.com/hosua">Github</a>
			<br> <a href="https://gitlab.com/hosua"><img src="images/gitlab-icon.png" style="width:42px;height:42px;"></a>
			<a href="https://gitlab.com/hosua">Gitlab</a>
			<br> <a href="https://www.codewars.com/users/hosua/"><img src="https://www.codewars.com/users/hosua/badges/small" alt="codewars stats"></a>
		  </div>
		</div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
	<!-- Needed for responsive menu -->
	<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="offcanvas.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	<!-- popper.js and jQuery are needed for many bootstrap components to work -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
    <div class="container">
	<!--
	<style type="text/css">
		body { background: #061424 !important; }
	</style>
	-->
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	<!-- popper.js and jQuery are needed for many bootstrap components to work -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

