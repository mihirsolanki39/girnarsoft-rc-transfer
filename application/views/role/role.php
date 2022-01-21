<style>
    .modal-backdrop.in {
     opacity: -1.5 !important;
}
.modal-backdrop {
    z-index: 0 !important;
}
    
</style>

<link href="<?= base_url('/assets/css/jquery_dataTable.css') ?>" rel="stylesheet">
<link href="<?= base_url('/assets/css/common.css') ?>" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
       <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Role Listing</h2>
    <div class="white-section">
       
   
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary add_dealer_btn" href="<?php echo base_url(); ?>addRole"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        
        <table class="table" id="bankRecord">
        <thead>
            <tr>
                <th>Team</th>
                <th>Role</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>

        </thead>
        <tbody>
            <?php
                        $attributes = array('name' => 'rolelist', 'id' => 'rolelist');
                        echo form_open('/role/edit', $attributes);
                        ?>
             <?php 
             
             //echo '<pre>';print_r($userRecords);die;
                    if(!empty($roles))
                    {
                        foreach($roles as $key => $val)
                        {
                            $status  = '';
                                $checked = '';
                                $class   = '';
                                if ($val['status'] == 0)
                                {
                                    $checked = '';
                                    $status  = 'Inactive';
                                    $class   = "class='inactive-danger'";
                                }
                                    else if ($val['status'] == 1)
                                {
                                    $status  = 'Active';
                                    $class   = "class=''";
                                    $checked = "checked='checked'";
                                }
                    ?>
                    <tr>
                      <td><?php echo $val['team_name']; ?></td>
                      <td><?php echo ucfirst($val['role_name']); ?></td>
                      <td><label class="switch">
                                      <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $val['id']; ?>" <?php echo $checked; ?> onclick="activeDeactiveRole('<?php echo $val['id']; ?>','<?php echo $val['role_name'] ?>')">
                                      <div class="slider round"></div>
                                  </label>
                                  <span class="switch-primary table-text-edit_<?php echo $val['id']; ?>" id="<?php echo $val['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php ///echo $status;           ?></span></td>
                      <td class="text-center">
                          <a href="<?php echo base_url('/role/delete/'.$val['id'])?>" onclick="return confirm('Are you sure to delete?')"><i class="glyphicon glyphicon-remove"></i></a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'addRole/'.base64_encode($val['id']); ?>"><i class="fa fa-pencil"></i></a>
                          <input type="hidden" class="clsteamId" name="roleId[]" id="roleId[]" value="<?php echo $val['id']; ?>"/>
                      </td>
                    </tr>
                    <?php
                        }
                    
                    }
                    else {?>
                    <tr><td colspan="5"><?php echo 'Record Not Available' ?></td></tr>  
                   <?php }  ?>
                    <input type="hidden" name="roleTypeId" id="roleTypeId" value=""/>
                    <?php echo form_close(); ?>
        </tbody>
    </table>
</div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
        
   




