<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/26/2016
 * Time: 1:45 PM
 * @formatter:off
 */
include ('includes/initialize.php');
if (LOGGED_IN)
	{
	$results = mysqli_query($conn,"SELECT * FROM cart WHERE id_user=".$_SESSION['userID']." AND open=1 AND id=".$_GET['id_cart'].";");
	if ($results)
		{
		$cart = mysqli_fetch_array($results);
		$total = floatval($cart['total']);
		$results = mysqli_query($conn,"SELECT * FROM cart_products WHERE id_cart=".$_GET['id_cart']." AND id_product=".$_GET['id_product'].";");

		while ($row = mysqli_fetch_array($results))
			{
			$res = mysqli_query($conn,"SELECT * FROM products WHERE id=".$row['id_product']);
			$p = mysqli_fetch_array($res);
			$total -= floatval($p['price']);
			}
		echo $total;
		mysqli_query($conn, "UPDATE cart SET total=".$total." WHERE id=".$_GET['id_cart']);
		mysqli_query($conn, "DELETE FROM cart_products WHERE id_cart=".$_GET['id_cart']." AND id_product=".$_GET['id_product']);
		}
	}
header("Location: cart.php");