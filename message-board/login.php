<?php session_start(); ?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">

<title>Login</title>

<!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="../starter-template.css" rel="stylesheet">

<link href="../offcanvas.css" rel="stylesheet">


<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="../assets/js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="text-light bg-dark">
<!-- END OF BOILERPLATE -->
<div class="container">
	<div class="left-align">
		<h3>Login</h3>
		<form method='post' class="row g-3">
		<div class="col-md-4">
			<label for="username" class="form-label">Username</label>
			<input class='bg-dark text-white form-control' id='username' minlength='4' maxlength='30' type='text' name='username' placeholder='Enter username...' required>
		</div>
		<div class="col-md-5">
			<label for="password" class="form-label">Password</label>
			<div class="input-group mb-3">
				<input class='bg-dark text-white form-control' id='password' minlength='6' maxlength='30' type='password' name='password' placeholder='Enter password...' required>
				<div class="input-group-append">
					<button id='btn_password' style='text-align:left' type='button' class='btn btn-outline-secondary text-white' onclick="toggle_visibility('password'); changeText('btn_password')">Show</button>
				</div>
			</div>
		</div>
		<div class="row g-3">
			<div class="col-md-4">
				<button style='text-align:left' type='submit' class='btn btn-primary'>Login</button>
				<button style='text-align:left' type='button' class='btn btn-primary' onclick="history.back()">Go back</button>
			</div>
			<p> Not registered yet? <a href="register.html">Register</a> now! </p>
		</div>
	<script language='javascript' type='text/javascript'> 
			function changeText(input) {
				var x = document.getElementById(input);
				if (x.innerText === "Hide"){
					x.innerText = "Show";
				} else {
					x.innerText = "Hide";
				}
			}
			// Source: https://www.w3schools.com/howto/howto_js_toggle_password.asp
			function toggle_visibility(input) {
			  var x = document.getElementById(input);
			  if (x.type === "password") {
				x.type = "text";
			  } else {
				x.type = "password";
			  }
			} 
			// Source: https://stackoverflow.com/questions/8395269/what-do-form-action-and-form-method-post-action-do
			function check(input) {
				if (input.value != document.getElementById('password').value) {
					input.setCustomValidity('Password Must be Matching.');
				} else {
					// input is valid -- reset the error message
					input.setCustomValidity('');
				}
			}
			// Source: https://stackoverflow.com/questions/6320113/how-to-prevent-form-resubmission-when-page-is-refreshed-f5-ctrlr
			if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );
			}
		</script>
		</form>
	<?php
	# For debug
	ini_set('display_errors', 1);
	date_default_timezone_set('America/New_York');

	if ($_SERVER['REQUEST_METHOD'] === 'POST'){
		$servername = "127.0.0.1";
		$db_username = "";
		$db_password = "";
		$db_name = "Accounts";

		// Create connection
		$conn = new mysqli($servername, $db_username, $db_password, $db_name);

		// Check connection
		if ($conn->connect_error){
			die("Connection failed: ".$conn->connect_error);
		}

		$sql = "SHOW TABLES FROM $db_name";
		$result = $conn->query($sql);
		if (!$result){
			echo "Could not find the database $db_name";
			echo 'MySQL Error: '.mysql_error();
			exit;
		}

		$table_name = 'Users';
		$user = trim(htmlspecialchars($_POST['username']));
		$pass = trim(htmlspecialchars($_POST['password']));
		$time_logged = date("Y-m-d H:i:s");
		$ip_logged = $_SERVER['REMOTE_ADDR'];
		$hash_pass = mysqli_fetch_row($conn->query("SELECT password from $table_name WHERE username = '$user'"))[0];
		$login_user = mysqli_fetch_row($conn->query("SELECT username from $table_name WHERE username = '$user'"))[0];
		if (password_verify($pass, $hash_pass)){
			$_SESSION['login_user'] = $login_user;
			header("location: welcome.php");
		} else {
			$db_logs = 'Logs';
			$login_table = 'Login';
			$conn_logs = new mysqli($servername, $db_username, $db_password, $db_logs);
			$sql = "INSERT INTO $login_table (user, status, ip, time_logged)
				VALUES(\"$user\", \"failure\", \"$ip_logged\", \"$time_logged\");";
			if ($conn_logs->query($sql) === TRUE){
				echo "<p><strong>Invalid username or password.</strong></p>";
			} else {
				echo "<p>ERROR: ".$sql."<br>".$conn_logs->error."</p>";
			}
		}
	}
	?>
	</div>
</div>


<!-- START OF BOILERPLATE -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="../assets/dist/js/bootstrap.min.js"></script>
<!-- Needed for responsive menu -->
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="offcanvas.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
<!-- popper.js and jQuery are needed for many bootstrap components to work -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
<!-- END OF BOILERPLATE -->
</html>

