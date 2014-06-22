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

class DB {

    private static $mysqli;
    private function __construct(){} //no instantiation

    static function cxn() {

        if( !self::$mysqli ) {

            self::$mysqli = new mysqli(config::DB_HOST, config::DB_USER, config::DB_PASS, config::DB_NAME, config::DB_PORT);

            if (self::$mysqli->connect_errno) {

    			echo "Failed to connect to MySQL: " . self::$mysqli->connect_error;
    			
			}

			if (!mysqli_set_charset(self::$mysqli, "utf8")) {

    			echo "Error loading character set utf8: " . mysqli_error(self::$mysqli);

			}

        }

        return self::$mysqli;

    }
}

?>