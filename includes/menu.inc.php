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

class menu {
	public static function create_links() {

		$res = DB::cxn()->query("SELECT id, menu, link FROM pages WHERE active = 1 ORDER BY sort");
		$res->data_seek(0);		

		if ($res->num_rows != 0) {

			while ($row = $res->fetch_assoc()) {

				$active = '';

				if ((isset($_GET['page']) && $_GET['page'] == $row['link']) || (!isset($_GET['page']) && $row['link'] == 'home')) {

					$active = ' class="active"';

				}

				echo '<li'.$active.'><a href="index.php?page='.$row['link'].'">'.$row['menu'].'</a></li>';
			}

		}

		$res->close();

	}
}

?>