<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-31
 */

function validateAddress() {
    global $wpdb;

    global $googleApiKey;
    global $pledgeTable;
    global $pledgeDivisionsTable;

    $result = $wpdb->get_results ( "
        SELECT *
        FROM $pledgeTable
        WHERE addressValidated IS NULL
        ORDER BY pledgeId  DESC
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
