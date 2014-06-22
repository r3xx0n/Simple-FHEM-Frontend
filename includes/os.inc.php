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

class os {
	
	static function NumberWithCommas($in) {
		return number_format($in);
	}
		
	static function  WriteToStdOut($text) {
		$stdout = fopen('php://stdout','w') or die($php_errormsg);
		fputs($stdout, "\n" . $text);
	}

	// in °C
	static function temp() {
		$temp = round(exec("cat /sys/class/thermal/thermal_zone0/temp ") / 1000, 1);
		return $temp.' °C';		
	}
	
	// in MHz
	static function frequency() {
		$freq = self::NumberWithCommas(exec("cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq") / 1000);
		return $freq.' MHz';
	}
	
	static function uptime() {
		$uptime_array = explode(" ", exec("cat /proc/uptime"));
		$seconds = round($uptime_array[0], 0);
		$minutes = $seconds / 60;
		$hours = $minutes / 60;
		$days = floor($hours / 24);
		$hours = sprintf('%02d', floor($hours - ($days * 24)));
		$minutes = sprintf('%02d', floor($minutes - ($days * 24 * 60) - ($hours * 60)));
		if ($days == 0):
			$uptime = $hours . "h, " .  $minutes . "m";
		elseif($days == 1):
			$uptime = $days . " day, " .  $hours . "h, " .  $minutes . "m";
		else:
			$uptime = $days . " days, " .  $hours . "h, " .  $minutes . "m";
		endif;	
		
		return $uptime;
	}
	
	// in %
	static function cpuload() {
		$output1 = null;
		$output2 = null;
		//First sample
		exec("cat /proc/stat", $output1);
		//Sleep before second sample
		sleep(1);
		//Second sample
		exec("cat /proc/stat", $output2);
		$cpuload = 0;
		for ($i=0; $i < 1; $i++)
		{
			//First row
			$cpu_stat_1 = explode(" ", $output1[$i+1]);
			$cpu_stat_2 = explode(" ", $output2[$i+1]);
			//Init arrays
			$info1 = array("user"=>$cpu_stat_1[1], "nice"=>$cpu_stat_1[2], "system"=>$cpu_stat_1[3], "idle"=>$cpu_stat_1[4]);
			$info2 = array("user"=>$cpu_stat_2[1], "nice"=>$cpu_stat_2[2], "system"=>$cpu_stat_2[3], "idle"=>$cpu_stat_2[4]);
			$idlesum = $info2["idle"] - $info1["idle"] + $info2["system"] - $info1["system"];
			$sum1 = array_sum($info1);
			$sum2 = array_sum($info2);
			//Calculate the cpu usage as a percent
			$load = (1 - ($idlesum / ($sum2 - $sum1))) * 100;
			$cpuload += $load;
		}
		$cpuload = round($cpuload, 1); //One decimal place
		return $cpuload.' %';
	}

	static function meminfo() {
		//Memory Utilisation
		$meminfo = file("/proc/meminfo");
		for ($i = 0; $i < count($meminfo); $i++)
		{
			list($item, $data) = preg_split("/:/", $meminfo[$i], 2);
			$item = trim(chop($item));
			$data = intval(preg_replace("/[^0-9]/", "", trim(chop($data)))); //Remove non numeric characters
			switch($item)
			{
				case "MemTotal": $total_mem = $data; break;
				case "MemFree": $free_mem = $data; break;
				default: break;
			}
		}
		$used_mem = $total_mem - $free_mem;
		$percent_free = round(($free_mem / $total_mem) * 100);
		$percent_used = round(($used_mem / $total_mem) * 100);
		$used_mem = self::NumberWithCommas($used_mem);
		$total_mem = self::NumberWithCommas($total_mem);
		$free_mem = self::NumberWithCommas($free_mem);	
		
		$return = array();
		$return['total'] = $total_mem.' MB';
		$return['free'] = $free_mem.' MB';
		$return['used'] = $used_mem.' MB';
		$return['free_percent'] = $percent_free.' %';;
		$return['used_percent'] = $percent_used.' %';
		
		return $return;
		
	}

	static function processor()	{
		$processor = str_replace("-compatible processor", "", explode(": ", exec("cat /proc/cpuinfo | grep Processor"))[1]);
		return $processor;
	}

	static function currenttime() {
		$current_time = exec("date +'%d %b %Y<br />%T %Z'");
		return $current_time;
	}
	
}

?>