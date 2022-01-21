<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Financce (FinanceController)
 * User Class to control all dealer related operations.
 * @author : apoorva panchal
 */
class Reporting extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Crm_user');
        $this->load->model('Crm_rc');
        $this->load->model('Crm_insurance');
        $this->load->model('Loan_customer_info');
        $this->load->model('Loan_customer_case');
        $this->load->library('form_validation');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_dealers');
        $this->load->model('Make_model');
        $this->load->model('UserDashboard');
        $this->load->model('Loan_customer_reference_info');
        $this->load->model('City');
        $this->load->model('Crm_banks_List');
        $this->load->model('state_list');
        $this->load->model('Crm_banks');
        $this->load->model('Loan_post_delivery_info');
        $this->load->model('Crm_insurance_company');
        $this->load->model('Loan_payment_info');
        $this->load->model('Crm_applicant_type');
        $this->load->model('Crm_upload_docs_list');
        $this->load->model('crm_stocks');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_buy_lead_history_track');
        if (!$this->session->userdata['userinfo']['id'])
        {
            return redirect('login');
        }
        $this->load->helper('mail_helper');
        //error_reporting(1);
        //ini_set('display_errors', 1);
    }

    public function loanEmailReport()
    {
        $getAllBankId = $this->Crm_banks->getAllBankId();
        foreach($getAllBankId as $key => $val){
            $loanCount['bank'][$val['bank_name']]['purchase'] = current($this->Loan_customer_case->getBankWiseLoanHistoryReport('1',$val['bank_id']));
            $loanCount['bank'][$val['bank_name']]['refinance']  = current($this->Loan_customer_case->getBankWiseLoanHistoryReport('2',$val['bank_id']));
           
        }
        $getEmployee = $this->Crm_user->getEmployee();
        foreach($getEmployee as $keys => $vals){
            $loanCount['emp'][$vals['name']]['purchase'] = current($this->Loan_customer_case->getEmpWiseLoanHistoryReport('1',$vals['id']));
            $loanCount['emp'][$vals['name']]['refinance']  = current($this->Loan_customer_case->getEmpWiseLoanHistoryReport('2',$vals['id']));
           
        }
      //  $message = 'Please find below the number of cases added/update Today ('.date('jS M, Y').')';
        $message = $this->renderTableHtml($loanCount); //exit;
        $to = 'rahul.bothra@girnarsoft.com, monalisa.nayak@girnarsoft.com, apoorva.panchal@girnarsoft.com' ;
        $subject = "Loan Cases Report ".date('d M, Y');
       // $sendMail =  commonMailSenderNew($to, $subject, $message,'','Gaadi.com');
          $this->sendReportMail('apoorva.panchal257@gmail.com','Cdrive.com',$to,$message,$subject);
        
    }


    public function renderTableHtml($data)
    {
        $logo = LOGO;
        $cdrivelogo = CDLOGO;
        $todaydate = date('jS M, Y');
        $html = '<!doctype html>
                    <html lang="en">
                       <head>
                          <meta charset="utf-8">
                          <meta http-equiv="X-UA-Compatible" content="IE=edge">
                          <meta name="viewport" content="width=device-width, initial-scale=1">
                          <title>Loan Cases Report</title>
                       </head>
                       <body style="font-family: roboto,Sans-Serif,Arial;font-size:12px;">
                          <table  style="width: 600px;margin: 0 auto;border: 1px solid #ddd;background-color: #f1f2f4; border-collapse: collapse; border-spacing: 0; ">
                             <tbody>
                                <tr>
                                   <td>
                                      <table  style="background:#ffffff; WIDTH:590PX;margin: 10px auto 10px;border-radius: 8px;box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.15); border-collapse: collapse; border-spacing: 0; ">
                                         <tbody>
                                           <tr>
                                              <td style="padding:15px; text-align:left"><a href="" target="_blank"><img src="'.$logo.'" alt="" title="" style="width:130px;"></a></td>
                                               <td style="padding:15px; text-align:right"><a href="" target="_blank"><img src="'.$cdrivelogo.'" alt="" title="" style="width:120px;"></a></td>
                                            </tr>
                                          
                                            <tr>
                                               <td colspan="2"  style="padding:20px 25px 0px;">
                                                  <table style=" border-collapse: collapse; border-spacing: 0;width:100%;">
                                                     <tbody>
                                                      
                                                         <tr>
                                                           <td style="font-size: 15px; line-height: 1.5; color: #24272c;"><strong>Hi All,</strong></td>
                                                        </tr>
                                                        <tr>
                                                           <td style="font-size: 14px; line-height: 1.41; color: #24272c; padding-top: 10px;">
                                                             Please find below the number of cases added/updated in Loan Module today ('.$todaydate.')
                                                           </td>
                                                        </tr>
                                                         
                                                     </tbody>
                                                  </table>
                                                  
                                               </td>
                                            </tr>
                                            
                                             <tr>
                                               <td colspan="2"  style="padding:10px 25px 10px;">
                                                  <table style=" border-collapse: collapse; border-spacing: 0;width:100%;">
                                                     <tbody>
                                                      
                                                        <tr>
                                                           <td style="font-size: 14px; line-height: 1.41; color: #24272c; padding-top: 10px;">
                                                            Report 1 : Bankwise cases updated :
                                                           </td>
                                                        </tr>
                                                        
                                                        
                                                        <tr>
                                                           <td style="padding-top:10px;">
                                                              <table style="width:100%;border-spacing: 0;" border="1">
                                                                 <tbody>
                                                                    <tr>
                                                                       <th>&nbsp;</th>
                                                                       <th colspan="4">Purchase</th>
                                                                       <th colspan="4">Refinance</th>
                                                                    </tr>
                                                               <tr>
                                                                        <td style="padding: 3px 5px">Cases / Bank</td>
                                                                       
                                                                          <td style="padding: 3px 5px">Added</td>
                                                                          <td style="padding: 3px 5px">File LogIn</td>
                                                                          <td style="padding: 3px 5px">Approved</td>
                                                                          <td style="padding: 3px 5px">Disbursed</td>
                                                                         
                                                                          <td style="padding: 3px 5px">Added</td>
                                                                          <td style="padding: 3px 5px">File LogIn</td>
                                                                          <td style="padding: 3px 5px">Approved</td>
                                                                          <td style="padding: 3px 5px">Disbursed</td>
                                                                       
                                                                    </tr>';
                                                                    
                                                                   foreach ($data['bank'] as $bankname => $value) {
                                                                        $purchaseAdded = $value['purchase']['Added'];
                                                                        $purchasefiled = $value['purchase']['Filed'];
                                                                        $purchaseapproved = $value['purchase']['Approved'];
                                                                        $purchasedisbursed = $value['purchase']['Disbursed'];

                                                                        $refinanceAdded = $value['refinance']['Added'];
                                                                        $refinancefiled = $value['refinance']['Filed'];
                                                                        $refinanceapproved = $value['refinance']['Approved'];
                                                                        $refinancedisbursed = $value['refinance']['Disbursed'];
                                                                 if((empty($purchaseAdded)) && (empty($purchasefiled)) && (empty($purchaseapproved)) && (empty($purchasedisbursed)) && (empty($refinanceAdded)) && (empty($refinancefiled)) && (empty($refinanceapproved)) && (empty($refinancedisbursed)))
                                                                 {
                                                                    continue;
                                                                 }      
                                                          $html.= ' <tr>
                                                   <td style="padding: 3px 5px">'.$bankname.'</td>
                                                   
                                                      <td style="padding: 3px 5px">'.$purchaseAdded.'</td>
                                                      <td style="padding: 3px 5px">'.$purchasefiled.'</td>
                                                      <td style="padding: 3px 5px">'.$purchaseapproved.'</td>
                                                      <td style="padding: 3px 5px">'.$purchasedisbursed.'</td>
                                                     
                                                      <td style="padding: 3px 5px">'.$refinanceAdded.'</td>
                                                      <td style="padding: 3px 5px">'.$refinancefiled.'</td>
                                                      <td style="padding: 3px 5px">'.$refinanceapproved.'</td>
                                                      <td style="padding: 3px 5px">'.$refinancedisbursed.'</td>
                                                   
                                                </tr>' ; 
                                             }                                                                    
                                                                $html.=  '</tbody>
                                                              </table>
                                                           </td>
                                                        </tr>
                                                         
                                                     </tbody>
                                                  </table>
                                                  
                                               </td>
                                            </tr>
                                            
                                             <tr>
                                               <td colspan="2" style="padding:10px 25px 10px;">
                                                  <table style=" border-collapse: collapse; border-spacing: 0;width:100%;">
                                                     <tbody>
                                                      
                                                        <tr>
                                                           <td style="font-size: 14px; line-height: 1.41; color: #24272c; padding-top: 10px;">
                                                            Report 2 : Employee wise cases updated 
                                                           </td>
                                                        </tr>
                                                        
                                                        
                                                        <tr>
                                                           <td style="padding-top:10px;">
                                                              <table style="width:100%;border-spacing: 0;" border="1">
                                                                 <tbody>
                                                                    <tr>
                                                                       <th>&nbsp;</th>
                                                                       <th colspan="4">Purchase</th>
                                                                       <th colspan="4">Refinance</th>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                       <td style="padding: 3px 5px">Cases / Employee</td>
                                                                       
                                                                          <td style="padding: 3px 5px">Added</td>
                                                                          <td style="padding: 3px 5px">File LogIn</td>
                                                                          <td style="padding: 3px 5px">Approved</td>
                                                                          <td style="padding: 3px 5px">Disbursed</td>
                                                                         
                                                                          <td style="padding: 3px 5px">Added</td>
                                                                          <td style="padding: 3px 5px">File LogIn</td>
                                                                          <td style="padding: 3px 5px">Approved</td>
                                                                          <td style="padding: 3px 5px">Disbursed</td>
                                                                       
                                                                    </tr>';
                                                                     foreach ($data['emp'] as $empname => $empCount) {
                                                                        $emppurchaseAdded = $empCount['purchase']['Added'];
                                                                        $emppurchasefiled = $empCount['purchase']['Filed'];
                                                                        $emppurchaseapproved = $empCount['purchase']['Approved'];
                                                                        $emppurchasedisbursed = $empCount['purchase']['Disbursed'];

                                                                        $emprefinanceAdded = $empCount['refinance']['Added'];
                                                                        $emprefinancefiled = $empCount['refinance']['Filed'];
                                                                        $emprefinanceapproved = $empCount['refinance']['Approved'];
                                                                        $emprefinancedisbursed = $empCount['refinance']['Disbursed'];
                                                                        if((empty($emppurchaseAdded)) && (empty($emppurchasefiled)) && (empty($emppurchaseapproved)) && (empty($emppurchasedisbursed)) && (empty($emprefinanceAdded)) && (empty($emprefinancefiled)) && (empty($emprefinanceapproved)) && (empty($emprefinancedisbursed)))
                                                                 {
                                                                    continue;
                                                                 }      

                                                                     $html .='<tr>
                                                                       <td style="padding: 3px 5px">'.$empname.'</td>
                                                                       
                                                                          <td style="padding: 3px 5px">'.$emppurchaseAdded.'</td>
                                                                          <td style="padding: 3px 5px">'.$emppurchasefiled.'</td>
                                                                          <td style="padding: 3px 5px">'.$emppurchaseapproved.'</td>
                                                                          <td style="padding: 3px 5px">'.$emppurchasedisbursed.'</td>
                                                                         
                                                                          <td style="padding: 3px 5px">'.$emprefinanceAdded.'</td>
                                                                          <td style="padding: 3px 5px">'.$emprefinancefiled.'</td>
                                                                          <td style="padding: 3px 5px">'.$emprefinanceapproved.'</td>
                                                                          <td style="padding: 3px 5px">'.$emprefinancedisbursed.'</td>
                                                                       
                                                                    </tr>';
                                                                  }  
                                                                     
                                                                    
                                                                $html.= '</tbody>
                                                              </table>
                                                           </td>
                                                        </tr>
                                                         
                                                     </tbody>
                                                  </table>
                                                  
                                               </td>
                                            </tr>
                                            
                                         </tbody>
                                      </table>
                                   </td>
                                </tr>
                               
                               
                             </tbody>
                          </table>
                       </body>
                    </html>';
        return $html;
    }


    public function insuranceEmailReport()
    {
            $getEmployee = $this->Crm_user->getEmployee();
            foreach($getEmployee as $keys => $vals){
                $historyData['emp'][$vals['name']] = current($this->Crm_insurance->getInshistoryEmail($vals['id']));             
            }
            $historyData['comp']=$this->Crm_insurance->getInsuranceCompMailer();
            $message = $this->renderInsuranceMailer($historyData); 
            $to = 'rahul.bothra@girnarsoft.com, monalisa.nayak@girnarsoft.com, apoorva.panchal@girnarsoft.com' ;
            $subject = "Insurance Cases Report ".date('d M, Y');
            //$sendMail =  commonMailSenderNew($to, $subject, $message,'','Gaadi.com');
            $this->sendReportMail('apoorva.panchal257@gmail.com','Cdrive.com',$to,$message,$subject);
    }

    public function renderInsuranceMailer($data)
    {
        $logo = LOGO;
        $cdrivelogo = CDLOGO;
        $todaydate = date('jS M, Y');
        $html = '<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Insurance Report</title>
   </head>
   <body style="font-family: roboto,Sans-Serif,Arial;font-size:12px;">
      <table  style="width: 600px;margin: 0 auto;border: 1px solid #ddd;background-color: #f1f2f4; border-collapse: collapse; border-spacing: 0; ">
         <tbody>
            <tr>
               <td>
                  <table  style="background:#ffffff; WIDTH:590PX;margin: 10px auto 10px;border-radius: 8px;box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.15); border-collapse: collapse; border-spacing: 0; ">
                     <tbody>
                        <tr>
                          <td style="padding:15px; text-align:left"><a href="" target="_blank"><img src="'.$logo.'" alt="" title="" style="width:130px;"></a></td>
                           <td style="padding:15px; text-align:right"><a href="" target="_blank"><img src="'.$cdrivelogo.'" alt="" title="" style="width:120px;"></a></td>
                        </tr>
                      
                        <tr>
                           <td colspan="2"  style="padding:20px 25px 0px;">
                              <table style=" border-collapse: collapse; border-spacing: 0;width:100%;">
                                 <tbody>
                                  
                                     <tr>
                                       <td style="font-size: 15px; line-height: 1.5; color: #24272c;"><strong>Hi All,</strong></td>
                                    </tr>
                                    <tr>
                                       <td style="font-size: 14px; line-height: 1.41; color: #24272c; padding-top: 10px;">
                                       Please find below the number of cases added/updated in Insurance Module today ('.$todaydate.')
                                       </td>
                                    </tr>
                                     
                                 </tbody>
                              </table>
                              
                           </td>
                        </tr>
                        
                         <tr>
                           <td colspan="2"  style="padding:10px 25px 10px;">
                              <table style=" border-collapse: collapse; border-spacing: 0;width:100%;">
                                 <tbody>
                                  
                                    <tr>
                                       <td style="font-size: 14px; line-height: 1.41; color: #24272c; padding-top: 10px;">
                                      Report 1 : Insurance Company wise cases updated :
                                       </td>
                                    </tr>
                                    
                                    
                                    <tr>
                                       <td style="padding-top:10px;">
                                          <table style="width:100%;border-spacing: 0;" border="1">
                                             <tbody>
                                              
                                                
                                                <tr>
                                                   <td style="padding: 3px 5px; font-weight:bold;">Cases / Insurers</td>
                                                   <td style="padding: 3px 5px;font-weight:bold;">Issued</td>
                                                </tr>';
                                                foreach($data['comp'] as $compkey => $valu){
                                                    $name = $valu['short_name'];
                                                    $counter = $valu['counter'];
                                              $html .= ' <tr>
                                                   <td style="padding: 3px 5px; font-weight:bold;">'.$name.'</td>
                                                   <td style="padding: 3px 5px;font-weight:bold;">'.$counter.'</td>
                                                </tr>';
                                                
                                                 
                                                }
                                            $html .= '</tbody>
                                          </table>
                                       </td>
                                    </tr>
                                     
                                 </tbody>
                              </table>
                              
                           </td>
                        </tr>
                        <tr>
                           <td colspan="2"  style="padding:10px 25px 10px;">
                              <table style=" border-collapse: collapse; border-spacing: 0;width:100%;">
                                 <tbody>
                                  
                                    <tr>
                                       <td style="font-size: 14px; line-height: 1.41; color: #24272c; padding-top: 10px;">
                                     Report 2 : Employee wise cases updated :
                                       </td>
                                    </tr>
                                    
                                    
                                    <tr>
                                       <td style="padding-top:10px;">
                                          <table style="width:100%;border-spacing: 0;" border="1">
                                             <tbody>
                                              
                                                
                                                <tr>
                                                   <th>Cases / Employee</th>
                                                   <th>Added</th>
                                                   <th>Quotes Shared</th>
                                                   <th>Issued</th>
                                                </tr>';
                                                
                                                foreach($data['emp'] as $empname => $val)
                                                {
                                                    $caseadded = $val['added'];
                                                    $quote = $val['quote'];
                                                    $issued = $val['issued'];
                                                    if((empty($caseadded)) && (empty($quote)) && (empty($issued)))
                                                    {
                                                       continue;
                                                    }

                                             $html .=     '<tr>
                                                    <td style="padding: 3px 5px; font-weight:bold;">'.$empname.'</td>
                                                    <td style="padding: 3px 5px;">'.$caseadded.'</td>
                                                    <td style="padding: 3px 5px;">'.$quote.'</td>
                                                    <td style="padding: 3px 5px;">'.$issued.'</td>
                                                </tr>';
                                                }
                                            $html .= '</tbody>
                                          </table>
                                       </td>
                                    </tr>
                                     
                                 </tbody>
                              </table>
                              
                           </td>
                        </tr>
                       
                        
                     </tbody>
                  </table>
               </td>
            </tr>

         </tbody>
      </table>
   </body>
</html>';

return $html;
    }


    public function sendReportMail($email,$name,$sendto,$mailContent,$subject){
        $CI =& get_instance();
        $CI->load->library('phpmailer_lib');
        $mail = $CI->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host     = '180.179.212.241';
        $mail->SMTPAuth = true;
        $mail->Username = 'usedcardesk.gaadimail';
        $mail->Password = '@%GHYijeuir*&';
        $mail->SMTPSecure = 'tcp';
        $mail->Port     = 587; 
        $mail->setFrom('apoorva.panchal@girnarsoft.com', $name);
        $mail->addAddress('rahul.bothra@girnarsoft.com');
        $mail->addAddress('monalisa.nayak@girnarsoft.com');
        $mail->addAddress('apoorva.panchal@girnarsoft.com');

        $mail->Subject = $subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = $mailContent;
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }
    }
}