<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-30
 */

if (!function_exists("organizations_count_shortcode")) {

    function organizations_count_shortcode($atts, $content = "") {
        global $wpdb;
        global $pledgeTable;

        $user_count = $wpdb->get_var("SELECT count(1) FROM $pledgeTable WHERE category='Group'");

        return $user_count;
    }

}

add_shortcode('organizationscount', 'organizations_count_shortcode');
