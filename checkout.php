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
	header('Location: my_account.php');
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

$results = mysqli_query($conn,"SELECT * FROM users WHERE id='".$_SESSION['userID']."';");
$user = mysqli_fetch_array($results);
$message_post = '';
if (isset($_POST['card_name']))
	{
	mysqli_query($conn,"INSERT INTO orders VALUES (NULL,".$_SESSION['userID'].",".$cart['id'].",".$cart['total'].",1,'".$_POST['card_name']."','".$_POST['card_type']."','".$_POST['card_number']."','".$_POST['card_exp_m']."','".$_POST['card_exp_y']."','".$_POST['card_ccc']."',NOW(),'".$user['first_name']."','".$user['last_name']."','".$user['address']."')");
	mysqli_query($conn,"UPDATE cart SET open=0 WHERE id=".$cart['id']);
	mysqli_query($conn,"UPDATE users SET card_name='".$_POST['card_name']."', card_type='".$_POST['card_type']."', card_number='".$_POST['card_number']."', card_exp_m='".$_POST['card_exp_m']."', card_exp_y='".$_POST['card_exp_y']."', card_ccc='".$_POST['card_ccc']."' WHERE id=".$_SESSION['userID']);
	$message_post = 'Thank you for your order';
	}


?>

	<div class="cart-page-content page-section-padding">
		<div class="container">
			<div class="row">
				<div class="checkout-content">
					<div class="col-xs-12">
						<form action="" method="post" aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
							<div class="panel sauget-accordion">
								<div id="headingFour" role="tab" class="panel-heading">
									<h4 class="panel-title">
										<a aria-controls="paymentInformation" aria-expanded="false" href="#paymentInformation" data-parent="#accordion" data-toggle="collapse" class="collapsed">
											4. Payment Information
										</a>
									</h4>
								</div>
								<div aria-labelledby="headingFour" role="tabpanel" class="panel-collapse collapse in" id="paymentInformation" aria-expanded="true">
									<div class="content-info">
										<div class="col-xs-12">
											<div class="checkout-option">
												<div class="method-input-box">
													<p><input type="radio" name="payment" value="card" checked><label>Credit Card (saved) </label></p>
												</div>
												<div class="master-card-info">
														<div class="form-group">
															<label>Name on Card</label>
															<input type="text" name="card_name" class="form-control">
														</div>
														<div class="cardtype form-group">
															<label>Credit Card Type</label>
															<select class="form-control" name="card_type">
																<option value="-">--Please Select--</option>
																<option value="american express">American Express</option>
																<option value="visa">Visa</option>
																<option value="mastercard">MasterCard</option>
																<option value="discover">Discover</option>
															</select>
														</div>
														<div class="form-group">
															<label>Credit Card Number</label>
															<input type="text" name="card_number" class="form-control">
														</div>
														<div class="expirationdate form-group">
															<label>Expiration Date</label>
															<select class="form-control month-select" name="card_exp_m">
																<option value="-">Month</option>
																<option value="01">01 - January</option>
																<option value="02">02 - February</option>
																<option value="03">03 - March</option>
																<option value="04">04 - April</option>
																<option value="05">05 - May</option>
																<option value="06">06 - June</option>
																<option value="07">07 - July</option>
																<option value="08">08 - August</option>
																<option value="09">09 - September</option>
																<option value="10">10 - October</option>
																<option value="11">11 - November</option>
																<option value="12">12 - December</option>
															</select><br/>
															<select class="form-control year-select" name="card_exp_y">
																<option value="-">Year</option>
																<option value="2016">2016</option>
																<option value="2017">2017</option>
																<option value="2018">2018</option>
																<option value="2019">2019</option>
																<option value="2020">2020</option>
																<option value="2021">2021</option>
																<option value="2022">2022</option>
																<option value="2023">2023</option>
																<option value="2024">2024</option>
																<option value="2025">2025</option>
															</select>
														</div>
														<div class="verificationcard form-group">
															<label>Card Verification Number</label>
														   <input type="text" class="form-control" name="card_ccc"><br/>
															<a href="#">What is this?</a>
														</div>
													</form>
													<div class="block-area-button">
														<a class="checkPageBtn" onclick="CheckCard()">Continue</a>
													</div>
													<p class="message" id="message1"></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel sauget-accordion">
								<div id="headingFive" role="tab" class="panel-heading">
									<h4 class="panel-title">
										<a aria-controls="orderReview" aria-expanded="false" href="#orderReview" data-parent="#accordion" data-toggle="collapse" class="collapsed">
											5. Order Review
										</a>
									</h4>
								</div>
								<div aria-labelledby="headingFive" role="tabpanel" class="panel-collapse collapse in" id="orderReview" aria-expanded="true">
									<div class="content-info">
										<div class="review-bar">
											<div class="col-xs-12 col-sm-6">
												<?php
												foreach($products as $p) {
													echo '<p>'.$p['product']['name'].' ('.$p['qty'].') - $'.$p['product']['price'].'</p>';
												}
												echo '<p><strong>Total: $'.$cart['total'].'</strong></p>';
												 ?>
												<button type="submit" class="checkPageBtn" onclick="checkout()">Submit</button>
												<p class="message" id="message1"><?=$message_post?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php
include ('includes/template/footer.php');
?>