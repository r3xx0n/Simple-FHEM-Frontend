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
	// title
	echo '<h3>Timer</h3>';
	// get rooms
	$xmllist = fhem::getCMD('xmllist');
	$timertypes = fhem::getTimer($xmllist);
	$t_count = count($timertypes);

	if ($t_count >= 1) {

		foreach($timertypes as $type => $timers) {
			foreach ($timers as $timer) {
				echo '<div class="panel panel-default">';
				echo '<div class="panel-heading"><span class="badge badge-info">'.$type.'</span>&nbsp; '.$timer['name'].'</div>';
				echo '<div class="panel-body">';
				echo '	Status: '.$timer['state'].'<br />';
				echo '	Definition: '.$timer['definition'].'<br />';
				echo '	Triggertime: '.$timer['triggertime'].'<br />';
				echo '	Room: '.$timer['room'];
				echo '</div>';
				echo '</div>';
			}
			
			
		}
		echo '</div>';

	}else{
		
		echo '<p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp; Es sind keine Räume vorhanden. Weisen Sie ihren Geräten Räume zu.</p>';
		
	}