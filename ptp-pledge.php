<?php
/*
* Plugin Name: Pro-Truth Pledge Form
* Description: Shortcode [ptppledge] will display the pledge form.
* Version: 1.0
* Author: Bentley Davis
* Author URI: https://BentleyDavis.com
*/


// $wpdb is in scope
$config       = require "config.php";
$googleApiKey = $config['googleApiKey'];

$pledgeTable          = $wpdb->prefix . "ptp_pledges";
$pledgeDivisionsTable = $wpdb->prefix . "ptp_pledgeDivisions";


$templatesDir = __DIR__ . "/templates/";

foreach (glob(__DIR__ . "/functions/*.php") as $file) {
    include_once($file);
}

foreach (glob(__DIR__ . "/shortcodes/*.php") as $file) {
    include_once($file);
}
