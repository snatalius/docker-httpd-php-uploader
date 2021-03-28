<!DOCTYPE html>
<html>

<head>
	<title>Change Key</title>
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
if(isset($_POST["oldPass"])){
	
	// Read hash of old key
	$codefile = fopen("uc.sha", "r") or die("Error while opening uc.sha!");
	$oldPass = fread($codefile,filesize("uc.sha"));
	fclose($codefile);
	
	// Compare the hash of old key input with the stored hash
	if (strcmp(hash('sha3-512' , $_POST["oldPass"]),$oldPass)!== 0){
		
		// Wrong old key, output error notification
		notify("Incorrect old key. Please try again!",1);
		
	}
	else{
		
		// Correct old key, confirm the new key
		if (($_POST["newPass"] === "") or (strcmp($_POST["newPass"],$_POST["newPassR"]) !== 0)){
			// New key and its repeat do not match, output error notification
			notify("Error with the new key input. Please try again!",1);
		}
		else{
			// New key and its repeat match, proceed with changing the key
			$codefile = fopen("uc.sha", "w") or die("Error while opening uc.sha!");
			fwrite($codefile,hash('sha3-512' , $_POST["newPass"]));
			fclose($codefile);
			notify("Key changed successfully!",0);
		}
		
	}
	
}

?>

<div class="container">
	<form id="contact" action="changekey.php" method="post" enctype="multipart/form-data">
		<h3>Change Key</h3>
		<fieldset>
			<input placeholder="Type old key" type="password" name="oldPass" id="oldPass">
		</fieldset>
		<fieldset>
			<input placeholder="Type new key" type="password" name="newPass" id="newPass">
		</fieldset>
		<fieldset>
			<input placeholder="Repeat new key" type="password" name="newPassR" id="newPassR">
		</fieldset>
		<fieldset>
			<button type="submit" name="submit">Change</button>
		</fieldset>
	</form>
</div>

</body>

</html>