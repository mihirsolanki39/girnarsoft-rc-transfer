<?php
if (!empty($payout_history)) {
    $countArr = array_count_values($payout_history);
    $dateLable = '';
    foreach ($payout_history as $key => $value) {
        ?>
        <tr class="hover-section">
            <td style="position:relative">
                <div class="mrg-B5"><b><?= !empty($value['payment_id']) ? $value['payment_id'] : "" ?></b></div>
            </td>
            <td style="position:relative">
                <div class="mrg-B5"><b><?= ucwords(strtolower($value['organization'])) ?></b></div>
            </td>
            <td style="position:relative">
                        <div class="mrg-B5 history_amount_commas" id="<?= $value['payment_id'] ?>"><b><i class="fa fa-rupee"></i> <span class="<?= $value['payment_id'] ?>"><?= !empty($value['amount']) ? $value['amount'] : "" ?></span></b></div>                                                                    
                        <?php if (!empty($value['tds_amount'])) { ?>
                            <div class="mrg-B5 history_amount_commas" id="tds_<?= $value['payment_id'] ?>">TDS - <i class="fa fa-rupee"></i> <span class="tds_<?= $value['payment_id'] ?>"><?= !empty($value['tds_amount']) ? $value['tds_amount'] : "" ?></span></b></div>                         
                        <?php } if (!empty($value['gst_amount'])) { ?>
                            <div class="mrg-B5 history_amount_commas" id="gst_<?= $value['payment_id'] ?>">GST - <i class="fa fa-rupee"></i> <span class="gst_<?= $value['payment_id'] ?>"><?= !empty($value['gst_amount']) ? $value['gst_amount'] : "" ?></span></div>                         
                        <?php } if (!empty($value['pdd_charge_total'])) { ?>
                            <div class="mrg-B5 history_amount_commas" id="pdd_<?= $value['payment_id'] ?>">PDD - <i class="fa fa-rupee"></i> <span class="pdd_<?= $value['payment_id'] ?>"><?= !empty($value['pdd_charge_total']) ? $value['pdd_charge_total'] : "" ?></span></div>                         
                        <?php } ?>
                    </td>
            <td style="position:relative"> <?= !empty($value['date_time']) ? date('d M, Y', strtotime($value['date_time'])) : "" ?></td>
            <td style="position:relative"><?= !empty($value['payment_mode']) ? PAYMENT_MODE[$value['payment_mode']] : "" ?> </td>
            <td style="position:relative">
                <div class="mrg-B5"> 
                    <?php if ($value['payment_mode'] != 1 && $value['payment_mode'] != 4 && $value['instrument_date'] != "0000-00-00") { ?>
                        <?= !empty($value['instrument_date']) ? date('d M, Y', strtotime($value['instrument_date'])) : "" ?>
                    <?php } ?>
                </div>
            </td>
            <td style="position:relative">                                                                                                                                                                 
                <div class="mrg-B5"><?= !empty($value['instrument_no']) ? $value['instrument_no'] : "" ?></div>                                                                        
            </td>
            <td style="position:relative">                                                                                                                                                                 
                <div class="mrg-B5"><?= !empty($value['bank_name']) ? $value['bank_name'] : "" ?></div>                                                                        
            </td>
            <td style="position:relative">                                                                                                                                                                 
                <div class="mrg-B5"><?= !empty($value['pay_remark']) ? $value['pay_remark'] : "" ?></div>                                                                        
            </td>

            <td style="position:relative">  
                                                                <a class="adownl" style="cursor: pointer;" onclick="downloadFile('<?php echo $value['payment_id']; ?>')" data-toggle="tooltip" data-placement="left" title="Download Payout"><img src="<?php echo base_url() ?>assets/images/download.svg" /></a>
                                                            </td>

            <td style="position:relative">  
                 <a class="btn btn-default" href="<?php echo base_url();?>makePayout/<?=base64_encode('payoutId_'.$value['payment_id']) ?>" >Edit Payout</a>
            </td>
        </tr>
        <?php
    }
?>
<tr><td colspan="11" style="text-align: center !important;">
        <?php if ((int) $total_count > 0) { ?>

            <div class="col-lg-12 col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination" >
                        <?php
                        $total_pages = ceil($total_count / $limit);
                        $pagLink = "";

                        if ($total_pages < 1) {
                            $total_pages = 1;
                        }
                        if ($total_pages != 1) {
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
                            // if($i > $page){ 
                            ?>
                            <li class="active"  onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>

                            <?php
                            // }
                            //this will print pages which will come after current page
                            for ($i = $page + 1; $i <= $total_pages; $i++) {
                                ?>
                                <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                <?php
                                if ($i >= $page + 3) {
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
<?php } ?>
        <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
        <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>    
                                  
<script type="text/javascript">
    $('#total_count').text('(' + "<?= $total_count ?>" + ')');
</script>  