<?php
// @formatter:off
	include ('includes/initialize.php');
	include ('includes/template/header.php');
?>

	<!-- Slider-Section-Strat  -->
	<div class="slider_area">
		<div class="fullwidthbanner">
			<ul>

				<?php
				$results = mysqli_query($conn,"SELECT * FROM products LIMIT 5;");
				while ($row = mysqli_fetch_array($results)) {
					?>
					<!-- SLIDE-1  -->
					<li data-transition="random" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">
						<!-- MAIN IMAGE -->
						<img src="images/slider/slider_bg-2.jpg" alt="mainbanner-31" data-bgposition="center top"
							 data-bgfit="cover" data-bgrepeat="no-repeat">
						<!-- LAYERS -->
						<!-- LAYER NR. 1 -->
						<div class="tp-caption banner1 tp-fade tp-resizeme"
							 data-x="910"
							 data-y="20"
							 data-speed="300"
							 data-start="500"
							 data-easing="Power3.easeInOut"
							 data-splitin="none"
							 data-splitout="none"
							 data-elementdelay="0"
							 data-endelementdelay="0"
							 data-end="8700"
							 data-endspeed="300"
							 style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;"><img src="<?=$row['image']?>" alt="">
						</div>

						<!-- LAYER NR. 2 -->
						<div class="tp-caption banner12 tp-fade tp-resizeme"
							 data-x="385"
							 data-y="145"
							 data-speed="300"
							 data-start="800"
							 data-easing="Power3.easeInOut"
							 data-splitin="none"
							 data-splitout="none"
							 data-elementdelay="0"
							 data-endelementdelay="0"
							 data-end="8700"
							 data-endspeed="300"
							 style="z-index: 7;font-size:72px; font-family:nexa_blackregular;font-weight:700;color:#3a4b60;max-width: auto; max-height: auto; white-space: nowrap;">
							<?=$row['name']?>
						</div>

						<!-- LAYER NR. 3 -->
						<div class="tp-caption banner13 tp-fade tp-resizeme"
							 data-x="385"
							 data-y="190"
							 data-speed="300"
							 data-start="1100"
							 data-easing="Power3.easeInOut"
							 data-splitin="none"
							 data-splitout="none"
							 data-elementdelay="0"
							 data-endelementdelay="0"
							 data-end="8700"
							 data-endspeed="300"
							 style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;font-size:24px;line-height:26px;font-family:Roboto;font-weight:100; color:#ffffff;letter-spacing:8px;">
							<?=$row['subtitle']?>
						</div>

						<!-- LAYER NR. 4.1 -->
						<div class="tp-caption banner21 tp-fade tp-resizeme"
							 data-x="385"
							 data-y="273"
							 data-speed="300"
							 data-start="800"
							 data-easing="Power3.easeInOut"
							 data-splitin="none"
							 data-splitout="none"
							 data-elementdelay="0"
							 data-endelementdelay="0"
							 data-end="8700"
							 data-endspeed="300"
							 style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;font-size:20px;line-height:2;font-family:nexa_bookregular;color:#ffffff;">
							<?=$row['description']?><br />
							Color: <?=$row['description']?><br />
							Fit: <?=$row['description']?><br />
						</div>

						<!-- LAYER NR. 4.7 -->
						<div class="tp-caption banner2 tp-fade tp-resizeme"
							 data-x="385"
							 data-y="530"
							 data-speed="1800"
							 data-start="500"
							 data-easing="Power3.easeInOut"
							 data-splitin="none"
							 data-splitout="none"
							 data-elementdelay="0"
							 data-endelementdelay="0"
							 data-end="8700"
							 data-endspeed="300"
						>
							<a class="slide_btn" href="product.php?id=<?=$row['id']?>"
							   style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;font-size:16px; color:#fff;border: 2px solid #ffffff;line-height:2;padding: 10px 30px;">SHOP
								NOW</a>
						</div>


					</li>
					<?php
						}
					?>
			</ul>
		</div>
	</div>
	<!-- Slider-Section-End  -->
	<!-- Product-Section-Strat  -->
	<section class="product_area section-padding">
		<?php
		$results = mysqli_query($conn,"SELECT * FROM products LIMIT 2,8;");
		$i=0;
		while ($row = mysqli_fetch_array($results)) {
				?>
				<div class="padding_right main_single_product">
					<div class="single_product">
						<div class="product_img">
							<img src="<?=$row['image']?>" alt="DARK BLUE IMAGE"/>
						</div>
						<div class="product_text dark_product">
							<h1><a href="product.php?id=<?=$row['id']?>"><?=$row['name']?></a></h1>
						</div>
					</div>
				</div>
			<?php
		}
		?>
	</section>
	<!-- Product-Section-End  -->


<?php
	include ('includes/template/footer.php');
?>