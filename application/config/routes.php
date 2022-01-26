<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
$route['admin/dashboard'] = "dashboard/dashboardMain";
$route['dealerListing']        = 'Dealer/dealerListing';
$route['dealerListing/(:num)'] = "Dealer/dealerListing/$1";
$route['dealerListing/exportdealer/(:num)'] = "Dealer/exportDealerExcel/$1";
$route['addDealer']            = "Dealer/addNew";
$route['saveDealer']            = "Dealer/addNewDealer";
$route['saveDealer/(:any)']     = "Dealer/addNewDealer/$1";
$route['addUser']              = "User/addUser";
$route['addUser/(:any)']       = "User/addUser/$1";
$route['updateUser/(:any)']    = "User/updateUser/$1";
$route['editDealer']           = "Dealer/editDealer";
$route['editDealer/(:any)']    = "Dealer/editDealer/$1";
$route['bank']                 = 'Bank/bankListing';
$route['addBank']              = "Bank/addBank";
$route['addBank/(:num)']       = "Bank/addBank/$1";
$route['bankCheck/(:num)']     = "Bank/activeInactive/$1";
$route['addNewBank']           = "Bank/addNewBank";
$route['addBank/(:any)']    = "Bank/addBank/$1";
$route['editBank/(:any)']      = "Bank/editBank/$1";
$route['updateBank/']           = "Bank/updateBank";
$route['addLead']              = 'Lead/AddLeadIndex';
$route['addLead/(:num)']       = "Lead/AddLeadIndex/$1";
//$route['role/(:any)']          = "Role/index/$1";
$route['addRole']              = "Role/addNewRole";
$route['addRole/(:any)']       = "Role/addNewRole/$1";
$route['team']                 = "Team/team";
$route['team/(:num)']          = "Team/team/$1";
$route['inventoryListing']     = 'Stock/inventoryListing';
$route['inventoryListing/(:any)'] = 'Stock/inventoryListing/$1';
$route['carDetails/(:any)']    = 'Stock/carDetails/$1';
$route['inventoryAjax']         = 'Stock/inventoryAjax';
$route['team/activeInactiveTeam']= "Team/activeInactiveTeam";
$route['role/activeInactiveRole']= "Role/activeInactiveRole";
//$route['inventories/add_inventories/(:any)']     = "inventories/add_inventories/$1";
$route['inventories']     = "inventories/index";
$route['default_controller'] = 'welcome';
$route['default_controller'] = 'login';
$route['userList']               = 'user/userList';
$route['userList/(:num)']        = "user/userList/$1";
$route['addInsurance']           = "Insurance/addNew";
$route['addInsurance/(:any)']    = "Insurance/addNew/$1";
$route['addNewProcess']           = "Insurance/addNewProcess";
$route['saveUpdateInsuranceData'] = "Insurance/saveUpdateInsuranceData";
$route['saveUpdateInsuranceData/(:any)'] = "Insurance/saveUpdateInsuranceData/$1";
$route['inspersonalDetail']            = 'Insurance/inspersonalDetail';
$route['inspersonalDetail/(:any)']     = "Insurance/inspersonalDetail/$1";
$route['insvehicalDetail']            = 'Insurance/insvehicalDetail';
$route['insvehicalDetail/(:any)']     = "Insurance/insvehicalDetail/$1";
$route['insCustomerStatus']            = 'Insurance/insCustomerStatus';
$route['insCustomerStatus/(:any)']        = "Insurance/insCustomerStatus/$1";
$route['insPremiumDetails']            = 'Insurance/insPremiumDetails';
$route['insPremiumDetails/(:any)']        = "Insurance/insPremiumDetails/$1";
$route['insPreviousDetails']            = 'Insurance/insPreviousDetails';
$route['insPreviousDetails/(:any)']        = "Insurance/insPreviousDetails/$1";
$route['insPolicyDetails']            = 'Insurance/insPolicyDetails';
$route['insPolicyDetails/(:any)']        = "Insurance/insPolicyDetails/$1";
$route['insDocumentDetails']            = 'Insurance/insDocumentDetails';
$route['insDocumentDetails/(:any)']        = "Insurance/insDocumentDetails/$1";
$route['uploadDocument']            = 'Insurance/uploadDocument';
$route['uploadDocument/(:any)']        = "Insurance/uploadDocument/$1";
$route['inspaymentDetail']            = 'Insurance/inspaymentDetail';
$route['inspaymentDetail/(:any)']        = "Insurance/inspaymentDetail/$1";
$route['insFileLogin']            = 'Insurance/insFilelogin';
$route['insFileLogin/(:any)']        = "Insurance/insFilelogin/$1";
$route['getinsFilelogin/(:any)']            = 'Insurance/getinsFilelogin/$1';
$route['insInspection']            = 'Insurance/insInspection';
$route['insInspection/(:any)']        = "Insurance/insInspection/$1";
$route['insListing/(:any)']            = 'Insurance/insListing/$1';
$route['insListing']            = 'Insurance/insListing';
$route['reopenCase']            = 'Insurance/reopenCase';
$route['leadDetails']            = 'Finance/renderLeadDetailsForm';
$route['leadDetails/(:any)']     = "Finance/renderLeadDetailsForm/$1";
$route['saveUpdateFinanceData']  = 'Finance/saveUpdateFinanceData';
$route['saveUpdateFinanceData/(:any)'] = "Finance/saveUpdateFinanceData/$1";
$route['personalDetail']               = 'Finance/personalDetail';
$route['personalDetail/(:any)']        = "Finance/personalDetail/$1";
$route['financeAcedmic']               = 'Finance/financeAcedmic';
$route['financeAcedmic/(:any)']        = "Finance/financeAcedmic/$1";
$route['loanExpected']                 = 'Finance/loanExpected';
$route['loanExpected/(:any)']          = "Finance/loanExpected/$1";
$route['residentialInfo']                 = 'Finance/residentialInfo';
$route['residentialInfo/(:any)']          = "Finance/residentialInfo/$1";
$route['refrenceDetails']                 = 'Finance/refrenceDetails';
$route['refrenceDetails/(:any)']          = "Finance/refrenceDetails/$1";
$route['loanFileLogin']                 = 'Finance/loanFileLogin';
$route['loanFileLogin/(:any)']          = "Finance/loanFileLogin/$1";

$route['cpvDetails']                 = 'Finance/cpvDetails';
$route['cpvDetails/(:any)']          = "Finance/cpvDetails/$1";
$route['decisionDetails']                 = 'Finance/decisionDetails';
$route['decisionDetails/(:any)']          = "Finance/decisionDetails/$1";
$route['disbursalDetails']                 = 'Finance/disbursalDetails';
$route['disbursalDetails/(:any)']          = "Finance/disbursalDetails/$1";

$route['postDeliveryDetails']               = 'Finance/postDeliveryDetails';
$route['postDeliveryDetails/(:any)']        = "Finance/postDeliveryDetails/$1";
$route['paymentDetails']               = 'Finance/paymentDetails';
$route['paymentDetails/(:any)']        = "Finance/paymentDetails/$1";
$route['uploadDocs']                 = 'Finance/uploadDocs';
$route['uploadDocs/(:any)']          = "Finance/uploadDocs/$1";
$route['uploadDocs/(:any)/(:any)']     = "Finance/uploadDocs/$1/$1";
$route['dashboardDetails']          = "Finance/dashboardDetails";
$route['loanListing']          = "Finance/loanListing";
$route['loanListing/(:any)']          = "Finance/loanListing/$1";
$route['loanDoInfo']          = "DeliveryOrder/loanDoInfo";
$route['loanDoInfo/(:any)']          = "DeliveryOrder/loanDoInfo/$1";
$route['loanReceiptDetail']          = "DeliveryOrder/loanReceiptDetail";
$route['loanReceiptDetail/(:any)']   = "DeliveryOrder/loanReceiptDetail/$1";
$route['saveDeliveryOrderData']  = 'DeliveryOrder/saveDeliveryOrderData';
$route['saveDeliveryOrderData/(:any)'] = "DeliveryOrder/saveDeliveryOrderData/$1";
$route['loanDetails']  = 'DeliveryOrder/loanDetails';
$route['dealerDetails']  = 'DeliveryOrder/dealerDetails';
$route['orderListing']  = 'DeliveryOrder/orderListing';
$route['bookingDetails']  = 'DeliveryOrder/bookingDetails';
$route['orderListing/(:any)']          = "DeliveryOrder/orderListing/$1";
$route['getpdf/(:any)/(:any)']  = 'DeliveryOrder/getpdf/$1/$1';
$route['bankInfo']               = 'Finance/bankInfo';
$route['bankInfo/(:any)']        = "Finance/bankInfo/$1";

$route['addRcCase']              = "RcCase/add_rc_transfer";
$route['rcUploadDoc']            = "RcCase/rcTransferUploadDoc";
$route['rcUploadDoc/(:any)']     = "RcCase/rcTransferUploadDoc/$1";


$route['rcListing']              = "RcCase/rcListing";
$route['rcListing/(:any)']       = "RcCase/rcListing/$1";
$route['rcDetail']          = "RcCase/rcDetail";
$route['rcDetail/(:any)']          = "RcCase/rcDetail/$1";
$route['uploadRcDocs']  = "RcCase/uploadRcDocs";
$route['uploadRcDocs/(:any)']  = "RcCase/uploadRcDocs/$1";
$route['uploadRcDocs/(:any)/(:any)']     = "RcCase/uploadRcDocs/$1/$1";
$route['advBookingListing'] =  'DeliveryOrder/advBookingListing/';
$route['addadvbooking'] =  'DeliveryOrder/addadvbooking';
$route['addadvbooking/(:any)'] =  'DeliveryOrder/addadvbooking/$1';
$route['getLeads/(:any)']     = "Lead/getLeads/$1";
$route['buyerleadlist']       = 'Lead/buyerleadreportlist';
$route['buyerleadlist/(:any)']       = 'Lead/buyerleadreportlist/$1';
$route['getImagedownload']               = 'Finance/getImagedownload';
$route['getImagedownload']               = 'Insurance/getImagedownload';
$route['cron/singlebuyerLeadsToDC'] = 'Crontodo/singlebuyerLeadsToDC';
$route['cron/buyerLeadsToDC'] = 'Crontodo/buyerLeadsToDC';
$route['cron/buyerUpdateLeadsToDC'] = 'Crontodo/buyerUpdateLeadsToDC';
$route['api/buyerupdatedLeadsfromDC'] = 'Apitodo/buyerupdatedLeadsfromDC';
$route['api/SyncbuyerupdatedLeadsfromDC/(:any)'] = 'Apitodo/SyncbuyerupdatedLeadsfromDC/$1';
$route['cron/sellerLeadunSyncToDC/(:any)'] = 'Crontodo/sellerLeadunSyncToDC/$1';
$route['cron/sellerLeadCommentsToDC/(:any)'] = 'Crontodo/sellerLeadCommentsToDC/$1';
$route['api/addRc/(:any)'] = 'Apitodo/addRcCaseTransfer/$1';
$route['api/sellerupdatedLeadsfromDC/(:any)'] = 'Apitodo/sellerupdatedLeadsfromDC/$1';
$route['api/setSellCustomerCommentsfromDC/(:any)'] = 'Apitodo/setSellCustomerCommentsfromDC/$1';
$route['api/setSellCustomerStatusfromDC/(:any)'] = 'Apitodo/setSellCustomerStatusfromDC/$1';
$route['api/sellerupdatedCommentsLeadsfromDC/(:any)'] = 'Apitodo/sellerupdatedCommentsLeadsfromDC/$1';
$route['api/sellerupdatedStatusLeadsfromDC/(:any)'] = 'Apitodo/sellerupdatedStatusLeadsfromDC/$1';
$route['getinspdf/(:any)']  = 'Insurance/getinspdf/$1';
$route['usedcarpurchase/(:any)'] 		= "UsedcarPurchase/usedcarpurchase/$1";
$route['cardetails/(:any)']     		= "UsedcarPurchase/usedcarcardetail/$1";
$route['uploadcardocs/(:any)']     	= "UsedcarPurchase/uploadDocs/$1";
$route['sellerdetails/(:any)']     		= "UsedcarPurchase/sellerDetails/$1";
$route['paymentdetails/(:any)']    	 = "UsedcarPurchase/paymentDetails/$1";
$route['refurbdetails/(:any)']     		= "UsedcarPurchase/refurbDetails/$1";
$route['uploadcardocs/(:any)/(:any)']     = "UsedcarPurchase/uploadDocs/$1/$1";
$route['centralStockExists']     = "UsedcarPurchase/checkCentralStock";
$route['printpdf/(:any)']  = 'UsedcarPurchase/printpdf/$1';
$route['refurbworkshoplisting'] =  'DeliveryOrder/refurbWorkshopListing/';
$route['addrefurbworkshop'] =  'DeliveryOrder/addrefurbworkshop';
$route['addrefurbworkshop/(:any)'] =  'DeliveryOrder/addrefurbworkshop/$1';
$route['getInsCases']     = "Insrenewal/getInsCases";
$route['getInsCases/(:any)']     = "Insrenewal/getInsCases/$1";
$route['renewlisting']      = 'Insrenewal/getRenewListing';
$route['renewlisting/(:any)'] = 'Insrenewal/getRenewListing/$1';
$route['api/addCrmUC'] = 'Apitodo/addUsedCarDetailsApi';
$route['api/addCrmUC/(:any)'] = 'Apitodo/addUsedCarDetailsApi/$1';
$route['api/dcToCrmImageSync/(:any)'] = 'Apitodo/dcToCrmImageSync/$1';
$route['addBuyerLead']              = 'UsedCarSale/AddLeadIndex';
$route['saveUpdateUsedCarsaleData'] = "UsedCarSale/saveUpdateUsedCarsaleData";
$route['uploadUcSalesDocument/(:any)'] = "UsedCarSale/uploadCustomerDocs/$1";
$route['uploadUcSalesDocument/(:any)/(:any)'] = "UsedCarSale/uploadCustomerDocs/$1/$2";
$route['addUcBuyerLead']                              = 'UsedCarSale/AddLeadIndex';
$route['addUcBuyerLead/(:any)']                       = 'UsedCarSale/AddLeadIndex/$1';
$route['saveUpdateUsedCarsaleData']                   = "UsedCarSale/saveUpdateUsedCarsaleData";
//$route['uploadUcSalesDocument/(:any)']                = "UsedCarSale/uploadCustomerDocs";
$route['uploadVehicleDeliveryImages/(:any)']          = "UsedCarSale/uploadVehicleDocs";

$route['ucSalesTxnDetails/(:any)']                    = "UsedCarSale/getTransactionDetails/$1";
$route['ucSalesBookingDetails/(:any)']                = "UsedCarSale/getBookingDetails/$1";
$route['ucSalesPaymentDetails/(:any)']                = "UsedCarSale/getPaymentDetails/$1";
$route['ucSalesDeliveryDetails/(:any)']               = "UsedCarSale/getDeliveryDetails/$1";
$route['cron/addrenewCase/(:any)'] = 'Crontodo/addNewcaseInsurance/$1';
$route['paymentRefurb']= 'Stock/paymentRefurb';
$route['bankListingNew']= 'Bank/bankListingNew';
$route['ucSalesChecklist']     	              = "UsedCarSale/checkList";

$route['Finance/loanpdf/(:any)']  = 'Finance/printpdf/$1';
$route['EmployeeListing']= 'User/EmployeeListing';
$route['refurblisting']      = 'Refurb/refurblisting';
$route['refurblist']      = 'Refurb/refurblist';
$route['DealerListingNew']      = 'Dealer/DealerListingNew';
$route['cron/adminPullDealer'] = 'Crontodo/adminPullDealer';
$route['workdetails']      = 'Refurb/workdetails';

$route['cron/dcToCrmStockSync'] = 'cron/StockSync/dcToCrmStockSync';
$route['cron/dcToCrmImageSync'] = 'cron/StockSync/dcToCrmImageSync';
$route['cron/crmToDcImageSync'] = 'cron/StockImagesSync/sync';
$route['insurance/uploadexcel'] = 'Insurance/uploadexcel';

$route['lead/assignment'] = 'Lead/getLeadAssignment';
$route['dopayment']               = 'DeliveryOrder/dopayment';
$route['dopayment/(:any)']        = "DeliveryOrder/dopayment/$1";

$route['loanpayment']               = 'Finance/loanpayment';
$route['loanpayment/(:any)']        = "Finance/loanpayment/$1";

$route['loanPayout']               = 'Payout/loanPayout';
$route['loanPayout/(:any)']        = "Payout/loanPayout/$1";

$route['makePayout']               = 'PayoutInsurance/makePayout';
$route['makePayout/(:any)']   = "PayoutInsurance/makePayout/$1";
$route['insurancePayout']          = 'PayoutInsurance/insurancePayout';
$route['insurancePayout/(:any)/(:any)']   = "PayoutInsurance/insurancePayout/$1/$2";
$route['insurancePayout/(:any)']   = "PayoutInsurance/insurancePayout/$1";    
$route['cron/sendSmsToDealer'] = 'Crontodo/sendSmsToDealer';
$route['payoutFromCompanies']          = 'PayoutInsurance/insurancePayoutOthers';
$route['payoutFromCompanies/(:any)']          = 'PayoutInsurance/insurancePayoutOthers/$1';

$route['cron/pullmodel'] = 'Crontodo/pullModel';
$route['cron/pullversion'] = 'Crontodo/pullVersion';
$route['docmanager'] = 'Docmanager/docManager';
$route['cron/oneTimeDoMigration'] = 'Crontodo/oneTimeDoMigration';
$route['getUserRoleByTeam'] = 'user/getUserRoleByTeam';

$route['addNewUser'] = 'user/addNew';
$route['edituser/(:any)']       = "User/edit/$1";
$route['rc_make_payment']       = "RcCase/rc_make_payment";
$route['rc_make_payment/(:any)']       = "RcCase/rc_make_payment/$1";
$route['cron/updateMiscellaneous'] = 'Crontodo/updateMiscellaneous';
$route['cron/updateCarPermits'] = 'Crontodo/updateCarPermits';
$route['cron/updateinsurancestatus'] = 'Crontodo/checkinsuranceValid';
$route['dashboard/(:any)']       = "dashboard/dashboardMain/$1";
$route['dashboard']       = "dashboard/dashboardMain";

$route['cron/moveoldimagestoaws'] = 'Crontodo/moveoldimagestoaws';
$route['cron/uploadimagestoaws'] = 'Crontodo/uploadimagestoaws';
$route['downloadCSV/(:any)']       = "PayoutInsurance/downloadCSV/$1";
$route['getdashboardlistpage/(:any)'] = 'lead/getdashboardlistpage/$1';
$route['loanEmailReport'] = 'Reporting/loanEmailReport';
$route['insuranceEmailReport'] = 'Reporting/insuranceEmailReport';
$route['coapplicantDetail/(:any)'] = 'Finance/coapplicantDetail/$1';
$route['guarantorDetail/(:any)'] = 'Finance/guarantorDetail/$1';





