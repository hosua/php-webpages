<?php session_start();
$login_user = $_SESSION['login_user'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Hoswoo's Website</title>

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
				  <a class="nav-link active" aria-current="page" href="portfolio.php">Portfolio</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" aria-current="page" href="contact.php">Contact</a>
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
	 <!-- End side menu -->
	 <div class="center-align">
	 	<h2>Portfolio</h2>
	 </div>
	 <hr>
	 <div class="container">
	 	<h4>hoswoo.xyz
	 		<span style='float:right;'>
	 			<a class="btn btn-primary" href="https://github.com/hosua/php-webpages">Source Code</a>
	 		</span>
	 	</h4>
	 	<p> This website is currently a work in progress, and considered part of my portfolio. </p>
	 	<p> It uses Bootstrap 5 for the front-end, mysql for storing account information and threads/messages, 
		and php to serve dynamic html pages. Everything you see on this website was implemented by me (and <a href="https://stackoverflow.com/">stackoverflow</a>)!</p>
	 	<p> I currently am unsure of what features are to come, but so far there is a system for 
		user authentication and posting messages as a logged-in user. There are also download pages, 
		<a href="assetto_corsa/assetto_corsa.php">Assetto Corsa Mods</a> and 
		<a href="ROM_pages/rom_pages.php">ROM Downloads</a>. They both use php to serve dynamic html pages.
		</p>
	 </div>
	 <hr>
	 <div class="container">
		<h4>Blackjack Simulator
	 		<span style='float:right;'>
	 			<a class="btn btn-primary" href="https://github.com/hosua/Blackjack">Source Code</a>
	 		</span>
		</h4>
		<div class='ratio ratio-16x9'>
		   <iframe class='embed-responsive-item' src="https://replit.com/@hosuao/Blackjack?embed=1&outputonly=1"></iframe>
		</div>
		<br>
		<p> This is text-based Blackjack simulator created in Python. </p>
		<p> The game features betting money (not actual money) and rules that
		are true to real Blackjack, with the exception that you cannot double down your bets. 
		This was a planned feature but I never got around to implementing it. </p>
	 </div>
	 <hr>
	 <div class="container">
		<h4>Discord Bot
			<span style='float:right;'>
				<a class="btn btn-primary" href="https://github.com/hosua/Discord-Bot">Source Code</a>
			</span>
		</h4>
		<img class="img-fluid" src="images/discord-bot.png" alt="discord-bot.png">	
		<br> <br>
		<p> This is a Discord bot created in Python. It can play music in voice chat, scrape ebay for prices, 
			solve algebraic equations, and much more. It is one of my first projects that I made in Python.
		</p>
	 </div>
	 <hr>
	 <div class="container">
	 	<h4>Folder Organizer Tool
			<span style='float:right;'>
				<a class="btn btn-primary" href="https://github.com/hosua/Folder-Organizer-Tool/">Source Code</a>
			</span>
		</h4>
		<img class="img-fluid" src="images/FOT.png" alt="discord-bot.png">	
		<br> <br>
		<p> This tool is a Python script that is used to manage my ROMs and put them into alphabetical folders. 
		<p> It can also separate betas and romhacks from official releases, provided that the ROMs follow naming conventions.
		I don't have any use for it anymore since I have found better ways to manage all of my ROMs, but it is still available to use. </p>
	 </div>
	 <hr>
	 <div class="container">
		<h4>Minecraft Fisher
			<span style='float:right;'>
				<a class="btn btn-primary" href="https://github.com/hosua/Minecraft-Fisher">Source Code</a>
			</span>
		</h4>
		<img class="img-fluid" src="images/Minecraft-Fisher.png">
		<br> <br>
		<p> This is a fishing bot that I created in Python. 
			It is heavily inspired by another fishing bot called <a href="https://github.com/FairfieldTekLLC/McFishing">McFishing</a>. 
		</p>
		<p> The original was created in C# however, I wanted to recreate a version in Python from scratch. 
			The way the bot works is simple. It scans an array of pixels for a very specific shade of red on the screen (the fishing bobber). 
			When that color disappears from the screen, that must mean that the bobber went underwater, indicating that a fish can be reeled in.
		</p>
	 </div>
	 <hr>
	 <div class="container">
		<h4>Windows 11 - Enable/Disable Show More Options
			<span style='float:right;'>
				<a class="btn btn-primary" href="https://github.com/hosua/Win11-enable-disable-show-options">Source Code</a>
			</span>
		</h4>
		<p> Windows 11 changed the right click menu and made it terrible. 
			This batch script reverts it back to how it has always been and should be.</p>
		<p> There is also another script to revert it back to the way it was if you wish to undo the changes. </p>
		<div class="row g-3">
			<span class="col-md-4">
				<strong> Before: </strong> <br>
				<img class="img-fluid" src="images/windows-before.png">
			</span>
			<span class="col-md-4">
				<strong> After: </strong> <br>
				<img class="img-fluid" src="images/windows-after.png">
			</span>
		</div>
	 </div>
	 <hr>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="assets/dist/js/bootstrap.min.js"></script>
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
