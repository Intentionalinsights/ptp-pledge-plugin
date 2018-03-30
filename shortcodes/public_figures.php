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

        $html = "";
        ob_start(); ?><Style>img.pFImage {max-width: 400px; width: auto; height: auto; max-height: 100px; float: left; padding-right: 5px;}</Style><?php $html .= ob_get_clean();

        foreach ( $result as $row )
        {
            ob_start(); ?>
            <div class='publicFigure'>
                <?php
                if (empty($row->groupName)){
                    echo "<h3>".$row->fName." ".$row->lName."</h3>";
                } else {
                    echo "<h3>".$row->groupName."</h3>";
                }
                if (substr( $row->linkUrl1, 0, 4 ) === "http" && strpos($row->linkUrl1, ' ') == false){
                    echo "<a class='figureLink' href='" . $row->linkUrl1 . "'>". $row->linkText1 ."</a>";
                }
                if (substr( $row->linkUrl2, 0, 4 ) === "http" && strpos($row->linkUrl1, ' ') == false){
                    echo "<a class='figureLink' href='" . $row->linkUrl2 . "'>". $row->linkText2 ."</a>";
                }
                if (substr( $row->linkUrl3, 0, 4 ) === "http" && strpos($row->linkUrl1, ' ') == false){
                    echo "<a class='figureLink' href='" . $row->linkUrl3 . "'>". $row->linkText3 ."</a>";
                }
                if (substr( $row->imageUrl, 0, 4 ) === "http" && strpos($row->linkUrl1, ' ') == false){
                    echo "<br/><img class='pFImage' src='" . $row->imageUrl . "'>";
                }				?>
                <p class='figureDescription'><?php echo $row->description ?></p>
            </div>
            <div style="clear:both;"></div>
            <?php $html .= ob_get_clean();
        }
        return $html;

        //return $output;
    }
}

add_shortcode('publicFigures', 'public_figures_shortcode');
