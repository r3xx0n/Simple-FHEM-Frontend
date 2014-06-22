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

class config {
	/* ********************** */
	/* - Hauptkonfiguration - */
	/* ********************** */

	const SITE_TITLE 	= 'SimpleFHEM'; 	// Titel der Webseite

	/* ********************** */
	/* -  DB Konfiguration 	- */
	/* ********************** */

	const DB_HOST 		= 'localhost'; 		// Adresse der Datenbank
	const DB_USER 		= ''; 			// Username des Datenbankusers
	const DB_PASS 		= ''; 				// passwort für den User
	const DB_NAME 		= ''; 				// Datenbankname für die Webseite
	const DB_PORT		= 3306; 			// Mysql Port

	/* ********************** */
	/* - FHEM Konfiguration - */
	/* ********************** */

	const FHEM_HOST		= 'localhost'; 		// FHEM Adresse
	const FHEM_PORT		= '7072'; 			// FHEM Telnet Port
	const FHEM_TIMEOUT  = 10;				// Timeout for Telnet
}

?>
