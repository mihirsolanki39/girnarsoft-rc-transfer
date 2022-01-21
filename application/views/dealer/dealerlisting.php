<?php //print_r($list); ?>
<div id="content">
    <div class="container-fluid mrg-all-20">
        <div class="row">
            <div class="">
                <div class="cont-spc pad-all-20" id="buyer-lead">
                    <form id="searchform" name="searchform" method="post" class="" role="form">
                        <div class="row">
                            <div class="col-md-2 pad-R0">
                                <label for="" class="crm-label" >Search By</label>
                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search By">
                            </div>
                            <div class="col-md-2 pad-R0">
                                <label for="" class="crm-label">Category</label>
                                <select class="form-control crm-form testselect123" name="category" id="category">
                                    <option value="">Select Category</option>
                                    <option value="1">New Car</option>
                                    <option value="0">Used Car</option>
                                    <option value="2">Both</option>
                                </select>
                            </div>
                            <div class="col-md-2 pad-R0">
                                <label for="" class="crm-label">Status</label>
                                <select class="form-control crm-form testselect123" name="status" id="status">
                                    <option value="">Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2 pad-R0">
                            <label for="" class="crm-label">Sales Executive</label>
                              <select class="form-control crm-form " name="dealtby" id="dealtby">
                                 <option selected="selected" value="">Select</option>
                                 <?php foreach ($employeeList as $key=>$value){ ?>
                                        <option value="<?=$value['id']?>" <?php echo !empty($CustomerInfo) && $CustomerInfo['assign_to']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                 <?php } ?>
                              </select>
                            </div>
                            <div class="col-md-2 pad-R0">
                                <span id="spnsearch">
                                    <input type="button" class="btn-save btn-save-new" value="Search" id="search">
                                   <a href="#" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                                    <input type="hidden" name="page" id="page" value="1">
                                    <input type="hidden" name="dashboard" id="dashboard" value="<?= (!empty($url) ? $url : '') ?>">
                                </span>
                            </div>
                            <div class="col-md-2 mrg-T30">
                                <a class="pull-right mrg-L15  pad-L15" id="dealerexportexcel" href="JavaScript:Void(0)">DOWNLOAD EXCEL</a>
                            </div>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mrg-all-20">
        <div class="row">
            <div class="list_div">
                <div class="background-ef-tab" id="loandetails">
                    <div class="tabs loandetails">
                        <div class="row pad-all-20">
                            <div class="col-md-6">
                                <h5 class="cases">Partner Dealers (<span id="totcnt"><?php echo (!empty($totalCnt)) ? trim($totalCnt) : 0; ?></span>)</h5>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo base_url(); ?>addDealer" target="_blank"> <button class="btn-success pull-right">ADD NEW</button></a>
                            </div>  
                        </div>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="row">
                                                <style>
                                                    #banklisting .dealer-ship{font-size:14px; color:#000000; opacity:0.87; font-weight:500;}
                                                    #banklisting .dt-bank{font-size:#000000; opacity:.67; font-size:14px; margin-top:5px;}
                                                    #banklisting .switch {position: relative;display: inline-block;width: 34px;height: 14px; vertical-align: middle;}
                                                </style>
<div class="table-responsive" id="banklisting">
<table class="table table-bordered table-striped table-hover enquiry-table myLoantbl">
<thead>
<tr>
<!-- <th>Loan ID </th>-->
<th width="15%">Dealership Details</th>
<th width="15%">Owner Details</th>
<th width="15%" >Category</th>
<th width="15%" >Created By</th>
<th width="15%" >Sales Executive</th>
<th width="8%" >Status</th>
<th width="7%" >Action</th>
</tr>
</thead>
<tbody id="dlist">
<?php if (count($list) > 0) { ?> 
<?php
foreach ($list as $k => $val) {
    $checked = '';
    $status = '';
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
        <td>
          <?php if ($val['status'] == 1){?>
            <a href="<?php echo base_url() . 'editDealer/' . base64_encode('dealerId_' . $val['id']); ?>"><button title="Edit" data-placement="top" class="btn btn-default">EDIT</button></a>
          <?php } ?>
        </td>
    </tr>
        <?php }
    } ?>
<tr><td colspan="7" align="center">
<?php if (intval($totalCount) > 0) { ?>

        <div class="col-lg-12">
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
                            $pagLink .= '<li onclick="pagination(' . $prePage . ');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>';
                            //this for loop will print pages which come before the current page
                            for ($i = $page - 6; $i < $page; $i++) {
                                if ($i > 0) {
                                    $pagLink .= "<li onclick='pagination(" . $i . ");'><a href='#'>" . $i . "</a></li>";
                                }
                            }
                        }

                        //this is the current page
                        $pagLink .= "<li  class='active' onclick='pagination(" . $i . ");'><a href='#'>" . $page . "</a></li>";
                        //this will print pages which will come after current page
                        for ($i = $page + 1; $i <= $total_pages; $i++) {

                            //$pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='pagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 
                            $pagLink .= "<li onclick='pagination(" . $i . ");' ><a href='#'>" . $i . "</a></li>";
                            if ($i >= $page + 3) {
                                break;
                            }
                        }

                        // this is for next button
                        if ($page != $total_pages) {
                            $nextPage = intval($page) + 1;
                            $pagLink .= '<li onclick="pagination(' . $nextPage . ');"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
                        }
                    }

                    echo $pagLink;
                    ?>
                </ul>
            </nav>
        </div>
                <?php } ?>     
</td></tr>
</tbody>
</table>
</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
<script type="text/javascript">
    function pagination(page) {
       // alert(page);
        $("#page").val(page);
        $("#dlist").html('');
        $.ajax({
            url: base_url + "dealer/ajax_dealer",
            type: 'post',
            dataType: 'html',
            data: {'data': $("#searchform").serialize()},
            success: function (response)
            {
                var res = response.split("#####");
                if (res[1] == '1') {
                    $("#totcnt").text(res[0]);
                    $("#dlist").html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
                } else {
                    $("#totcnt").text($.trim(res[0]));
                    $("#dlist").html(res[1]);
                    $(window).scrollTop(0);
                }
                // reset();
            }
        });
    }
    
    
    function reset()
    {
         $('#keyword').val('');
                    $('#category').val('');
                     $('#status').val('');
                    $('#dealtby').val('');
                     $('#category')[0].sumo.reload();
                      $('#status')[0].sumo.reload();
                       $('#dealtby')[0].sumo.reload();
                    $('#search').trigger('click');
        
    }
    $("#search").click(function (event) {
        $.ajax({
            url: base_url + "dealer/ajax_dealer",
            type: 'post',
            dataType: 'html',
            data: {'data': $("#searchform").serialize()+'&issearch=1'},
            success: function (response)
            {
                var res = response.split("#####");
                if (res[1] == '1') {
                    $("#totcnt").text(res[0]);
                    $("#dlist").html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
                } else {
                    $("#totcnt").text(res[0]);
                    $("#dlist").html(res[1]);
                    $(window).scrollTop(0);
                }
            }
        });
    });
    $(document).on('click', '#Reset', function (ev) {
        $('#category').val('');
        $('#status').val('');
        $('#dealtby').val('');
        $('#search').trigger('click');
        //location.reload(true);
    });
    $('#dealerexportexcel').click(function () {
    //jQuery("#search").trigger('click');  
    var data=$("#searchform").serialize();
    $('#export').val('export');
    window.top.location.href = "dealerListing/exportdealer/1?"+data;

});
$(document).ready(function()               
    {
        // enter keyd
        $(document).bind('keypress', function(e) {
            if(e.keyCode==13){
                 $('#search').trigger('click');
                 e.preventDefault();
             }
        });
        $('#dealtby').SumoSelect({ search: true,  searchText:'Enter here.' });
        $('.testselect123').SumoSelect({ search: false,  searchText:'Enter here.' });
    });        
</script>