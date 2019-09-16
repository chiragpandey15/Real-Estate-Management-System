<?php
	session_start();
	
	include("header.php");
	include("connection.php");
	
	$query = "SELECT * FROM `broker` WHERE `id` = '".mysqli_real_escape_string($link, $_SESSION['id'])."'";
	$result=mysqli_query($link,$query);
	$row=mysqli_fetch_array($result);	
	$name=$row['NAME'];
	$email=$row['EMAIL'];	
	$Earned=$row['EARNED'];
	
	
	
	if(array_key_exists("logout", $_POST))
	{
		session_destroy();
		
	}
		
	
?>

	<div class="container3 vertical-align">
		<p><span>Name:</span><br> <?php echo $name?></p>
		
		<p><span>Email:</span><br> <?php echo $email?></p>
		
		<p><span>Earned:</span><br> <?php echo $Earned?></p>
	
	
	<fieldset class="form-group">
			<a href="index.php"><input type="submit" class="btn btn-lg btn-danger" name="logout" value="Logout" ></a>
		</fieldset>
	</div>


<?php

include("footer.php");


?>