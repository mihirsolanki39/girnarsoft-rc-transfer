<link href="<?= base_url('/assets/css/jquery_dataTable.css') ?>" rel="stylesheet">
<link href="<?= base_url('/assets/css/common.css') ?>" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
       <div class="col-md-12 pad-LR-10 mrg-B40">
    <h2 class="page-title">Team Listing</h2>
    <div class="white-section" style="margin:20px">
        
    <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary add_dealer_btn" href="<?php echo base_url(); ?>team/add"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <table  class="table" id="teamRecord">
        <thead>
            <tr>
                <th>Team Id</th>
                <th>Team Name</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>

        </thead>
        <tbody>
            <?php
                        $attributes = array('name' => 'teamlist', 'id' => 'teamlist', 'class' => 'text-left os-animation');
                        echo form_open('/team/edit', $attributes);
                        ?>
             <?php 
             
             //echo '<pre>';print_r($userRecords);die;
                    if(!empty($teams))
                    {
                        foreach($teams as $key => $val)
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
                      <td><?php echo $val['id']; ?></td>
                      <td><?php echo ucfirst($val['team_name']); ?></td>
                      <td>
                          <label class="switch">
                                      <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $val['id']; ?>" <?php echo $checked; ?> onclick="activeDeactiveTeam('<?php echo $val['id']; ?>','<?php echo $val['team_name'] ?>')">
                                      <div class="slider round"></div>
                                  </label>
                                  <span class="switch-primary table-text-edit_<?php echo $val['id']; ?>" id="<?php echo $val['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php ///echo $status;           ?></span>
                          </td>
                      <td class="text-center">
                          <a href="<?php echo base_url('/team/delete/'.$val['id'])?>" onclick="return confirm('Are you sure to delete?')"><i class="glyphicon glyphicon-remove"></i></a>
                          &nbsp;<a class="btn btn-sm btn-info editteamcls" href="#" onclick="editTeam('<?php echo $val['id']?>')"  id="<?php echo $val['id']; ?>"><i class="fa fa-pencil"></i></a>
                          <input type="hidden" class="clsteamId" name="teamId[]" id="teamId[]" value="<?php echo $val['id']; ?>"/>
                      </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    <input type="hidden" name="teamTypeId" id="teamTypeId" value=""/>
                    <?php echo form_close(); ?>
        </tbody>
    </table>
    <div class="box-footer clearfix" style="margin-left: 47%;">
        <?php echo $this->pagination->create_links(); ?>
    </div>    
</div>
</div>
</div>
    </div>
 <script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
     
    
   




