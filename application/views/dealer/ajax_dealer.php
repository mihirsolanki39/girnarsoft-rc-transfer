<?php if (isset($totalCount)) {
    echo $totalCount;
} echo "#####"; ?>
<?php if (count($list) > 0) { ?> 
    <?php
    foreach ($list as $k => $val) {
        $checked = '';
        $status = '';
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
                <div class="dealer-ship"><?php echo!empty($val['organization']) ? $val['organization'] : ''; ?></div>
                <div class="dt-bank"><?php echo!empty($val['dealership_email']) ? $val['dealership_email'] : ''; ?></div>
                <div class="dt-bank"><?php echo!empty($val['dealership_contact']) ? $val['dealership_contact'] : ''; ?></div>
            </td>
            <td>
                <div class="dealer-ship"><?php echo!empty($val['owner_name']) ? $val['owner_name'] : ''; ?></div>
                <div class="dt-bank"><?php echo!empty($val['owner_mobile']) ? $val['owner_mobile'] : ''; ?></div>
            </td>
            <td>
                <?php
                if (isset($val['dealer_type'])) {
                    if ($val['dealer_type'] == '1') {
                        $dType = 'New Car';
                    } else if ($val['dealer_type'] == '0') {
                        $dType = 'Used Car';
                    } else if ($val['dealer_type'] == '2') {
                        $dType = 'Both';
                    }
                }
                ?>
                <div class="dealer-ship"><?php echo (!empty($dType)) ? $dType : ''; ?></div>

            </td>
            <td>
                <div class="dt-bank">
                    <?php
                    if (!empty($val['created_by'])) {
                        $created_date = ($val['created_date'] != '0000-00-00 00:00:00') ? " On " . date("d M, Y", strtotime($val['created_date'])) : '';
                        echo "Created By: " . $val['uname'] . $created_date;
                    }
                    ?>
                </div>
                <div class="dt-bank">
                    <?php
                    if (!empty($val['updated_by'])) {
                        $updated_date = ($val['updated_date'] != '0000-00-00 00:00:00') ? " On " . date("d M, Y", strtotime($val['updated_date'])) : '';
                        echo "Updated By: " . $val['uuname'] . $updated_date;
                    }
                    ?>
                </div>
            </td>
            <td>
                <div class="dealer-ship"><?php echo (!empty($val['role_name']) && ($val['role_name']=='Executive')) ? $val['assignuser'] : ''; ?></div>
            </td>
            <td>
                <label class="switch">
                    <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $val['id']; ?>" <?php echo $checked; ?> onclick="activeDeactiveDealer('<?php echo $val['id']; ?>', '<?php echo $val['organization'] ?>')">
                    <div class="slider round"></div>
                </label>
            </td>
            <!-- <td>
                <button data-target="#" data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-default">EDIT</button>
            </td> --> 
            <td>
               <?php if ($val['status'] == 1){?>           
                <a href="<?php echo base_url() . 'editDealer/' . base64_encode('dealerId_' . $val['id']); ?>"><button title="Edit" data-placement="top" class="btn btn-default">EDIT</button></a>
              <?php } ?>
            </td>
        </tr>
    <?php } ?>
    <tr><td colspan="7" align="center">
    <?php if (intval($totalCount) > 0) { ?>

                <div class="col-lg-12 col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" >
                            <?php
                            $total_pages = ceil($totalCount / $limit);
                            $pagLink = "";

                            if ($total_pages < 1) {
                                $total_pages = 1;
                            }

                            if ($total_pages != 1) {

                                //this is for previous button
                                if (intval($page) > 1) {
                                    $prePage = intval($page) - 1;
                                    ?>
                                    <li onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                    <?php
                                    //this for loop will print pages which come before the current page
                                    for ($i = $page - 6; $i < $page; $i++) {
                                        if ($i > 0) {
                                            ?>   
                                            <li onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                            <?php
                                        }
                                    }
                                }

                                //this is the current page
                                ?>
                                <li  class='active' onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li> 
                                <?php
                                //this will print pages which will come after current page
                                for ($i = $page + 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li  onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                    <?php
                                    if ($i >= $page + 3) {
                                        break;
                                    }
                                }

                                // this is for next button
                                if ($page != $total_pages) {
                                    $nextPage = intval($page) + 1;
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
} else {
    echo "1";
    exit;
}
?>
