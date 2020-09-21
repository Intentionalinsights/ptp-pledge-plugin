<?php
/**
 * @author      Bentley davis
 * @copyright   2020 Intentional Insights
 * @since       2020-09-21
 */

function addToEmailList($user_email, $user_fname, $user_lname) {
    global $emailApiKey;
    global $emailApiServer;
    global $emailListId;
 
    $url = "https://{$emailApiServer}.api.mailchimp.com/3.0/lists/{$emailListId}/members";
    $date = date("m/d/y");

    $body = "{
        \"email_address\": \"$user_email\",
        \"status\": \"subscribed\",
        \"merge_fields\": {
            \"FNAME\": \"$user_fname\",
            \"LNAME\": \"$user_lname\",
            \"MMERGE6\": \"$date\"
        }
        }";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,            $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST,           true );
    curl_setopt($curl, CURLOPT_POSTFIELDS,     $body ); 
    curl_setopt($curl, CURLOPT_HTTPHEADER,     array('content-type: application/json'));
    curl_setopt($curl, CURLOPT_USERPWD, "key:{$emailApiKey}");
    $result = curl_exec($curl);
    curl_close($curl);

    // echo "<div style=\"display:none;\">";
    // echo ":url:".$url;
    // echo ":body:".var_dump($body);
    // echo ":result:".var_dump($result);
    // echo "</div>";
} 