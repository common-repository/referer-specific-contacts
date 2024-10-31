<?php
/*
Plugin Name: Referer Specific Contact
Plugin URI:
Description: Referer Specific Contact plugin allows to show different contact details based on the user's referer. Using this plugin you can show a different contact details to users coming from Google search or from social networks.
Version: 1.0
Author: Software Associates
Author URI: http://www.softwareassociates.in/
License: GPLv2
*/

defined('ABSPATH') or die("No script kiddies please!");

if ( ! defined('REFERER_SPECIFIC_CONTCT_FILE')) {
    define('REFERER_SPECIFIC_CONTCT_FILE', __FILE__);
}

if (is_admin()) {
    include_once dirname(REFERER_SPECIFIC_CONTCT_FILE) . '/admin/class.options.php';
} else {
    include_once dirname(REFERER_SPECIFIC_CONTCT_FILE) . '/front-end/class.shortcodes.php';
}