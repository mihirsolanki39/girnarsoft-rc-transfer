<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(0);
function pdf_create($html, $filename, $stream=TRUE,$email='',$data=[]) 
{
  //  echo $email; exit;
   @require_once(APPPATH."third_party/dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper("a4", "portrait" );
    @$dompdf->render();
    @$dompdf->stream($filename.".pdf",array('Attachment'=>'1'));
    $file_to_save = UPLOAD_IMAGE_PATH_LOCAL.'deliverydocs/'.$filename.'.pdf';
    $file_to_read = UPLOAD_IMAGE_URL.'deliverydocs/'.$filename.'.pdf';
    //save the pdf file on the server

    file_put_contents($file_to_save, $dompdf->output());
    if(!empty($email)) {
         sendPdfEmail($filename,$data);
    }
    $mime = get_mime_by_extension($file_to_save);
    //print the pdf file to the screen for saving
    //ob_end_clean();
    // Build the headers to push out the file properly.
        header('Pragma: public');     // required
        header('Expires: 0');         // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_to_save)).' GMT');
        header('Cache-Control: private',false);
        header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
        header('Content-Disposition: attachment; filename="'.basename($filename.'.pdf').'"');  // Add the file name
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($file_to_read)); // provide file size
        header('Connection: close');
        readfile($file_to_read); // push it out
        exit();
}

 function sendPdfEmail($filename,$data=[])
    {
        $make = $data['CustomerInfo']['makeName'];
        $model = $data['CustomerInfo']['modelName'];
        $version = $data['CustomerInfo']['versionName'];
        $date = $data['CustomerInfo']['make_year'];
        $email = 'apoorva.panchal@girnarsoft.com';//DEALER_EMAIL;  //$data['senderEmail']['email'];
        $name = !empty(DEALER_NAME)?DEALER_NAME:ORGANIZATION;    //$data['senderEmail']['name'];
        $mobile = DEALER_MOBILE; //$data['senderEmail']['mobile'];
        $organization = ORGANIZATION; //$data['senderEmail']['organization'];
        $sendto = 'apoorva.panchal@girnarsoft.com';
        $customerName = (!empty($data['caseData']['customer_name']))?$data['caseData']['customer_name']:$data['caseData']['customer_company_name'];
        $CI =& get_instance();
        $CI->load->library('phpmailer_lib');
        $mail = $CI->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host     = 'email-smtp.us-east-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIAI22VPITDHA6CMTJQ';
        $mail->Password = 'AqTRRbRe81R7gHGkJ3+9iB/9DEoUJMlAQYvXCzKREayk';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        
        $mail->setFrom($email, $name);
        $mail->addAddress($sendto);

        $mail->Subject = 'Insurance Quotes for '.$make.' '.$model.' ';
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = "Dear ".ucwords($customerName).",<br/>
           Secure your ".$date." ".$make." ".$model." ".$version." today with one of the following plans provided by Insurers.<br/><br/>

Feel free to reach out in case of any query.<br/><br/>

Regards,<br/>

".$name."<br/>
".$mobile."<br/>
".$organization." 

";
        $mail->Body = $mailContent;
        $mail->AddAttachment(UPLOAD_IMAGE_PATH_LOCAL.'deliverydocs/'.$filename.'.pdf');
        
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }
    }
?>  