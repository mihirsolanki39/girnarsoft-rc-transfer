<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function no_to_words($no) {
    if ($no == 0) {
        return ' ';
    } else {
        $n = strlen($no);
        switch ($n) {
            case 3:
                $val = $no / 100;
                $val = round($val, 2);
                $finalval = $val . " hundred";
                break;
            case 4:
                $val = $no / 1000;
                $val = round($val, 2);
                $finalval = $val . " thousand";
                break;
            case 5:
                $val = $no / 1000;
                $val = round($val, 2);
                $finalval = $val . " thousand";
                break;
            case 6:
                $val = $no / 100000;
                $val = round($val, 2);
                $finalval = $val . " lakh";
                break;
            case 7:
                $val = $no / 100000;
                $val = round($val, 2);
                $finalval = $val . " lakh";
                break;
            case 8:
                $val = $no / 10000000;
                $val = round($val, 2);
                $finalval = $val . " crore";
                break;
            case 9:
                $val = $no / 10000000;
                $val = round($val, 2);
                $finalval = $val . " crore";
                break;
            default:
                echo "";
        }
        return $finalval;
    }

    function getbudgetList() {
        $budgetArr = array(
            array('key' => '0', 'value' => '0'),
            array('key' => '25000', 'value' => '25,000'),
            array('key' => '50000', 'value' => '50,000'),
            array('key' => '75000', 'value' => '75,000'),
            array('key' => '100000', 'value' => '1 Lac'),
            array('key' => '125000', 'value' => '1.25 Lacs'),
            array('key' => '150000', 'value' => '1.50 Lacs'),
            array('key' => '175000', 'value' => '1.75 Lacs'),
            array('key' => '200000', 'value' => '2 Lacs'),
            array('key' => '225000', 'value' => '2.25 Lacs'),
            array('key' => '250000', 'value' => '2.50 Lacs'),
            array('key' => '275000', 'value' => '2.75 Lacs'),
            array('key' => '300000', 'value' => '3 Lacs'),
            array('key' => '325000', 'value' => '3.25 Lacs'),
            array('key' => '350000', 'value' => '3.50 Lacs'),
            array('key' => '375000', 'value' => '3.75 Lacs'),
            array('key' => '400000', 'value' => '4 Lacs'),
            array('key' => '425000', 'value' => '4.25 Lacs'),
            array('key' => '450000', 'value' => '4.50 Lacs'),
            array('key' => '475000', 'value' => '4.75 Lacs'),
            array('key' => '500000', 'value' => '5 Lacs'),
            array('key' => '550000', 'value' => '5.50 Lacs'),
            array('key' => '600000', 'value' => '6 Lacs'),
            array('key' => '650000', 'value' => '6.50 Lacs'),
            array('key' => '700000', 'value' => '7 Lacs'),
            array('key' => '750000', 'value' => '7.50 Lacs'),
            array('key' => '800000', 'value' => '8 Lacs'),
            array('key' => '850000', 'value' => '8.50 Lacs'),
            array('key' => '900000', 'value' => '9 Lacs'),
            array('key' => '950000', 'value' => '9.50 Lacs'),
            array('key' => '1000000', 'value' => '10 Lacs'),
            array('key' => '1100000', 'value' => '11 Lacs'),
            array('key' => '1200000', 'value' => '12 Lacs'),
            array('key' => '1300000', 'value' => '13 Lacs'),
            array('key' => '1400000', 'value' => '14 Lacs'),
            array('key' => '1500000', 'value' => '15 Lacs'),
            array('key' => '1600000', 'value' => '16 Lacs'),
            array('key' => '1700000', 'value' => '17 Lacs'),
            array('key' => '1800000', 'value' => '18 Lacs'),
            array('key' => '1900000', 'value' => '19 Lacs'),
            array('key' => '2000000', 'value' => '20 Lacs'),
            array('key' => '2500000', 'value' => '25 Lacs'),
            array('key' => '3000000', 'value' => '30 Lacs'),
            array('key' => '4000000', 'value' => '40 Lacs'),
            array('key' => '5000000', 'value' => '50 Lacs'),
            array('key' => '7500000', 'value' => '75 Lacs'),
            array('key' => '10000000', 'value' => '1 Crore'),
            array('key' => '30000000', 'value' => '3 Crores')
        );

        return $budgetArr;
    }

}


 function filterStatus($nextStaus, $currentStatus) {
        $currentStatus = intval($currentStatus);
        $nextStaus = intval($nextStaus);
        switch ($currentStatus) {
            case'1':
            case'13':
                return true;
                break;
            case '2':
                if ($nextStaus == '1') {
                    return false;
                } else {
                    return true;
                }
                break;
            case '3':
            case '4' :
                if ($nextStaus == '1' || $nextStaus == '2') {
                    return false;
                } else {
                    return true;
                }
                break;
            case '10':
                if ($nextStaus == '1' || $nextStaus == '9' || $nextStaus == '2' || $nextStaus == '4' || $nextStaus == '3') {
                    return false;
                } else {
                    return true;
                }
                break;
            case '9':
                if ($nextStaus == '1' || $nextStaus == '2' || $nextStaus == '4' || $nextStaus == '3') {
                    return false;
                } else {
                    return true;
                }
                break;

            case '11':
                if ($nextStaus == '11' || $nextStaus == '12' || $nextStaus == '13') {
                    return true;
                } else {
                    return false;
                }
                break;
            case '12':
                if ($nextStaus == '12') {
                    return true;
                } else {
                    return false;
                }
                break;
        }
        
   if(!function_exists('formatInIndianStyle')){     
    function formatInIndianStyle($num) {
        $pos = strpos((string) $num, ".");
        if ($pos === false) {
            $decimalpart = "";
        } else {
            $decimalpart = "." . substr($num, $pos + 1, 2);
            $num = substr($num, 0, $pos);
        }

        if (strlen($num) > 3 & strlen($num) <= 12) {
            $last3digits = substr($num, -3);
            $numexceptlastdigits = substr($num, 0, -3);
            $formatted = makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last3digits . $decimalpart;
        } elseif (strlen($num) <= 3) {
            $stringtoreturn = $num . $decimalpart;
        } elseif (strlen($num) > 12) {
            $stringtoreturn = number_format($num, 2);
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {
            $stringtoreturn = "-" . substr($stringtoreturn, 2);
        }

        return $stringtoreturn;
    }
   }
if(!function_exists('makecomma')){
    function makecomma($input) {
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }
}
if(!function_exists('formatTotalTalkTime')){
   function formatTotalTalkTime($seconds){
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds / 60) % 60);
            $seconds = $seconds % 60;
            return $hours > 0 ? "$hours h, $minutes m" : ($minutes > 0 ? "$minutes m, $seconds s" : "$seconds s");

    }
}    
if(!function_exists('Number_Format')){
function Number_Format($number) {
        $decimal_precision = 0;
        $decimals_separator = '.';
        $thousands_separator = ',';
        $total_segments = strlen($number);
        for ($i = 0; $i < $total_segments; $i++) {
            $number[$i];
        }
        $number = strrev($number);
        $k = 0;
        $coma = 1;
        for ($i = 0; $i < $total_segments; $i++) {
            if ($coma == 1) {
                for ($j = 0; $j < 3; $j++) {
                    $number1[$k] = $number[$i];
                    $k++;
                    $i++;
                }
                $number1[$k] = ',';
                $k++;
                $coma = 2;
            } else {
                for ($j = 0; $j < 2; $j++) {
                    $number1[$k] = $number[$i];
                    $k++;
                    $i++;
                }
                $number1[$k] = ',';
                $k++;
                $coma = 2;
            } $i--;
        }
        for ($i = 0; $i < sizeof($number1) - 1; $i++) {
            $number2[$i] = $number1[$i];
        }
        $number = implode("", $number2);
        $number1 = strrev($number);

        return $number1;
    }

}
 }


function indian_currency_form($money) {
    $len = strlen($money);
    $m = '';
    $money = strrev($money);
    for ($i = 0; $i < $len; $i++) {
        if (( $i == 3 || ($i > 3 && ($i - 1) % 2 == 0) ) && $i != $len) {
            $m .=',';
        }
        $m .=$money[$i];
    }
    return strrev($m);
}

function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100), array(11, 12, 13))) {
        switch ($num % 10) {
            // Handle 1st, 2nd, 3rd
            case 1: return $num . 'st';
            case 2: return $num . 'nd';
            case 3: return $num . 'rd';
        }
    }
    return $num . 'th';
}
function strclean($str){
    $str=str_replace(",","",$str);
    return $str;
}
function convertToIndianCurrency($number,$icon='Rs ') {
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    return ($Rupees ? $icon.'' . $Rupees : '') . $paise . " Only";
}
function priceFormatShortVersion($price) {
    //price = price.replace(/,/g, '');
    $price=str_replace(',','',$price);
    $length=strlen($price); 
    //thousands
    if($length>=4 && $length <6){
        return  number_format((float)($price/1000), 1, '.', '').' Thousand';
    }
    //lakh
    if($length>=6 && $length <8){
        return   number_format((float)($price/100000), 1, '.', '').' Lakh';
    }
    //crore
    if($length>=8){
        return  number_format((float)($price/10000000), 1, '.', '').' Crore';
    }
    return $price;
}

function filterRenewStatus($nextStaus, $currentStatus) {
        $currentStatus = intval($currentStatus);
        $nextStaus = intval($nextStaus);
        switch ($currentStatus) {
            case'1':
            return true;
                break;
            case '2':
                if ($nextStaus == '1') {
                    return false;
                } else {
                    return true;
                }
                break;
            case '3':
                if ($nextStaus == '1' || $nextStaus == '2') {
                    return false;
                } else {
                    return true;
                }
                break;
            case '4' :
                if ($nextStaus == '1' || $nextStaus == '2') {
                    return false;
                } else {
                    return true;
                }
                break;
        }
}