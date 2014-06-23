# README #

Simple FHEM Frontend

## What is this repository for? ##

Simple FHEM Frontend is an open source frontend for the fhem home automation system, built with PHP+MySQL (Server), HTML5, Bootstrap, jQuery, Font Awesome (Frontend).

Live Preview (Login): http://r3xx0n.selfhost.eu

#### Please note that this project is still under development and far from being a productive version! ####
 
## Features ##

* login page with validation
* Bootstrap with support for mobile devices
* get/set device states
* list rooms
* list devices
* list timer
* OS information

## Planned features ##

* set timer
* temperature graphs
* weather page
* energy monitoring

## Requirements ##

* MySQL
* PHP 5.5+
* Webserver (Apache2 or nginx [recommended])
* a fully configured FHEM Server

## Setup ##

### Database configuration ###
Import the install.sql from /install/ to your MySQL Database. There will be a default user in the users table.

````
username: fhem
password: defaultuser
````

Furthermore, you need to edit the /includes/config.inc.php and fill in your database connection credentials.

```
#!php
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
