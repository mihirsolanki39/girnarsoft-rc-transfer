<?php
if (!empty($loan_listing)) {
    $countArr = array_count_values($loan_list_id);
    $dateLable = '';
    foreach ($loan_listing as $key => $value) {
      //  echo "<pre>";print_r($value);die;
        $caseinfotab = '1';
        if((!empty($value['guaranter_case'])) && (!empty($value['co_applicant'])))
        {
            if((!empty($value['coapplicant_id'])) && (!empty($value['guarantor_id']))){
              $caseinfotab = '1';
            }
            else
            {
               $caseinfotab = '';
            }
        }
        elseif((empty($value['guaranter_case'])) && (!empty($value['co_applicant'])))
        {
          if((!empty($value['coapplicant_id']))){
              $caseinfotab = '1';
            }
            else
            {
               $caseinfotab = '';
            }
        }
        elseif((!empty($value['guaranter_case'])) && (empty($value['co_applicant'])))
        {
          if((!empty($value['guarantor_id']))){
              $caseinfotab = '1';
            }
            else
            {
               $caseinfotab = '';
            }
        }
        if ($value['loan_approval_status'] == '11') {
            $paydate = $this->Loan_customer_case->selectLoanPartpayment('', '', '', $value['customer_loan_id'], '1');
            $value['payment_dates'] = $paydate[0]['created_date'];
        }
        $value['cartype'] = ($value['loan_for'] == '2') ? 'Used Car' : 'New Car';
        $value['sales_exe'] = ($value['meet_the_customer'] == '1') ? 'Self' : $value['sales_exe'];
        $reopen = $datetime = '';
        $link = ((!empty($value["instrument_type"])) ? base_url('leadDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        if (empty($link)) {
            $link = ((!empty($value["upload_dis_doc_flag"]) && ($value["upload_dis_doc_flag"] == '1')) ? base_url('postDeliveryDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["invoice_no"])) ? base_url('paymentDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["tag_flag"]) && ($value["tag_flag"] == '4')) ? base_url('uploadDocs/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) . '/dis' : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["file_tag"]) && (($value["tag_flag"] == '2') || $value["tag_flag"] == '4')) ? base_url('disbursalDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link) && (($value['cpv_status'] != '2') && ($value['cpv_status'] != '0') )) {
            $link = ((!empty($value["file_tag"]) && (!empty($value['cpvstatus']) && ($value['cpvstatus'] > 0) )) ? base_url('decisionDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {

            $link = ((!empty($value["file_tag"]) && ($value["tag_flag"] == '1') && (!empty($value["ref_id"]))) ? base_url('cpvDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["customer_id"]) && ($value["tag_flag"] == '5')  && ($caseinfotab=='1') && ($value['upload_login_doc_flag']=='1')) ? base_url('loanFileLogin/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["customer_id"]) && ($value["tag_flag"] == '5') && !empty($value["bnkIf"]) && ($caseinfotab=='1') && ($value['upload_login_doc_flag']=='0')) ? base_url('uploadDocs/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if((empty($link)) && (!empty($value['guaranter_case']))  && (!empty($value['ref_name_one'])) && (!empty($value['residence_pincode']))  && (!empty($value['loan_amt'])))
        {
            $link = ((!empty($value["customer_id"])) ? base_url('guarantorDetail/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');   
        }
        if((empty($link)) && (!empty($value['co_applicant'])) && (empty($value['guarantor_id']))  && (!empty($value['ref_name_one'])) && (!empty($value['residence_pincode']))  && (!empty($value['loan_amt'])))
        {
            $link = ((!empty($value["customer_id"])) ? base_url('coapplicantDetail/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');   
        }
        if (empty($link)) {
            $link = ((!empty($value["customer_id"]) && !empty($value["ref_name_one"])) ? base_url('refrenceDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["customer_id"]) && !empty($value["residence_pincode"])) ? base_url('residentialInfo/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["customer_id"]) && !empty($value["loan_amt"])) ? base_url('loanExpected/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["customer_id"]) && !empty($value["highest_education"])) ? base_url('financeAcedmic/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = ((!empty($value["customer_id"]) && !empty($value["pan_number"])) ? base_url('personalDetail/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '');
        }
        if (empty($link)) {
            $link = (!empty($value["customer_id"]) ? base_url('leadDetails/') . base64_encode('CustomerId_' . $value["customer_loan_id"]) : '#');
        }
        $value['link'] = $linkk = $link;
        if ($value['loan_approval_status'] > '5') {
            $value['file_tag'] = $loan_tags[$value['loan_approval_status']];
            $value['tag_flag'] = $value['loan_approval_status'];
        } else {
            $value['file_tag'] = $value['file_tag'];
            $value['tag_flag'] = $value['tag_flag'];
        }
        $tagStatus = $value['file_tag'];
        if (!empty($value['customer_loan_id'])) {
            $countmore = (int) $countArr[$value['customer_loan_id']] - 1;
        }
        if (!empty($value['tag_flag']) && $value['tag_flag'] == '4') {
            $dateLable = 'Disbursed on';
            if ($value['disbursed_date'] != '0000-00-00 00:00:00') {
                $datetime = date('d M, Y', strtotime($value['disbursed_date']));
            }
        }
        if (!empty($value['tag_flag']) && $value['tag_flag'] == '2') {
            $dateLable = 'Approved on';
            if ($value['approved_date'] != '0000-00-00 00:00:00') {
                $datetime = date('d M, Y', strtotime($value['approved_date']));
            }
        }
        if (!empty($value['tag_flag']) && $value['tag_flag'] == '3') {
            $dateLable = 'Rejected on';
            if ($value['rejected_date'] != '0000-00-00 00:00:00') {
                $datetime = date('d M, Y', strtotime($value['rejected_date']));
            }
        }
        if (!empty($value['tag_flag']) && $value['tag_flag'] == '1') {
            $dateLable = 'Filed on';
            if ($value['file_login_date'] != '0000-00-00 00:00:00') {
                $datetime = date('d M, Y', strtotime($value['file_login_date']));
            }
        }
        if ((!empty($value['tag_flag']) && ($value['tag_flag'] == '5')) || (empty($value['tag_flag']) && ($value['loan_approval_status'] == '5'))) {
            $dateLable = 'Added on';
            if ($value['created_date'] != '0000-00-00 00:00:00') {
                $datetime = date('d M, Y', strtotime($value['created_date']));
            }
            $tagStatus = 'Open';
        }
        if ((!empty($value['tag_flag']) && ($value['tag_flag'] == '6' || $value['tag_flag'] == '9' )) || ($value['loan_approval_status'] == '6' || $value['loan_approval_status'] == '9' ))  {
            if ($value['tag_flag'] == '6' || $value['loan_approval_status'] == '6') {
                $dateLable = 'Washout on';
            }
            if ($value['tag_flag'] == '9' || $value['loan_approval_status'] == '9') {
                $dateLable = 'Cancel on';
            }
            if ($value['cancel_date'] != '0000-00-00 00:00:00') {
                $datetime = date('d M, Y', strtotime($value['cancel_date']));
            }
            $reopen = '1';
        }
        if (!empty($value['loan_approval_status']) && ($value['loan_approval_status'] == '7' || $value['loan_approval_status'] == '8')) {
            if (!empty($value['upload_docs_created_at']) && $value['loan_approval_status'] == '7') {
                $dateLable = 'Login Docs Collected';
                $datetime = date('d M, Y', strtotime($value['upload_docs_created_at']));
            }
            if (!empty($value['upload_dis_created_date']) && $value['loan_approval_status'] == '8') {
                $dateLable = 'Disbursed Docs Collected';
                $datetime = date('d M, Y', strtotime($value['upload_dis_created_date']));
            }
        }
        if (!empty($value['loan_approval_status']) && ($value['loan_approval_status'] == '11')) {
            $tagStatus = 'Payment Completed';
            $dateLable = 'Payment Completed On';
            $datetime = date('d M, Y', strtotime($value['payment_dates']));
        }
        ?>
        <tr class="hover-section">
            <td style="position:relative">
                <div class="mrg-B5"><b><?= $value['sr_no'] ?></b></div>

            </td>
            <td style="position:relative">
                <div class="mrg-B5"><b><?= $value['name'] ?></b></div>
                <div class="font-13 text-gray-customer"><span class="font-13"><?= $value['customer_mobile'] ?></span><br><?= $value['email'] ?></div>
                <?php if (!empty($value['residence_address'])) { ?>
                    <div><span class="text-gray-customer font-13"><?= $value['residence_address'] ?> <?= (!empty($value['customer_city']) ? (' ,' . $value['customer_city']) : '') ?></span></div><?php } ?>
                <div><span class="text-gray-customer font-13"><?= date('d M, Y', strtotime($value['created_date'])) ?></span></div>
            </td>
            <td style="position:relative">
                <div class="mrg-B5"><b>
                        <?php
                        if (!empty($value['make_name'])) {
                            echo $value['make_name'] . ' ' . $value['model_name'] . ' ' . $value['version_name'];
                        } else {
                            echo "NA";
                        }
                        ?></b></div>
                <div class="font-13 text-gray-customer"><span class="font-13">
                        <?php
                        if (!empty($value['regno'])) {
                            echo strtoupper($value['regno']);
                        }
                        ?>
                        <?php if (!empty($value['myear'])) { ?> 
                            <span class="dot-sep"></span> <?php echo $value['myear'] ?>    Model
                        <?php } ?></span></div>
                <a href="#" data-toggle="modal">
                    <div class="arrow-details" >
                        <span class="font-10"><?= $value['cartype'] . ' - ' . ucwords($value['loan_type']) ?></span>
                    </div>
                </a>
            </td>
            <td style="position:relative">
                <?php if (!empty($value['file_loan_amount'])) { ?>
                    <div class="mrg-B5"><b>Loan Amount - <i class="fa fa-rupee"></i> <?= (!empty($value['disbursed_amount']) ? indian_currency_form($value['disbursed_amount']) : (!empty($value['approved_loan_amt']) ? indian_currency_form($value['approved_loan_amt']) : indian_currency_form($value['file_loan_amount']))) ?></b></div>
                    <div class="font-13 text-gray-customer"><span class="font-13"><?= $value['financer_name'] ?></span></div>
                    <div ><span class="text-gray-customer font-13">Ref. Id - <?= $value['ref_id'] ?></span></div>
                    <?if(!empty($value['loanno'])){?> <div ><span class="text-gray-customer font-13">LOS/Loan No. - <?= $value['loanno'] ?></span></div><? } ?>
                    <div><span class="text-gray-customer font-13">Interest Rate - <?= (!empty($value['approved_roi']) ? $value['approved_roi'] : (!empty($value['file_roi']) ? $value['file_roi'] : 'NA')) ?>%</span></div>
                    <div><span class="text-gray-customer font-13">Loan Tenure - <?= (!empty($value['approved_tenure']) ? $value['approved_tenure'] : (!empty($value['file_tenure']) ? $value['file_tenure'] : 'NA')) ?> Months</span></div><br>
                    <div><span class="text-gray-customer font-13"> <?= ($countmore >= 1 ) ? '+ ' . $countmore . '  More Banks' : '' ?></span></div>
                    <?php
                } else {
                    echo "NA";
                }
                ?>
            </td>
            <td style="position:relative">

                <div class="mrg-B5"><b>Source -<?= ($value['source_type'] == '1') ? 'Dealer' : 'InHouse'; ?></b></div>
                <?php if ($value['source'] == 'Dealer') { ?>
                    <div class="font-13 text-gray-customer"><span class="font-13">Dealer Organization - <?= $value['dealer_detail'] ?></span></div>

                    <?php
                }
                ?>
                <div><span class="text-gray-customer font-13">Assigned to - <?= $value['assigned_to'] ?></span></div>
                <div><span class="text-gray-customer font-13">Sales Executive - <?= $value['sales_exe'] ?></span></div>
            </td>
            <td style="position:relative">
                <div class="mrg-B5"><b>Status - <?= $tagStatus ?></b></div>
                <div class="font-13 text-gray-customer"><span class="font-13"><?= !empty($dateLable) ? $dateLable . ' - ' : '' ?> <?= !empty($datetime) ? $datetime : '' ?></span></div>
                <?php if ($value['pendency'] >= 1) { ?>

                    <div class="arrow-details alert-btn" >
                        <span class="font-10"><?= $value['pendency'] ?> Documents pending</span>
                    </div>

                <?php } ?>
            </td>
            <td class="td-action">
                <div >
                    <?php if (empty($reopen)) { ?>
                        <a href="<?= $linkk ?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                    <?php } else { ?> 

                        <button id="reopen_<?= $value['customer_loan_id'] ?>" data-target="#booking-done" data-toggle="tooltip" title="reopen" onclick="reopen(<?= $value['customer_loan_id'] ?>, '<?= $linkk ?>');" data-placement="top" class="btn btn-default">Reopen</button>

                    <?php } ?>
                    <br>
                    <button onclick="showHistory(<?= $value['customer_loan_id'] ?>)" class="btn btn-default">Timeline</button>
                </div>
            </td>
        </tr>
    <?php } ?>

    <tr><td colspan="7" style="text-align: center !important;">

            <?php if ((int) $total_count > 0) { ?>

                <div class="col-lg-12 col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" >
                            <?php
                            //echo "sdsdsd".$page; exit;
                            $total_pages = ceil($total_count / $limit);
                            $pagLink = "";

                            if ($total_pages < 1) {
                                $total_pages = 1;
                            }

                            if ($total_pages != 1) {

                                //this is for previous button
                                if ((int) $page > 1) {
                                    $prePage = (int) $page - 1;
                                    ?>
                                    <li onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                    <?php
                                    //this for loop will print pages which come before the current page
                                    for ($i = (int) $page - 6; $i < $page; $i++) {
                                        if ($i > 0) {
                                            ?>   
                                            <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                            <?php
                                        }
                                    }
                                }

                                //this is the current page
                                ?>
                                <li class="active" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li> 
                                    <?php
                                    //this will print pages which will come after current page
                                    for ($i = $page + 1; $i <= $total_pages; $i++) {
                                        ?>
                                    <li class="<?= $i ?>"  onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                    <?php
                                    if ($i >= (int) $page + 3) {
                                        break;
                                    }
                                }

                                // this is for next button
                                if ($page != $total_pages) {
                                    $nextPage = (int) $page + 1;
                                    ?> 
                                    <li onclick="pagination('<?php echo $nextPage; ?>')"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            <?php } ?> 

        </td></tr>
    <?php
} 
?>
<script type="text/javascript">
    $('#total_count').text('(' + "<?= $total_count ?>" + ')');
</script>






