<?php
session_start();
$servername = "localhost";
$username = "elixir_fashion";
$password = "elixir_fashion123";
$database = "elixir_fashion";
if (file_exists("../ip_map"))
	{
	$f_ip_map = fopen("../ip_map","r");
	$ip = $_SERVER['REMOTE_ADDR'];
	while ($line = fgets($f_ip_map)) {
		if (strpos($line,$ip)!==false)
			{
			$db_nr = trim(substr($line,strpos($line,' ')+1));
			$username = 'test'.$db_nr.'user';
			$password = 'test'.$db_nr.'pass';
			$database = 'elixir_fashion'.$db_nr;
			break;
			}
	}
	fclose($f_ip_map);
	}
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$ok_login=0;
if (isset($_SESSION['login']))
	if ($_SESSION['login']==1)
		$ok_login=1;
if ($ok_login==1)
{
	$results = mysqli_query($conn,"SELECT * FROM users WHERE id='".$_SESSION['userID']."';");

	if (mysqli_num_rows($results)) {
		$user = mysqli_fetch_array($results);
		$ok_login=1;
	}
	else
		$ok_login=0;
}
define("LOGGED_IN",$ok_login);
define("BE_SECURE",2); //0 - not at all, 1- yes, 2-by chance or set by a better constant
define("BE_SECURE_LOGIN",0);
define("LOGIN_USE_USERNAME",1);
define("LOGIN_USE_MD5",1);
/*
$myFile = "most_common_usernames.txt";
$users = file($myFile);//file in to an array
$myFile2 = "most_common_passwords.txt";
$passes = file($myFile2);//file in to an array
$n = 220044;
$n2 = 226082;
for ($i=0; $i<9543; $i++)
	{
	if ($i<2238)
		$u = $users[$i];
		else
		$u = $users[rand(2238,$n-1)];
	$p = $passes[rand(0,226081)];
	mysqli_query($conn,"INSERT INTO users (id,username,password) VALUES (NULL,'".mysqli_escape_string($conn,$u)."','".mysqli_escape_string($conn,$p)."')");
	}
die();*/

function be_secure($case) {
	if (BE_SECURE==2)
		{
		if (constant($case)==1)
			return 1;
			else if (constant($case)==0)
				return 0;
				else
				{
				return 0;
				}
		}
	else
		return BE_SECURE;
}
