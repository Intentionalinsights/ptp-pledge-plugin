<?php
/*
* Plugin Name: Pro-Truth Pledge Form
* Description: Shortcode [ptppledge] will display the pledge form.
* Version: 1.0
* Author: Bentley Davis
* Author URI: https://BentleyDavis.com
*/


// $wpdb is in scope

$pledgeTable          = $wpdb->prefix . "ptp_pledges";
$pledgeDivisionsTable = $wpdb->prefix . "ptp_pledgeDivisions";


foreach (glob("functions/*.php") as $file) {
    include_once($file);
}

foreach (glob("shortcodes/*.php") as $file) {
    include_once($file);
}



































function plugin_activated() {
    global $wpdb;
    $pledgeTable = $wpdb->prefix . "ptp_pledges";
    $pledgeDivisionsTable = $wpdb->prefix . "ptp_pledgeDivisions";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    //******************** Be sure to remove drop tables after initial run
/* 	$wpdb->query("DROP TABLE $pledgeDivisionsTable");
    $wpdb->query("DROP TABLE $pledgeTable");
 */
    // creates table in database if not exists
    $charset_collate = $wpdb->get_charset_collate();
    dbDelta ( "CREATE TABLE IF NOT EXISTS $pledgeTable (
        `pledgeId` mediumint(9) NOT NULL AUTO_INCREMENT,
        `key` varchar(40) NULL,
        `category` text NULL,
        `step` text NULL,
        `show` bool NOT NULL DEFAULT 0,
        `fName` text NULL,
        `lName` text NULL,
        `groupName` text NULL,
        `email` text NULL,
        `volunteer` bool NULL,
        `emailList` bool NULL,
        `directory` bool NULL,
        `emailAlerts` bool NULL,
        `textAlerts` bool NULL,
        `repNudge` bool NULL,
        `address1` text NULL,
        `address2` text NULL,
        `city` text NULL,
        `region` text NULL,
        `zip` text NULL,
        `country` text NULL,
        `orgs` text NULL,
        `phone` text NULL,
        `description` text NULL,
        `imageUrl` text NULL,
        `linkText1` text NULL,
        `linkUrl1` text NULL,
        `linkText2` text NULL,
        `linkUrl2` text NULL,
        `linkText3` text NULL,
        `linkUrl3` text NULL,
        `addressValidated` bool NULL,
        `vaddress1` text NULL,
        `vaddress2` text NULL,
        `vaddress3` text NULL,
        `vcity` text NULL,
        `vregion` text NULL,
        `vzip` text NULL,
        `vcountry` text NULL,
        `latLongPulled` bool NULL,
        `lat` text FLOAT(10,6) NULL,
        `lng` text FLOAT(10,6) NULL,
        `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `edited` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`pledgeId`)
    ) $charset_collate;
    ");
/*
    dbDelta ( "CREATE TABLE IF NOT EXISTS $pledgeDivisionsTable (
        `pledgeId` mediumint(9) NOT NULL,
        `divisionId` VARCHAR(191) NOT NULL,
        `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `edited` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (pledgeId, divisionId),
        FOREIGN KEY  (pledgeId) REFERENCES $pledgeTable(pledgeId)
    ) $charset_collate;
    ");
 */

    //********************** Add old records be sure to remove
/* 	$result = $wpdb->get_results ( "
        SELECT ID, post_date
        FROM `wp_ei4xkg_posts`
        where `post_type` = 'nf_sub' AND `post_status` = 'publish'
        ORDER BY ID
    ");

    foreach ( $result as $row ) {
        $meta = get_post_meta($row->ID);

        $catText = $meta["_field_25"][0];
        if (strpos($catText, 'official') !== false && strpos($catText, 'staff') === false){
            $category = "Official";
        } elseif (strpos($catText, 'figure')!==false && strpos($catText, 'staff') === false){
            $category = "Figure";
        } elseIf (strpos($catText, 'organization')!==false && strpos($catText, 'staff') === false){
            $category = "Group";
        } else {
            $category = "Public";
        }

        $dbResult = $wpdb->insert(
            $pledgeTable,
            array(
                'key' => $row->ID,
                'fName' => $meta["_field_11"][0],
                'lName' => $meta["_field_12"][0],
                'email' => $meta["_field_13"][0],
                'phone' => $meta["_field_14"][0],
                'address1' => $meta["_field_27"][0],
                'address2' => $meta["_field_28"][0],
                'city' => $meta["_field_29"][0],
                'region' => $meta["_field_30"][0],
                'zip' => $meta["_field_31"][0],
                'country' => $meta["_field_32"][0],
                'orgs' => $meta["_field_41"][0],
                'repNudge' => $meta["_field_34"][0],
                'linkUrl1' => $meta["_field_35"][0],
                'volunteer' => $meta["_field_39"][0],
                'emailList' => strpos($meta["_field_24"][0], 'infrequent-email')!==false,
                'emailAlerts' => strpos($meta["_field_24"][0], 'email-action')!==false,
                'textAlerts' => strpos($meta["_field_24"][0], 'text-action')!==false,
                'category' => $category,
                'imageUrl' => $meta["_field_40"][0],
                'description' => $meta["_field_33"][0],
                'created' => $row->post_date,
            )
        );
        if ($dbResult === false){
            trigger_error(var_dump($wpdb->last_query) ,E_USER_ERROR);
        }
    }
 */

    }
register_activation_hook( __FILE__, 'plugin_activated' );





function pledgerSocialMediaLinkFields( ) {

    ob_start(); ?>

        <div class="row">
            <div class="form-group col-sm-6">
                <label for="linkText1">Text 1</label>
                <input name="linkText1" id="linkText1" placeholder="Facebook" class="form-control" value="Facebook">
            </div>
            <div class="form-group col-sm-6">
                <label for="linkUrl1">link 1</label>
                <input name="linkUrl1" id="linkUrl1" placeholder="https://www.facebook.com/userName" class="form-control" value="https://www.facebook.com/">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="linkText2">Text 2</label>
                <input name="linkText2" id="linkText2" placeholder="LinkedIn" class="form-control" value="LinkedIn">
            </div>
            <div class="form-group col-sm-6">
                <label for="linkUrl2">link 2</label>
                <input name="linkUrl2" id="linkUrl2" placeholder="https://www.linkedin.com/in/userName" class="form-control" value="https://www.linkedin.com/in/">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="linkText3">Text 3</label>
                <input name="linkText3" id="linkText3" placeholder="My Website" class="form-control">
            </div>
            <div class="form-group col-sm-6">
                <label for="linkUrl3">link 3</label>
                <input name="linkUrl3" id="linkUrl3" placeholder="https://example.com" class="form-control" value="http://">
            </div>
        </div>
    <?php $html = ob_get_clean();
    return $html;
}






/**
 * Take a WPDB query result and display it as a table, with headers from data keys.
 * This example only works with ARRAY_A type result from $wpdb query.
 * @param  array                $db_data Result from $wpdb query
 * @return bool                          Success, outputs table HTML
 * @author Tim Kinnane <tim@nestedcode.com>
 * @link   http://nestedcode.com
 */
function data_table( $db_data ) {
    if ( !is_array( $db_data) || empty( $db_data ) ) return false;
    // Get the table header cells by formatting first row's keys
    $header_vals = array();
    $keys = array_keys( $db_data[0] );
    foreach ($keys as $row_key) {
        $header_vals[] = ucwords( str_replace( '_', ' ', $row_key ) ); // capitalise and convert underscores to spaces
    }
    $header = "<thead><tr><th>" . join( '</th><th>', $header_vals ) . "</th></tr></thead>";
    // Make the data rows
    $rows = array();
    foreach ( $db_data as $row ) {
        $row_vals = array();
        foreach ($row as $key => $value) {
            // format any date values properly with WP date format
            if ( strpos( $key, 'date' ) !== false || strpos( $key, 'modified' ) !== false ) {
                $date_format = get_option( 'date_format' );
                $value = mysql2date( $date_format, $value );
            }
            $row_vals[] = $value;
        }
        $rows[] = "<tr><td>" . join( '</td><td>', $row_vals ) . "</td></tr>";
    }
    // Put the table together and output
    return '<table  class="table">' . $header . '<tbody>' . join( $rows ) . '</tbody></table>';
    //return true;
}






















function validateAddress() {
    global $wpdb;
    $pledgeTable = $wpdb->prefix . "ptp_pledges";
    $pledgeDivisionsTable = $wpdb->prefix . "ptp_pledgeDivisions";

    $result = $wpdb->get_results ( "
        SELECT *
        FROM $pledgeTable
        WHERE addressValidated IS NULL
        LIMIT 10
    ");
    //addressValidated = null

    foreach ( $result as $row )
    {
        echo "{{" . $row->pledgeId . "}}";
        //echo var_dump($row->addressValidated);




        //Get normalized Address from google
        $url = "https://www.googleapis.com/civicinfo/v2/representatives?key=******&address="
        . urlencode (
            $row->address1
            . " "
            .$row->address2
            . " "
            . $row->city
            . ", "
            . $row->region
            . " "
            . $row->zip
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $civicJson = curl_exec($ch);
        curl_close($ch);
        //echo $url;


        $data = array(
            'addressValidated' => '1',
        );

        if (substr($civicJson, 0, 1) == "{" && substr($civicJson,0,10) != '{ "error":'){
            $civic = json_decode($civicJson);
            if ($civic->normalizedInput != null) {
                $data += ['vaddress1' => $civic->normalizedInput->line1];
                $data += ['vaddress2' => $civic->normalizedInput->line2];
                $data += ['vaddress3' => $civic->normalizedInput->line3];
                $data += ['vcity' => $civic->normalizedInput->city];
                $data += ['vregion' => $civic->normalizedInput->state];
                $data += ['vzip' => $civic->normalizedInput->zip];
                $data += ['vcountry' => 'USA'];
            } else {
                unset($civic);
            }
        }

        //Save Data
        $dbResult = $wpdb->update(
            $pledgeTable,
            $data,
            array(
                'pledgeId' => $row->pledgeId,
            )
        );
/*		echo "{{" . $row->pledgeId . "}}<br>";
        echo "{{" . $row->addressValidated . "}}";
        if ($dbResult === false){
            echo var_dump($wpdb->last_query."||".var_dump($data));
        } */

        if (isset($civic)) {

            foreach ( $civic->divisions as $key => $division ) {
                // ToDo: Make updates happen
                $wpdb->insert(
                    $pledgeDivisionsTable,
                    array(
                        'pledgeId' => $row->pledgeId,
                        'divisionId' => $key,
                    )
                );
            }
        }
    }
}



function latLongPull() {
    global $wpdb;
    $pledgeTable = $wpdb->prefix . "ptp_pledges";

    $result = $wpdb->get_results ( "
        SELECT *
        FROM $pledgeTable
        WHERE latLongPulled IS NULL
        AND (city > '' or zip >'')
        LIMIT 10
    ");
    echo "<br>{{lat-long}}";
    //echo var_dump($result);

    foreach ( $result as $row )
    {
        echo "{{" . $row->pledgeId . "}}";
        //Get Lat Long google
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=******&address="
        . urlencode (
            // $row->address1
            // . " "
            // .$row->address2
            $row->city
            . ", "
            . $row->region
            . " "
            . $row->zip
            . " "
            . $row->country
            );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $googleJson = curl_exec($curl);
        curl_close($curl);

        //echo "{{url:".$url."}}";
        //echo var_dump($googleJson);

        $data = array(
            'latLongPulled' => '1',
        );

        if (substr($googleJson, 0, 1) == "{" && substr($googleJson,0,10) != '{ "error":'){
            $googleResult = json_decode($googleJson);
            $location = $googleResult->results[0]->geometry->location;
            // echo "{{lat:";
            // echo var_dump($location);
            // echo "}}";
            if ($location != null) {
                $data += ['lat' => $location->lat];
                $data += ['lng' => $location->lng];
            }
        }

        //Save Data
        $dbResult = $wpdb->update(
            $pledgeTable,
            $data,
            array(
                'pledgeId' => $row->pledgeId,
            )
        );
/*		echo "{{" . $row->pledgeId . "}}<br>";
        echo "{{" . $row->addressValidated . "}}";
        */
/* 		if ($dbResult === false){
            echo var_dump($wpdb->last_query."||".var_dump($data));
        }  */
    }
}



function ptpRegionCount( ) {
    global $wpdb;
    $pledgeTable = $wpdb->prefix . "ptp_pledges";

    $result = $wpdb->get_results ( "
        SELECT (CASE ISNULL(vRegion) WHEN 1 THEN region ELSE vRegion END) as region,
            (CASE ISNULL(vCountry) WHEN 1 THEN country ELSE vCountry END) as country,
            COUNT(1) as counter
        FROM `wp_ei4xkg_ptp_pledges` 
        GROUP BY (CASE ISNULL(vRegion) WHEN 1 THEN region ELSE vRegion END),
            (CASE ISNULL(vCountry) WHEN 1 THEN country ELSE vCountry END)
        LIMIT 5
    ");

    foreach ( $result as $row )
    {
        //Get Lat Long google
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=******&address="
        . urlencode (
            $row->region
            . " "
            . $row->country
            );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $googleJson = curl_exec($curl);
        curl_close($curl);

        if (substr($googleJson, 0, 1) == "{" && substr($googleJson,0,10) != '{ "error":'){
            $googleResult = json_decode($googleJson);
            $location = $googleResult->results[0]->geometry->location;
            // echo "{{lat:";
            // echo var_dump($googleResult);
            // echo "}}";
            if (!empty($location->lat)){
                $out .= "{position:";
                $out .= "{lat: " . $location->lat . ", lng: " . $location->lng ."},";
                $out .= "title: '" . $row->counter . "'},";
            }
        }
    }
    return $out;
}


