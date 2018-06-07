<?php
	
	$db_username = "luis_quinones21";
	$db_password = "801156424";
	$db_hostname = "localhost";
	$db_database = "luis_quinones21";

	mysqli_report(MYSQLI_REPORT_STRICT);

	try 
	{
		$dbconnection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or $error = 1;
	}
	catch(Exception $ex) 
	{
		die("Failed to connect to database: " . $ex->getMessage());
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Miller's Lab Database</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href=" bootstrap-4.1.1-dist/css/custom.css">
</head>

<body>
	<!-- Logo -->
	<center><img src="images/institutelogo.jpg" class="banner-logo"></center>

	<!-- Banner -->
	<div class="banner">
		<center>
			<div class="box-title">
				<center><h1>Miller Lab Projects Database</h1></center>
			</div>
		</center>
		
		<ul class="nav justify-content-center">
			<li class="nav-item">
		    	<a class="nav-link" href="#">Home</a>
		  	</li>
		  	<li class="nav-item">
		 		<a class="nav-link" href="#">Profile</a>
			</li>
			<li class="nav-item">
		    	<a class="nav-link" href="manage_data.php">Manage Data</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="manage_projects.html">Manage Projects</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="#">Manage Students</a>
			</li>
		</ul>
	</div>

	<!-- Content -->
	<div class="container">

	<?php

	$requestProjects = sprintf("select pid,pname from Projects");
	$projects = mysqli_query($dbconnection, $requestProjects);

	while($project = mysqli_fetch_array($projects,MYSQL_ASSOC))
	{	
		?>
		<div class="box-project">
			<div class="box-project-heading">
				<h4><span class="fas fa-caret-right"></span> <?php print $project['pname'] ?></h4>
			</div>
			<div class="box-project-techniques" style="display: none">
				<h5>Results</h5>
				<ul>
					<li>
						<div class="technique">
							<h5><span class="fas fa-caret-right"></span> Immuno</h5>
						</div>
						<ul class="results" style="display: none">
						<?php
						$requestResults = sprintf("select path from Results where technique='Immuno' and pid=%s",$project['pid']);
						$results = mysqli_query($dbconnection, $requestResults);
						while($result = mysqli_fetch_array($results,MYSQL_ASSOC)){ ?>
							<li><img src="<?php print $result['path']?>"></li>
						<?php } ?>
						</ul>
					</li>
					<li>
						<div class="technique">
							<h5><span class="fas fa-caret-right"></span> Backfill</h5>
						</div>
						<ul class="results" style="display: none">
						<?php
						$requestResults = sprintf("select path from Results where technique='Backfill' and pid=%s", $project['pid']);
						$results = mysqli_query($dbconnection, $requestResults);
						while($result = mysqli_fetch_array($results,MYSQL_ASSOC)){ ?>
							<li><img src="<?php print $result['path']?>"></li>
						<?php } ?>
						</ul>
					</li>
				</ul>
			</div>
		</div> <!-- end box-project -->
	<?php } ?>				
	</div> <!-- end container -->

	<!-- Footer -->
	
			<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="bootstrap-4.1.1-dist/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="bootstrap-4.1.1-dist/js/custom.js"></script>
</body>
</html>