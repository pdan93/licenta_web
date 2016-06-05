<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/26/2016
 * Time: 1:45 PM
 * @formatter:off
 */
include ('includes/initialize.php');

$_SESSION['login'] = 0;
$_SESSION['userID'] = 0;

header('Location: signup.php');
die();