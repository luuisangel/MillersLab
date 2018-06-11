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
		$pname = $_POST['project'];
		$aid = $_POST['aid'];

		$request = sprintf("select sid from Students where sname='%s'",$sname);
		$response = mysqli_query($dbconnection, $request);

		$rowSid = mysqli_fetch_array($response,MYSQL_ASSOC);
		$sid = $rowSid['sid'];

		$request = sprintf("select pid from Antibodies where aid='%s'",$aid);
		$response = mysqli_query($dbconnection, $request);

		$request = sprintf("select pid from Projects where pname='%s'",$pname);
		$rowPid = mysqli_fetch_array($response,MYSQL_ASSOC);
		$pid = $rowPid['pid'];

		$insert = sprintf("insert into ResultsPhotos (path,date) values ('%s','%s')",$image,$date);

		mysqli_query($dbconnection,$insert);

		$insert = sprintf("insert into Results (pid,path,aid,sid,technique) values (%s,'%s','%s',%s,'%s')",$pid,$image,$aid,$sid,$technique);

		mysqli_query($dbconnection,$insert);

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
									?><option value="<?php print $row['sname'] ?>"><?php print $row['sname'] ?></option><?php ; ?>
						  	  <?php } ?>
				      	</select>
				    </div>
				    <div class="form-group col-md-4">
				    	<label>Project</label>
				    	<select id="project" name="project" class="form-control">
					        <option selected>Choose project</option>
					        <?php
					        	$request = sprintf("select pname from Projects");
								$response = mysqli_query($dbconnection, $request);

								while($row = mysqli_fetch_array($response,MYSQL_ASSOC))
								{	
									print "<option>".$row['pname']."</option>";
								}
					        ?>
				      	</select>
				    </div>
				     <div class="form-group col-md-4">
				    	<label>Antibody</label>
				    	<select id="aid" name="aid" class="form-control">
					        <option selected>Antibody</option>
					        <?php
					        	$request = sprintf("select aid from Antibodies");
								$response = mysqli_query($dbconnection, $request);

								while($row = mysqli_fetch_array($response,MYSQL_ASSOC))
									{	
									?><option value="<?php print $row['aid'] ?>"><?php print $row['aid'] ?></option><?php ; ?>
						  	  <?php } ?>
				      	</select>
				    </div>
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
		</div> <!-- end upload results -->
		<br>
		<!-- Edit section -->
		<div class="form-box">
			<h2>Edit your results</h2>
			<form method="post" action="manage_data.php" enctype="multipart/form-data">
				<div class="form-group col-md-4">
			    	<label>Name</label>
			    	<select id="edit-student-name" name="edit-student-name" class="form-control">
				        <option selected>Name</option>
				        <?php
				        	$request = sprintf("select sname from Students");
							$response = mysqli_query($dbconnection, $request);

							while($row = mysqli_fetch_array($response,MYSQL_ASSOC))
							{	
								?><option value="<?php print $row['sname'] ?>"><?php print $row['sname']; ?></option>
					  <?php } ?>
			      	</select>
			      	<br>
			      	<button type="submit" class="btn btn-primary">Load Results</button>
				</div>	
			</form>
		</div>
		<?php if(isset($_POST['edit-student-name'])){ ?>
		<div class="box-project">
		<div class="box-project-techniques">
			<h5>Results</h5>
			<ul>
				<li>
					<div class="technique">
						<h5><span class="fas fa-caret-right"></span> Immuno</h5>
					</div>
					<ul class="results" style="display: none">
					<?php
					$requestResults = sprintf("select path from Results natural join Students where technique='Immuno' and sname='%s'",$_POST['edit-student-name']);
					$results = mysqli_query($dbconnection, $requestResults);
					while($result = mysqli_fetch_array($results,MYSQL_ASSOC)){ ?>
						<li><img src="images/<?php print $result['path']?>"></li>
					<?php } ?>
					</ul>
				</li>
				<li>
					<div class="technique">
						<h5><span class="fas fa-caret-right"></span> Backfill</h5>
					</div>
					<ul class="results" style="display: none">
					<?php
					$requestResults = sprintf("select path from Results natural join Students where technique='Backfill' and sname='%s'", $_POST['edit-student-name']);
					$results = mysqli_query($dbconnection, $requestResults);
					while($result = mysqli_fetch_array($results,MYSQL_ASSOC)){ ?>
						<li><img src="images/<?php print $result['path']?>"></li>
					<?php } ?>
					</ul>
				</li>
			</ul>
		</div> <!-- end edit results -->
		</div>
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
