<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">
<title>Assetto Corsa Mods</title>
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
<div class="left-align">
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
				  <a class="nav-link" aria-current="page" href="../index.html">Home</a>
				</li>
				<li>
				  <a class="nav-link" aria-current="page" href="../message-board/board.php">Message Board</a>
				</li>
				<li>
				  <a class="nav-link active" aria-current="page" href="assetto_corsa.php">Assetto Corsa Mods</a>
				</li>
				<li>
				  <a class="nav-link" aria-current="page" href="../ROM_pages/rom_pages.php">ROM Downloads</a>
				</li>
			  </ul>
			</div>
		 </div>
		</nav>


<strong>Note: I am not the creator of these mods</strong>
<br><br>
<?php
# For debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function dirToArray($dir, $dir_only = False) { // https://www.php.net/manual/en/function.scandir.php
   $result = array();
   $cdir = scandir($dir);
   foreach ($cdir as $key => $value){
      if (!in_array($value,array(".",".."))){
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)){
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
		 } else {
			 if (!$dir_only) {
				 $result[] = $value;
			 }
         }
      }
   }
   return $result;
} 

function human_filesize($bytes, $decimals = 2){ // https://www.php.net/manual/en/function.filesize.php
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
$root = 'assetto-files';
chdir($root);
$dirArray = array('cars', 'tracks');
foreach($dirArray as $subdir){
	$function_name = $subdir . "fn";
	echo "<h2>" . ucfirst($subdir) . "</h2>";
	chdir($subdir);
	$files = dirToArray('.');
	echo "<div class=\"table-responsive\">";
	echo "<input type=\"text\" id=\"$subdir-input\" onkeyup=\"$function_name()\" placeholder=\"Search $subdir..\">
		<table id=\"$subdir\", class=\"table table-dark table-striped table-hover\">
		<thead>
		  <tr class=\"table-dark\">
			<th scope=\"col\">#</th>
			<th scope=\"col\">File</th>
			<th scope=\"col\">Size</th>
			<th scope=\"col\">Link</th>
		  </tr>
		</thead><br>";
	foreach($files as $key => $value){
		$fsize = human_filesize(filesize($value));
		$path = "$root".DIRECTORY_SEPARATOR."$subdir".DIRECTORY_SEPARATOR."$value";
		echo "<tr class=\"table-dark\">\n";
		echo "<td>".($key+1)."</td>\n";
		echo "<td>$value</td>\n";
		echo "<td>$fsize</td>\n";
		echo "<td><a href=\"$path\">Download</a></td>\n";
		echo "</tr>\n";
	}
	echo "</table>";
	echo "
		<script>
		function $function_name() {
		  // Declare variables
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById(\"$subdir-input\");
		  filter = input.value.toUpperCase();
		  table = document.getElementById(\"$subdir\");
		  tr = table.getElementsByTagName(\"tr\");

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName(\"td\")[1];
			if (td) {
			  txtValue = td.textContent || td.innerText;
			  if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = \"\";
			  } else {
				tr[i].style.display = \"none\";
			  }
			}
		  }
		}
	</script>\n";
	echo "</div><br><br> <!-- End table responsive -->";
	chdir('..');
}

?>
<br><br>
<H1>Other Sources</H2>
<a href='https://assettocorsa.club/content-manager.html'>Content Manager</a><br>
<br><br>
<a href='https://www.racedepartment.com/forums/assetto-corsa-mods.36/'>Race Department</a><br>
<a href='https://assettocorsa.club/'>assetto corsa club</a><br>
<a href='assetto-db.com/'>assetto-db</a><br>
<a href='https://assettomods.com/assettomods-releases/'>assetto-mods</a><br>
<a href='https://tm-modding.eu/reboot-team-tracks/'>reboot-team-tracks</a><br>
<a href='https://rgnnr8.wixsite.com/modbase/cars---brands'>wix-site</a><br>
<br><br>
<a href='https://vrc-modding-team.net/'>VRC<br>
<a href='https://www.assettocorsamods.org/shop/'>assetto corsa-mods</a><br>
<br><br>
<a href='Presets.7z'>My Presets</a><br>
<br><br>
</div>
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

