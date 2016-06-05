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
$ok=0;

if (LOGGED_IN==1)
	{
	$results = mysqli_query($conn,"SELECT * FROM cart WHERE id_user=".$_SESSION['userID']." AND open=1;");
	if (mysqli_num_rows($results)) {
		$ok=1;
		$cart = mysqli_fetch_array($results);
	}
	}
if ($ok==0)
	{
	header('Location: index.php');
	die();
	}
$products = array();
$results = mysqli_query($conn,"SELECT * FROM cart_products WHERE id_cart=".$cart['id'].";");
while ($row = mysqli_fetch_array($results))
	{
	$res = mysqli_query($conn,"SELECT * FROM products WHERE id=".$row['id_product']);
	if (!isset($products[$row['id_product']]))
		$products[$row['id_product']] = array('qty'=>1,'product'=>mysqli_fetch_array($res));
		else
		{
		$products[$row['id_product']]['product'] = 	mysqli_fetch_array($res);
		$products[$row['id_product']]['qty']++;
		}
	}
?>

	<div class="cart-page-content page-section-padding">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="cart_title">
						<h4>Shopping Cart</h4>
					</div>
					<div class="table-responsive">
						<table class="cart-table text-center">
							<thead>
								<tr id="cart_th">
									<th>#</th>
									<th>Image</th>
									<th>Product name</th>
									<th>QUANTITY</th>
									<th>Price</th>
									<th>Remove</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$total_qty = 0;
							foreach ($products as $p) {
								echo '
								<tr>
									<td>1</td>
									<td>
										<a href="#"><img alt="" class="img-responsive" src="'.$p['product']['image'].'"></a>
									</td>
									<td>
										<h6><a href="product.php?id='.$p['product']['id'].'">'.$p['product']['name'].'</a></h6>
									</td>
									<td>
										'.$p['qty'].'
									</td>
									<td>
										<div class="cart-price">$'.$p['product']['price'].'</div>
									</td>
									<td><a href="remove_from_cart.php?id_cart='.$cart['id'].'&id_product='.$p['product']['id'].'" ><i class="fa fa-trash"></i></a></td>
								</tr>';
								$total_qty += $p['qty'];
							}

							?>

								<tr id="total_colspan">
									<td colspan="3" class="text-left">total</td>
									<td>
										<?=$total_qty;?>
									</td>
									<td>
										$<?=$cart['total']?>
									</td>
									<td colspan="2">
										<a class="checkPageBtn" href="checkout.php">Checkout</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php
include ('includes/template/footer.php');
?>