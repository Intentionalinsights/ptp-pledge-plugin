<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-30
 */

if (!function_exists("rep_count_shortcode")) {

    function rep_count_shortcode($atts, $content = "") {

        global $wpdb;
        global $pledgeDivisionsTable;

        global $googleApiKey;

        ob_start();

        if (!empty($_GET['address'])) {
            //Get normalized Address from google
            $url = "https://www.googleapis.com/civicinfo/v2/representatives?key={$googleApiKey}&address="
                . urlencode ( $_GET['address']	);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $civicJson = curl_exec($ch);
            curl_close($ch);



            if (substr($civicJson, 0, 1) == "{" && substr($civicJson,0,10) != '{ "error":'){
                $civic = json_decode($civicJson);
                if ($civic->normalizedInput != null) {



                    foreach ( $civic->offices as $office ){
                        $where .= "DivisionId = '" . $office->divisionId . "' OR ";
                    }
                    $where = substr($where, 0, -3);

                    $query = $wpdb->get_results("
                        SELECT DivisionId, COUNT(DivisionId) as PledgeCount
                        FROM $pledgeDivisionsTable
                        WHERE $where
                        GROUP BY DivisionId
                        LIMIT 5
                    ", ARRAY_A);

                    //echo data_table( $query );

                    //build PledgeCount dictionary
                    $divisionPledgeCountDict = [];
                    foreach ( $query as $row){
                        $divisionPledgeCountDict[$row["DivisionId"]] = $row["PledgeCount"];
                        //var_dump($row["DivisionId"])."--";
                    }

                    //var_dump($divisionPledgeCountDict);

                    //Put Office on Official
                    foreach ( $civic->offices as $office){
                        foreach ( $office->officialIndices as $oi){
                            $civic->officials[$oi]->{"office"} = $office;
                            $civic->officials[$oi]->{"pledgeCount"} = $divisionPledgeCountDict[$office->divisionId];
                            //echo $divisionPledgeCountDict[$office->divisionId]."**";
                            //var_dump($office->divisionId);
                        }
                    }

                    ?>
                    <h2>Number of pledge-takers per representative for <?php echo $_GET['address']; ?></h2>
                    <style>
                        .s_twitter:before{
                            content: '\f202';
                            font: normal 18px/1 social-logos;
                        }
                        .s_facebook:before{
                            content: '\f203';
                            font: normal 18px/1 social-logos;
                        }
                        .s_youtube:before{
                            content: '\f213';
                            font: normal 18px/1 social-logos;
                        }
                        .s_link{
                            font-weight: 900;
                            font-size: 18px;
                        }
                    </style>
                    <script> //Twitter tweet button
                        window.twttr = (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0],
                                t = window.twttr || {};
                            if (d.getElementById(id)) return t;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "https://platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);

                            t._e = [];
                            t.ready = function(f) {
                                t._e.push(f);
                            };

                            return t;
                        }(document, "script", "twitter-wjs"));
                    </script>
                    <div class="row"><?php

                        foreach ( $civic->officials as $rep ) {
                            ?>
                            <div class="col-sm-4 col-lg-3" style="position: relative;margin-bottom:20px">
                                <div  style="background-image: url('<?php echo $rep->photoUrl; ?>');
                                        display: inline-block;
                                        width: 100px;
                                        height: 100px;
                                        border: 1px solid lightgray;
                                        background-position: 50% 20%;
                                        background-size: cover;
                                        margin: 0;
                                        float:left;
                                        background-color: #eeeeee;
                                        margin-right: 4px; position: relative;">
                                    <div style="font-size: 20px; min-height: 28px; background: linear-gradient(to bottom, #00000000 1%,#0007 100%); color: white; position: absolute; bottom: 0; text-align: right; font-weight: 900; width:100%; text-shadow: black 0 0 5px; padding: 5px 0 0 5px;"><?php echo  $rep->pledgeCount; ?>&nbsp;</div>
                                </div>
                                <div style="position: relative; height: 100px; margin-left: 110px;">
                                    <div style="position: absolute; bottom: 0">

                                        <?php
                                        //Click to tweet
                                        if (isset($rep->channels)){
                                            foreach ($rep->channels as $channel) {
                                                if ($channel->type == "Twitter") {
                                                    ?>
                                                    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-text="I took the #ProTruthPledge at https://ProTruthPledge.org because I value #truth and #facts and I ask my representative @<?php echo  $channel->id; ?> to join me in taking @ProTruthPledge and showing that #TruthMatters and #FactsMatter to them" data-show-count="false" data-url="https://ProTruthPledge.org">Tweet</a>

                                                    <br>
                                                    <?php
                                                }
                                            }
                                        }

                                        //Loop through channels
                                        if (isset($rep->channels)){
                                            foreach ($rep->channels as $channel) {
                                                if ($channel->type == "Twitter") {
                                                    ?>
                                                    <a class="s_twitter" href="https://twitter.com/<?php echo  $channel->id; ?>" target="_blank"></a>
                                                    <?php
                                                } elseif ($channel->type == "Facebook") {
                                                    ?>
                                                    <a class="s_facebook" href="https://facebook.com/<?php echo  $channel->id; ?> target="_blank""></a>
                                                    <?php
                                                } elseif ($channel->type == "YouTube") {
                                                    ?>
                                                    <a class="s_youtube" href="https://www.youtube.com/user/<?php echo  $channel->id; ?>" target="_blank"></a>
                                                    <?php
                                                }
                                            }
                                        }

                                        //Loop through urls
                                        if (isset($rep->urls)){
                                            foreach ($rep->urls as $link) {
                                                ?>
                                                <a class="s_link" href="<?php echo  $link; ?>" target="_blank">W</a>
                                                <?php
                                            }
                                        }

                                        ?>
                                        <div style="font-weight: bolder;"><?php echo $rep->name; ?></div>
                                        <div style="font-size: smaller;"><?php echo $rep->office->name; ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?><div style="clear:both;"></div>
                    </div class="row">

                    <br>
                    <br><?php
                }
            }
        }

        ?>
        <form method="get">
            <div class="container">
                <div class="row">
                    <div class="form-group">
                        <label for="address">Enter a US address to find the number of pledge-takers per representative for this address</label>
                        <input type="text" name="address" id="address" class="form-control" autocomplete="address" value="<?php echo $_GET['address']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input type="submit" class="btn btn-primary" value="Search" >
                    </div>
                </div>
            </div>
        </form>
        <?php //echo $url; ?>
        <?php //var_dump($civicJson); ?>
        <?php $html .= ob_get_clean();
        return $html;

    }

}


add_shortcode('rep_count', 'rep_count_shortcode');
