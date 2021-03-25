<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-30
 */

if (!defined(SAFE_HTML_FLAGS)) {
    define('SAFE_HTML_FLAGS', ENT_COMPAT | ENT_HTML401);
}

if (!defined(SAFE_HTML_CHARSET)) {
    define('SAFE_HTML_CHARSET', ini_get('default_charset'));
}

if (!function_exists('safe_html')) {

    function safe_html($content) {
        return htmlspecialchars($content, SAFE_HTML_FLAGS, SAFE_HTML_CHARSET, false);
    }

}

if (!function_exists("public_figures_shortcode")) {

    function public_figures_shortcode($atts, $content = "") {
        global $wpdb;
        global $pledgeTable;

        $result = $wpdb->get_results ( "
            SELECT fName, lName, groupName, prominent, category, pledgeId
            FROM $pledgeTable
            WHERE (category='Official'
            OR category='Group'
            OR category='Figure')
            and `show` = true
            ORDER BY prominent DESC, created DESC
        ");

        $publicFigures = [];

        foreach ( $result as $row )
        {
            $figure = [
                'name'        => ($row->groupName) ? $row->groupName : $row->fName . ' ' . $row->lName,
                'prominent'   => (bool) $row->prominent,
                'category'    => $row->category,
                'pledgeId'    => $row->pledgeId
            ];
            $publicFigures[] = $figure;
        }

        ob_start();

        include __DIR__ . '/../templates/publicFigures.php';

        $html = ob_get_clean();

        return $html;
    }
}

add_shortcode('publicFigures', 'public_figures_shortcode');
