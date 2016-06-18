<?php
$servername = "localhost";
$username = "honeypot";
$password = "Dan230793";
$database = "honeypot";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

function getcount($sql) {
	global $conn;
	$results = mysqli_query($conn,$sql);
	while ($row = mysqli_fetch_array($results)) {
		return $row[0];
	}
}

$attack_types_map = array(
	0 => array( 'name'=>'None', 0=> 'none'),
	1 => array(
		'name'=>'Sql Injection',
		1 => 'Tautologie',
		2 => 'Illegal/Logically incorrect query',
		3 => 'Union query',
		4 => 'Piggy backed query',
		5 => 'Stored procedure',
		6 => 'Alternate encoding',
	),
	2 => array(
		'name'=>'Password Guessing',
		1 => 'Tautologie',
		2 => 'Illegal/Logically incorrect query',
		3 => 'Union query',
		4 => 'Piggy backed query',
		5 => 'Stored procedure',
		6 => 'Alternate encoding',
	),
	3 => array(
		'name'=>'File Permission',
		1 => 'Tautologie',
		2 => 'Illegal/Logically incorrect query',
		3 => 'Union query',
		4 => 'Piggy backed query',
		5 => 'Stored procedure',
		6 => 'Alternate encoding',
	),
);