<style>
    .modal-backdrop.in {
     opacity: -1.5 !important;
}
.modal-backdrop {
    z-index: 0 !important;
}

.dataTables_wrapper .dataTables_paginate {
    margin-bottom: 15px;
    margin-top: 15px;
}
    
</style> 
<?php
//$bankRecords = [];
if(!empty($bankRecords))
 {   ?>
<link href="<?= base_url('/assets/css/jquery_dataTable.css') ?>" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
<?php } ?>
<link href="<?= base_url('/assets/css/common.css') ?>" rel="stylesheet">
<div id="content">
<div class="container-fluid">
        <div class="row background-color box-S">
            <div class="col-lg-6 col-md-6 bsd-sec">
                <h4 class="basic-detail-heading mrg-all-0">Bank List</h4>
            </div>
            <div class="col-xs-6 text-right pad-T20">
                <div class="form-group">
                    <a class="btn btn-primary add_dealer_btn" href="<?php echo base_url(); ?>addBank"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid mrg-T20">
    <div class="row">
       <div class="col-md-12 mrg-B40">
            
<div class="white-section pad-T20">
   

    <div class="box-tools">
                        <form action="<?php echo base_url() ?>bank" method="POST" id="searchList">
                            <div class="input-group mrg-B10">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList" style="padding: 7px 16px"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
    <table class="table table-bordered" style="background-color: #fff !important" id="bankRecord">
        <thead>
            <tr>
                <th>#</th>
                <th>Name of the Bank</th>
                <th>Branch</th>
                <th>Address</th>
                <th>Loan Limit</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>

        </thead>
        <tbody>
             <?php 
             
                    if(!empty($bankRecords))
                    {
                        foreach($bankRecords as $record)
                        {
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
                $bankName  = $this->Crm_banks_List->crmBankName($record->bank_id);
                    ?>
                    <tr>
                      <td><?php echo $record->id ?></td>
                      <td><?= !empty($bankName[0]->bank_name)?$bankName[0]->bank_name:'' ?></td>
                      <td><?php echo $record->branch_name ?></td>
                      <td><?php echo $record->address ?></td>
                      <td><?php echo $record->amount_limit ?></td>
                      <td> 
                                  <label class="switch">
                                      <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $record->id; ?>" <?php echo $checked; ?> onclick="activeDeactiveBank('<?php echo $record->id; ?>','<?php echo $record->bank_id ?>')">
                                      <div class="slider round"></div>
                                  </label>
                                  <span class="switch-primary table-text-edit_<?php echo $record->id; ?>" id="<?php echo $record->id; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php ///echo $status;           ?></span>
                              </td>
                      <td class="text-center">
                          <?php if($record->status == 1){ ?>
                          <a class="btn btn-sm btn-default pad-all-5" style="line-height: 10px" href="<?php echo base_url().'editBank/'.base64_encode(DEALER_ID.'_'.$record->id); ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                          <?php } ?>
                      </td>
                    </tr>
                    <?php
                        }
                    }

                    ?>
        </tbody>
    </table>
</div>
</div>
        </div>
    </div>
  </div>
    <script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
<!--    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>-->
    


