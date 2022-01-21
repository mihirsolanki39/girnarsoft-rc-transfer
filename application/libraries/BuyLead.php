<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  ======================================= 
 *  Author     : Team Tech Arise 
 *  License    : Protected 
 *  Email      : info@techarise.com 
 * 
 *  ======================================= 
 */

require_once(APPPATH.'controllers/Lead.php');
class BuyLead extends Lead {
    public function __construct() {
        parent::__construct();
    }
}
?>