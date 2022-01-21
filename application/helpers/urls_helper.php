<?php

function clean($string, $replace = '-') {
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    return preg_replace('/' . $replace . '+/', $replace, $string);
}

function getCleanUrl($domain, $make, $model, $version, $id, $ext = '.htm', $prefix = 'used-') {
    $component = [];
    $component[] = $make;
    $component[] = $model;
    $component[] = $version;


    return domainWithHttp($domain) . '/' . $prefix . clean(implode('-', $component)) . '_' . $id . $ext;
}

function domainWithHttp($domain) {
    if (false === strpos($domain, '://')) {
        $domain = 'http://' . $domain;
    }
    return rtrim($domain, '/');
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