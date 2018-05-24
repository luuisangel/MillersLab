<?php

	// Handle upload click
	if (isset($_POST['upload'])){

		$target = "images/".basename($_FILES['image']['name']);

		$db_username = "root";
		$db_password = "Luisthebezt1";
		$db_hostname = "localhost";
		$db_database = "MillersLab";

		mysqli_report(MYSQLI_REPORT_STRICT);

		try 
		{
			$dbconnection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or $error = 1;
			$image = $_FILES['image']['name'];
			$technique = $_POST['technique'];
			$date = $_POST['date'];

			echo "<h1>".$technique."</h1>";
			echo "<h1>".$date."</h1>";

			$sql = "insert into ResultsPhotos (photo,date) values ('$image','$date')";

			mysqli_query($dbconnection,$sql);

			$msg = "";
			if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
				$msg = "Image uploaded succesfully.";
			}
			else{
				$msg = "Image failed to upload.";
			}
		}
		catch(Exception $ex) 
		{
			die("Failed to connect to database: " . $ex->getMessage());
		}	
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Miller's Lab Database</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">ˀ
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
		    	<a class="nav-link" href="home.php">Home</a>
		  	</li>
		  	<li class="nav-item">
		 		<a class="nav-link" href="#">Profile</a>
			</li>
			<li class="nav-item">
		    	<a class="nav-link" href="#">Manage Data</a>
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
		<div class="form-box">
			<h2>Upload your results</h2>
			<form method="post" action="manage_data.php" enctype="multipart/form-data">
				<div class="form-row">
					<div class="form-group col-md-6">
						<div class="custom-file">
  							<input type="file" class="custom-file-input" name="image">
  							<label class="custom-file-label" for="image">Choose photo</label>
						</div>
					</div>
				</div>
				<div class="form-row">
				    <div class="form-group col-md-4">
				    	<select name="technique" class="form-control">
					        <option selected>Choose technique</option>
					        <option>Immuno</option>
					        <option>Backfill</option>
				      	</select>
				    </div>
				</div>
				<div class="form-row">
				    <div class="form-group col-md-4">
				    	<input type="date" name="date" class="form-control">
				    </div>
				</div>
				<button type="submit" class="btn btn-primary">Upload</button>
			</form>
		</div>
		<pre>
			<?php 
				var_dump($_POST); 
				var_dump($_FILES);
			?>
		</pre>
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
