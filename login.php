<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = login($_POST);

	if(count($errors) == 0)
	{
		header("Location: dashboard.php");
		die;
	}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-COMPATIBLE" 
	content="IE=edge">
	<meta name="viewport"
	content="width=device-width, initial-scale=1.0" >
	<title>MANAGEMENT</title>
	<link rel="stylesheet" href="forms.css">
	<script src="https://kit.fontawesome.com/cb9201ce8c.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="contentreg">
</div>
<form action="" method="post" class="reg-form" >
	<h2>Registration</h2>
	<div class="details personal">
		<h3 class="title">Personal details</h3>
		<div style="color: red;">
			<?php if(count($errors) > 0):?>
			<?php foreach ($errors as $error):?>
				<?= $error?> <br>	
			<?php endforeach;?>
		<?php endif;?>
	</div >


				<div class="input-field">
				<span class="icon"><i class="fa-solid fa-envelope fa-bounce"></i></span>
					<label for = "email"> Email:</label>
				<input type="email" name="email" id="email" autocomplete="on"required>
			</div>
			
				<div class="input-field">
				<span class="icon"><i class="fa-solid fa-lock fa-bounce"></i></span>
					<label for = "password"> Password:</label>
				<input type="password" name="password" id="password" autocomplete="on" required>
			</div>

	
			<button class="submit" name="login">
				Login
			</button>

	</form>

			
		</div>

</body>
</html>
