 <?php
	session_start();
	
	include("header.php");
	include("connection.php");
	
	
	$query = "SELECT * FROM `customer` WHERE `id` = '".mysqli_real_escape_string($link, $_SESSION['id'])."'";
	$result=mysqli_query($link,$query);
	$row=mysqli_fetch_array($result);	
	$name=$row['name'];
	$email=$row['email'];	
	$number=$row['phone_number'];
	echo '<div class="Right">Welcome '; echo $name; echo "<br></div>";

	
	
	
	
	
	
	
	if(array_key_exists("info", $_GET))
	{
		$query = "SELECT `belongs_to` FROM `rooms` WHERE `R_ID`=".$_GET['ID'];
		$result=mysqli_query($link,$query);
		while($row=mysqli_fetch_array($result))
		{
			$query = "SELECT * FROM `owner` WHERE `ID`=".$row['belongs_to'];
			$r=mysqli_query($link,$query);
			while($info=mysqli_fetch_array($r))
			{
				echo 'Name: '.$info['name'];
				echo '<br> Number: '.$info['phone_number'];
				echo '</br>';
			}
		}
	}
	
	
	
	if(array_key_exists("submit", $_POST))
	{
		if(!$_POST['search'] )
		{
			echo "Location is missing";
		}
		else
		{
			$query = "SELECT `R_ID`,`address`,`price`,`ROOM_DESCRIPTION` FROM `rooms` WHERE `address` LIKE '%".mysqli_real_escape_string($link, $_POST['search'])."%' ";
			$result=mysqli_query($link,$query);
			
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
				  echo '<td><form><input type="hidden" name="ID" value="'.$id.'"><button class="btn btn-danger" name="info" type="submit" >Owner\'s Info</button></td></form></td>';
				echo '</tr>';
			}
			echo '</tbody>
			</table>';
		}
	}
	

	
	
	
	
	
	if(array_key_exists("book", $_POST))
	{
		if(!$_POST['room_id'] )
		{
			echo '<p style="color: red; font-weight: bolder;" align="center">Room ID is missing</p>';
		}
		else
		{
			if($_POST['broker_id'] )
			{
				$commission=0;
				$query="INSERT into `booked`(`R_ID`,`C_ID`,`B_ID`) values ('".mysqli_real_escape_string($link, $_POST['room_id'])."',{$_SESSION['id']},'".mysqli_real_escape_string($link, $_POST['broker_id'])."')";	
				$result=mysqli_query($link,$query);
				if(!$result)
					echo '<p style="color: red; font-weight:bolder;" align="center">This room is already booked...</p>';
				else
				{
					$query = "SELECT `price`,`BELONGS_TO` FROM `rooms` WHERE `id` = ".mysqli_real_escape_string($link, $_POST['room_id'])."";
					$result=mysqli_query($link,$query);
					$row=mysqli_fetch_array($result);
					$Price=$row['price'];
					$owner_id=$row['BELONGS_TO'];
					$query ="SELECT `EARNED` FROM `broker` WHERE `id`=".mysqli_real_escape_string($link, $_POST['broker_id'])."";
					$result=mysqli_query($link,$query);
					$row=mysqli_fetch_array($result);
					$commission=$Price *0.02 + $row['EARNED'];
					
					
					$query = "UPDATE `broker` SET `EARNED`={$commission} WHERE `id`=".mysqli_real_escape_string($link, $_POST['broker_id'])."";
					$result=mysqli_query($link,$query);
					
					
					
					$balance=$Price-$commission;
					
					$query = "UPDATE `owner` SET `BALANCE`={$balance} WHERE `id`={$owner_id}";
					$result=mysqli_query($link,$query);
					
				
					
				}
				
				
			}
			else
			{
				$query="INSERT into `booked`(`R_ID`,`C_ID`) values ('".mysqli_real_escape_string($link, $_POST['room_id'])."',{$_SESSION['id']})";	
				$result=mysqli_query($link,$query);
				if(!$result)
					echo '<p style="color: red; font-weight: bolder;" align="center">This room is already booked...</p>';
				//else
					//$query = "UPDATE `owner` SET `BALANCE`={$balance} WHERE `id`={$owner_id}";
			}
		}
	}
	
	
	
	
	
	
?>
	
 
	<div class ="container3">
	<form class="" method="post" id="search">
		<fieldset class="form-group">
			<input type="text" class="form-control-lg" name="search" placeholder="Enter location">
		</fieldset>
		<fieldset class="form-group">
			<input type="submit" class="btn btn-lg btn-success" name="submit" value="Search">
		</fieldset>
	</form>





	<fieldset class="form-group">
			<a href="index.php"><input type="submit" class="btn btn-lg btn-danger" name="logout" value="Logout" ></a>
		</fieldset>

	</div>



<?php

include("footer.php");


?>
