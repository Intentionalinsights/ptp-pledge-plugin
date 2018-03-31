<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-31
 */

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
