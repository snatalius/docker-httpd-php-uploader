<!DOCTYPE html>
<html>

<head>
	<title>Uploader</title>
	<link rel="stylesheet" href="css/style.css" />
</head>

<body>

<?php

function notify($msg,$msgcode){
	switch($msgcode){
		case 0: // success
			echo "<mark style='background-color:green;color:white'>".$msg."</mark>";
			break;
		case 1: // error
			echo "<mark style='background-color:red;color:white'>".$msg."</mark>";
			break;
	}
}

// Activate the process only if the $_POST["passForUpload"] is set.
if(isset($_POST["passForUpload"])){
	
	/*
	Before you start, set your php.ini:
	1. make sure file_uploads=On
	2. adjust post_max_size to your needs (default: 8M)
	3. adjust upload_max_filesize to your needs (default: 2M)
	*/

	$target_dir = "files/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	// get secret key for upload
	$codefile = fopen("uc.sha", "r") or die("Error while opening uc.sha!");
	$uploadpass = fread($codefile,filesize("uc.sha"));
	fclose($codefile);

	// Check if image file is a actual image or fake image
	// if(isset($_POST["submit"])) {
	//   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	//   if($check !== false) {
	//     echo "File is an image - " . $check["mime"] . ".";
	//     $uploadOk = 1;
	//   } else {
	//     echo "File is not an image.";
	//     $uploadOk = 0;
	//   }
	// }

	// Check if file already exists
	if (file_exists($target_file)) {
	  notify("Sorry, file already exists.",1);
	  $uploadOk = 0;
	}

	// Check file size
	// if ($_FILES["fileToUpload"]["size"] > 500000) {
	//   echo "Sorry, your file is too large.";
	//   $uploadOk = 0;
	// }

	// Allow certain file formats
	// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	// && $imageFileType != "gif" ) {
	//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	//   $uploadOk = 0;
	// }

	// Check if $uploadOk is set to 0 by an error,
	// if everything is ok, try to upload file
	if ($uploadOk == 0 || hash('sha3-512', $_POST["passForUpload"]) != $uploadpass) {
	  notify("Sorry, your file was not uploaded.",1);
	} else {
	  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		notify("The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.",0);
	  } else {
		notify("Sorry, there was an error uploading your file.",1);
	  }
	}
}

?>

<div class="container">
	<form id="contact" action="index.php" method="post" enctype="multipart/form-data">
		<h3>Upload File</h3>
		<fieldset>
			<label for="fileToUpload">Select file to upload:</label>
			<input type="file" name="fileToUpload" id="fileToUpload">
		</fieldset>
		<fieldset>
			<input placeholder="Type key to proceed" type="password" name="passForUpload" id="passForUpload">
		</fieldset>
		<fieldset>
			<button type="submit" name="submit">Upload</button>
		</fieldset>
	</form>
</div>
</body>

</html>
