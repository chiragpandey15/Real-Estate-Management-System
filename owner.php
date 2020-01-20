<?php
	session_start();
	
	include("header.php");
	include("connection.php");
	//$query = "SELECT * FROM `owner` WHERE `id` =".mysqli_real_escape_string($link, $_SESSION['id'])."";
	$error="";
	$query = "SELECT * FROM `owner` WHERE `id` = '".mysqli_real_escape_string($link, $_SESSION['id'])."'";
	$result=mysqli_query($link,$query);
	$row=mysqli_fetch_array($result);	
	$name=$row['name'];
	$email=$row['email'];
	if(array_key_exists("delete", $_GET))
	{
		$query = "DELETE FROM rooms WHERE R_ID=".$_GET['ID'];
		$result=mysqli_query($link,$query);
	}

	$query = "SELECT * FROM `rooms` WHERE `belongs_to` = '".mysqli_real_escape_string($link, $_SESSION['id'])."'";
	$result=mysqli_query($link,$query);

	echo '<div class="Right"> Welcome '; echo $name; echo "<br></div>";
	
	echo '<table class="table table-dark">
						<thead>
						<tr>
				  <th scope="col">Id</th>
				  <th scope="col">Address</th>
				  <th scope="col">Price</th>
				  <th scope="col">Description</th>
				</tr>
			  </thead>
			  <tbody>';
					
			
			
			while($row=mysqli_fetch_array($result))
			{
				$id=$row['R_ID'];
				$address=$row['address'];
				$price=$row['price'];
				$description=$row['ROOM_DESCRIPTION'];
				echo '
				<tr>
				  <th scope="row">'.$id;
				  echo '</th>
				  <td>'.$address;
				  echo '</td>
				  <td>'.$price;
				  echo '</td>
				  <td>'.$description;
				  echo '</td>';
				  echo '<td><form><input type="hidden" name="ID" value="'.$id.'"><button class="btn btn-danger" name="delete" type="submit" >Delete</button></td></form></td>';
				echo '</tr>';
			
			}
			echo '</tbody>
			</table>';
	
	
		
	
	
	
	
	if(array_key_exists("Add", $_POST))
	{
		if(!$_POST['price'] OR !$_POST['address'] OR !$_POST['description'])
		{
			//$error="Something is missing";
			echo '<p style="color: red; font-weight: bolder;" align="center">Something is missing</p>';
		}
		else
		{
			$query="INSERT into `rooms`(`address`,`price`,`belongs_to`,`room_description`) values('".mysqli_real_escape_string($link, $_POST['address'])."','".mysqli_real_escape_string($link, $_POST['price'])."',{$_SESSION['id']},'".mysqli_real_escape_string($link, $_POST['description'])."')";
			$result=mysqli_query($link,$query);			
			if(!$result)
			{
					//$error="Could not enter please try again...";
						echo '<p style="color: red; font-weight: bolder;" align="center">Could not Enter pls try again</p>';
			}
			
			unset($_POST);
			header("Location: owner.php");
		}
	}
	
	
	
	
	
	
	
?>

	<div class="container3">
	
	<form class="form-inline" method="post" id="AddForm">
		<fieldset class="form-group">
			<input type="text" class="form-control form-control-lg"name="address" placeholder="Address">
		</fieldset>
		<fieldset class="form-group">
			<input type="number_format" class="form-control form-control-lg" name="price" placeholder="Price">
		</fieldset>
		
		<fieldset class="form-group">
			<input type="number_format" class="form-control form-control-lg" name="description" placeholder="Description">
		</fieldset>
		
		<fieldset class="form-group">
			<input type="submit" class="btn btn-lg btn-success" name="Add" value="Add">
		</fieldset>
		
		</form>
		
		<fieldset class="form-group">
			<a href="index.php"><input type="submit" align="center" class="btn btn-lg btn-danger" name="logout" value="Logout" ></a>
		</fieldset>
		
	</div>
	

<?php

include("footer.php");


?>
