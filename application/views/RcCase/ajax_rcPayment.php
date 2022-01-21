<?php
if (!empty($rcPayment)) {
    foreach ($rcPayment as $payment) {
        ?>
        <tr>
            <td><?= $payment['payment_rnd_id']; ?></td>
            <td><?= $payment['rto_name'] ?></td>
            <td>
                <div class="commastoamount" id="amount_<?= $payment['id']; ?>"><i class="fa fa-rupee"></i><span class="amount_<?=$payment['id'];?>"><?= indian_currency_form($payment['amount']); ?></span></div>
            </td>
            <td>
        <?= !empty($payment['paydates']) ? date('d M, Y', strtotime($payment['paydates'])) : "" ?>
            </td>
            <td><?= PAYMENT_MODE[$payment['payment_mode']]; ?></td>
            <td>
        <?= !empty($payment['instrument_date']) && $payment['instrument_date'] != "0000-00-00" ? date('d M, Y', strtotime($payment['instrument_date'])) : "" ?>
            </td>
            <td><?= $payment['instrument_no']; ?></td>
            <td><?= $payment['bank_name']; ?></td>
            <td><?= $payment['remark']; ?></td>
            <td>
                <?php $link=  base_url('rc_make_payment/').base64_encode('rcpay_'.$payment['id']); 
                ?>
                <a class="btn btn-default font-11" href="<?=$link?>"> Edit Payment </a>                                               
            </td> 
        </tr>

    <?php }
}
?>
        <tr>
            <td colspan="11" style="text-align: center !important;">
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
                                    ?>
                                    <li class="active"  onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>
                                    <?php
                                    for ($i = $page + 1; $i <= $total_pages; $i++) {
                                        ?>
                                        <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                        <?php
                                        if ($i >= $page + 3) {
                                            break;
                                        }
                                    }
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
            </td>
        </tr>
<?php if (empty($rcPayment)) {
    echo "<tr><td align='center' colspan='10'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
}
?>        
 <script type="text/javascript">
    $('#total_count').text('(' + "<?= $total_count ?>" + ')');
</script>  