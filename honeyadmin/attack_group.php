<?php
include ('includes/initialize.php');
include ('includes/template/header.php');
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
			<small>Control panel</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">


		<div class="row">
			<!-- Left col -->


			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Attacks Group for
							<?php
							$results = mysqli_query($conn,"SELECT r_useragent_ip as 'ip', attack_type, COUNT(*) as 'total', MIN(timestamp) as 'min_date', MAX(timestamp) as 'max_date' FROM `logs` WHERE is_attack=1 AND r_useragent_ip='".$_GET['ip']."' AND attack_type=".$_GET['attack_type']." ;");
							$row = mysqli_fetch_array($results);
							echo $row['ip'].', Total of '.$row['total'].', '.$attack_types_map[$row['attack_type']]['name'].', '.$row['min_date'].' - '.$row['max_date'];
							?></h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="attacks-table" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>Date</th>
								<th>Specific Attack Type</th>
								<th>Uri</th>
								<th>In Headers</th>
								<th>Out Headers</th>
								<th>Request Body</th>
								<th>Request Method</th>
								<th>Request Content type</th>
								<th>Server Port</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$results = mysqli_query($conn,"SELECT * FROM `logs` WHERE is_attack=1 AND r_useragent_ip='".$_GET['ip']."' AND attack_type=".$_GET['attack_type'].";");
							while ($row = mysqli_fetch_array($results))
								echo '<tr>
										<td>'.$row['timestamp'].'</td>
										<td>'.$attack_types_map[$row['attack_type']][$row['specific_attack_type']].'</td>
										<td>'.$row['r_uri'].'</td>
										<td>'.$row['headers_in'].'</td>
										<td>'.$row['headers_out'].'</td>
										<td>'.$row['request_body'].'</td>
										<td>'.$row['r_method'].'</td>
										<td>'.$row['r_content_type'].'</td>
										<td>'.$row['s_port'].'</td>
										</tr>
									';
							?>
							</tbody>
							<tfoot>
							<tr>
								<th>Date</th>
								<th>Specific Attack Type</th>
								<th>Uri</th>
								<th>In Headers</th>
								<th>Out Headers</th>
								<th>Request Body</th>
								<th>Request Method</th>
								<th>Request Content type</th>
								<th>Server Port</th>
							</tr>
							</tfoot>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>

		</div>
	</section>
	<!-- /.content -->
</div>
<?php
include ('includes/template/footer.php');
include ('includes/finalize.php');
?>
