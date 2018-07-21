<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-30
 */

if (!function_exists("public_figures_shortcode")) {

    function public_figures_shortcode($atts, $content = "") {
        global $wpdb;
        global $pledgeTable;

        $result = $wpdb->get_results ( "
            SELECT *
            FROM $pledgeTable
            WHERE (category='Official'
            OR category='Group'
            OR category='Figure')
            and `show` = true
            ORDER BY created DESC
        ");

        $publicFigures = [];

        foreach ( $result as $row )
        {
            $figure = [
                'name'        => ($row->groupName) ? $row->groupName : $row->fName . ' ' . $row->lName,
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

add_shortcode('publicFigures', 'public_figures_shortcode');
