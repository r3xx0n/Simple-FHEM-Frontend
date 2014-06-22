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
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
	header("location: login.php");
	exit();
}
require_once 'includes/functions.inc.php'; ?>
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

	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>

	          <a class="navbar-brand" href="index.php"><?php echo config::SITE_TITLE; ?></a>

	        </div>

	        <div class="navbar-collapse collapse">
	        	<ul class="nav navbar-nav navbar-right">
	        		<?php menu::create_links(); ?>
	        		<li><a href="logout.php">Logout</a></li>
	        	</ul>
	        </div>

	      </div>
	    </div>

	    <!-- CONTENT -->
	    <div class="container container-content" role="main">
			<?php 	if(isset($_GET['page']) && $_GET['page'] !=''){
						$include = filterfilename("content/".$_GET['page']);
					}else{
						$include = filterfilename("content/home");
					}
					include($include); ?>
	    </div>

		<!-- FOOTER -->
		<div class="container container-footer" role="footer">
			<p>&copy; 2014 by r3xx0n</p>
		</div>


		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Bootstrap Validation Plugin -->
		<script src="js/validator.min.js"></script>
		<!-- IOS Web-App Behandlung von Links -->
		<!-- AJAX Funktionen für FHEM -->
		<script src="js/fhem.js"></script>
		<!-- IOS Web-App Behandlung von Links -->
		<script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
	</body>
</html>