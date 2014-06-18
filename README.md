Simple-FHEM-Frontend
====================

## What is this repository for? ##

Simple FHEM Frontend is an open source frontend for the fhem home automation system, built with PHP+MySQL (Server), HTML5, Bootstrap, jQuery, Morris.js, Font Awesome (Frontend).

Please not that this project is still under development and far from being a productive version!

## Features ##

* Login Page mit Validation
* Bootstrap mit Untersützung für Mobile Devices
* Get/Set Device States
* List Rooms
* List Devices

## Planned features ##

* get/Set Timer
* temperature graphs
* weather page
* energy monitoring
* OS information (realtime)

## Requirements ##

* MySQL
* PHP 5.5+
* Webserver (Apache2, nginx)
* a fully configured FHEM Server

## Setup ##

### Database configuration ###
Import the install.sql to your MySQL Database. There will be a default user in the users table with the username and passwort "admin".

Furthermore, you need to edit the /includes/config.inc.php and fill in your database connection credentials.

```
/* ********************** */
/* -  DB Konfiguration 	- */
/* ********************** */

const DB_HOST 		= 'localhost';
const DB_USER 		= 'youruser';
const DB_PASS 		= 'yourpassword';
const DB_NAME 		= 'yourdatabasename';
const DB_PORT		= 3306;
```

## Development platform ##

* Raspberry Pi running Debian jessie minimal
* FHEM 5.5
* Stacked SCC 433Mhz + 868Mhz
* nginx
* PHP 5.6 Beta
* MySQL 5
* Bootstrap 3.1.1
