<?php 
require_once("common.php"); 

if(empty($_SESSION['user'])) 
{ 
    header("Location: index.php"); 
    die; 
} 
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Hotel Backup</title>
		<meta name="description" content="AMH">
		<link rel="stylesheet" href="/login/css/main.css">
		<script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.js"></script>
		<script src="/login/js/library.js"></script>
		<script src="/login/js/bespoke.js"></script>
	</head>

	<body>
		<div class="menu">
			<div class="logo"> </div>
			<div class="links"> |&nbsp;<a href="/login/private">Backups</a>&nbsp;|&nbsp;<a href="/login/register">Register</a>&nbsp;|&nbsp;<a href="/login/memberlist">Memberlist</a>&nbsp;|&nbsp;<a href="/login/account">Edit&nbsp;Account</a>&nbsp;|&nbsp;<a href="/login/logout">Logout</a>&nbsp;| </div>
			<div class="mobile-menu-spacer"></div>
			<button class="hamburger" id="burger" onclick="myFunction()">
				<div class="menuicon" id="menuicon1"></div>
				<br>
				<div class="menuicon" id="menuicon2"></div>
				<br>
				<div class="menuicon" id="menuicon3"></div>
				<div class="spanholder" id="spanholder"> <span class="span" id="span1"></span> <span class="span" id="span2"></span> </div>
				<ul class="onclick-menu-content" id="myDropdown">
					<li><a href="/login/private">Backups</a></li>
					<li><a href="/login/register">Register</a></li>
					<li><a href="/login/memberlist">Memberlist</a></li>
					<li><a href="/login/edit_account">Edit&nbsp;Account</a></li>
					<li><a href="/login/logout">Logout</a></li>
					<div class="overlay-menuhide"></div>
				</ul>
			</button>
		</div>
		<div class="menupushdown"></div>