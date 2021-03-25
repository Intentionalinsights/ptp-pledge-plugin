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

if (!function_exists("public_figure_shortcode")) {

    function public_figure_shortcode($atts, $content = "") {
        $pledgeId = $_GET['pledgeId'];
        global $wpdb;
        global $pledgeTable;

        $result = $wpdb->get_results ( "
            SELECT *
            FROM $pledgeTable
            WHERE (category='Official'
            OR category='Group'
            OR category='Figure')
            and `show` = true
            and pledgeId = $pledgeId
            ORDER BY prominent DESC, created DESC
            LIMIT 1000
        ");

        $publicFigures = [];

        foreach ( $result as $row )
        {
            $figure = [
                'name'        => ($row->groupName) ? $row->groupName : $row->fName . ' ' . $row->lName,
                'prominent'   => (bool) $row->prominent,
                'category'    => $row->category,
                'description' => $row->description,
                'links'       => [],
                'imageUrl'    => filter_var($row->imageUrl, FILTER_VALIDATE_URL),
            ];

            $url1 = filter_var($row->linkUrl1, FILTER_VALIDATE_URL);
            if ($url1) {
                $figure['links'][] = [
                    'url'  => $url1,
                    'text' => $row->linkText1,
                ];
            }

            $url2 = filter_var($row->linkUrl2, FILTER_VALIDATE_URL);
            if ($url2) {
                $figure['links'][] = [
                    'url'  => $url2,
                    'text' => $row->linkText2,
                ];
            }

            $url3 = filter_var($row->linkUrl3, FILTER_VALIDATE_URL);
            if ($url3) {
                $figure['links'][] = [
                    'url'  => $url3,
                    'text' => $row->linkText3,
                ];
            }

            $publicFigures[] = $figure;
        }

        ob_start();

        include __DIR__ . '/../templates/publicFigure.php';

        $html = ob_get_clean();

        return $html;
    }
}

add_shortcode('publicFigure', 'public_figure_shortcode');
