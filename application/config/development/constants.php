<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$url =  "http://".$_SERVER['HTTP_HOST'];

if($url == 'http://stagingcdrive.acillp.gaadi.com/')
{
    define('LOGO','assets/images/autocredits.png');
    define('CSS','home_style.css');
    define('NAME','autodealercrmstaging');
    define('CDLOGO','assets/images/autocredits.png');
}
if($url == 'http://betacdrive.acillp.gaadi.com')
{
    define('LOGO','assets/images/autocredits.png');
    define('CSS','home_style.css');
    define('NAME','autodealercrmbeta');
     define('CDLOGO','assets/images/autocredits.png');
}
if($url == 'http://stagingcdrive.bir.gaadi.com')
{
    //echo "sdfdf"; exit;
    define('LOGO','assets/images/bir-motors.png');
    define('CSS','birmotors-home.css');
    define('NAME','birdealercrmstaging');
    define('CDLOGO','assets/images/cdrivelogo-b.png');
}
if($url == 'http://betacdrive.bir.gaadi.com ')
{
   define('LOGO','assets/images/bir-motors.png');
    define('CSS','birmotors-home.css');
    define('NAME','birdealercrmbeta');
    define('CDLOGO','assets/images/cdrivelogo-b.png');
}
if($url == 'http://dealercrm.com' || $url == 'http://dealercrmbeta.gaadi.com')
{
    define('LOGO','assets/images/bir-motors.png');
    define('CSS','birmotors-home.css');
    define('NAME','dealercrmstaging');
    define('CDLOGO','assets/images/cdrivelogo-b.png');

}
else
{
    define('LOGO','assets/images/cdrivelogo-b.png');
    define('CSS','home_style.css');
    define('NAME','dealercrmbeta');
    define('CDLOGO','assets/images/autocredits.png');
}

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


defined('HOST')                         OR define('HOST','http://'.$_SERVER['HTTP_HOST'].'/');//CHANGE IN PRODUCTION
defined('BASE_URL')                     OR define('BASE_URL',HOST );//CHANGE IN PRODUCTION
/*
| Api Urls constants
|
*/
if (!function_exists('p'))
{

    function p($data)
    {
        echo '';
        print_r($data);
        die;
    }

}
defined('SMS_URL') OR define('SMS_URL',"http://www.gaadi.com/api_send_sms.php" );

defined('CENTRAL_CITY_LIST') OR define('CENTRAL_CITY_LIST',"city_list" );
define('BANK_LOGO',"http://beta.dealercrm.gaadi.com/assets/images/banklogo/");

defined('IS_CLASSIFIED_PACKAGE') OR define('IS_CLASSIFIED_PACKAGE','1');
defined('IS_CLASSIFIED_LIMIT') OR define('IS_CLASSIFIED_LIMIT','5');
defined('IS_FEATURED_LIMIT') OR define('IS_FEATURED_LIMIT','50');

defined('TOTALCLASSIFIED') OR define('TOTALCLASSIFIED',"50");
defined('CLASSIFIEDLIMIT') OR define('CLASSIFIEDLIMIT',"100");

define('PERSONAL_DOCS','61,10,8,9,23');
define('CENTRAL_USED_CAR','crm_used_car');
define('BANK_EMP_LIMIT_MAPPING','bank_employee_limit_mapping');
define('CARCOLOR','carcolor');
define('CAR_MAKE','car_make');
define('CNT_USED_CAR_DOCS','cnt_used_car_docs');
define('COLORS','colors');
define('COLORVARIANT','colorvariant');
define('CRM_USER','crm_user');
define('MAKE_MODEL','make_model');
define('MODEL_VERSION','model_version');
define('ORP_ACTUAL_PRICE','orp_price_actual');
define('STATE_LIST','state_list');
define('TECHNICAL_SPECIFICATION','technical_specifications');
define('USEDCAR_ACHEATER','usedcar_acheater');
define('USEDCAR_BATTERY','usedcar_battery');
define('USEDCAR_BODYFRAME','usedcar_bodyframe');
define('USEDCAR_BREAKS','usedcar_breaks');
define('USEDCAR_CERTIFICATION_MAPPER','usedcar_certification_mapper');
define('USEDCAR_CONDITION_MAPPER','usedcar_condition_mapper');
define('USEDCAR_ELECTRICAL','usedcar_electrical');
define('USEDCAR_ETC','usedcar_etc');
define('USEDCAR_EXTERIOR','usedcar_exterior');
define('USEDCAR_INTERIOR','usedcar_interior');
define('USEDCAR_OVERALLCONDITION','usedcar_overallcondition');
define('USEDCAR_SUSSTE','usedcar_susste');
define('USEDCAR_TAGS','usedcar_tags');
define('USEDCAR_TIRES','usedcar_tires');
define('USEDCAR_CERTIFICATION','used_car_certification');
define('USED_CAR_IMAGE_MAPPER','crm_used_car_image_mapper');
define('USED_CAR_MISCELLANEOUS','used_car_miscellaneous');
define('USED_CAR_MODEL_DETAILS','used_car_model_details');
define('CRM_BANK','crm_banks');
define('CRM_ROLE','	crm_role');
define('CRM_OUTLET','crm_outlet');
define('CRM_TEAM','crm_team_type');
define('TAGS_ARRAY','');
defined('IS_CLASSIFIED')   OR define('IS_CLASSIFIED','0');
defined('API_URL') OR define('API_URL', 'http://beta.priceindex.gaadi.com/');
/*;

| Database constants
|
*/
defined('AWS_PATH') OR define('AWS_PATH','http://cdn.cdrive.online/');
if(APPLICATION_ENV=='development')// || APPLICATION_ENV=='development'
{
    if($url == 'http://dealercrm.com')
    {
         defined('DB_SERVER')        OR define('DB_SERVER',"192.168.72.34");//192.168.80.13
         defined('DB_NAME')          OR define('DB_NAME',"dealercrmstaging");
         defined('DB_USER')          OR define('DB_USER',"gaadi" );
         defined('DB_PASSWORD')      OR define('DB_PASSWORD',"gaadi@123" );
 
    }
    else{      


         defined('DB_SERVER')        OR define('DB_SERVER',"192.168.72.34");//192.168.80.13
         defined('DB_NAME')          OR define('DB_NAME',"dealercrmstaging");
         defined('DB_USER')          OR define('DB_USER',"gaadi" );
         defined('DB_PASSWORD')      OR define('DB_PASSWORD',"gaadi@123" );//G@@di\
    }

     
/*
defined('DB_SERVER')        OR define('DB_SERVER',"192.168.72.34");//192.168.80.13
defined('DB_NAME')          OR define('DB_NAME',"dealercrmbeta" );
defined('DB_USER')          OR define('DB_USER',"gaadi" );
defined('DB_PASSWORD')      OR define('DB_PASSWORD',"gaadi@123" );//G@@di\

/*defined('DB_SERVER')        OR define('DB_SERVER',"192.168.72.34");//192.168.80.13
defined('DB_NAME')          OR define('DB_NAME',"autodealercrmstaging" );
defined('DB_USER')          OR define('DB_USER',"gaadi" );
defined('DB_PASSWORD')      OR define('DB_PASSWORD',"gaadi@123" );//G@@di\
*/

//defined('DB_SERVER')        OR define('DB_SERVER',"192.168.80.13");//192.168.80.13
//defined('DB_NAME')          OR define('DB_NAME',"dealercrmnew" );
//defined('DB_USER')          OR define('DB_USER',"root" );
//defined('DB_PASSWORD')      OR define('DB_PASSWORD',"G@@di" );
/*
defined('DB_SERVER')        OR define('DB_SERVER',"192.168.80.13");//192.168.80.13
defined('DB_NAME')          OR define('DB_NAME',"crm" );
defined('DB_USER')          OR define('DB_USER',"root" );
defined('DB_PASSWORD')      OR define('DB_PASSWORD',"G@@di" );//G@@di
*/


//defined('DB_SERVER')        OR define('DB_SERVER',"localhost");//192.168.80.13


//defined('DB_SERVER')        OR define('DB_SERVER',"localhost");//192.168.80.13
//defined('DB_NAME')          OR define('DB_NAME',"crm_local" );
//defined('DB_USER')          OR define('DB_USER',"root" );

//defined('DB_PASSWORD')      OR define('DB_PASSWORD',"gaadi" );//G@@di




//defined('DB_SERVER')        OR define('DB_SERVER',"localhost");//192.168.80.13
//defined('DB_NAME')          OR define('DB_NAME',"crm_local" );
//defined('DB_USER')          OR define('DB_USER',"root" );

//defined('DB_PASSWORD')      OR define('DB_PASSWORD',"gaadi" );//G@@di
defined('UPLOAD_IMAGE_URL') OR define('UPLOAD_IMAGE_URL',"http://localhost/girnarsoft-rc-transfer/");
defined('UPLOAD_IMAGE_PATH') OR define('UPLOAD_IMAGE_PATH',"/opt/lampp/htdocs/dealercrmimage/");
defined('UPLOAD_INS_IMAGE_PATH') OR define('UPLOAD_INS_IMAGE_PATH',"/opt/lampp/htdocs/dealercrmimage/insurance_document/");
defined('ADMIN_HOST_ROOT') OR define('ADMIN_HOST_ROOT',"http://beta.crmcdn.gaadi.com/");
defined('UPLOAD_IMAGE_URL_LOCAL') OR define('UPLOAD_IMAGE_URL_LOCAL',"http://localhost/girnarsoft-rc-transfer/");
defined('UPLOAD_IMAGE_PATH_LOCAL') OR define('UPLOAD_IMAGE_PATH_LOCAL',"/xampp/htdocs/girnarsoft-rc-transfer/");

defined('HOST_ROOT_STOCK') OR define('HOST_ROOT_STOCK', UPLOAD_IMAGE_URL.'uploaddoc/');
//define('BANK_LOGO',"http://dealercrmimage.com/assets/images/banklogo/"); 


}else{
defined('DB_SERVER')        OR define('DB_SERVER',"192.168.72.34" );//192.168.80.13
defined('DB_NAME')          OR define('DB_NAME',NAME);
defined('DB_USER')          OR define('DB_USER',"dealercrm" );
defined('DB_PASSWORD')      OR define('DB_PASSWORD',"dealercrm@123" );//G@@di

defined('UPLOAD_IMAGE_URL') OR define('UPLOAD_IMAGE_URL',"http://beta.dealercrmcdn.gaadi.com/");
defined('UPLOAD_IMAGE_PATH') OR define('UPLOAD_IMAGE_PATH',"/home/deployer/dealercrmimage/");
defined('UPLOAD_INS_IMAGE_PATH') OR define('UPLOAD_INS_IMAGE_PATH',"/home/deployer/dealercrmimage/insurance_document/");
defined('ADMIN_HOST_ROOT') OR define('ADMIN_HOST_ROOT',"http://beta.dealercrmcdn.gaadi.com/");
defined('UPLOAD_IMAGE_URL_LOCAL') OR define('UPLOAD_IMAGE_URL_LOCAL',"http://dealercrmimage.com/");
defined('UPLOAD_IMAGE_PATH_LOCAL') OR define('UPLOAD_IMAGE_PATH_LOCAL',"/xampp/htdocs/");
defined('HOST_ROOT_STOCK') OR define('HOST_ROOT_STOCK', UPLOAD_IMAGE_URL.'uploaddoc/');
//define('BANK_LOGO',"http://beta.dealercrm.gaadi.com/assets/images/banklogo/");
}

/*defined('DB_SERVER')      OR define('DB_SERVER',"192.168.80.13" );//192.168.80.13
defined('DB_NAME')          OR define('DB_NAME',"crm" );
defined('DB_USER')          OR define('DB_USER',"root" );
defined('DB_PASSWORD')      OR define('DB_PASSWORD',"G@@di" );*///G@@di

define('SEGMENT',2);

//defined('MONGO_SERVER')     OR define('MONGO_SERVER','localhost' );
//defined('MONGO_DB_NAME')    OR define('MONGO_DB_NAME','dealer' );
/*
| Base url
|
*/

//defined('DEALER_ID')          OR define('DEALER_ID',"69");
/*defined('CENTRAL_CITY_LIST')          OR define('CENTRAL_CITY_LIST',"city_list");
defined('CITY_ID')          OR define('CITY_ID',"125");
define('GAADI_COM_URL','http://www.gaadi.com/');
define('DOMAIN','http://dealercrm.com/');
define('DEALER_LOGO',DOMAIN.'assets/images/logo.jpg');*/
//define('MOBILESMS','9910085955');
//define('ORGANIZATION','Auto Credits');
define('SIS_COMPANY','ABC');
/*define('DEALER_NAME','Shashi');
define('DEALER_EMAIL','shashikant.kumar@gaadi.com');
define('DEALER_ADDRESS','F-24, Preet Vihar, Main Vikas Marg, Near Preet Vihar Metro Station, New Delhi-110018');*/

/*  
| Table constants
|
*/
const PAYMENT_BY_INHOUSE = array('1'=>'Customer','2'=>'Dealer','3'=>'Showroom','4'=>'Financier','5'=>'Third Party');
const CASE_TYPE = array('1_Purchase'=>'New Car Purchase','2_Purchase'=>'Used Car Purchase','2_refinance'=>'Used Car Refinance','2_topup'=>'Used Car Internal top up');
const PAYMENT_MODE = array("1"=>"Cash","2"=>"Cheque","3"=>"DD","4"=>"Online");
const RC_STATUS = array("1"=>"Pending","2"=>"In Process","3"=>"Transferred");
const RC_PENDING_FROM = array("1"=>"Dealer","2"=>"Self");
const INSURANCE_STATUS = array("1"=>"New","2"=>"Quotes shared","4"=>"Inspection Completed","5"=>"Policy Pending","6"=>"Payment Pending","7"=>"Cancelled","8"=>"Not Interested","9"=>"Issued");
const INSURANCE_LEFT_SIDE_MENU = array(
  'CASE_DETAILS'        => '1',
  'VEHICLE_DETAILS'     => '2',
  'INSURANCE_QUOTES'    => '3',
  'INSPECTION'          => '4',
  'PREVIOUS_POLICY'     => '5',
  'CUSTOMER_DETAILS'    => '6',
  'PAYMENT_DETAILS'     => '7',
  'NEW_POLICY_DETAILS'  => '8',
  'UPLOAD_DOCS'         => '9',
);
defined('DEALER_ID')          OR define('DEALER_ID',"69");
define('CITY_LIST',' city_list ');
define('PAGE_LIMIT_RENEW_CASE',10);
define('DEFAULT_BANK',35);
const EMPLOYEE_TEAM = array("1"=>"Loan","2"=>"Insurance","3"=>"Sales","4"=>"RTO","5"=>"RC Transfer","6"=>"Delivery","7"=>"Used Car");

const STATUS = array("0"=>"Inactive","1"=>"Active");
const NCB_DISCOUNT_PREV = array("0"=>"0%","20"=>"20%","25"=>"25%","35"=>"35%","45"=>"45%","50"=>"50%","55"=>"55%","60"=>"60%","65"=>"65%");
const NCB_DISCOUNT = array("0"=>"0%","20"=>"20%","25"=>"25%","35"=>"35%","45"=>"45%","50"=>"50%","55"=>"55%","60"=>"60%","65"=>"65%");

const INSURANCE_POLICY_TYPE = array("1"=>"Comprehensive","2"=>"Third Party","3"=>"Own Damage Only");

