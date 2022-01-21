<?php

 function curlPostData($mobile, $smsText, $source){
        $data = array();
        $data['mobile']     = $mobile;
        //$data['mobile']   = '9910578589';
        $data['message']    = $smsText;
        $data['source']     = 'dealerCentral';
        $data['priority']   = 5;
        $data['NDNC']       = 1;
        $data['sender']     = 'iGAADI';
        //$data['send_via']   = 'PINNACLE';
        $data['send_response'] = 'Yes';
        $url                    = SMS_URL;
        $datas                  = $data;
        $fields_string          = '';
        foreach ($datas as $keys => $values) {
            $fields_string .= $keys . '=' . $values . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
}
function SEND_SMS($dealer_mobile, $sms_text, $source='gaadi')
{
    if (curlPostData($dealer_mobile, $sms_text, $source))
    {
        $result = ['status' => true, 'SMS Send Successfully To ' . $dealer_mobile];
    }
    else
    {
        $result = ['status' => false, 'SMS Couldn\'t Be Send Successfully To ' . $dealer_mobile];
    }
    return json_encode($result);
}
