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


foreach (glob("functions/*.php") as $file) {
    include_once($file);
}

foreach (glob("shortcodes/*.php") as $file) {
    include_once($file);
}



































function plugin_activated() {
    global $wpdb;
    global $pledgeTable;
    global $pledgeDivisionsTable;

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



















function validateAddress() {
    global $wpdb;

    global $googleApiKey;
    global $pledgeTable;
    global $pledgeDivisionsTable;

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
        $url = "https://www.googleapis.com/civicinfo/v2/representatives?key={$googleApiKey}&address="
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

    global $googleApiKey;
    global $pledgeTable;


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
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key={$googleApiKey}&address="
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

    global $googleApiKey;
    global $pledgeTable;

    $result = $wpdb->get_results ( "
        SELECT (CASE ISNULL(vRegion) WHEN 1 THEN region ELSE vRegion END) as region,
            (CASE ISNULL(vCountry) WHEN 1 THEN country ELSE vCountry END) as country,
            COUNT(1) as counter
        FROM $pledgeTable 
        GROUP BY (CASE ISNULL(vRegion) WHEN 1 THEN region ELSE vRegion END),
            (CASE ISNULL(vCountry) WHEN 1 THEN country ELSE vCountry END)
        LIMIT 5
    ");

    foreach ( $result as $row )
    {
        //Get Lat Long google
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key={$googleApiKey}&address="
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


