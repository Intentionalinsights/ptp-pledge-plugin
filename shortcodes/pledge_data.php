<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-30
 */

if (!function_exists("pledge_data")) {

    function pledge_data($atts, $content = "") {
        global $wpdb;
        global $pledgeTable;
        global $pledgeDivisionsTable;

        $limit = 5;
        if (isset($_GET['limit'])) {
            $limit = (int) $_GET['limit'];
        }

        $query1 = $wpdb->get_results ( "
            SELECT *
            FROM $pledgeTable
            ORDER BY created DESC
            LIMIT $limit
        ", ARRAY_A);

//        $query2 = $wpdb->get_results ( "
//            SELECT *
//            FROM $pledgeDivisionsTable
//            ORDER BY edited DESC
//            LIMIT 5
//        ", ARRAY_A);

        ob_start(); ?>
        <br>
        Pledges: <?php echo do_shortcode('[pledgecount]'); ?><br>
        Public: <?php echo do_shortcode('[publiccount]'); ?><br>
        Officials: <?php echo do_shortcode('[officialscount]'); ?><br>
        Public Figures: <?php echo do_shortcode('[figurescount]'); ?><br>
        Groups: <?php echo do_shortcode('[organizationscount]'); ?><br>
        <?php
        echo data_table( $query1 );
        //echo data_table( $query2 );

        //echo ptpRegionCount()
        ?>
        </div>
        <?php $html = ob_get_clean();

        //validateAddress();
        //latLongPull();

        //return "";
        return $html;
    }

}

add_shortcode('pledge_data', 'pledge_data');
