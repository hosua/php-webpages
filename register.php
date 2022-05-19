<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">

<title>Register an account</title>

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
<div class="container">
	<?php
		# For debug
		ini_set('display_errors', 1);

		date_default_timezone_set('America/New_York');

		$servername = "127.0.0.1";
		$username = "";
		$password = "";
		$dbname = "Accounts";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error){
			die("Connection failed: ".$conn->connect_error);
		}

		$sql = "SHOW TABLES FROM $dbname";
		$result = $conn->query($sql);
		if (!$result){
			echo "Could not find the database $dbname";
			echo 'MySQL Error: '.mysql_error();
			exit;
		}

		$table_name = 'Users';

		$user = htmlspecialchars($_POST['username']);
		$pass = htmlspecialchars($_POST['password']);
		$email = htmlspecialchars($_POST['email']);
		$time_registered = date("Y-m-d H:i:s");
		$user_ip = $_SERVER['REMOTE_ADDR'];
		# Create table if it does not exist yet
		if (!$conn->query("DESCRIBE $table_name")){
			$sql = "CREATE TABLE $table_name (
					id VARBINARY(36) PRIMARY KEY NOT NULL, 
					username VARCHAR(30) NOT NULL, 
					password VARCHAR(255), 
					ip_registered VARBINARY(16), 
					time_registered DATETIME);";
			if ($conn->query($sql) === TRUE){
				# echo "Created table $table_name<br>";	
			} else {
				echo "<strong>ERROR: ".$sql."<br>".$conn->error."</strong><br>";	
			}
		}
		$check_user = "SELECT * from $table_name WHERE username = '$user'";
		
		if ($conn->query($check_user)){
			if (mysqli_num_rows($conn->query($check_user)) == 0){
				$sql = "INSERT INTO $table_name (id, username, password, ip_registered, time_registered)
							VALUES(UUID(), \"$user\", \"$pass\", \"$user_ip\", \"$time_registered\");";
				if ($conn->query($sql) === TRUE){
					echo "<p>Successfully registered user with the username \"$user\".</p>";
				} else {
					echo "<p>ERROR: ".$sql."<br>".$conn->error."</p>";
				}
			} else {
				echo <<<EOT
				<p>The username <strong>$user</strong> was already taken. Please try using another one!</p>
				<a class="btn btn-primary" href="register.html">Back To Registration</a>
EOT;
			}
			echo <<<EOT
				<a class="btn btn-primary" href="../index.html">Home</a>
EOT;
		}

		# echo "$user, $pass, $email, $time_registered, $user_ip"
	?>
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

