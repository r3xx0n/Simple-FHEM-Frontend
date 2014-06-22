<?php
/**
*	This file is part of simple FHEM
*
*   simple FHEM - A simple webfrontend for FHEM home automation
*   Copyright (C) 2014  Sascha Wilts
*
*   This program is free software: you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation, either version 3 of the License, or
*   any later version.
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* 	Sascha Wilts - info@saschawilts.de
**/
header('X-UA-Compatible: IE=edge,chrome=1'); // XHTML 1.1 compatible
ob_start();
session_start();
require_once 'includes/functions.inc.php'; 
if(isset($_POST['username']) && isset($_POST['password'])) {
	
	$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	$stmt = DB::cxn()->prepare("SELECT id, hash FROM users WHERE username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $hash);

	if($stmt->num_rows == 0) {
		header('Location: login.php');
		exit;
	}

	$row = $stmt->fetch();

	if(password_verify($password, $hash)) {
		session_regenerate_id();
		$_SESSION['sess_user_id'] = $id;
		$_SESSION['sess_username'] = $username;
		session_write_close();

		header('Location: index.php');
		exit;
	}else{
		header('Location: login.php');
		exit;
	}

	$stmt->close();

}else{ ?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<!-- METAS --> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
		<!-- APPLE WEBAPP -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="apple-mobile-web-app-title" content="sFHEM">
		<link rel="apple-touch-icon" sizes="120x120" href="images/touch-icon-iphone-retina.png">
		<!-- CHROME MOBILE WEBAPP -->
		<meta name="mobile-web-app-capable" content="yes">
		<!-- TITLE -->
		<title><?php echo config::SITE_TITLE; ?></title>
	    <!-- BOOTSTRAP -->
	    <link href="css/bootstrap.min.css" rel="stylesheet" />
	    <!-- FONT AWESOME STYLES -->
		<link href="css/font-awesome.min.css" rel="stylesheet" />
	    <!-- OWN STYLES -->
	    <link href="css/style.css" rel="stylesheet" />  
	    <link href="css/style.colors.css" rel="stylesheet" />

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>

	<body role="document">

		<!-- FIXED NAVBAR -->
	    <div class="navbar navbar-fhem navbar-fixed-top" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	          <a class="navbar-brand" href="login.php"><?php echo config::SITE_TITLE; ?></a>
	        </div>
	      </div>
	    </div>

	    <!-- CONTENT -->
		<div class="container">
			<form data-toggle="validator" role="form" method="post" class="form-signin">

				<!-- HEADING -->
				<div class="page-header">
  					<h2>Login</h2>
				</div>
				<!-- INPUT USERNAME -->
				<div class="form-group">
					<div class="input-group ">
  						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
 						<input   type="text" name="username" id="username" class="form-control"
 								 placeholder="Enter username" required />
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<!-- INPUT PASSWORD -->
				<div class="form-group">
					<div class="input-group">
  						<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
 						<input  type="password" name="password" id="password" class="form-control" 
 								placeholder="Enter password" data-minlength="10" required />
					</div>
					<span class="help-block with-errors">Minimum of 10 characters</span>
				</div>
				<!-- SUBMIT BUTTON -->
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
				</div>

			</form>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Bootstrap Validation Plugin -->
		<script src="js/validator.min.js"></script>
		<!-- IOS Web-App Behandlung von Links -->
		<script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>

	</body>
<?php } ?>