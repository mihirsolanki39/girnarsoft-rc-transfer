<?php
$data = json_decode(json_encode($results), True);
if (!empty($data)) {
    foreach ($data as $key => $val) {
        $is_sales_ex = 0;
        if($val['team_id'] == 3 && $val['role_id'] == 16){
            $is_sales_ex = 1;
        }
        $status = '';
        $checked = '';
        $class = '';
        if ($val['status'] == 0) {
            $checked = '';
            $status = 'Inactive';
            $class = "class='inactive-danger'";
        } else if ($val['status'] == 1) {
            $status = 'Active';
            $class = "class=''";
            $checked = "checked='checked'";
        }
        ?>
        <tr>
            <td>
                <div class="dealer-ship"><?= $val['name'] ?></div>
                <div class="dt-bank"><?= $val['email'] ?></div>
                <div class="dt-bank"><?= $val['mobile'] ?></div>
            </td>
            <td>
                <div class="dealer-ship"><?= $val['role'] ?></div>
                <div class="dt-bank"><?= $val['team'] ?></div>
            </td>
            <td><label class="switch">
                    <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $val['id']; ?>" <?php echo $checked; ?> onclick="activeDeactiveEmp('<?php echo $val['id']; ?>', '<?php echo $val['name'] ?>','<?=$is_sales_ex?>')">
                    <div class="slider round"></div>
                </label>
                <span class="switch-primary table-text-edit_<?php echo $val['id']; ?>" id="<?php echo $val['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </td>

            <td>
               <?php if($val['status'] == 1){?>
                <a class="btn btn-default" style="line-height: 10px" href="<?php echo base_url() . 'edituser/' . base64_encode(DEALER_ID . '_' . $val['id']); ?>" title="Edit">EDIT</a>
               <?php } ?>
            </td>
        </tr>
        <?php
    }
}
?>

<?php //echo form_close(); ?>
    <?php if ((int) $total_count > 0) { ?>
<tr><td colspan="4" style="text-align: center !important;">
    <input type="hidden" name="userTypeId" id="userTypeId" value=""/>
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
          
    </td></tr>
<?php } //else { ?>   
<?php if ((int) $total_count == 0) { ?>
 <tr><td colspan="4" align='center'>
         <input type="hidden" name="userTypeId" id="userTypeId" value=""/>
         <div class='text-center pad-T30 pad-B30'><img src='<?=base_url()?>assets/admin_assets/images/NoRecordFound.png'></div></td></tr>
<?php } ?>
<script type="text/javascript">
    $('#total_cases').text('('+"<?=!empty($total_count)?$total_count:"0"?>"+')');
</script>