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

class fhem {

    static function getCMD($cmd) {
    	global $errormessage;
        $xmllist = '';
        $address = 'tcp://'.config::FHEM_HOST.':'.config::FHEM_PORT;
        $timeout = config::FHEM_TIMEOUT;

        if (($fp = stream_socket_client($address, $errno, $errstr, $timeout)) === FALSE) {
            $return = $errormessage = "ERROR: '$address': $errstr ($errno)";
        } else {
   			fwrite($fp, "$cmd\r\n;quit\r\n");
            while (!feof($fp)) {
            	$xmllist .= fgets($fp, 1024);
            }
            fclose($fp);
        }
        return $xmllist;
    }

	// Listet alle Devices
    static function getDevices($xmllist) {
		$xml = simplexml_load_string($xmllist);
		
		if(!empty($xml->IT_LIST)){ $types[] = $xml->IT_LIST->children(); }
		if(!empty($xml->FS20_LIST)){ $types[] = $xml->FS20_LIST->children(); }
		if(!empty($xml->FHT_LIST)){ $types[] = $xml->FHT_LIST->children(); }
		if(!empty($xml->dummy_LIST)){ $types[] = $xml->dummy_LIST->children(); }
		
		foreach($types as $type) {
					
			foreach ($type as $key => $actor) {
				
				$name = (string) $actor->attributes()->name;
				$state = (string) $actor->attributes()->state;
				
				// ATTR Array abfragen, wenn welche vorhanden
				if(!count($actor->ATTR) == 0){
					foreach($actor->ATTR as $ATTR) {
						if($ATTR->attributes()->key == 'alias'){ $alias = (string) $ATTR->attributes()->value; }
						if($ATTR->attributes()->key == 'room'){ $room = (string) $ATTR->attributes()->value; }
						if($ATTR->attributes()->key == 'webCmd'){ $webcmd = (string) $ATTR->attributes()->value; }
					}
				}
				
				// STATE Array abfragen, für zeitpunkt des letzten states
				if(!count($actor->STATE) == 0){
					foreach($actor->STATE as $STATE) {
						if($STATE->attributes()->key == 'state'){ $measured = (string) $STATE->attributes()->measured; }
					}
				}
				
				// Wenn einige Werte nicht gefunden wurden, werden diese gefüllt.
				if (!isset($room)) $room = 'unassigned';
				if (!isset($alias)) $alias = $name;
				if (!isset($measured)) $measured = 'unknown';
				if (!isset($webcmd)) $webcmd = 'on::off';
				
				$dev[$room][$key][] = array(
					"name"      => $name,
					"alias"     => $alias,
					"state"     => $state,
					"webcmd"	=> $webcmd,
					"measured"	=> $measured);
				
			}		
			
		}
		
		ksort($dev);
		return $dev;

    }
	
    static function getRooms($xmllist) {
		$devices = self::getDevices($xmllist);
				
 		$rooms = array();
        foreach ($devices as $key => $name) {
			
            if ($key != "hidden") {
                array_push($rooms,$key);
            }
        }
		
		return $rooms;
    }
	
	public static function getRoomDevices($xml, $room) {
        $devices = self::getDevices($xml);

        foreach ($devices as $key=>$name) {
            if ($key == "hidden" || $key != $room) {
                unset($devices[$key]);
            }
        }
        return ($devices);
    }
	
	
	// Listet alle Timer
	static function getTimer($xmllist) {
		$xml = simplexml_load_string($xmllist);
			
		if(!empty($xml->at_LIST)){ $types[] = $xml->at_LIST->children(); }
		
		foreach($types as $type) {
			
			foreach ($type as $key => $timer) {
				
				$name = (string) $timer->attributes()->name;
				$state = (string) $timer->attributes()->state;
				
				// INT Array abfragen, wenn welche vorhanden
				if(!count($timer->INT) == 0){
					foreach($timer->INT as $INT) {
						if($INT->attributes()->key == 'DEF'){ $definition = (string) $INT->attributes()->value; }
						if($INT->attributes()->key == 'TRIGGERTIME_FMT'){ $triggertime = (string) $INT->attributes()->value; }
					}
				}
				
				// ATTR Array abfragen, wenn welche vorhanden
				if(!count($timer->ATTR) == 0){
					foreach($timer->ATTR as $ATTR) {
						if($ATTR->attributes()->key == 'room'){ $room = (string) $ATTR->attributes()->value; }
						
					}
				}
				
				// Wenn einige Werte nicht gefunden wurden, werden diese gefüllt.
				if (!isset($room)) $room = 'unassigned';
				if (!isset($definition)) $definition = '';
				if (!isset($triggertime)) $triggertime = '';
							
				$tim[$key][] = array(
					"name"      	=> $name,
					"state"     	=> $state,
					"definition"    => $definition,
					"triggertime"	=> $triggertime,
					"room"			=> $room);
				
			}
			
		}
		
		ksort($tim);
		return $tim;
		
	}
	
	// Gibt den Namen der aktuellen Logdatei wieder
    static function getLogName($xmllist) {
    	$xml = simplexml_load_string($xmllist);
    	$currentlogfile = '';
    	$INTs = $xml->Global_LIST->Global->INT;
    	foreach ($INTs as $INT) {
    		if($INT->attributes()->key == 'currentlogfile'){
    			$currentlogfile = (string) $INT->attributes()->value;
    		}
    	}
    	$currentlogfile = end(preg_split("*/*", $currentlogfile));
    	return $currentlogfile;
    }

} // end class fhem

?>