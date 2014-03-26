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

            include(sprintf("%s/post-types/news.php", dirname(__FILE__)));
            $News = new News();
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

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init() {
            // Set up the settings for this plugin
            $this->init_settings();
            // Possibly do additional admin_init tasks
        } // END public static function activate

        /**
         * Initialize some custom settings
         */
        public function init_settings() {
            // register the settings for this plugin
            register_setting('news_plugin-group', 'setting_a');
            register_setting('news_plugin-group', 'setting_b');
        } // END public function init_custom_settings()

        /**
         * add a menu
         */
        public function add_menu() {
            add_options_page('News Plugin Settings', 'News Plugin', 'manage_options', 'wp_plugin_template', array(&$this, 'plugin_settings_page'));
        } // END public function add_menu()

        /**
         * Menu Callback
         */
        public function plugin_settings_page() {
            // if(!current_user_can('manage_options')) {
            //    wp_die(__('You do not have sufficient permissions to access this page.'));
            // }

            // Render the settings template
            include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()

    } // END class News_Plugin
} // END if(!class_exists('News_Plugin'))

if(class_exists('News_Plugin')) {
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('News_Plugin', 'activate'));
    register_deactivation_hook(__FILE__, array('News_Plugin', 'deactivate'));

    // instantiate the plugin class
    $news_plugin = new News_Plugin();
    // Add a link to the settings page onto the plugin page

    if(isset($news_plugin)) {
    // Add the settings link to the plugins page
        function plugin_settings_link($links) {
            $settings_link = '<a href="options-general.php?page=news">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
        }

        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
    }
}

?>
