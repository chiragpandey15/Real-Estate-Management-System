<?php
	
	
	session_start();
	
	if(array_key_exists("submit", $_POST))
	{
		include("connection.php");
		if(!$_POST['email'] OR !$_POST['password'])
		{
			echo '<p style="color: red; font-weight: bolder;" align="center">Something is missing</p>';
		}
		else
		{
			if($_POST['signup']=='1')
			{
				$query = "SELECT * FROM `broker` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
				
				$result=mysqli_query($link,$query);
				if(mysqli_num_rows($result)){
					echo '<p style="color: red; font-weight: bolder;" align="center">Email address is already taken</p>';
				}
				else
				{
					
					$query="INSERT into `broker`(`name`,`email`,`password`,`phone_number`) values ('".mysqli_real_escape_string($link, $_POST['name'])."','".mysqli_real_escape_string($link, $_POST['email'])."','".mysqli_real_escape_string($link, $_POST['password'])."','".mysqli_real_escape_string($link, $_POST['num'])."')";						
					if(!mysqli_query($link,$query))
					{
						echo '<p style="color: red; font-weight: bolder;" align="center">Could not Sign Up...please try again</p>';
					}
					else
					{
						$_SESSION['id'] =mysqli_insert_id($link);
						
						header ("Location: broker.php");
					}
					
				}
			}
			else
			{
				$query = "SELECT * FROM `broker` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['email'])."' AND PASSWORD='".mysqli_real_escape_string($link, $_POST['password'])."'";
				$result=mysqli_query($link,$query);
				if(mysqli_num_rows($result)==1) 
				{
					$row=mysqli_fetch_array($result);
					$_SESSION['id']=$row['ID'];
					
					header ("Location: broker.php");
				}
				else
					echo '<p style="color: red; font-weight: bolder;" align="center">Email Id or Password is incorrect</p>';
				
			}
			
		}
	}


?>

<?php include("header.php"); ?>
	<div class="container">
		
		<h1> Broker </h1>
		
	
		<form method="post" id="SignUpForm">
		<fieldset class="form-group">
			<input type="text" class="form-control"name="name" placeholder="Your Name">
		</fieldset>
		<fieldset class="form-group">
			<input type="email" class="form-control" name="email" placeholder="Your Email">
		</fieldset>
		<fieldset class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Password">
		</fieldset>
		<fieldset class="form-group">
			<input type="tel" class="form-control" name="num" placeholder="Contact Number">
		</fieldset>
		<fieldset class="form-group">
			<input type="hidden"  name="signup" value="1">
			<input type="submit" class="btn btn-success" name="submit" value="Sign Up!">
		</fieldset>
		<p><a class="ToggleForm">Log in</a></p>
		</form>
		
		
		<form method="post" id="LogInForm">
		<fieldset class="form-group">
			<input type="email" class="form-control" name="email" placeholder="Your Email">
		</fieldset>
		<fieldset class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Password">
		</fieldset>
		<fieldset class="form-group">
			<input type="hidden" name="signup" value="0">
			<input type="submit" class="btn btn-success" name="submit" value="Log In!">
		</fieldset>
		<p><a class="ToggleForm">Sign Up</a></p>
		</form>
	
	</div>
    
<?php include("footer.php"); ?>












    
























