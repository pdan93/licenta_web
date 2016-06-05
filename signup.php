<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/26/2016
 * Time: 1:45 PM
 * @formatter:off
 */
include ('includes/initialize.php');
$posted = 0;
if (isset($_POST['first_name']))
	{
	$ok=1;
	$posted = 1;
	$message = '';
	if ($_POST['first_name']=='' || $_POST['last_name']=='' || $_POST['email']=='' || $_POST['password']=='') {
		$ok = 0;
		$message = 'all fields must be completed';
	}
	if ($_POST['password']!=$_POST['password_conf']) {
		$ok = 0;
		$message = 'Passwords do not equal';
	}

	$results = mysqli_query($conn,"SELECT * FROM users WHERE email='".$_POST['email']."';");
	if (mysqli_num_rows($results)) {
		$ok = 0;
		$message = 'Email already registered';
	}

	if ($ok==1)
		{
		mysqli_query($conn,"INSERT INTO users (id,first_name,last_name,email,password,address) VALUES
			(NULL,'".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['email']."','".md5($_POST['password'])."','".$_POST['address']."')");
		$message = 'Registered succesfully';
		}

	}
	else
	if (isset($_POST['email'])) //LOGIN PART
	{
	$ok=1;
	$posted = 2;
	$message = '';
	if (be_secure('BE_SECURE_LOGIN')==1)
		{
		$results = mysqli_query($conn,"SELECT * FROM users WHERE email='".mysqli_escape_string($conn,$_POST['email'])."';");
		}
		else
		$results = mysqli_query($conn,"SELECT * FROM users WHERE email='".$_POST['email']."';");

	if (!$results)
		{
		header('HTTP/1.1 500 Internal Server Error');
		die();
		}
	if (mysqli_num_rows($results)) {
		$row = mysqli_fetch_array($results);
		if ($row['password'] == md5($_POST['password']))
			{
			$ok=1;
			$_SESSION['login']=1;
			$_SESSION['userID']=$row['id'];
			header('Location: my_account.php');
			die();
			}
			else
			{
			$ok=0;
			$message = 'Password incorrect';
			}
		}
		else
		{
		$ok=0;
		$message = 'Email not registered';
		}
	}
include ('includes/template/header.php');

?>

	<div class="cart-page-content page-section-padding">
		<div class="container">
			<div class="row">
				<div class="col-xs-6">
					<h2>Register</h2>
					<form action="" method="post" class="signup_form">
						<label>First Name</label>
						<input type="text" name="first_name">
						<label>Last Name</label>
						<input type="text" name="last_name">
						<label>Email</label>
						<input type="email" name="email">
						<label>Password</label>
						<input type="password" name="password">
						<label>Password Conf</label>
						<input type="password" name="password_conf">
						<label>Address</label>
						<input type="text" name="address">
						<input type="submit" value="Submit" />
						<?php
						if ($posted==1)
							echo '<p class="message">'.$message.'</p>';
						?>
					</form>
				</div>
				<div class="col-xs-6">
					<h2>Login</h2>
					<form action="" method="post" class="signup_form">
						<label>Email</label>
						<input type="text" name="email">
						<label>Password</label>
						<input type="password" name="password">
						<input type="submit" value="Submit" />
						<?php
						if ($posted==2)
							echo '<p class="message">'.$message.'</p>';
						?>
					</form>
				</div>
			</div>
		</div>
	</div>


<?php
include ('includes/template/footer.php');
?>