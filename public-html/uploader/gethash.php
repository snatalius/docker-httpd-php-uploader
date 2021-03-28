<!DOCTYPE html>
<html>

<head>
	<title>Get Hash</title>
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

// Activate the process only if the $_POST["oldPass"] is set.
if(isset($_POST["string"])){
    notify("Hash: ".hash('sha3-512' , $_POST["string"]),1);
}

?>

<div class="container">
	<form id="contact" action="gethash.php" method="post" enctype="multipart/form-data">
		<h3>Get Hash</h3>
		<fieldset>
			<input placeholder="Type String" type="text" name="string" id="string">
		</fieldset>
		<fieldset>
			<button type="submit" name="submit">Get Hash</button>
		</fieldset>
</div>

</body>

</html>