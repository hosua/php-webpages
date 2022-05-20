<?php session_start();
$login_user = $_SESSION['login_user'];
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">
<title>Message Board</title>
<!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="../starter-template.css" rel="stylesheet">
<link href="../offcanvas.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="../assets/js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
	<body class="text-light bg-dark">
		<!-- Side Menu -->
		<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
		  <div class="container-fluid">
			<a class="navbar-brand" href="#">Hoswoo's Website</a>
			<button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>

			<div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
			  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
				  <a class="nav-link" aria-current="page" href="../index.php">Home</a>
				</li>
				<li>
				  <a class="nav-link active" aria-current="page" href="board.php">Message Board</a>
				</li>
				<li>
				  <a class="nav-link" aria-current="page" href="../assetto_corsa/assetto_corsa.php">Assetto Corsa Mods</a>
				</li>
				<li>
				  <a class="nav-link" aria-current="page" href="../ROM_pages/rom_pages.php">ROM Downloads</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" aria-current="page" href="../contact.php">Contact</a>
				</li>
			  </ul>
<?php 
	if (!isset($login_user)){
		echo <<<EOT
				<a class="btn-sm btn-primary me-2" href="login.php">Login</a>
				<a class="btn-sm btn-success" href="register.html">Register</a>
EOT;
	} else {
		echo <<<EOT
				<p>Logged in as <strong class="me-2">$login_user</strong> </p>
				<a class="btn-sm btn-danger" href="logout.php">Logout</a>
EOT;
	}
?>
			</div>
		  </div>
		</nav>
<div class="left-align">
<?php
if (!isset($login_user)){
	echo <<<EOT
		<p> Note: You are not logged in. You must <a href='login.php'>login</a> first before you can post messages! </p>
EOT;
} 
?>
</div>
<?php
# For debug
# ini_set('display_errors', 1);

date_default_timezone_set('America/New_York');

$servername = "127.0.0.1";
$db_username = "";
$db_password = "";
$db_name = "Forum";

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

$table_name = 'Main';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	$user = $login_user;
	$msg = htmlspecialchars($_POST['message']);
	$time_stamp = date("Y-m-d H:i:s");
	$user_ip = $_SERVER['REMOTE_ADDR'];
	# Create table if it does not exist yet
	if (!$conn->query("DESCRIBE $table_name")){
		$msql = "CREATE TABLE $table_name (
			id VARBINARY(36) PRIMARY KEY NOT NULL, 
			user VARCHAR(255) NOT NULL, 
			message VARCHAR(1024), 
			ip VARBINARY(16), 
			time_posted DATETIME);";
		if ($conn->query($msql) === TRUE){
			# echo "Created table $table_name<br>";	
		} else {
			echo "<strong>ERROR: ".$msql."<br>".$conn->error."</strong><br>";	
		}
	}
	/* Putting quotes around message is important for handling single quotes */
	if (strlen($user) < 4){
		echo "<strong>ERROR: Username must be at least 4 characters long.</strong><br>";
	} else if (strlen($msg) < 10 || strlen($msg) > 1024){
		echo "<strong>ERROR: Message must be between 10 and 1024 characters long.</strong><br>";
	} else {
		$msql = "INSERT INTO $table_name (id, user, message, ip, time_posted)
			VALUES(UUID(), \"$user\", \"$msg\", \"$user_ip\", \"$time_stamp\");";
		if ($conn->query($msql) === TRUE){
			# echo "Message added to database<br>";
		} else {
			echo "ERROR: ".$msql."<br>".$conn->error;
		}
	}
}
// echo "<button onclick='new-thread.php' class='btn btn-primary'>New Thread</button>";
echo "
	<div class='bd-example'>
		<div id='threads' class='accordion'>";
# Query all threads (We only have one in this case)
while ($table = $result->fetch_assoc()){
	$thread = $table['Tables_in_Forum'];
	$msql = "SELECT user, message, time_posted FROM $thread ORDER BY time_posted DESC";
	$res = $conn->query($msql);
	# Query all messages
	echo <<<EOT
		<div class='accordion-item bg-dark center-align'>
			<h4 id='headingOne' class='accordion-header'>
			<button class='accordion-button bg-secondary text-white' type='button' data-bs-toggle='collapse' 
				data-bs-target='#collapseOne' aria-expanded='true' aria-controls='collapseOne'>
				$thread
			</button>
			<div id='collapseOne' class='accordion-collapse collapse show' aria-lablledby='headingOne' 
				data-bs-parent='#accordionExample' style=''>
EOT;
	/* Message Board */
	if (isset($login_user)){
		echo <<<EOT
		<div>
			<div class='left-align'>
				<h3>Post a message</h3>
				<form method='post'>
				<textarea name='message' type='message' class='form-control bg-dark text-white' 
						rows='5' cols='40' aria-label='With textrea'
						placeholder='Enter a message...'></textarea>
				<button style='text-align:left'type='submit' class='btn btn-primary'>Submit</button>
				<p id='count' style='float:right'>Characters left: 1024</p>
				</form>
			</div>
			<div class='center-align'>
				<script type='text/javascript'>
				const textarea = document.querySelector('textarea')
				const count = document.getElementById('count')
				textarea.onkeyup = (e) => {
					count.innerHTML = 'Characters left: ' + (1024 - e.target.value.length);
				};
				// Source: https://stackoverflow.com/questions/6320113/how-to-prevent-form-resubmission-when-page-is-refreshed-f5-ctrlr
				if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
				}
				</script>

EOT;
	}
	while ($row = $res->fetch_assoc()){
		$u_name = $row['user'];
		$u_msg = $row['message'];	
		$time_posted = $row['time_posted'];
		echo <<<EOT
			<div class='border border-secondary accordion-body'>
				<p class='display-6' style='text-align:left;'>$u_name</p>
				<HR>
				<div style='text-align:left'>$u_msg</div>
				<div style='text-align:right; font-size:75%;'>Posted on</div>
				<div style='text-align:right; font-size:75%;'>$time_posted</div>
			</div>
EOT;
	}
	echo <<<EOT
			</div>
		</div>
	</div>
</div>
EOT;
}
?>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="../assets/dist/js/bootstrap.min.js"></script>
<!-- Needed for responsive menu -->
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="../offcanvas.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
<!-- popper.js and jQuery are needed for many bootstrap components to work -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

