<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/26/2016
 * Time: 1:45 PM
 * @formatter:off
 */
include ('includes/initialize.php');
if (LOGGED_IN==1)
	{
	$results = mysqli_query($conn,"SELECT * FROM cart WHERE id_user=".$_SESSION['userID']." AND open=1;");
	if (mysqli_num_rows($results)==0) {

		mysqli_query($conn,"INSERT INTO cart (id, id_user, total, open, created) VALUES (NULL, ".$_SESSION['userID'].", 0, 1, NOW())");
		$results = mysqli_query($conn,"SELECT * FROM cart WHERE id_user='".$_SESSION['userID']."';");
		}
	$cart = mysqli_fetch_array($results);
	$results = mysqli_query($conn,"SELECT * FROM products WHERE id='".$_POST['id_product']."';");
	if (mysqli_num_rows($results)) {
		$product = mysqli_fetch_array($results);
		mysqli_query($conn,"INSERT INTO cart_products VALUES (NULL,".$cart['id'].",".$_POST['id_product'].")");
		mysqli_query($conn,"UPDATE cart SET total=total+".$product['price']." WHERE id=".$cart['id']." ;");
		}
		else
		die('product incorrect');
	}
	else
	echo 0;