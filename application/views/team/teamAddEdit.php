

<div class="container-fluid">
      
                <h2 class="basic-detail-heading mrg-all-0"><?php if(!empty($data[0])) {echo 'Edit '; } else { echo 'Add ';} ?>Team Details</h4>
           


   <div class="container-fluid mrg-all-20 pad-all-0 mrg8">
       
            <?php
            $this->load->helper('form');
           // $error = $this->session->flashdata('error');
            if (!empty($error)) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo (!empty($error))?$error:''; ?>                    
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
            $attributes = array('name' => 'teamedit', 'id' => 'teamedit', 'class' => 'text-left os-animation');
            echo form_open('/team/'.$action, $attributes);
            ?>
                        <div class="padLR23 clearfix">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Dname" class="customize-label">Team Name*</label>
                                        <input type="text"   name="team_name" id="team_name" class="form-control customize-form" value="<?= set_value('team_name', !empty($data[0]['team_name']) ? $data[0]['team_name'] : '') ?>" placeholder="Enter Team Name" autocomplete="off">
                                        <div class="error" id="teamName_error" ></div>
                                        <?php echo form_error('team_name'); ?>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                            <label for="Demail" class="customize-label">Team Status</label>
                                            <select name="status" id="status" class="form-control customize-form">
                                                <?php if(isset($data[0])){?>
                                                <option value="1"<?php if ($data[0]['status'] == '1') { echo "selected=selected";} ?>>Active</option>
                                                <option value="0"<?php if ($data[0]['status'] == '0') { echo "selected=selected";} ?> >Inactive</option>
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
                                                                <input  style="text-align: center" type="submit" class="btn btn-lg btn-save-editable" name="teamSubmit" id="teamSubmit" value="<?= (!empty($data[0])) ? 'Update' : 'Save' ?>" onclick="return validateTeam(this);">
                                                                <input type="hidden" name="id" value="<?php echo (!empty($data[0]['id'])) ? $data[0]['id'] : ''; ?>"/>
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
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>