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
if (isset($_POST['name']) && isset($_POST['state']) && isset($_POST['room'])) {

	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
	$room = filter_var($_POST['room'], FILTER_SANITIZE_STRING);

	fhem::getCMD("set ".$name." ".$state."") or die();

}elseif (isset($_GET['room']) && $_GET['room'] != "") {

	// String absichern
	$room_name = filter_var($_GET['room'], FILTER_SANITIZE_STRING);

	// header text
	echo '<h3>'.$room_name.'</h3>';

	// breadcrumb
	echo '<ol class="breadcrumb">';
	echo '  <li><a href="index.php?page=rooms">Raumübersicht</a></li>';
	echo '  <li class="active"><a href="index.php?page=rooms&room='.$room_name.'">'.$room_name.'</a></li>';
	echo '</ol>';

	// info alert
	//echo '<p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp; Hier können Sie all Ihre Geräte des jeweiligen Raumes steuern.</p>';

	// get devices
	$xmllist = fhem::getCMD('xmllist');
	$devices = fhem::getRoomDevices($xmllist,$room_name);

	echo '<form method="post" action="index.php?page=rooms&room='.$room_name.'" id="form">';

	echo '<table id="devices" class="tablelist">';
	echo '	<tbody>';
	foreach($devices[$room_name] as $key => $name) {
			foreach($name as $device => $option) {
				echo '<div class="panel panel-default">';

			    /* VERSCHIEDENE BUTTONS ------------------------------------------------- */
				 switch($option['webcmd']) {
				 	case "on::off":
				 		echo '	<div class="panel-heading">';
					    echo '		<i class="fa fa-adjust fa-fw"></i>&nbsp; '.$option['name'];
					    echo '	</div>';
					    echo '	<div class="panel-body">';
					    echo '		<div class="row">';
		  				echo '			<div class="col-md-1">';

				 		echo "<input type=\"checkbox\" name=\"".$option['name']."\" class=\"effeckt-ckbox-ios7\" onchange=\"setstate(this.name, ".($option['state'] == "on" ? "'off'" : "'on'").",'".$room_name."');\" ".($option['state'] == "on" ? "checked=\"checked\"" : "")." />";
				 		break;
				 	case "up::down":
				 		echo '	<div class="panel-heading">';
					    echo '		<i class="fa fa-sort fa-fw"></i>&nbsp; '.$option['name'];
					    echo '	</div>';
					    echo '	<div class="panel-body">';
					    echo '		<div class="row">';
		  				echo '			<div class="col-md-1">';

		  				echo "<button name=\"".$option['name']."\" class=\"btn btn-default".($option['state'] == "up" ? " active" : "")."\" onclick=\"setstate(this.name, 'up','".$room_name."');\" value=\"up\" ><i class=\"fa fa-sort-asc\"></i></button>";
		  				echo "<button name=\"".$option['name']."\" class=\"btn btn-default".($option['state'] == "down" ? " active" : "")."\" onclick=\"setstate(this.name, 'down','".$room_name."');\" value=\"down\" ><i class=\"fa fa-sort-desc\"></i></button>";
		  				
				 		break;
				 	default:
				 		echo '	<div class="panel-heading">';
					    echo '		<i class="fa fa-adjust fa-fw"></i>&nbsp; '.$option['name'];
					    echo '	</div>';
					    echo '	<div class="panel-body">';
					    echo '		<div class="row">';
		  				echo '			<div class="col-md-1">';
				 		echo "<input type=\"checkbox\" name=\"".$option['name']."\" class=\"effeckt-ckbox-ios7\" onchange=\"setstate(this.name, this.checked,'".$room_name."');\" ".($option['state'] == "on" ? "checked=\"checked\"" : "")." />";
				 		break;
				 }
				
				/* END ------------------------------------------------------------------- */

			    echo '			</div>';
			    echo '		</div>';
			    echo '	</div>';


			    echo '</div>';
			}
	}
	echo '	</tbody>';
	echo '</table>';
	echo '</form>';

}else{

	// title
	echo '<h3>Raumübersicht</h3>';
	// get rooms
	$xmllist = fhem::getCMD('xmllist');
	$rooms = fhem::getRooms($xmllist);
	$r_count = count($rooms);

	if ($r_count >= 1) {
		
		echo '<p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp; Klicken Sie auf einen der Räume, um die Geräte anzuzeigen.</p>';

		echo '<div id="rooms">';
		echo '	<div class="list-group">';
		foreach($rooms as $id => $name) {
			echo '<a href="index.php?page=rooms&room='.$name.'" class="list-group-item">'.$name.'</a>';
		}
		echo '	</div>';
		echo '</div>';

	}else{
		
		echo '<p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp; Es sind keine Räume vorhanden. Weisen Sie ihren Geräten Räume zu.</p>';
		
	}
}

?>