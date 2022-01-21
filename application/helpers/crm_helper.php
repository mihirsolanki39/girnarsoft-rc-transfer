<?php

function chkEmailVaild($email) {
    $flag = '0';
    $emailArr = explode("@", $email);
    $emailArr2 = explode(".", $emailArr[1]);
    if ($email != '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || is_numeric($emailArr[0]) || is_numeric($emailArr2[0]) || is_numeric($emailArr2[1])) {
            $flag = '1';
        }
    }

    return $flag;
}

function getUpperCase($str){
    return str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($str))));
}


