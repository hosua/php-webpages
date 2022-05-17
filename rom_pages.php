<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">
<title>ROMs page</title>
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
				  <a class="nav-link" aria-current="page" href="../assetto_corsa/assetto_corsa.php">Assetto Corsa Mods</a>
				</li>
				<li>
				  <a class="nav-link active" aria-current="page" href="rom_pages.php">ROM Downloads</a>
				</li>
			  </ul>
			</div> <!-- end navbar-collapse -->
		 </div> <!-- end container-fluid -->
		</nav>

	<br><br>
	<div class="accordion" id="accordionExample">
<?php
# For debug
/*
 * ini_set('display_errors', 1);
 * ini_set('display_startup_errors', 1);
 * error_reporting(E_ALL);
 */

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

function serve_dir_page($root, $dirArray){
	chdir($root);
	$is_first = True;
	foreach($dirArray as $subdir){
		$table_name = str_replace(array(' ', '-'), '', $subdir . "Table");
		$function_name = str_replace(array(' ', '-'), '', $subdir . "Fn");
		$input_name = str_replace(array(' ', '-'), '', $subdir . "Input");
		$heading_name = str_replace(array(' ', '-'), '', $subdir . "Heading");
		$collapse_name = str_replace(array(' ', '-'), '', $subdir . "Collapse");

		echo " 
			<div class=\"accordion-item bg-dark\"> 
				<h2 class=\"accordion-header\" id=\"$heading_name\">";
		// This is soooo ugly lol
		if ($is_first){
			echo "<button class=\"accordion-button bg-secondary text-white\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#$collapse_name\" aria-expanded=\"true\" aria-controls=\"$collapse_name\">";
		} else {
			echo "<button class=\"accordion-button collapsed bg-secondary text-white\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#$collapse_name\" aria-expanded=\"false\" aria-controls=\"$collapse_name\">";
		}
		echo ucfirst($subdir) ."</button>
			    </h2>
		";
		if ($is_first){
			echo "<div id=\"$collapse_name\" class=\"accordion-collapse collapse show\" aria-labelledby=\"$heading_name\" data-bs-parent=\"#accordionExample\">\n";
			$is_first = False;
		} else {
			echo "<div id=\"$collapse_name\" class=\"accordion-collapse collapse\" aria-labelledby=\"$heading_name\" data-bs-parent=\"#accordionExample\">\n";
		}
	//echo "<div class=\"accordion-body\">\n";	
		// echo "<h2>" . ucfirst($subdir) . "</h2>";
		chdir($subdir);
		$files = dirToArray('.');
		echo "
				<div class=\"table-responsive\">";
		echo "
					<input type=\"text\" id=\"$input_name\" onkeyup=\"$function_name()\" placeholder=\"Search $subdir...\">
						<table id=\"$table_name\" class=\"table table-dark table-striped table-hover\">
						<thead>
						  <tr class=\"table-dark\">
							<th scope=\"col\">#</th>
							<th scope=\"col\">File</th>
							<th scope=\"col\">Size</th>
							<th scope=\"col\">Link</th>
						  </tr>
						</thead><br>
		";
		foreach($files as $key => $value){
			if (is_file($value)){
				$fsize = human_filesize(filesize($value));
				$path = "$root".DIRECTORY_SEPARATOR."$subdir".DIRECTORY_SEPARATOR."$value";
				echo "
				<tr class=\"table-dark\">
					<td>".($key+1)."</td>
					<td>$value</td>
					<td>$fsize</td>
					<td><a href=\"$path\">Download</a></td>
				</tr>";
			}
		}
	echo "</table>
		</div> <!-- end table-responsive -->\n";
		echo "
			<script>
				function $function_name() {
				  // Declare variables
				  var input, filter, table, tr, td, i, txtValue;
				  input = document.getElementById(\"$input_name\");
				  filter = input.value.toUpperCase();
				  table = document.getElementById(\"$table_name\");
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
		echo "</div> <!-- end accordion body -->
			</div> <!-- end accordion collapse -->";
		chdir('..');
	}
}

$root = 'ROM-files';
$dirArray = array('Atari 2600', 'Atari 5200', 'Atari 7800', 
	'Nintendo - Game Boy', 'Nintendo - Game Boy Color', 'Nintendo - Game Boy Advance');
serve_dir_page($root, $dirArray);
?>
<br><br>
</div> <!-- end accordion -->
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

