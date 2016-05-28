<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/26/2016
 * Time: 1:45 PM
 * @formatter:off
 */
include ('includes/initialize.php');
$ok=0;
if (isset($_SESSION['login']))
	if ($_SESSION['login']==1)
		$ok=1;
if ($ok==1)
	{
	$results = mysqli_query($conn,"SELECT * FROM users WHERE id='".$_SESSION['userID']."';");
	if (mysqli_num_rows($results)) {
		$user = mysqli_fetch_array($results);
		$ok=1;
		}
		else
		$ok=0;
	}
if ($ok==0)
	{
	header('Location: signup.php');
	die();
	}


include ('includes/template/header.php');
?>

	<div class="cart-page-content page-section-padding">
		<div class="container">
			<div class="row">
				<div class="col-xs-6">
					<h2>Account info</h2>
					<p>First Name: <?=$user['first_name']?></p>
					<p>Last Name: <?=$user['last_name']?></p>
					<p>Email: <?=$user['email']?></p>
					<p>Address: <?=$user['address']?></p>
					<p>Card Name: <?=$user['card_name']?></p>
					<p>Card Type: <?=$user['card_type']?></p>
					<p>Card Number: <?=$user['card_number']?></p>
					<p>Card Exp m: <?=$user['card_exp_m']?></p>
					<p>Card Exp y: <?=$user['card_exp_y']?></p>
					<p>Card CCC: <?=$user['card_ccc']?></p>
				</div>
				<div class="col-xs-6">
					<h2>Orders</h2>
					<?php
					$results = mysqli_query($conn,"SELECT * FROM orders WHERE id_user='".$_SESSION['userID']."';");
					while ($row = mysqli_fetch_array($results))
						{
						echo '<p>'.$row['created'].' - $'.$row['total'].'</p>';
						}
					?>
				</div>
			</div>
		</div>
	</div>


<?php
include ('includes/template/footer.php');
?>