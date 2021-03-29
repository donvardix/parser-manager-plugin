<?php
/*
Plugin Name: Parser Manager
Description: Parser Manager
Author: donvardix
Text Domain: parser-manager-plugin
Domain Path: /languages
Version: 1.0.0
Author URI: https://github.com/donvardix
License: GPLv2 or later
*/

/*  © Copyright 2021

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Parser_Manager') ) {

class Parser_Manager {

	function __construct() {
		require_once 'includes/class-parser.php';
		require_once 'includes/class-model.php';
		require_once 'includes/class-frontend-settings.php';
		require_once 'includes/class-plugin-settings.php';
	}



}

new Parser_Manager();

} // class_exists check