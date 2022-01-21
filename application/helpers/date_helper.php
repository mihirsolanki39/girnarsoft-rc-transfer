<?php

function getMonthText($monthNumeric) {
    if ($monthNumeric == '01') {
        $month = 'Jan';
    } else if ($monthNumeric == '02') {
        $month = 'Feb';
    } else if ($monthNumeric == '03') {
        $month = 'Mar';
    } else if ($monthNumeric == '04') {
        $month = 'Apr';
    } else if ($monthNumeric == '05') {
        $month = 'May';
    } else if ($monthNumeric == '06') {
        $month = 'Jun';
    } else if ($monthNumeric == '07') {
        $month = 'Jul';
    } else if ($monthNumeric == '08') {
        $month = 'Aug';
    } else if ($monthNumeric == '09') {
        $month = 'Sep';
    } else if ($monthNumeric == '10') {
        $month = 'Oct';
    } else if ($monthNumeric == '11') {
        $month = 'Nov';
    } else {
        $month = 'Dec';
    }
    return $month;
}

    function getownerAsText($ownerNumeric) {
    if ($ownerNumeric == '0') {
        $owner = '--';
    } else if ($ownerNumeric == '1') {
        $owner = 'First';
    } else if ($ownerNumeric == '2') {
        $owner = 'Second';
    } else if ($ownerNumeric == '3') {
        $owner = 'Third';
    } else if ($ownerNumeric == '4') {
        $owner = 'Fourth';
    } else {
        $owner = 'Above Four';
    }
    return $owner;
}

function getMonthArr() {
        $month['1'] = 'Jan';
        $month['2'] = 'Feb';
        $month['3'] = 'Mar';
        $month['4'] = 'Apr';
        $month['5'] = 'May';
        $month['6'] = 'Jun';
        $month['7'] = 'Jul';
        $month['8'] = 'Aug';
        $month['9'] = 'Sep';
        $month['10'] = 'Oct';
        $month['11'] = 'Nov';
        $month['12'] = 'Dec';
    return $month;
}
