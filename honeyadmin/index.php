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
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?=getcount("SELECT COUNT(*) FROM logs WHERE is_attack=1")?></h3>

						<p>Attacks</p>
					</div>
					<div class="icon">
						<i class="ion ion-ionic"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?=getcount("SELECT COUNT(DISTINCT(r_useragent_ip)) FROM logs")?></h3>

						<p>Unique Visitors</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-circle-filled"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?=getcount("SELECT COUNT(DISTINCT(r_useragent_ip)) FROM logs WHERE is_attack=1")?></h3>

						<p>Unique Attackers</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-close-outline"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>
							<?php
							$visitors = getcount("SELECT COUNT(DISTINCT(r_useragent_ip)) FROM logs");
							$attackers = getcount("SELECT COUNT(DISTINCT(r_useragent_ip)) FROM logs WHERE is_attack=1");
							echo ceil($attackers*100/$visitors).'%';
							?>
						</h3>

						<p>Attackers/Visitors rate</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-loop-strong"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- Left col -->
			<section class="col-lg-7 connectedSortable">
				<!-- Custom tabs (Charts with tabs)-->
				<div class="nav-tabs-custom">
					<!-- Tabs within a box -->
					<ul class="nav nav-tabs pull-right">
						<li class="active"><a href="#attacks-chart" data-toggle="tab">Area</a></li>
						<li class="pull-left header"><i class="fa fa-inbox"></i> Attacks/Visits</li>
					</ul>
					<div class="tab-content no-padding">
						<!-- Morris chart - Sales -->
						<div class="chart tab-pane active" id="attacks-chart" style="position: relative; height: 300px;"></div>
						<script>
							var to_be_called = new Array();
							to_be_called.push(function(){
							var attacks_chart = new Morris.Area({
								element: 'attacks-chart',
								resize: true,
								data: [
								<?php
									$results = mysqli_query($conn,"SELECT DATE_FORMAT(timestamp,'%Y-%m') as 'date',COUNT(*) as 'all',SUM(if(is_attack=1,is_attack,0)) as 'attacks',SUM(if(is_attack=0,1,0)) as 'normal' FROM `logs` GROUP BY DATE_FORMAT(timestamp,'%Y %m') ORDER BY timestamp ASC");
									while ($row = mysqli_fetch_array($results))
										{
										echo "{y: '".$row['date']."', item1: ".$row['attacks'].", item2: ".$row['normal']."},";
										}
								?>
								],
								xkey: 'y',
								ykeys: ['item1', 'item2'],
								labels: ['Attacks', 'Just Visits'],
								lineColors: ['#a0d0e0', '#3c8dbc'],
								hideHover: 'auto'
							});
						});
						</script>
					</div>
				</div>
				<!-- /.nav-tabs-custom -->

			</section>

			<section class="col-lg-5 connectedSortable">
				<!-- Custom tabs (Charts with tabs)-->
				<div class="nav-tabs-custom">
					<!-- Tabs within a box -->
					<ul class="nav nav-tabs pull-right">
						<li class="pull-left header"><i class="fa fa-inbox"></i> Attack Types</li>
					</ul>
					<div class="tab-content no-padding">
						<!-- Morris chart - Sales -->
						<div class="chart tab-pane active" id="attack-types-chart" style="position: relative; height: 300px;"></div>
						<script>
							to_be_called.push(function(){
								var attack_types_chart = new Morris.Donut({
									element: 'attack-types-chart',
									resize: true,
									colors: ["#3c8dbc", "#f56954", "#00a65a"],
									data: [
									<?php
									$attack_types = array(
										'Sql Injections' => getcount("SELECT COUNT(*) FROM logs WHERE attack_type=1"),
										'Password Guessing' => getcount("SELECT COUNT(*) FROM logs WHERE attack_type=2"),
										'File Permission' => getcount("SELECT COUNT(*) FROM logs WHERE attack_type=3"),
										);
									foreach($attack_types as $key=>$value)
										echo '{label: "'.$key.'", value: '.$value.'},';
									?>
									],
									hideHover: 'auto'
								});
							});
						</script>
					</div>
				</div>
				<!-- /.nav-tabs-custom -->

			</section>

			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Attacks Grouped</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="attacks-table" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>Ip</th>
								<th>Attack Type</th>
								<th>Total</th>
								<th>Date start</th>
								<th>Date end</th>
								<th>Visit</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$results = mysqli_query($conn,"SELECT r_useragent_ip as 'ip', attack_type, COUNT(*) as 'total', MIN(timestamp) as 'min_date', MAX(timestamp) as 'max_date' FROM `logs` WHERE is_attack=1 GROUP BY r_useragent_ip,attack_type");
								while ($row = mysqli_fetch_array($results))
									echo '<tr>
										<td>'.$row['ip'].'</td>
										<td>'.$attack_types_map[$row['attack_type']]['name'].'</td>
										<td>'.$row['total'].'</td>
										<td>'.$row['min_date'].'</td>
										<td>'.$row['max_date'].'</td>
										<td><a href="attack_group.php?ip='.$row['ip'].'&attack_type='.$row['attack_type'].'">Link</a></td>
										</tr>
									';
							?>
							</tbody>
							<tfoot>
							<tr>
								<th>Ip</th>
								<th>Attack Type</th>
								<th>Total</th>
								<th>Date start</th>
								<th>Date end</th>
								<th>Visit</th>
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
