<?php
/* BEGINNING OF BOILERPLATE */
# For debug
# ini_set('display_errors', 1);

date_default_timezone_set('America/New_York');


$servername = "127.0.0.1";
/* Before using, you should run db-manager.py first to create the first message board. 
 * You should also set up mysql first before this script can serve web pages.
 * Once you have mysql set up, set the $username and $password variables below to the proper username and password of your database.
 */
$username = "";
$password = "";
$dbname = "Forum";

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


echo "<html lang=\"en\">
<head>
<meta charset=\"utf-8\">
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name=\"description\" content=\"\">
<meta name=\"author\" content=\"\">
<link rel=\"icon\" href=\"favicon.ico\">

<title>Message Board</title>

<!-- Bootstrap core CSS -->
<link href=\"../assets/dist/css/bootstrap.min.css\" rel=\"stylesheet\">

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href=\"../assets/css/ie10-viewport-bug-workaround.css\" rel=\"stylesheet\">

<!-- Custom styles for this template -->
<link href=\"../starter-template.css\" rel=\"stylesheet\">

<link href=\"../offcanvas.css\" rel=\"stylesheet\">


<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src=\"../assets/js/ie8-responsive-file-warning.js\"></script><![endif]-->
<script src=\"../assets/js/ie-emulation-modes-warning.js\"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
<![endif]-->
</head>
<body class=\"text-light bg-dark\">";



$table_name = 'Main';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	$usr = htmlspecialchars($_POST['username']);
	$msg = htmlspecialchars($_POST['message']);
	$time_stamp = date("Y-m-d H:i:s");
	$usr_ip = $_SERVER['REMOTE_ADDR'];
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
	if (strlen($usr) < 4){
		echo "<strong>ERROR: Username must be at least 4 characters long.</strong><br>";
	} else if (strlen($msg) < 10 || strlen($msg) > 1024){
		echo "<strong>ERROR: Message must be between 10 and 1024 characters long.</strong><br>";
	} else {
		$msql = "INSERT INTO $table_name (id, user, message, ip, time_posted)
					VALUES(UUID(), \"$usr\", \"$msg\", \"$usr_ip\", \"$time_stamp\");";
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
	echo "
		<div class='accordion-item bg-dark center-align'>
			<h4 id='headingOne' class='accordion-header'>
			<button class='accordion-button bg-secondary text-white' type='button' data-bs-toggle='collapse' 
				data-bs-target='#collapseOne' aria-expanded='true' aria-controls='collapseOne'>
				$thread
			</button>
			<div id='collapseOne' class='accordion-collapse collapse show' aria-lablledby='headingOne' 
				data-bs-parent='#accordionExample' style=''>
		";
	/* Message Board */
	echo "
	<div
	<div class='left-align'>
		<h3>Post a message</h3>
		<form method='post'>
		<input class='bg-dark text-white' id='floatingInput' type='username' name='username' placeholder='Username'>
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
		</script>";
	while ($row = $res->fetch_assoc()){
		$u_name = $row['user'];
		$u_msg = $row['message'];	
		$d_time = $row['time_posted'];
		echo "
			<div class='border border-secondary accordion-body'>
				<p class='display-6' style='text-align:left;'>$u_name</p>
				<HR>
				<div style='text-align:left'>$u_msg</div>
				<p style='text-align:right;'>Posted on: $d_time</p>
			</div>";
	}
echo "
		</div>
	</div>
</div>
</div>
</div>";
}





/* END OF BOILERPLATE */
echo "
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
<script>window.jQuery || document.write('<script src=\"assets/js/vendor/jquery.min.js\"><\/script>')</script>
<script src=\"../assets/dist/js/bootstrap.min.js\"></script>
<!-- Needed for responsive menu -->
<script src=\"../assets/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"offcanvas.js\"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src=\"../assets/js/ie10-viewport-bug-workaround.js\"></script>
<!-- popper.js and jQuery are needed for many bootstrap components to work -->
<script src=\"https://code.jquery.com/jquery-3.4.1.slim.min.js\" integrity=\"sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n\" crossorigin=\"anonymous\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js\" integrity=\"sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo\" crossorigin=\"anonymous\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js\" integrity=\"sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6\" crossorigin=\"anonymous\"></script>
</body>
</html>"
?>

