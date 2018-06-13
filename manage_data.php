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

	if(isset($_POST['rename-submit'])){
		$oldname = $_POST['oldname'];
		$newname = $_POST['rename'].".".$_POST['ext'];
		$newpath = "images/".$newname;
		$oldpath ="images/".$oldname;
		echo $oldpath." to ".$newpath;
		rename($oldpath,$newpath);

		$update= sprintf("set FOREIGN_KEY_CHECKS=0"); 
		mysqli_query($dbconnection,$update);
		$update = sprintf("update Results set path='%s' where path='%s'",$newname,$oldname);
		mysqli_query($dbconnection,$update);
		$update = sprintf("update ResultsPhotos set path='%s' where path='%s'",$newname,$oldname);
		mysqli_query($dbconnection,$update);
		$update= sprintf("set FOREIGN_KEY_CHECKS=1"); 
		mysqli_query($dbconnection,$update);

	}

	if(isset($_POST['delete'])){
		unlink("images/".$_POST['delete']);
		$delete = sprintf("set FOREIGN_KEY_CHECKS=0"); 
		mysqli_query($dbconnection,$delete);
		$delete = sprintf("delete from Results where path='%s'",$_POST['delete']);
		mysqli_query($dbconnection,$delete); 
		$delete = sprintf("delete from ResultsPhotos where path='%s'",$_POST['delete']);
		mysqli_query($dbconnection,$delete); 
		$delete= sprintf("set FOREIGN_KEY_CHECKS=1"); 
		mysqli_query($dbconnection,$delete);
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
		  	<!-- <li class="nav-item">
		 		<a class="nav-link" href="#">Profile</a>
			</li> -->
			<li class="nav-item">
		    	<a class="nav-link" href="#">Manage Data</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="manage_projects.php">Manage Projects</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="manage_students.php">Manage Students</a>
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
					        <?php
							$requestTechniques = sprintf("select technique from Techniques");
							$techniques = mysqli_query($dbconnection, $requestTechniques);
							
							while($technique = mysqli_fetch_array($techniques,MYSQL_ASSOC)){ ?>
					        <option><?php print $technique['technique'] ?></option>
					    <?php } ?>
				      	</select>
				    </div>
				</div>
				<div class="form-row">
				    <div class="form-group col-md-4">
				    	<label>Date</label>
				    	<input type="date" name="date" class="form-control">
				    </div>
				</div>
				<br>
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
				<?php
				$requestTechniques = sprintf("select technique from Techniques");
				$techniques = mysqli_query($dbconnection, $requestTechniques);
				while($technique = mysqli_fetch_array($techniques,MYSQL_ASSOC)){ ?>
				<li>
					<div class="technique">
						<h5><span class="fas fa-caret-right"></span> <?php print $technique['technique'] ?></h5>
					</div>
					<ul class="results" style="display: none">
					<?php
					$requestResults = sprintf("select path from Results natural join Students where technique='%s' and sname='%s'",$technique['technique'],$_POST['edit-student-name']);
					$results = mysqli_query($dbconnection, $requestResults);
					while($result = mysqli_fetch_array($results,MYSQL_ASSOC)){ ?>
						<li>
							<figure>
								<img src="images/<?php print $result['path']?>">
								<figcaption>
									<button type="button" name="rename-button" class="btn btn-primary" data-toggle="modal" data-target="#rename-modal">Rename</button>
									<!-- Modal -->
									<div class="modal fade" id="rename-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="exampleModalLongTitle">Rename result: <?php print $result['path']?></h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="modal-body">
									      <!-- rename form -->
									     	<form method="post" action="manage_data.php" enctype="multipart/form-data">
									     		<div class="input-group mb-3">
												  <input type="text" class="form-control" id="rename" name="rename" placeholder="Describe your result..." aria-label="Describe your result" aria-describedby="extension">
												  <div class="input-group-append">
												    <span class="input-group-text" id="extension">.<?php 
												    $ext = pathinfo($result['path'], PATHINFO_EXTENSION);
												    echo $ext ;?></span>
												  </div>
												  <input type="hidden" name="ext" value="<?php echo $ext ?>"/>
												  <input type="hidden" name="oldname" value="<?php echo $result['path'] ?>"/>
												</div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									        <button type="submit" name="rename-submit" class="btn btn-primary">Save changes</button>
									        <!-- </form> -->
									        <!-- end rename form -->
									      </div>
									    </div>
									  </div>
									 </div>
									</div>
									<!-- end modal -->
									<!-- <form method="post" action="manage_data.php" enctype="multipart/form-data"> -->
									<button type="submit" name="delete" value="<?php echo $result['path'] ?>" class="btn btn-primary">Delete</button>
									</form>
								</figcaption>
							</figure>
						</li>
					<?php } ?>
					</ul>
				</li>
				<?php } ?>
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
