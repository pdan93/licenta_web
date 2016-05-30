<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Elixir Fashion</title>
	<!-- All daniel Files Here -->
	<!-- fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,500' rel='stylesheet' type='text/css'>
	<!-- bootstrap css -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<!-- fontawesome css -->
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<!-- revolution banner css settings -->
	<link rel="stylesheet" type="text/css" href="lib/rs-plugin/css/settings.css" media="screen" />
	<!-- style css -->
	<link rel="stylesheet" href="style.css">
	<!-- mobilemenu css -->
	<link rel="stylesheet" href="css/meanmenu.min.css"/>
	<!-- responsive css -->
	<link rel="stylesheet" href="css/responsive.css"/>
	<!-- favicon -->
	<link rel="shortcut icon" href="images/favicon.png" />
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<!-- Header-Section-Strat  -->
<header>
	<div class="container">
		<div class="header_top">
			<div class="row">
				<div class="col-md-6">
					<div class="header_top_left float-left">
						<ul class="social_icon">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						</ul>

					</div>
				</div>
				<div class="col-md-6">
					<div class="header_top_right text-right">
						<ul>
							<?php
							if (LOGGED_IN==1)
								echo '
								<li><a href="my_account.php">Account</a></li>
								<li><a href="logout.php">Logout</a></li>
								';
								else
								echo '<li><a href="signup.php">Register / Login</a></li>';
							?>


							<li class="searchbox">
								<input type="search" placeholder="Search......" name="search" class="searchbox-input" onkeyup="buttonUp();" required>
								<input type="submit" class="searchbox-submit" value="">
								<span class="searchbox-icon"><i class="fa fa-search"></i></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row mega_relative">
			<div class="col-xs-12 col-sm-2">
				<div class="logo head_lo">
					<a href="index.php"><img src="images/logo.png" alt="Logo" /></a>
				</div>
			</div>
			<div class="col-sm-10">
				<div class="mainmenu float-right">
					<nav>
						<ul>
							<li><a href="index.html">HOME</a></li>
							<li><a href="#">FEATURED</a></li>
							<li><a href="contact.html">CONTACT</a></li>
							<?php
							$results = mysqli_query($conn,"SELECT * FROM cart WHERE id_user=".$_SESSION['userID']." AND open=1;");
							if (mysqli_num_rows($results)) {
								$cart = mysqli_fetch_array($results);
								$results = mysqli_query($conn,"SELECT COUNT(*) FROM cart_products WHERE id_cart=".$cart['id'].";");
								$nr = mysqli_fetch_array($results);
								echo '<li class="shop_icon">
									<a href="cart.php"><img src="images/menu_icon_img.png" alt="" /></a>
									<span>'.$nr['COUNT(*)'].'</span>
								</li>';
							}
							?>

						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</header>