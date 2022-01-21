

<div class="container-fluid">
    <div class="row">
       <div class="col-md-12 pad-LR-10 mrg-B40">

<h2 class="page-title"><?php if(!empty($roleInfo[0])) {echo 'Edit '; } else { echo 'Add ';} ?>Role Details</h2>
 <div class="white-section">
        
            <?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if ($error) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
            <?php } ?>
            <?php
            $add = $this->session->flashdata('add');
            $update = $this->session->flashdata('update');
            if ($add) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('add'); ?>
                </div>
            <?php } ?>
            <?php if ($update) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('update'); ?>
                </div>
            <?php } ?>
       
        
            <div class="white-section">
                <div class="error-box">
                </div>
                <span class="error-message"></span>
               
                
                    <?php
                $roleId=(isset($roleInfo[0]['id'])) ?  '/'.base64_encode($roleInfo[0]['id']): '';
            $attributes = array('name' => 'roleedit', 'id' => 'roleedit');
            $action=base_url('/addRole'.$roleId);
            echo form_open($action, $attributes);
            ?>
                    
                       
                            <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group mrg-B29">
                                            <label for="Demail" class="customize-label">Team Name</label>
                                            <select name="teamName" id="teamName" class="form-control customize-form">
                                                <option value="">Select Team</option>
                                                <?php if(isset($teamList[0])){?>
                                                <?php foreach ($teamList as $team) { ?>
                                                    <?php if (isset($roleInfo)) { ?>
                                                        <option value="<?= $team->teamId ?>" <?php if ($team->teamId == $roleInfo[0]['team_id']) {
                                                    echo "selected=selected";
                                                } ?>><?= $team->team_name ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?= $team->teamId ?>" ><?= $team->team_name ?></option>
                                                <?php }
                                            } ?>
                                                <?php } ?>
                                            </select>
                                            <div class="error" id="teamName_error" ></div>
                                            <?php echo form_error('teamName'); ?>
                                        </div>
                                    </div>
                    </div>
                            <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group mrg-B29">
                                            <label for="Dname" class="customize-label">Role Name*</label>
                                            <input type="text" maxlength="100"  value="<?= set_value('role_name', !empty($roleInfo[0]['role_name']) ? $roleInfo[0]['role_name'] : '') ?>" name="role_name" id="role_name" class="form-control customize-form" placeholder="Enter Role Name" autocomplete="off">
                                            <input type="hidden" value="<?= isset($roleInfo[0]['id']) ? $roleInfo[0]['id'] : ''; ?>" name="updateId" id="updateId" />
                                            <div class="error" id="roleName_error" ></div>
                                            <?php echo form_error('role_name'); ?>
                                        </div>
                                    </div>
                                    
                                    
                    </div>
                            

                            
                            <div class="row">

                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group mrg-B29">
                                            <label for="Demail" class="customize-label">Role Status</label>
                                            <select name="status" id="status" class="form-control customize-form">
                                                <?php if(isset($roleInfo[0])){?>
                                                <option value="1"<?php if ($roleInfo[0]['status'] == '1') { echo "selected=selected";} ?>>Active</option>
                                                <option value="0"<?php if ($roleInfo[0]['status'] == '0') { echo "selected=selected";} ?> >Inactive</option>
                                                <?php } else { ?>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                            <div class="container-fluid mrg-all-20 pad-all-0 mrg8">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 bsi-sec">
                                                <div class="background-color">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 footer-button-edit">
                                                            <div class="sava-and-continue-button text-center">
                                                                <input  style="text-align: center" type="submit" class="btn btn-lg btn-save-editable" name="submit" id="submit" value="<?= (!empty($roleInfo[0])) ? 'Update' : 'Save' ?>" onclick="return ValidateRole(this);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        </div>
                    </form>
             
           


        </div>
        
          </div> 
        </div>
        </div>
          
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>