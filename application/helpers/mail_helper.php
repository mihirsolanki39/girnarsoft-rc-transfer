<?php

function commonMailSenderNew($to, $subject, $message, $sender = '', $name = 'Gaadi.com') {
    if ($sender == ''){
        $sender = '' . $name . ' <feedback@gaadi.com>';
    }
        $headers = "From: $sender\n";
        if (($subject == 'Your Subscription with Gaadi.com has expired') || ($subject == 'Request for renewal of subscription with Gaadi.com')) {
            $headers .= "Bcc: dealersupport@gaadi.com\n";
        }
        
        $headers .= "Reply-To: $sender\n";
        $headers .= "Return-Path: $sender\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
        $to_b = str_replace('@', '=', $to);
        $return_code = mail($to, $subject, $message, $headers, '-f mailer+' . $to_b . '@gaadi.com');
        if($return_code){
        echo 'mail sent';
        }else{
            echo 'mail not sent';
        }
}
