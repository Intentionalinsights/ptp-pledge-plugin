<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-31
 */

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
