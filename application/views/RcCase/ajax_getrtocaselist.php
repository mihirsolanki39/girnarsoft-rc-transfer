<?php
foreach ($case_details as $key => $value) {
    $make = !empty($value['parentmakeName']) ? $value['parentmakeName'] : $value['makeName'];
    $model = !empty($value['parentmodelName']) ? $value['parentmodelName'] : $value['modelName'];
    $version = $value['versionName'];
    $cardetails =  $make . ' ' . $model . ' ' . $version;
    $rto_work = explode(',', $value['rto_work']);
    $rto_works = '';
    if ($rto_work[0] != '0') {
        foreach ($rto_work as $key) {
            if ($key == '1')
                $rtowork = 'TO';
            if ($key == '2')
                $rtowork = 'HPT';
            if ($key == '3')
                $rtowork = 'HPA';
            if ($key == '4')
                $rtowork = 'HPC';
            if ($key == '5')
                $rtowork = 'DC';


            $rto_works .= $rtowork . ', ';
        }

        $rto_works = substr(trim($rto_works), 0, -1);
    }
    $rc_id = $value['rc_id'];

    $rto_amount = (!empty($value['rto_actual_charges']) && ($value['rto_actual_charges'] != 'undefined')) ? $value['rto_actual_charges'] : $value['rto_charges'];
?>
    <tr>
        <td>
            <div class="font-13 text-gray-customer">
                <input <?php if (!empty($value['payment_id'])) { ?> checked onclick="return false;" <? } else { ?> onclick="getSelectedCases(<?= $rc_id ?>);" <? } ?> type="checkbox" id="rtoid_<?= $value['rc_id'] ?>" name="rtoid_<?= $value['rc_id'] ?>"><label for="rtoid_<?= $value['rc_id'] ?>"><span></span></label>
            </div>
        </td>
        <td>
            <div class="mrg-B5"><b><?= $value['customer_name'] ?></b></div>
            <div class="font-13 text-gray-customer">
                <span class="font-13"><?= $value['customer_mobile'] ?></span>
            </div>
        </td>

        <td>
            <div class="mrg-B5"><b><?= $cardetails ?></b></div>
            <div class="font-13 text-gray-customer">
                <span class="font-13"><span style=" text-transform: uppercase;"><?= $value['reg_no'] ?></span> <span class="dot-sep"></span> <?= $value['reg_year'] ?> Model </span>
            </div>
        </td>
        <td>
            <div><span class="text-gray-customer font-13">RTO Works : <?= $rto_works ?></span></div>
            <div><span class="text-gray-customer font-13">Transferred On : <?= date('d M,Y', strtotime($value['rc_transferred_date'])) ?></span></div>
        </td>
        <td>
            <?php if (!empty($rto_amount)) {
                $class = "rto_amount";
            } else {
                $class = "";
            }
            ?>
            <div><input type="text" name="rto_amount_<?= $value['rc_id'] ?>" id="rtoamt_<?= $value['rc_id'] ?>" onkeydown="return isNumberKey(event);" onkeyup="addCommased(this.value,'rtoamt_<?= $value['rc_id'] ?>','1');" onchange="addAmount(<?= $value['rc_id'] ?>);" value="<?= !empty($rto_amount) ? $rto_amount : '0' ?>" class="form-control <?= $class ?> rupee-icon" readonly="readonly" maxlength="10"></div>

            <div><input type="hidden" name="rtid_<?= $value['rc_id'] ?>" id="rto_<?= $value['rc_id'] ?>" value="0" class="form-control"></div>
        </td>
    </tr>
<?php } ?>

<script>
    function addCommased(nStr, control, flag = '', flag1 = '') {
        if (flag == 1) {
            nStr = nStr.replace(/,/g, '');
        } else {
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
    $(document).ready(function() {
        addCommastoList();
        var payment_mode = $('#payment_mode').val();
        if (payment_mode == '1') {
            $('#ins_show').attr('style', 'display:none');
            $('#insd_show').attr('style', 'display:none');
            $('#bnk_show').attr('style', 'display:none');
            $('#fav_show').attr('style', 'display:none');
            $('#rem_show').attr('style', 'display:block');
        }
        if (payment_mode == '2') {
            $('#ins_show').attr('style', 'display:block');
            $('#insd_show').attr('style', 'display:block');
            $('#bnk_show').attr('style', 'display:block');
            $('#fav_show').attr('style', 'display:block');
            $('#rem_show').attr('style', 'display:block');
        }
        if (payment_mode == '3') {
            $('#ins_show').attr('style', 'display:block');
            $('#insd_show').attr('style', 'display:block');
            $('#bnk_show').attr('style', 'display:block');
            $('#fav_show').attr('style', 'display:block');
            $('#rem_show').attr('style', 'display:block');
        }
        if (payment_mode == '4') {
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