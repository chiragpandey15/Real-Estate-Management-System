<?php
	session_start();
	
	include("header.php");
	
?>
	
	<div id="container2">
		<div id="content-container">
			<h1>Ecstasy Real Estate Solutions</h1>
		</div>
		<form>
		<button type="button"  class="btn btn-outline-success"><a href="ownerEntry.php">Sell Now!</a></button>
		</form>
		<br>
		<form>
		<input type="hidden"  name="signup" value="2">
		<button type="button" class="btn btn-outline-primary" name="buy"><a href="customerEntry.php">Buy Now!</a></button>
		</form>
	</div>






<?php

include("footer.php");


?>
