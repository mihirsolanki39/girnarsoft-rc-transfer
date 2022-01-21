<style>
    .modal-backdrop.in {
     opacity: -1.5 !important;
}
.modal-backdrop {
    z-index: 0 !important;
}
</style>  
<link href="<?= base_url('/assets/css/common.css') ?>" rel="stylesheet">
<div id="content">
<div class="container-fluid">
    <div class="row background-color box-S">
        <div class="col-lg-6 col-md-6 bsd-sec">
            <h4 class="basic-detail-heading mrg-all-0">Partner Dealer List</h4>
        </div>
        <div class="col-xs-6 text-right pad-T20">
            <div class="form-group">
                <a class="btn btn-primary add_dealer_btn" href="<?php echo base_url(); ?>addDealer"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mrg-T20">
    <div class="row">
       <div class="col-md-12 mrg-B40">
        <div class="white-section pad-T20">

    <div class="box-tools">
        <form action="<?php echo base_url() ?>dealerListing" method="POST" id="searchList">
            <div class="input-group pad-B10">
                <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-default searchList" style="padding: 7px 16px;"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered" id="dealerRecord">
        <thead>
            <tr class="border-T">
                <th>#</th>
                <th>Dealership Name</th>
                <th>Dealership Email</th>
                <th>Dealership Mobile</th>
                <th>Owner Name</th>
                <th>Address</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>

        </thead>
        <tbody>
            <?php
            if (!empty($userRecords)) {
                foreach ($userRecords as $record) {
                    $status  = '';
                                $checked = '';
                                $class   = '';
                                if ($record->status == 0)
                                {
                                    $checked = '';
                                    $status  = 'Inactive';
                                    $class   = "class='inactive-danger'";
                                }
                                    else if ($record->status == 1)
                                {
                                    $status  = 'Active';
                                    $class   = "class=''";
                                    $checked = "checked='checked'";
                                }
                    ?>
                    <tr>
                        <td><?php echo $record->id ?></td>
                        <td><?php echo $record->organization ?></td>
                        <td><?php echo $record->dealership_email ?></td>
                        <td><?php echo $record->dealership_contact ?></td>
                        <td><?php echo $record->owner_name ?></td>
                        <td><?php echo $record->user_address ?></td>
                        <td> 
                        <label class="switch">
                            <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $record->id; ?>" <?php echo $checked; ?> onclick="activeDeactiveDealer('<?php echo $record->id; ?>','<?php echo $record->organization ?>')">
                            <div class="slider round"></div>
                        </label>
                        <span class="switch-primary table-text-edit_<?php echo $record->id; ?>" id="<?php echo $record->id; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php ///echo $status;           ?></span>
                              </td>
                        <td class="text-center">
                        <?php if($record->status == 1)  { ?>    
                            <a class="btn btn-sm btn-default pad-all-5" style="line-height: 10px" href="<?php echo base_url() . 'editDealer/' . base64_encode('dealerId_'.$record->id); ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                        <?php } ?>
                        </td>
                    </tr>
        <?php
    }
}else{ ?>
    <td colspan="13"><?php echo 'No Record Found!' ?></td>
<?php }
?>
        </tbody>
    </table>
    <div class="box-footer clearfix" style="margin-left: 37%;">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
</div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
<!--    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>


