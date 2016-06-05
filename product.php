<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/26/2016
 * Time: 1:45 PM
 * @formatter:off
 */
	include ('includes/initialize.php');
	include ('includes/template/header.php');
$results = mysqli_query($conn,"SELECT * FROM products WHERE id=".$_GET['id'].";");
$row = mysqli_fetch_array($results);

?>

	<div class="cart-page-content page-section-padding">
		<div class="container">
			<div class="row">
				<div class="col-xs-5">
					<img src="<?=$row['image']?>" />
				</div>
				<div class="col-xs-7">
					<h1><?=$row['name']?></h1>
					<h2><?=$row['subtitle']?></h2>
					<p><?=$row['description']?></p>
					<p>Color: <?=$row['color']?></p>
					<p>Fit: <?=$row['fit']?></p>
					<p>Qty: <?=$row['qty']?></p>
					<p>Price: $<?=$row['price']?></p>
					<a class="slide_btn" onclick="<?php
					if (LOGGED_IN==1)
						echo 'add_to_cart('.$row['id'].')';
						else
						echo 'first_login()';

					?>" style="background: #3a4b60; cursor: pointer; font-size:16px; color:#fff;border: 2px solid #ffffff;line-height:2;padding: 10px 30px;">Add To Cart</a>
					<p class="message"></p>
				</div>
			</div>
		</div>
	</div>


<?php
include ('includes/template/footer.php');
?>