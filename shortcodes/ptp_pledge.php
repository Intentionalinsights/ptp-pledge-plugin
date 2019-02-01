<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since       2018-03-30
 */

if (!function_exists("ptp_pledge")) {

    function ptp_pledge($atts, $content = "") {

        global $wpdb;
        global $pledgeTable;
        global $pledgeDivisionsTable;

        global $templatesDir;

        $step     = $_POST["step"] ;
        $key      = $_POST["key"] ;
        $pledgeId = $_POST["pledgeId"] ;
        $toStep   = "Start";
        $category = $_POST["category"];

        // Receive data for "Start" step
        if ( $step == "Start") {
            $key = base_convert(time(),10,36) . base_convert(mt_rand(1000,9999),10,36);

            $wpdb->insert(
                $pledgeTable,
                array(
                    'fName' => strip_tags($_POST["fName"], ""),
                    'lName' => strip_tags($_POST["lName"], ""),
                    'email' => strip_tags($_POST["email"], ""),
                    'volunteer' => isset($_POST['volunteer']),
                    'directory' => isset($_POST['directory']),
                    'emailList' => isset($_POST['emailList']),
                    'emailAlerts' => isset($_POST['emailAlerts']),
                    'category' => strip_tags($_POST["category"], ""),
                    'step' => strip_tags($_POST["step"], ""),
                    'key' => $key
                )
            );

            $pledgeId = $wpdb->insert_id;

            if ($category == "Public"){
                if (isset($_POST['volunteer'])){ //Violunteer
                    $emailSubject = $_POST["fName"] . " " . $_POST["lName"] . ", Thanks for Your Interest in Helping With the Pro-Truth Pledge";
                    ob_start(); ?>
                    <p>Dear <?php echo $_POST["fName"] . " " . $_POST["lName"]; ?>,</p>
                    <p></p>
                    <p>Thanks for taking the Pro-Truth Pledge (PTP) and I am glad that you indicated that <b>you want to help out with the pledge</b>, either when signing up online and leaving checking the box “I want to help with the Pro-Truth Pledge” or by signing up in person and marking the column in the sign-up sheet about helping out. If any of this was by mistake, and you did not intend to help out, please reply to this email to let me know and I will not bother you again!</p>
                    <p></p>
                    <p>You have already done something really important by taking the pledge, so thanks for that! Here are some <b><u>quick things you can do to fight lies and promote truth</b></u>: </p>
                    <p></p>
                    <ul>
                        <li>The first thing to do is post on social media about taking the pledge. You can use this Facebook <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2FProTruthPledge.org%2F&amp;src=sdkpreparse">sharer link</a>, this <a href="https://twitter.com/intent/tweet?hashtags=ProTruthPledge&amp;original_referer=https%3A%2F%2Fwww.protruthpledge.org%2Ftake-the-pro-truth-pledge%2F&amp;ref_src=twsrc%5Etfw&amp;text=I%20took%20the%20Pro-Truth%20Pledge!&amp;tw_p=tweetbutton&amp;url=http%3A%2F%2FProTruthPledge.org&amp;via=ProTruthPledge">Twitter sharer link</a>, this LinkedIn <a href="https://www.linkedin.com/cws/share?token&amp;isFramed=false&amp;url=https%3A%2F%2Fwww.protruthpledge.org%2F">sharer link</a>, and this Reddit <a href="https://www.reddit.com/submit?url=https%3A%2F%2Fwww.protruthpledge.org%2F&amp;resubmit=true&amp;title=">sharer link</a> do so. If you are active on other social media, you can share it there as well using the link to the <a href="https://www.protruthpledge.org/">Pro-Truth Pledge website</a>. </li>
                        <li>Next, please read <a href="https://www.protruthpledge.org/pro-truth-pledge-on-social-media/">through this blog</a> on enacting the pledge on social media, and follow the strategies there. Model the behavior you want to see in the world!</li>
                        <li>Then, please get involved with the Pro-Truth Pledge social media community. Please <a href="https://www.facebook.com/glebtsipursky">extend me</a> a Facebook friend request for ease of communication and collaboration. Please join this <a href="https://www.facebook.com/groups/InInInsiders/">Facebook group</a> for <a href="http://intentionalinsights.org/">Intentional Insights</a> (InIn), the organization that runs the Pro-Truth Pledge project. Also join this <a href="https://www.facebook.com/groups/ProTruthPledgeAdvocates/?ref=group_header">Facebook group</a> specifically for Pro-Truth Pledge-oriented activities, which is a smaller offshoot of the bigger Intentional Insights group. Look at the groups listed <a href="https://www.facebook.com/pg/ProTruthPledge/groups/?ref=page_internal">here</a> to see if there is a local PTP Facebook group in your area, and join that. Finally, join the <a href="https://www.linkedin.com/groups/12071033">PTP LinkedIn group</a>.</li>
                        <li>After that, please click “like” and “follow” on the <a href="https://www.facebook.com/ProTruthPledge/">official Facebook page</a> of the Pro-Truth Pledge, and also the <a href="https://www.facebook.com/intentionalinsights/">official page</a> of Intentional Insights (InIn), the nonpartisan educational 501(c)3 nonprofit running the Pro-Truth Pledge project. Please “follow” the <a href="https://twitter.com/protruthpledge">Twitter account</a> of the Pro-Truth Pledge and the <a href="https://twitter.com/intentinsights">Twitter account</a> of Intentional Insights. Also, “follow” the <a href="https://www.linkedin.com/company/25068392/">LinkedIn page</a> of the Pro-Truth Pledge, and the <a href="https://www.linkedin.com/company/10043566/">LinkedIn page</a> of Intentional Insights. If you are active on other social media, please take a look at the <a href="http://intentionalinsights.org/">home page</a> of Intentional Insights to see other social media you can follow.</li>
                        <li>Email about the pledge to friends and family, and pitch it to public figures, adapting <a href="https://drive.google.com/drive/folders/0B34f-fPTUdPHWDZjWUJKMENpbWM">these email templates</a> to your needs.</li>
                        <li>Purchase and wear <a href="https://www.protruthpledge.org/merchandise/">PTP-themed merchandise</a> to spread the word.</li>
                        <li>I will sign you up to the Intentional Insights Insiders Google Group (a type of email list) of Intentional Insights. Please add its email, <a href="mailto:intentional-insights-insiders@googlegroups.com">intentional-insights-insiders@googlegroups.com</a>, to your safe senders/contacts list. Please do the same for <a href="mailto:gleb@intentionalinsights.org">gleb@intentionalinsights.org</a>, <a href="mailto:info@intentionalinsighs.org">info@intentionalinsighs.org</a>, and <a href="mailto:info@protruthpledge.org">info@protruthpledge.org</a>.</li>
                        <li>Read <a href="https://www.protruthpledge.org/blog/">the blogs</a> on the PTP website, which are about the pledge in particular, and the more broad <a href="http://intentionalinsights.org/category/rational_politics/">political-themed blogs</a> on the website of Intentional Insights.</li>
                    </ul>
                    <p></p>
                    <p style="text-align: center;"><b>Advancing the Pro-Truth Pledge</b></p>
                    <p></p>
                    <ul>
                        <li><b>Volunteering</b>: We have a variety of activities available for you to help via contributing your time, described in our volunteering survey at <a href="https://docs.google.com/a/intentionalinsights.org/forms/d/e/1FAIpQLSdZdQk6lxGEqjPqEEFzEPbRCGs_hES1LhxhAZttpP053zShHw/viewform?c=0&amp;w=1">this link</a>: please fill it out and I will get back to you shortly with volunteer opportunities.</li>
                    </ul>
                    <p></p>
                    <ul>
                        <li><b>Donations</b>: Support the fight against fake news and deception financially through contributing to <a href="http://intentionalinsights.org/">Intentional Insights</a>, the US-based 501(c)(3) educational nonprofit organization that runs the Pro-Truth Pledge. You can make a donation at <a href="http://intentionalinsights.org/donate/">this link</a>, or or by writing a check to Intentional Insights and mailing it to 450 Wetmore road, Columbus, OH, 43214: all donations are tax-deductible for any income you earned in the US.</li>
                    </ul>
                    <p></p>
                    <p style="text-align: center;"><b>Next Steps</b></p>
                    <p></p>
                    <p>Let me know which combination of these fits your interests. If I don’t hear from you, I’ll check in later from a different email address in case my email got stuck in your spam filters.</p>
                    <p></p>
                    <p>To learn more about the principles behind the Pro-Truth Pledge, including behavioral science-based strategies for how to determine what is true and help others accept the facts, check out <i><b><u>The Truth-Seeker’s Handbook: A Science-Based Guide</i></b></u>. This book is described in more detail at <a href="http://glebtsipursky.com/the-truth-seekers-handbook-a-science-based-guide/">this link</a> and available on Amazon.com at <a href="https://www.amazon.com/gp/product/B078429WCF/ref=as_li_tl?ie=UTF8&amp;camp=1789&amp;creative=9325&amp;creativeASIN=B078429WCF&amp;linkCode=as2&amp;tag=intentinsigh-20&amp;linkId=6d0105548fcc9f38a235207516f6ed82">this link</a>.</p>
                    <p></p>
                    <p>Please let me know any questions you might have. Look forward to collaborating with you, and I’m excited you’re getting involved in fighting lies and promoting truth in politics and other life areas!</p>
                    <p></p>
                    <p>Truthfully Yours,</p>
                    <p></p>
                    <p>Gleb</p>
                    <p></p>
                    <p><a href="http://glebtsipursky.com/about/">Dr. Gleb Tsipursky</a></p>
                    <p>Co-Founder, <a href="https://www.protruthpledge.org/">Pro-Truth Pledge</p>
                    <p>President, <a href="http://intentionalinsights.org/">Intentional Insights</p>
                    <p>Assistant Professor, <a href="https://decisionsciences.osu.edu/people/tsipursky.1">The Ohio State University</p>
                    <p>Unsubscribe: This is a confirmation email. Future emails will include an unsubscribe link.</p>
                    <?php $html = ob_get_clean();
                    wp_mail( strip_tags($_POST["email"], ""), $emailSubject, $html );
                } elseif (isset($_POST['emailList'])){ //Just Email List
                    $emailSubject = $_POST["fName"] . " " . $_POST["lName"] . ", Thanks for Taking the Pro-Truth Pledge";
                    ob_start(); ?>
                    <p>Dear <?php echo $_POST["fName"] . " " . $_POST["lName"]; ?>,</p>
                    <p></p>
                    <p>Thanks for taking the <a href="http://protruthpledge.org">Pro-Truth Pledge</a> (PTP). Glad that you want to fight lies and promote truth in politics and other areas of public discourse!</p>
                    <p></p>
                    <p>You have already done something really important by taking the pledge, so thanks for that! Here are some <b><u>quick things you can do to fight lies and promote truth</b></u>: </p>
                    <p></p>
                    <ul>
                        <li>The first thing to do is post on social media about taking the pledge. You can use this Facebook <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2FProTruthPledge.org%2F&amp;src=sdkpreparse">sharer link</a>, this <a href="https://twitter.com/intent/tweet?hashtags=ProTruthPledge&amp;original_referer=https%3A%2F%2Fwww.protruthpledge.org%2Ftake-the-pro-truth-pledge%2F&amp;ref_src=twsrc%5Etfw&amp;text=I%20took%20the%20Pro-Truth%20Pledge!&amp;tw_p=tweetbutton&amp;url=http%3A%2F%2FProTruthPledge.org&amp;via=ProTruthPledge">Twitter sharer link</a>, this LinkedIn <a href="https://www.linkedin.com/cws/share?token&amp;isFramed=false&amp;url=https%3A%2F%2Fwww.protruthpledge.org%2F">sharer link</a>, and this Reddit <a href="https://www.reddit.com/submit?url=https%3A%2F%2Fwww.protruthpledge.org%2F&amp;resubmit=true&amp;title=">sharer link</a> do so. If you are active on other social media, you can share it there as well using the link to the <a href="https://www.protruthpledge.org/">Pro-Truth Pledge website</a>. </li>
                        <li>Next, please read <a href="https://www.protruthpledge.org/pro-truth-pledge-on-social-media/">through this blog</a> on enacting the pledge on social media, and follow the strategies there. Model the behavior you want to see in the world!</li>
                        <li>Then, please get involved with the Pro-Truth Pledge social media community. Please <a href="https://www.facebook.com/glebtsipursky">extend me</a> a Facebook friend request for ease of communication and collaboration. Please join this <a href="https://www.facebook.com/groups/InInInsiders/">Facebook group</a> for <a href="http://intentionalinsights.org/">Intentional Insights</a> (InIn), the organization that runs the Pro-Truth Pledge project. Also join this <a href="https://www.facebook.com/groups/ProTruthPledgeAdvocates/?ref=group_header">Facebook group</a> specifically for Pro-Truth Pledge-oriented activities, which is a smaller offshoot of the bigger Intentional Insights group. Look at the groups listed <a href="https://www.facebook.com/pg/ProTruthPledge/groups/?ref=page_internal">here</a> to see if there is a local PTP Facebook group in your area, and join that. Finally, join the <a href="https://www.linkedin.com/groups/12071033">PTP LinkedIn group</a>.</li>
                        <li>After that, please click “like” and “follow” on the <a href="https://www.facebook.com/ProTruthPledge/">official Facebook page</a> of the Pro-Truth Pledge, and also the <a href="https://www.facebook.com/intentionalinsights/">official page</a> of Intentional Insights (InIn), the nonpartisan educational 501(c)3 nonprofit running the Pro-Truth Pledge project. Please “follow” the <a href="https://twitter.com/protruthpledge">Twitter account</a> of the Pro-Truth Pledge and the <a href="https://twitter.com/intentinsights">Twitter account</a> of Intentional Insights. Also, “follow” the <a href="https://www.linkedin.com/company/25068392/">LinkedIn page</a> of the Pro-Truth Pledge, and the <a href="https://www.linkedin.com/company/10043566/">LinkedIn page</a> of Intentional Insights. If you are active on other social media, please take a look at the <a href="http://intentionalinsights.org/">home page</a> of Intentional Insights to see other social media you can follow.</li>
                        <li>Email about the pledge to friends and family, and pitch it to public figures, adapting <a href="https://drive.google.com/drive/folders/0B34f-fPTUdPHWDZjWUJKMENpbWM">these email templates</a> to your needs.</li>
                        <li>Purchase and wear <a href="https://www.protruthpledge.org/merchandise/">PTP-themed merchandise</a> to spread the word.</li>
                        <li>Read <a href="https://www.protruthpledge.org/blog/">the blogs</a> on the PTP website, which are about the pledge in particular, and the more broad <a href="http://intentionalinsights.org/category/rational_politics/">political-themed blogs</a> on the website of Intentional Insights.</li>
                        <li><b>Volunteering</b>: We have a variety of activities available for you to help via contributing your time, described in our volunteering survey at <a href="https://docs.google.com/a/intentionalinsights.org/forms/d/e/1FAIpQLSdZdQk6lxGEqjPqEEFzEPbRCGs_hES1LhxhAZttpP053zShHw/viewform?c=0&amp;w=1">this link</a>: please fill it out and I will get back to you shortly with volunteer opportunities.</li>
                        <li><b>Donations</b>: Support the fight against fake news and deception financially through contributing to <a href="http://intentionalinsights.org/">Intentional Insights</a>, the US-based 501(c)(3) educational nonprofit organization that runs the Pro-Truth Pledge. You can make a donation at <a href="http://intentionalinsights.org/donate/">this link</a>, or or by writing a check to Intentional Insights and mailing it to 450 Wetmore road, Columbus, OH, 43214: all donations are tax-deductible for any income you earned in the US.</li>
                    </ul>
                    <p></p>
                    <p>To learn more about the principles behind the Pro-Truth Pledge, including behavioral science-based strategies for how to determine what is true and help others accept the facts, check out <i><b><u>The Truth-Seeker’s Handbook: A Science-Based Guide</i></b></u>. This book is described in more detail at <a href="http://glebtsipursky.com/the-truth-seekers-handbook-a-science-based-guide/">this link</a> and available on Amazon.com at <a href="https://www.amazon.com/gp/product/B078429WCF/ref=as_li_tl?ie=UTF8&amp;camp=1789&amp;creative=9325&amp;creativeASIN=B078429WCF&amp;linkCode=as2&amp;tag=intentinsigh-20&amp;linkId=6d0105548fcc9f38a235207516f6ed82">this link</a>.</p>
                    <p></p>
                    <p>Please let me know any questions you might have. Once again, thank you very much, it’s a pleasure to work with you to help fight lies and advance truth in our public discourse!</p>
                    <p></p>
                    <p>Truthfully Yours,</p>
                    <p></p>
                    <p>Gleb</p>
                    <p></p>
                    <p><a href="http://glebtsipursky.com/about/">Dr. Gleb Tsipursky</a></p>
                    <p>Co-Founder, <a href="https://www.protruthpledge.org/">Pro-Truth Pledge</p>
                    <p>President, <a href="http://intentionalinsights.org/">Intentional Insights</p>
                    <p>Assistant Professor, <a href="https://decisionsciences.osu.edu/people/tsipursky.1">The Ohio State University</p>
                    <p>Unsubscribe: This is a confirmation email. Future emails will include an unsubscribe link.</p>
                    <?php $html = ob_get_clean();
                    wp_mail( strip_tags($_POST["email"], ""), $emailSubject, $html );
                } else { //Opted Out
                    $emailSubject = $_POST["fName"] . " " . $_POST["lName"] . ", Confirmation of taking the Pro-Truth Pledge";
                    ob_start(); ?>
                    <p>Dear <?php echo $_POST["fName"] . " " . $_POST["lName"]; ?>,</p>
                    <p></p>
                    <p>Thanks for taking the <a href="http://protruthpledge.org">Pro-Truth Pledge</a> (PTP). We are glad that you want to fight lies and promote truth in politics and other areas of public discourse! </p>
                    <p></p>
                    <p>This email is to confirm you took the pledge, but since you indicated you do not want to receive notifications, we will not send you any more emails. If you change your mind, you can always sign up for our newsletter at <a href="http://eepurl.com/cVFxxv">this link</a>. Signing up to the newsletter is valuable to incentivize politicians and other public figures to take the pledge, as they will see that our communication reaches more people, and thus has a stronger impact on the public discourse.</p>
                    <p></p>
                    <p>You have already done something really important by taking the pledge, so thanks for that! Here are some <b><u>quick things you can do to fight lies and promote truth</b></u>: </p>
                    <p></p>
                    <ul>
                        <li>The first thing to do is post on social media about taking the pledge. You can use this Facebook <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2FProTruthPledge.org%2F&amp;src=sdkpreparse">sharer link</a>, this <a href="https://twitter.com/intent/tweet?hashtags=ProTruthPledge&amp;original_referer=https%3A%2F%2Fwww.protruthpledge.org%2Ftake-the-pro-truth-pledge%2F&amp;ref_src=twsrc%5Etfw&amp;text=I%20took%20the%20Pro-Truth%20Pledge!&amp;tw_p=tweetbutton&amp;url=http%3A%2F%2FProTruthPledge.org&amp;via=ProTruthPledge">Twitter sharer link</a>, this LinkedIn <a href="https://www.linkedin.com/cws/share?token&amp;isFramed=false&amp;url=https%3A%2F%2Fwww.protruthpledge.org%2F">sharer link</a>, and this Reddit <a href="https://www.reddit.com/submit?url=https%3A%2F%2Fwww.protruthpledge.org%2F&amp;resubmit=true&amp;title=">sharer link</a> do so. If you are active on other social media, you can share it there as well using the link to the <a href="https://www.protruthpledge.org/">Pro-Truth Pledge website</a>. </li>
                        <li>Next, please read <a href="https://www.protruthpledge.org/pro-truth-pledge-on-social-media/">through this blog</a> on enacting the pledge on social media, and follow the strategies there. Model the behavior you want to see in the world!</li>
                        <li>Then, please get involved with the Pro-Truth Pledge social media community. Please <a href="https://www.facebook.com/glebtsipursky">extend me</a> a Facebook friend request for ease of communication and collaboration. Please join this <a href="https://www.facebook.com/groups/InInInsiders/">Facebook group</a> for <a href="http://intentionalinsights.org/">Intentional Insights</a> (InIn), the organization that runs the Pro-Truth Pledge project. Also join this <a href="https://www.facebook.com/groups/ProTruthPledgeAdvocates/?ref=group_header">Facebook group</a> specifically for Pro-Truth Pledge-oriented activities, which is a smaller offshoot of the bigger Intentional Insights group. Look at the groups listed <a href="https://www.facebook.com/pg/ProTruthPledge/groups/?ref=page_internal">here</a> to see if there is a local PTP Facebook group in your area, and join that. Finally, join the <a href="https://www.linkedin.com/groups/12071033">PTP LinkedIn group</a>.</li>
                        <li>After that, please click “like” and “follow” on the <a href="https://www.facebook.com/ProTruthPledge/">official Facebook page</a> of the Pro-Truth Pledge, and also the <a href="https://www.facebook.com/intentionalinsights/">official page</a> of Intentional Insights (InIn), the nonpartisan educational 501(c)3 nonprofit running the Pro-Truth Pledge project. Please “follow” the <a href="https://twitter.com/protruthpledge">Twitter account</a> of the Pro-Truth Pledge and the <a href="https://twitter.com/intentinsights">Twitter account</a> of Intentional Insights. Also, “follow” the <a href="https://www.linkedin.com/company/25068392/">LinkedIn page</a> of the Pro-Truth Pledge, and the <a href="https://www.linkedin.com/company/10043566/">LinkedIn page</a> of Intentional Insights. If you are active on other social media, please take a look at the <a href="http://intentionalinsights.org/">home page</a> of Intentional Insights to see other social media you can follow.</li>
                        <li>Email about the pledge to friends and family, and pitch it to public figures, adapting <a href="https://drive.google.com/drive/folders/0B34f-fPTUdPHWDZjWUJKMENpbWM">these email templates</a> to your needs.</li>
                        <li>Purchase and wear <a href="https://www.protruthpledge.org/merchandise/">PTP-themed merchandise</a> to spread the word.</li>
                        <li>Read <a href="https://www.protruthpledge.org/blog/">the blogs</a> on the PTP website, especially <a href="https://www.protruthpledge.org/category/activism/">these activism-themed blogs</a>, about the pledge, and also more broad rational politics-themed blog on <a href="http://intentionalinsights.org/category/rational_politics/">this section</a> of the Intentional Insights website.</li>
                        <li><b>Volunteering</b>: We have a variety of activities available for you to help via contributing your time, described in our volunteering survey at <a href="https://docs.google.com/a/intentionalinsights.org/forms/d/e/1FAIpQLSdZdQk6lxGEqjPqEEFzEPbRCGs_hES1LhxhAZttpP053zShHw/viewform?c=0&amp;w=1">this link</a>: please fill it out and I will get back to you shortly with volunteer opportunities.</li>
                        <li><b>Donations</b>: Support the fight against fake news and deception financially through contributing to <a href="http://intentionalinsights.org/">Intentional Insights</a>, the US-based 501(c)(3) educational nonprofit organization that runs the Pro-Truth Pledge. You can make a donation at <a href="http://intentionalinsights.org/donate/">this link</a>, or or by writing a check to Intentional Insights and mailing it to 450 Wetmore road, Columbus, OH, 43214: all donations are tax-deductible for any income you earned in the US.</li>
                    </ul>
                    <p></p>
                    <p>To learn more about the principles behind the Pro-Truth Pledge, including behavioral science-based strategies for how to determine what is true and help others accept the facts, check out <i><b><u>The Truth-Seeker’s Handbook: A Science-Based Guide</i></b></u>. This book is described in more detail at <a href="http://glebtsipursky.com/the-truth-seekers-handbook-a-science-based-guide/">this link</a> and available on Amazon.com at <a href="https://www.amazon.com/gp/product/B078429WCF/ref=as_li_tl?ie=UTF8&amp;camp=1789&amp;creative=9325&amp;creativeASIN=B078429WCF&amp;linkCode=as2&amp;tag=intentinsigh-20&amp;linkId=6d0105548fcc9f38a235207516f6ed82">this link</a>.</p>
                    <p></p>
                    <p>Please let me know any questions you might have. We will not send you any more emails, unless you sign up for our newsletter at <a href="http://eepurl.com/cVFxxv">this link</a>. Please let me know any questions you might have. Once again, thank you very much, it’s a pleasure to work with you to help fight lies and advance truth in our public discourse!</p>
                    <p></p>
                    <p>Truthfully Yours,</p>
                    <p></p>
                    <p>Gleb</p>
                    <p></p>
                    <p><a href="http://glebtsipursky.com/about/">Dr. Gleb Tsipursky</a></p>
                    <p>Co-Founder, <a href="https://www.protruthpledge.org/">Pro-Truth Pledge</p>
                    <p>President, <a href="http://intentionalinsights.org/">Intentional Insights</p>
                    <p>Assistant Professor, <a href="https://decisionsciences.osu.edu/people/tsipursky.1">The Ohio State University</p>
                    <p>Unsubscribe: This is just a confirmation email. There will be no future emails. There is no need to unsubscribe.</p>
                    <?php $html = ob_get_clean();
                    wp_mail( strip_tags($_POST["email"], ""), $emailSubject, $html );
                }
            } else { //Public Figures
                $emailSubject = $_POST["fName"] . " " . $_POST["lName"] . ", Thanks for Taking the Pro-Truth Pledge";
                ob_start(); ?>
                <p>Dear <?php echo $_POST["fName"] . " " . $_POST["lName"]; ?>,</p>
                <p></p>
                <p>Thanks for taking the <a href="http://protruthpledge.org">Pro-Truth Pledge</a> (PTP). Glad that you as a public figure want to fight lies and promote truth in politics and other areas of public discourse!</p>
                <p> </p>
                <p>Here is <b>something you can do immediately </b>to help spread the message about fighting lies and protecting truth<b> </b>and also help you get the full benefit of being recognized as publicly committing to truth-oriented behaviors: please<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2FProTruthPledge.org%2F&amp;src=sdkpreparse"> post on Facebook</a> and<a href="https://twitter.com/intent/tweet?hashtags=ProTruthPledge&amp;original_referer=https%3A%2F%2Fwww.protruthpledge.org%2Ftake-the-pro-truth-pledge%2F&amp;ref_src=twsrc%5Etfw&amp;text=I%20took%20the%20Pro-Truth%20Pledge!&amp;tw_p=tweetbutton&amp;url=http%3A%2F%2FProTruthPledge.org&amp;via=ProTruthPledge"> on Twitter</a> about taking the pledge, if you use those social media. Next, add the<a href="https://www.protruthpledge.org/website-badge-seal/"> Pro-Truth Pledge badge</a> to your website as Peter Singer did on<a href="http://www.petersinger.info/"> his website</a>. If you use Facebook, please add<a href="https://www.facebook.com/ProTruthPledge/photos/a.263914657431697.1073741828.195264327630064/264345110721985/?type=3&amp;theater"> this Facebook Frame</a> to your Facebook profile, and<a href="https://twibbon.com/support/pro-truth-pledge-2/twitter"> this Twibbon</a> to your Twitter profile if you use Twitter (please mark the Facebook Frame as "permanent" as the main point of the frame is to show others that you took the pledge and are comfortable being held publicly accountable for your words). For your LinkedIn profile, add that you are a “Signer” of the<a href="https://www.linkedin.com/company/25068392/"> Pro-Truth Pledge LinkedIn organization</a>. Click the “+” button on your experience section, put in “Signer” as title, choose “Pro-Truth Pledge” as the organization, put in your date of signing, and in the description state “I have taken the Pro-Truth Pledge at ProTruthPledge.org: please hold me accountable.” If you have other relevant social media venues, please add the same statement there. Finally, please read and take steps in<a href="https://www.protruthpledge.org/how-public-figures-can-get-maximum-benefit-from-taking-the-pro-truth-pledge/"> this blog</a> about how public figures like yourself can make the most difference in advancing the fight against fake news and political deception, while also getting the maximum benefit for their reputation of taking the PTP. </p>
                <p> </p>
                <p>Have you<b> filled in your full profile</b> on the<a href="https://www.protruthpledge.org/public-figures-signed-pledge/"> Pro-Truth Pledge public figures page</a>? We find that people who provide a paragraph about why they took the pledge, their photographs, and links to their online venues – websites, social media, articles about them, etc. – get quite a bit more traffic from the page. It also helps give the public figures page more impact on those who see it. The paragraph should be whatever you would like journalists to see when they look at the page, since news reporters use that to write stories about the pledge, and occasionally contact public figures who took the pledge based on the paragraph they provide. Likewise, private citizens who look at that page use the paragraphs to evaluate and decide which public figures to follow. You can send back an edited version of the paragraph if you wish, along with your photograph.</p>
                <p></p>
                <p>To learn more about the Pro-Truth Pledge and the 501(c)3 nonpartisan educational nonprofit that runs it, <a href="http://intentionalinsights.org/">Intentional Insights</a>, you are welcome to read <a href="https://docs.google.com/document/d/19dfGwyVJWbgszaKedMMCpuM_PJD8M7oOIcSzTKq2d6c/edit?usp=sharing">this link</a> with information about it. Also, consider getting involved with the <b>Pro-Truth Pledge community</b>. Our main collaborative venue is Facebook. Please <a href="https://www.facebook.com/glebtsipursky">extend me</a> a Facebook friend request for ease of communication and collaboration. Then, please join this <a href="https://www.facebook.com/groups/InInInsiders/">Facebook group</a> for Intentional Insights. Also join this <a href="https://www.facebook.com/groups/ProTruthPledgeAdvocates/?ref=group_header">Facebook group</a> for Pro-Truth Pledge-oriented activities, which is a smaller offshoot of the bigger Intentional Insights group. The Facebook group for Global Pro-Truth Pledge-oriented activities also has links out to local groups which you might be interested in joining in your area. Finally, join the <a href="https://www.linkedin.com/groups/12071033">PTP LinkedIn group</a>.</p>
                <p></p>
                <p>To learn more about the principles behind the Pro-Truth Pledge, including behavioral science-based strategies for how to determine what is true and help others accept the facts, check out <i><b><u>The Truth-Seeker’s Handbook: A Science-Based Guide</i></b></u>. This book is described in more detail at <a href="http://glebtsipursky.com/the-truth-seekers-handbook-a-science-based-guide/">this link</a> and available on Amazon.com at <a href="https://www.amazon.com/gp/product/B078429WCF/ref=as_li_tl?ie=UTF8&amp;camp=1789&amp;creative=9325&amp;creativeASIN=B078429WCF&amp;linkCode=as2&amp;tag=intentinsigh-20&amp;linkId=6d0105548fcc9f38a235207516f6ed82">this link</a>.</p>
                <p></p>
                <p>Once again, thank you very much, it’s a pleasure to work with you to help fight lies and advance truth in our public discourse!</p>
                <p></p>
                <p>Truthfully Yours,</p>
                <p></p>
                <p>Gleb</p>
                <p></p>
                <p><a href="http://glebtsipursky.com/about/">Dr. Gleb Tsipursky</a></p>
                <p>Co-Founder, <a href="https://www.protruthpledge.org/">Pro-Truth Pledge</p>
                <p>President, <a href="http://intentionalinsights.org/">Intentional Insights</p>
                <p>Assistant Professor, <a href="https://decisionsciences.osu.edu/people/tsipursky.1">The Ohio State University</p>
                <p>Unsubscribe: This is a confirmation email. Future emails will include an unsubscribe link.</p>
                <?php $html = ob_get_clean();
                wp_mail( strip_tags($_POST["email"], ""), $emailSubject, $html );
            }

            //wp_mail( strip_tags($_POST["email"], ""), $emailSubject, $emailBody );


            // $wpdb->insert(
            // $pledgeDivisionsTable,
            // array(
            // 'pledgeId' => $pledgeId,
            // 'divisionId' => "Test Division Id 2",
            // 'divisionData' => "Test Division Data 2"
            // )
            // );

            //echo "{{" . $wpdb->last_error. "}}";

            if ($_POST["category"] == "Public") {
                $toStep = "Address";
            } else
            {
                $toStep = "Description";
            }

        }

        if ( $step == "Description") {

            $data = array(
                'groupName' => strip_tags($_POST["groupName"], ""),
                'description' => strip_tags($_POST["description"], ""),
                'imageUrl' => strip_tags($_POST["imageUrl"], ""),
                'linkText1' => strip_tags($_POST["linkText1"], ""),
                'linkUrl1' => strip_tags($_POST["linkUrl1"], ""),
                'linkText2' => strip_tags($_POST["linkText2"], ""),
                'linkUrl2' => strip_tags($_POST["linkUrl2"], ""),
                'linkText3' => strip_tags($_POST["linkText3"], ""),
                'linkUrl3' => strip_tags($_POST["linkUrl3"], ""),
                'step' => strip_tags($_POST["step"], ""),
            );

            if(isset($_POST['fName']))
                $data += ['fName' => strip_tags($_POST["fName"], "")];

            if(isset($_POST['lName']))
                $data += ['lName' => strip_tags($_POST["lName"], "")];


            $wpdb->update(
                $pledgeTable,
                $data,
                array(
                    'pledgeId' => $pledgeId,
                    'key' => $key
                )
            );
            $toStep = "Address";
        }

        // Receive data for "Address" step
        if ( $step == "Address") {


            $data = array(
                'repNudge' => isset($_POST['repNudge']),
                'address1' => strip_tags($_POST["address1"], ""),
                'address2' => strip_tags($_POST["address2"], ""),
                'city' => strip_tags($_POST["city"], ""),
                'region' => strip_tags($_POST["region"], ""),
                'zip' => strip_tags($_POST["zip"], ""),
                'country' => strip_tags($_POST["country"], ""),
                'phone' => strip_tags($_POST["phone"], ""),
                'textAlerts' => isset($_POST['textAlerts']),
                'orgs' => strip_tags($_POST["orgs"], ""),
                'step' => strip_tags($_POST["step"], ""),
            );
            if(isset($_POST['linkText1']) && $_POST['linkUrl1'] != "https://www.facebook.com/"){
                $data += ['linkText1' => strip_tags($_POST["linkText1"], "")];
                $data += ['linkUrl1' => strip_tags($_POST["linkUrl1"], "")];
            }
            if(isset($_POST['linkText2']) && $_POST['linkUrl2'] != "https://www.linkedin.com/in/"){
                $data += ['linkText2' => strip_tags($_POST["linkText2"], "")];
                $data += ['linkUrl2' => strip_tags($_POST["linkUrl2"], "")];
            }
            if(isset($_POST['linkText3']) && $_POST['linkUrl3'] != "http://"){
                $data += ['linkText3' => strip_tags($_POST["linkText3"], "")];
                $data += ['linkUrl3' => strip_tags($_POST["linkUrl3"], "")];
            }

            //Get normalized Address from google
            $url = "https://www.googleapis.com/civicinfo/v2/representatives?key=******&address=". urlencode ($_POST["address2"] . " " . $_POST["city"] . ", " . $_POST["region"] . " " . $_POST["zip"]);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $civicJson = curl_exec($ch);
            curl_close($ch);
            if (substr($civicJson, 0, 1) == "{" && substr($civicJson,0,10) != '{ "error":'){
                $civic = json_decode($civicJson);
                if ($civic->normalizedInput != null) {
                    $data += ['addressValidated' => true];
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
            $wpdb->update(
                $pledgeTable,
                $data,
                array(
                    'pledgeId' => $pledgeId,
                    'key' => $key
                )
            );

            if (isset($civic)) {
                foreach ( $civic->divisions as $key => $division ) {
                    // ToDo: Make updates happen
                    $wpdb->insert(
                        $pledgeDivisionsTable,
                        array(
                            'pledgeId' => $pledgeId,
                            'divisionId' => $key,
                        )
                    );
                }
            }

            $toStep = "Done";
        }

        // STEP "Start" Render
        if ( $toStep == "Start") {
            ob_start(); ?>
            <h1>Take the Pro-Truth Pledge</h1>
            <form method="post" >
                <div class="row">
                    <div class="form-group col-sm-6" >
                        <label for="fName">First Name</label>
                        <input type="text" name="fName" id="fName" class="form-control"
                               placeholder="First Name" autocomplete="fname" maxlength="100">
                    </div>

                    <div class="form-group col-sm-6" >
                        <label for="lName">Last Name</label>
                        <input type="text" name="lName" id="lName" class="form-control"
                               placeholder="Last Name" autocomplete="lname" maxlength="100">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email (will be kept private) </label>
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="name@example.com" required autocomplete="email" maxlength="100">
                </div>

                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" style="display: inline;">
                            <input class="form-check-input" type="checkbox" name="directory" value="directory" checked>
                            I want to be in the public directory of signers
                        </label> (We will only post your name and social media links you provide)
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" style="display: inline;">
                            <input class="form-check-input" type="checkbox" name="volunteer" value="volunteer" checked>
                            I want to help with the Pro-Truth Pledge
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notifications</label>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" style="display: inline;">
                            <input class="form-check-input" type="checkbox" name="emailList" value="emailList" checked> Infrequent Email Updates
                        </label>
                        (important to motivate public figures to sign the pledge)
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label"  style="display: inline;">
                            <input class="form-check-input" type="checkbox" name="emailAlerts" value="emailAlerts" checked> Email Action Alerts
                        </label>(
                        important to ensure we can hold public figures accountable)
                    </div>
                </div>

                <div class="form-group">
                    <label>Are you?</label>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" style="display: inline;">
                            <input class="form-check-input" type="radio" name="category" value="Public" checked> Member of the Public
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" style="display: inline;">
                            <input class="form-check-input" type="radio" name="category" value="Figure" > Public Figure
                        </label>
                        or staff
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label"  style="display: inline;">
                            <input class="form-check-input" type="radio" name="category" value="Official" > Elected or Appointed Official or Candidate
                        </label>
                        or staff
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label"  style="display: inline;">
                            <input class="form-check-input" type="radio" name="category" value="Group" > Organization or Group
                        </label>
                    </div>
                </div>

                <input type="hidden" name="step" id="step" value="<?php echo $toStep; ?>" />
                <input type="submit" name="submit_form" value="I Pledge" class="btn btn-primary"/>
            </form>
            <?php $html = ob_get_clean();
        }

        if ( $toStep == "Description") {
            ob_start(); ?>
            <form method="post" >
                <?php if ($_POST["category"] == "Group") {?>
                <div class="row">
                    <div class="form-group col-sm-6" >
                        <label for="fName">Group/Organization Name</label>
                        <input type="text" name="groupName" id="groupName" class="form-control"
                               placeholder="Group Name"  value="<?php echo $_POST["fName"]; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">This is your chance to get the positive public recognition your group deserves for taking the pledge. </label>Please share why your group took the pledge and what you hope to accomplish by taking it. We will send your message to those who signed up for the Pro-Truth Pledge Updates.
                    <?php } else {?>
                    <div class="form-group">
                        <label for="description">This is your chance to get the positive public recognition you deserve for taking the pledge. </label>Please share why you took the pledge and what you hope to accomplish by taking it. We will send your message to those who signed up for the Pro-Truth Pledge Updates.
                        <?php } ?>
                        <textarea name="description" id="description" placeholder="I signed the pledge because..." class="form-control"  maxlength="1000"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imageUrl">A link to a profile picture for use on the Public Figures page</label>
                        <input name="imageUrl" id="imageUrl" placeholder="https://example.com/profile_pic.jpg" class="form-control"  maxlength="200">
                    </div>
                    <?php
                        include $templatesDir . "socialMediaLinkFields.php";
                    ?>
                    <input type="hidden" name="category" id="category" value="<?php echo $_POST["category"]; ?>" />
                    <input type="hidden" name="pledgeId" id="pledgeId" value="<?php echo $pledgeId; ?>" />
                    <input type="hidden" name="key" id="key" value="<?php echo $key; ?>" />
                    <input type="hidden" name="step" id="step" value="<?php echo $toStep; ?>" />
                    <input type="submit" name="submit_form" value="Save" class="btn btn-primary"/>
            </form>
            <?php $html = ob_get_clean();
        }

        if ( $toStep == "Address") {
            ob_start(); ?>
            <form method="post" >
                <p>Please provide your address. We will keep it private and use it to encourage elected representatives to take the Pro-Truth Pledge by telling them how many of their constituents have signed the pledge.</p>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" style="display: inline;">
                            <input class="form-check-input" type="checkbox" name="repNudge" value="repNudge" checked>
                            I call on all of my elected representatives to take the Pro-Truth Pledge
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address1">Address</label>
                    <input name="address1"  id="address" placeholder="123 Any Street" autocomplete="street-address" class="form-control"  maxlength="100">
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="city">City</label>
                        <input name="city"  id="city" placeholder="New York" autocomplete="locality" class="form-control" maxlength="100">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="region">State/ Region</label>
                        <input name="region"  id="state" placeholder="NY" autocomplete="region" class="form-control" maxlength="100">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="zip">Zip/ Postal Code</label>
                        <input name="zip"  id="zip" placeholder="10011" autocomplete="postal-code" class="form-control" maxlength="100">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="country">Country</label>
                        <input name="country"  id="country" placeholder="USA" autocomplete="country" class="form-control" value="USA" maxlength="100">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>will not be made public - we need it for action alerts and contacting you if you wish to help with the pledge, or if we need to clarify your information
                    <input name="phone" type="tel" id="phone" placeholder="+1 (555) 555-1234" autocomplete="tel" class="form-control" maxlength="100">
                </div>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" style="display: inline;">
                            <input class="form-check-input" type="checkbox" name="textAlerts" value="textAlerts" checked>
                            Send me text action alerts
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="orgs">Organizations you are affiliated with (list as many as you would like)</label>
                    <input name="orgs"  id="orgs" class="form-control">
                </div>
                <?php
                    if (isset($_POST['directory'])) {
                        echo "You can list up to three links to your online presence to be displayed in the directory of signers";
                        include $templatesDir . "socialMediaLinkFields.php";
                    }
                ?>

                <input type="hidden" name="category" id="category" value="<?php echo $_POST["category"]; ?>" />
                <input type="hidden" name="pledgeId" id="pledgeId" value="<?php echo $pledgeId; ?>" />
                <input type="hidden" name="key" id="key" value="<?php echo $key; ?>" />
                <input type="hidden" name="step" id="step" value="<?php echo $toStep; ?>" />
                <input type="submit" name="submit_form" value="Save" class="btn btn-primary"/>
            </form>
            <?php $html = ob_get_clean();
        }

        // Render "Done"
        if ( $toStep == "Done") {
            ob_start(); ?>
            <?php
            //echo var_dump(get_post_meta(132));
            ?>
            <h2>Thank you for taking the Pro-Truth Pledge.</h2>
            <h3>Now tell the world you took the pledge:</h3>

            <a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="I took the Pro-Truth Pledge!" data-url="http://ProTruthPledge.org" data-via="ProTruthPledge" data-hashtags="ProTruthPledge" data-show-count="false">Tweet</a><script async="" src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=245333989208064";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-share-button" data-href="https://ProTruthPledge.org" data-layout="button" data-size="large" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2FProTruthPledge.org%2F&amp;src=sdkpreparse">Share</a></div>

            <br>
            <a href="https://www.protruthpledge.org/website-badge-seal/">Add a badge to your website</a><br>
            <a href="https://www.protruthpledge.org/pro-truth-pledge-on-social-media/">Enacting the Pro-Truth Pledge on social media</a>
            <br><br>
            <div style="clear:both;"></div>
            <?php $html = ob_get_clean();
        }

        validateAddress();
        latLongPull();

        return $html;

    }

}

add_shortcode('ptppledge', 'ptp_pledge');
