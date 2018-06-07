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

	// Handle upload click
	if (isset($_POST['upload'])){

		$target = "images/".basename($_FILES['image']['name']);

	
		$image = $_FILES['image']['name'];
		$technique = $_POST['technique'];
		$date = $_POST['date'];
		$sname = $_POST['student-name'];

		$request = sprintf("select sid from Students where sname=%s",$sname);
		$response = mysqli_query($dbconnection, $request);

		$rowSid = mysqli_fetch_array($response,MYSQL_ASSOC);
		$sid = $rowSid['sid'];

		$request = sprintf("select aid from Antibodies where aname=%s",$aname);
		$response = mysqli_query($dbconnection, $request);

		$rowAid = mysqli_fetch_array($response,MYSQL_ASSOC);
		$aid = $rowAid['aid'];

		$request = sprintf("select pid from Antibodies where aid=%s",$aid);
		$response = mysqli_query($dbconnection, $request);

		$rowPid = mysqli_fetch_array($response,MYSQL_ASSOC);
		$pid = $rowPid['pid'];

		$sql = sprintf("insert into ResultsPhotos (path,date) values ('$image','$date')");
		$sql = sprintf("insert into Results values (%s,%s,%s,%s,%s)",$pid,$path,$aid,$sid,$technique);

		mysqli_query($dbconnection,$sql);

		$msg = "";
		if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
			$msg = "Image uploaded succesfully.";
		}
		else{
			$msg = "Image failed to upload.";
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
  							<input type="file" class="custom-file-input" id="image" name="image">
  							<label class="custom-file-label" for="image">Choose photo</label>
						</div>
					</div>
				</div>
				<div class="form-row">
				    <div class="form-group col-md-4">
				    	<label>Name</label>
				    	<select id="student-name" name="student-name" class="form-control">
					        <option selected>Name</option>
					        <?php
					        	$request = sprintf("select sname from Students");
								$response = mysqli_query($dbconnection, $request);

								while($row = mysqli_fetch_array($response,MYSQL_ASSOC))
								{	
									print "<option>".$row['sname']."</option>";
								}
					        ?>
				      	</select>
				    </div>
				<!-- </div> -->
				<!-- <div class="form-row"> -->
				    <div class="form-group col-md-4">
				    	<label>Project</label>
				    	<select id="project" name="project" class="form-control">
					        <option selected>Choose antibody</option>
					        <?php
					        	$request = sprintf("select aname from Antibodies");
								$response = mysqli_query($dbconnection, $request);

								while($row = mysqli_fetch_array($response,MYSQL_ASSOC))
								{	
									print "<option>".$row['aname']."</option>";
								}
					        ?>
				      	</select>
				    </div>
				<!-- </div> -->
				<!-- <div class="form-row"> -->
				    <div class="form-group col-md-4">
				    	<label>Technique</label>
				    	<select id="technique" name="technique" class="form-control">
					        <option selected>Choose technique</option>
					        <option>Immuno</option>
					        <option>Backfill</option>
				      	</select>
				    </div>
				</div>
				<div class="form-row">
				    <div class="form-group col-md-4">
				    	<label>Date</label>
				    	<input type="date" name="date" class="form-control">
				    </div>
				</div>
				<button type="submit" name="upload" class="btn btn-primary">Upload</button>
			</form>
		</div>
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
