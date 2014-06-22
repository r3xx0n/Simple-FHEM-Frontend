<?php
/**
*   This file is part of simple FHEM
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
*   Sascha Wilts - info@saschawilts.de
**/

require_once 'config.inc.php';				// Konfigurationskonstanten
require_once 'mysql.inc.php';				// Datenbankverbinden
require_once 'menu.inc.php';				// Menü aufbauen
require_once 'fhem.inc.php';				// FHEM Funktionen
require_once 'os.inc.php';					// Betriebssystem Infos

// Sicherheit von includes gewährleisten
// Für index Seite zum includen des Contents
function filterfilename($filename){
    $filename = strtolower($filename);
    $filename = preg_replace("/[^a-z0-9\-\/]/i","",$filename);

	if($filename[0] == "/"){
    	$filename = substr($filename,1);
    }
    $filename .= ".php";
    if(!file_exists($filename)){
        $filename = "content/errors/404.php";
    }
    return $filename;
}
?>