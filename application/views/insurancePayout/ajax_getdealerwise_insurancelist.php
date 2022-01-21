<?php
foreach ($case_details as $key => $value) {
    $make = !empty($value['makeName']) ? $value['makeName'] : "";
    $model = !empty($value['modelName']) ? $value['modelName'] : "";
    $version = !empty($value['versionName']) ? $value['versionName'] : ""; //$value['versionName'];
    $cardetails = $make . ' ' . $model . ' ' . $version;
     $checked = $dis = ""; 
     if (!empty($editid) && in_array($value['sno'], $caseids)){
        $checked = "checked";
    }
    ?>
    <tr>
        <td>
            <div class="font-13 text-gray-customer">  
                <input disabled="disabled" type="hidden" name="ins_customer_id_<?= $value['sno'] ?>" id="ins_customer_id_<?= $value['sno'] ?>" value="<?= $value['customer_id']?>" >
                <input <?= !empty($checked)?'onclick="return false"':"" ?> <?= !empty($checked)?'readonly="readonly"':"" ?> class="srno" name="verified[]" onclick="getCheckedCasesCount(1,<?= $value['sno'] ?>)"  type='checkbox' id="car_<?= $value['sno'] ?>" value="<?= $value['sno'] ?>" <?= $checked ?>>
                <label class='mrg-R10' for="car_<?= $value['sno'] ?>"><span></span></label> 
            </div>
        </td>
        <td>   
                 <?php if ($value['buyer_type'] == '1') { ?>    
                    <div class="mrg-B5"><b><?php echo (($value['customer_name'] != '') ? ucwords(strtolower($value['customer_name'])) : 'NA'); ?></b></div>
                <?php } elseif ($value['buyer_type'] == '2') { ?>
                    <div class="mrg-B5"><b><?php echo (($value['customer_company_name'] != '') ? ucwords(strtolower($value['customer_company_name'])) : 'NA'); ?></b></div>
                <?php } ?>
            <div class="font-13 text-gray-customer">
                <span class="font-13"><?php echo $value['mobile']; ?></span>
            </div>
        </td>
        <td>
            <div class="mrg-B5"><b>
            <?php echo $cardetails; ?></b></div>
            <div class="font-13 text-gray-customer"><span class="font-13">
               <?php if(!empty($value['regNo'])) { echo strtoupper($value['regNo']); } ?>
                <?php if(!empty($value['make_year']) && $value['make_year'] != "0000-00-00") {
                     if(!empty($value['regNo'])) {?> 
                      <span class="dot-sep"></span><?php } ?>
                <?php echo $value['make_year']; ?>    Model <?php } ?> </span></div>
                    <?php
                    if ($value["ins_category"] != '') {
                        $tagname = "";
                        if ($value['ins_category'] == '1') {
                            $tagname = 'New Car';
                        } else if ($value['ins_category'] == '2') {
                            $tagname = 'Used Car Purchase';
                        } else if ($value['ins_category'] == '3') {
                            $tagname = 'Renewal';
                        } else if ($value['ins_category'] == '4') {
                            $tagname = 'Policy Expired';
                        }
                        ?>
                <a href="#" data-toggle="modal">
                    <div class="arrow-details">
                        <span class="font-10"><?php echo $tagname; ?></span>
                    </div>
                </a>
            <?php } ?>
        </td>
        <td>
            <div class="font-13 text-gray-customer">
                <span class="font-13"><b>Policy No.- <?php echo $value['current_policy_no']; ?></b></span>
            </div>
            <?php
            $addOn = 0;
            if ($value['road_side_assistance'] == '1') {
                $addOn = (int) $value['road_side_assistance_txt'];
            }
            if ($value['loss_of_personal_belonging'] == '1') {
                $addOn += (int) $value['loss_of_personal_belonging_txt'];
            }
            if ($value['emergency_transport_hotel_premium'] == '1') {
                $addOn += (int) $value['emergency_transport_hotel_premium_txt'];
            }

            if ($value['driver_cover'] == '1') {
                $driver_cover = (int) $value['paid_driver'];
            }
            if ($value['personal_acc_cover'] == '1') {
                $personal_acc_cover = (int) $value['personal_acc_cover'];
            }
            if ($value['passenger_cover'] == '1') {
                $passenger_cover = $value['pass_cover'];
            }
            if ($value['anti_theft'] == '1') {
                $addOn -= $value['anti_theft_txt'];
            }
            if ($value['add_on']) {
                $addOn += $value['add_on'];
            }
            ?>
            <input type='hidden' value="<?= !empty($addOn)?$addOn:"0" ?>" id ="hidden_addon_<?= $value['sno'] ?>"> 
            <input type='hidden' value="<?= $value['own_damage'] ?>" id ="hidden_amount_<?= $value['sno'] ?>">
            <?php if (isset($value['short_name']) && !empty($value['short_name'])) { ?>
                <div><span class="text-gray-customer font-13"><?php echo $value['short_name']; ?></span></div>
            <?php } ?>
            <?php if (isset($value['own_damage']) && !empty($value['own_damage'])) { ?>
                <div><span class="text-gray-customer font-13">OD Amount -<span class="rupee-icon"><?php echo indian_currency_form($value['own_damage']); ?></span></span></div>
            <?php } if (isset($addOn) && !empty($addOn)) { ?>
                <div><span class="text-gray-customer font-13">AddOns  -<span class="rupee-icon"><?= indian_currency_form($addOn) ?></span></span></div>
            <?php } if (isset($value['totalpremium']) && !empty($value['totalpremium'])) { ?>
                <div><span class="text-gray-customer font-13">Premium - <span class="rupee-icon"><?php echo indian_currency_form($value['totalpremium']); ?></span></span></div>
            <?php } ?>
        </td>
        <td>
            <?php
            if (isset($value['source_id']) && !empty($value['source_id'])) {
                $source_name = "";
                foreach ($quote_sources as $key => $val) {
                    if ($value['source_id'] == $key)
                        $source_name = $val;
                }
                ?>
            <div><b><?php echo!empty($source_name) ? 'Source - ' . $source_name : ""; ?></b></div>
            <?php } if (isset($value['payout_percentage']) && !empty($value['payout_percentage'])) {
                if ($value['source_id'] != 1) { ?>
                    <div>Payout - <?php echo (!empty($source_percentage[$value['source_id']])?$source_percentage[$value['source_id']]:"0") . "%"; ?></div>
            <?php } else { ?>
                    <div>Payout -<?php echo (!empty($value['payout_percentage'])?$value['payout_percentage']:"0") . "%"; ?></div>
             <?php } } ?>
         </td><td>
            <?php
           // echo "<prE>";print_r($value);die;
            $duo_amount = 0;
            if (isset($inhouse_payment[$value['customer_id']])) {
                $duo_amount = $inhouse_payment[$value['customer_id']] - $clearance_payment[$value['customer_id']];
            }
            if(!empty($value['due_amount']))
                $duo_amount = $value['due_amount'];
            if ($duo_amount > 0 || $value['due_amount'] > 0) {
                ?>
                <?= 'Amount : ' ?><i class="fa fa-rupee"></i><span id="due_amount_<?= $value['sno'] ?>"> <?= indian_currency_form($duo_amount); ?></span>
                <div class="mrg-T5">
                    <input disabled="disabled" type="hidden" name="due_payment_<?= $value['sno'] ?>" id="hidden_settle_due_<?= $value['sno'] ?>" name="settle_due_<?= $value['sno'] ?>" value="<?= $duo_amount ?>">
                   <?php
                   $settled_check = "";
                   if(!empty($value['due_amount'])){
                       $settled_check = "checked";
                       $dis = "disabled=disabled";
                   }?>
                    <input <?= $settled_check ?> <?= $dis ?> value="'1'" type="checkbox" onclick="checkPayout()" class="settle_due" id="settle_due_<?= $value['sno'] ?>" name="settle_due_<?= $value['sno'] ?>"><label for="settle_due_<?= $value['sno'] ?>"><span></span></label><span class="mrg-L5">Settle Due Amount</span>
                </div>
            <?php } ?>
            <div>
            </div>
        </td>
        
        <td>
            <input <?= empty($checked)?'disabled="disabled"':""?> type='text' onkeypress="return isRoiNumberKey(event,this)" class='form-control col-md-2' maxlength='5' value='<?= $value['final_payout'] ?>' name="payout_per_<?= $value['sno'] ?>" onblur="calculatePayout(<?= $value['sno'] ?>)" id="payout_per_<?= $value['sno'] ?>">
        </td>
        <?php 
        $payout_amount = "0";
          $payout = $value['final_payout'];
        if (!empty($payout) && $payout != 0) {
            $payout_amount = ($value['own_damage'] + $addOn) * ($payout / 100);
            $payout_amount = round($payout_amount);
        }?>
        <td>
            <input <?= empty($checked)?'disabled="disabled"':""?> type='hidden' class='hidden_payment_amount' value="<?= !empty($payout_amount) ? $payout_amount : "" ?>" name="hidden_payment_amount_<?= $value['sno'] ?>" id="hidden_payment_amount_<?= $value['sno'] ?>">
            <div class="payout_amount_<?= $value['sno'] ?>"><i class='fa fa-rupee'></i>  <?= !empty($payout_amount) ? indian_currency_form($payout_amount) : "" ?></div>
        </td>                                         
    </tr>
<?php }
?>
 <input type="hidden" name="existing_cases_count" value="<?= !empty($caseids)?count($caseids):'0' ?>" id="existing_cases_count">
<script>
    function addCommased(nStr, control, flag = '', flag1 = '')
    {
        if (flag == 1) {
            nStr = nStr.replace(/,/g, '');
        } else
        {
            nStr = nStr;
        }
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{2})/;
        var len;
        var x3 = "";
        len = x1.length;
        if (len > 3) {
            var par1 = len - 3;

            x3 = "," + x1.substring(par1, len);
            x1 = x1.substring(0, par1);

            //alert(x3);
        }
        len = x1.length;
        if (len >= 3 && x3 != "") {
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
        }
        if (flag1 == 1)
            return x1 + x3 + x2;
        else
            document.getElementById(control).value = x1 + x3 + x2;
    }
    $(document).ready(function () {
        var payment_mode = $('#payment_mode').val();
        if (payment_mode == '1')
        {
            $('#ins_show').attr('style', 'display:none');
            $('#insd_show').attr('style', 'display:none');
            $('#bnk_show').attr('style', 'display:none');
            $('#fav_show').attr('style', 'display:none');
            $('#rem_show').attr('style', 'display:block');
        }
        if (payment_mode == '2')
        {
            $('#ins_show').attr('style', 'display:block');
            $('#insd_show').attr('style', 'display:block');
            $('#bnk_show').attr('style', 'display:block');
            $('#fav_show').attr('style', 'display:block');
            $('#rem_show').attr('style', 'display:block');
        }
        if (payment_mode == '3')
        {
            $('#ins_show').attr('style', 'display:block');
            $('#insd_show').attr('style', 'display:block');
            $('#bnk_show').attr('style', 'display:block');
            $('#fav_show').attr('style', 'display:block');
            $('#rem_show').attr('style', 'display:block');
        }
        if (payment_mode == '4')
        {
            $('#ins_show').attr('style', 'display:block');
            $('#insd_show').attr('style', 'display:none');
            $('#bnk_show').attr('style', 'display:none');
            $('#fav_show').attr('style', 'display:none');
            $('#rem_show').attr('style', 'display:block');
        }
        // $('.rto_amount').trigger('onkeyup');
    });
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>