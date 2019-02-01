<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-31
 */

function latLongPull() {
    global $wpdb;

    global $googleApiKey;
    global $pledgeTable;


    $result = $wpdb->get_results ( "
        SELECT *
        FROM $pledgeTable
        WHERE latLongPulled IS NULL
        AND (city > '' or zip >'')
        ORDER BY pledgeId  DESC
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
