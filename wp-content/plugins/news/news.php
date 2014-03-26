<?php
/*
Plugin Name: Volcano News Plugin
Plugin URI: N/A
Description: A simple customized Post
Version: 0.1
Author: Hainp
Author URI: http://
License: GPL2 or later
*/

/*  Copyright 2014  Hainp  (email : hai.nguyen@volcano.vn)

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

if(!class_exists('News_Plugin')) {
    class News_Plugin {
        /**
         * Construct the plugin object
         */
        public function __construct() {
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'add_menu'));
        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate() {

        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate() {

        } // END public static function deactivate
    } // END class News_Plugin
} // END if(!class_exists('News_Plugin'))

if(class_exists('News_Plugin')) {
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('News_Plugin', 'activate'));
    register_deactivation_hook(__FILE__, array('News_Plugin', 'deactivate'));

    // instantiate the plugin class
    $news_plugin = new News_Plugin();
}

?>
