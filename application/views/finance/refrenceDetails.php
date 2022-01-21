<?php 
$gs = "display:none;";
$cs = "display:none;";
if(!empty($CustomerInfo['guaranter_case']))
{
    $gs = "display:block;";
}
if(!empty($CustomerInfo['co_applicant']))
{
    $cs = "display:block;";
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Case Info</h2>


            <form  enctype="multipart/form-data" method="post"  id="refrenceForm" name="refrenceForm">
                <div id="reference" class="white-section">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Reference 1</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Name*</label>
                                <input onkeypress="return nameOnly(event)" type="text" class="form-control nameCaseLoan crm-form" value="<?= !empty($refrenceData['ref_name_one'])?$refrenceData['ref_name_one']:''?>" placeholder="" id="ref_name_one" name="ref_name_one" autocomplete="off">
                                 <div class="error" id="err_ref_name_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address*</label>
                                <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['ref_address_one'])?$refrenceData['ref_address_one']:''?>" placeholder="" id="ref_address_one" name="ref_address_one" autocomplete="off">
                                 <div class="error" id="err_ref_address_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile*</label>
                                <input onkeypress="return isNumberKey(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['ref_phone_one'])?$refrenceData['ref_phone_one']:''?>" placeholder="Mobile" id="ref_phone_one" name="ref_phone_one" maxlength="10" autocomplete="off">
                                <div class="error" id="err_ref_phone_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Relationship*</label>
                                <select class="form-control crm-form testselect1" id="ref_relationship_one" name="ref_relationship_one">
                                    <option value="">Select Relationship</option>
                                    <?php foreach ($relation as $rel){ ?>
                                    <option value="<?=$rel;?>" <?=  (!empty($refrenceData['ref_relationship_one']) && $refrenceData['ref_relationship_one']==$rel?'selected=selected':'')?>><?=$rel;?></option>
                                    <?php  } ?>
                                </select>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_ref_relationship_one"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="sub-title">Reference 2</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Name*</label>
                                <input type="text" class="form-control nameCaseLoan crm-form" value="<?= !empty($refrenceData['ref_name_two'])?$refrenceData['ref_name_two']:''?>" placeholder="" id="ref_name_two" name="ref_name_two" autocomplete="off" onkeypress="return nameOnly(event)">
                                <div class="error" id="err_ref_name_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address*</label>
                                <input type="text" class="form-control crm-form" value="<?= !empty($refrenceData['ref_address_two'])?$refrenceData['ref_address_two']:''?>" placeholder="" id="ref_address_two" name="ref_address_two">
                                 <div class="error" id="err_ref_address_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile*</label>
                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" value="<?= !empty($refrenceData['ref_phone_two'])?$refrenceData['ref_phone_two']:''?>" placeholder="Mobile" id="ref_phone_two" name="ref_phone_two" maxlength="10">
                                 <div class="error" id="err_ref_phone_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Relationship*</label>
                                <select class="form-control crm-form testselect1" id="ref_relationship_two" name="ref_relationship_two">
                                    <option value="">Select Relationship</option>
                                    <?php foreach ($relation as $rel){ ?>
                                    <option value="<?=$rel;?>" <?=  (!empty($refrenceData['ref_relationship_two']) && $refrenceData['ref_relationship_two']==$rel?'selected=selected':'')?>><?=$rel;?></option>
                                    <?php  } ?>
                                </select>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_ref_relationship_two"></div>
                            </div>
                        </div>


                        <!--
                        -->
                        <div class="" style="<?=$gs?>">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Guarantor 1</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Name</label>
                                <input onkeypress="return nameOnly(event)" type="text" class="form-control nameCaseLoan crm-form" value="<?= !empty($refrenceData['g_name_one'])?$refrenceData['g_name_one']:''?>" placeholder="" id="g_name_one" name="g_name_one" autocomplete="off">
                                 <div class="error" id="err_g_name_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address</label>
                                <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['g_address_one'])?$refrenceData['g_address_one']:''?>" placeholder="" id="g_address_one" name="g_address_one" autocomplete="off">
                                 <div class="error" id="err_g_address_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile</label>
                                <input onkeypress="return isNumberKey(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['g_phone_one'])?$refrenceData['g_phone_one']:''?>" placeholder="Mobile" id="g_phone_one" name="g_phone_one" maxlength="10" autocomplete="off">
                                <div class="error" id="err_g_phone_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Relationship</label>
                                <select class="form-control crm-form testselect1" id="g_relationship_one" name="g_relationship_one">
                                    <option value="">Select Relationship</option>
                                    <?php foreach ($grelation as $rel){ ?>
                                    <option value="<?=$rel;?>" <?=  (!empty($refrenceData['g_relationship_one']) && $refrenceData['g_relationship_one']==$rel?'selected=selected':'')?>><?=$rel;?></option>
                                    <?php  } ?>
                                </select>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_g_relationship_one"></div>
                            </div>
                        </div>

                    </div>

                    <!---->
                           <div class="" style="<?=$gs?>">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Guarantor 2</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Name</label>
                                <input onkeypress="return nameOnly(event)" type="text" class="form-control nameCaseLoan crm-form" value="<?= !empty($refrenceData['g_name_two'])?$refrenceData['g_name_two']:''?>" placeholder="" id="g_name_two" name="g_name_two" autocomplete="off">
                                 <div class="error" id="err_g_name_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address</label>
                                <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['g_address_two'])?$refrenceData['g_address_two']:''?>" placeholder="" id="g_address_two" name="g_address_two" autocomplete="off">
                                 <div class="error" id="err_g_address_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile</label>
                                <input onkeypress="return isNumberKey(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['g_phone_two'])?$refrenceData['g_phone_two']:''?>" placeholder="Mobile" id="g_phone_two" name="g_phone_two" maxlength="10" autocomplete="off">
                                <div class="error" id="err_g_phone_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Relationship</label>
                                <select class="form-control crm-form testselect1" id="g_relationship_two" name="g_relationship_two">
                                    <option value="">Select Relationship</option>
                                    <?php foreach ($grelation as $rel){ ?>
                                    <option value="<?=$rel;?>" <?=  (!empty($refrenceData['g_relationship_two']) && $refrenceData['g_relationship_two']==$rel?'selected=selected':'')?>><?=$rel;?></option>
                                    <?php  } ?>
                                </select>
                               <!-- <div class="d-arrow"></div>-->
                                <div class="error" id="err_g_relationship_two"></div>
                            </div>
                        </div>

                    </div>

                    <!--
                        -->
                        <div class="" style="<?=$cs?>">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Co-Applicant 1</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Name</label>
                                <input onkeypress="return nameOnly(event)" type="text" class="form-control nameCaseLoan crm-form" value="<?= !empty($refrenceData['co_name_one'])?$refrenceData['co_name_one']:''?>" placeholder="" id="co_name_one" name="co_name_one" autocomplete="off">
                                 <div class="error" id="err_co_name_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address</label>
                                <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['co_address_one'])?$refrenceData['co_address_one']:''?>" placeholder="" id="co_address_one" name="co_address_one" autocomplete="off">
                                 <div class="error" id="err_co_address_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile</label>
                                <input onkeypress="return isNumberKey(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['co_phone_one'])?$refrenceData['co_phone_one']:''?>" placeholder="Mobile" id="co_phone_one" name="co_phone_one" maxlength="10" autocomplete="off">
                                <div class="error" id="err_co_phone_one"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Relationship</label>
                                <select class="form-control crm-form testselect1" id="co_relationship_one" name="co_relationship_one">
                                    <option value="">Select Relationship</option>
                                    <?php foreach ($grelation as $rel){ ?>
                                    <option value="<?=$rel;?>" <?=  (!empty($refrenceData['co_relationship_one']) && $refrenceData['co_relationship_one']==$rel?'selected=selected':'')?>><?=$rel;?></option>
                                    <?php  } ?>
                                </select>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_co_relationship_one"></div>
                            </div>
                        </div>

                    </div>

                    <!---->
                           <div class="" style="<?=$cs?>">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Co-Applicant 2</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Name</label>
                                <input onkeypress="return nameOnly(event)" type="text" class="form-control nameCaseLoan crm-form" value="<?= !empty($refrenceData['co_name_two'])?$refrenceData['co_name_two']:''?>" placeholder="" id="co_name_two" name="co_name_two" autocomplete="off">
                                 <div class="error" id="err_co_name_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address</label>
                                <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['co_address_two'])?$refrenceData['co_address_two']:''?>" placeholder="" id="co_address_two" name="co_address_two" autocomplete="off">
                                 <div class="error" id="err_co_address_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile</label>
                                <input onkeypress="return isNumberKey(event)" type="text" class="form-control crm-form" value="<?= !empty($refrenceData['co_phone_two'])?$refrenceData['co_phone_two']:''?>" placeholder="Mobile" id="co_phone_two" name="co_phone_two" maxlength="10" autocomplete="off">
                                <div class="error" id="err_co_phone_two"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Relationship</label>
                                <select class="form-control crm-form testselect1" id="co_relationship_two" name="co_relationship_two">
                                    <option value="">Select Relationship</option>
                                    <?php foreach ($grelation as $rel){ ?>
                                    <option value="<?=$rel;?>" <?=  (!empty($refrenceData['co_relationship_two']) && $refrenceData['co_relationship_two']==$rel?'selected=selected':'')?>><?=$rel;?></option>
                                    <?php  } ?>
                                </select>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_co_relationship_two"></div>
                            </div>
                        </div>

                   </div>
                        <input type="hidden" value="1" name="refrenceForm">
                            <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                             <input type="hidden" value="<?= !empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:'' ?>" name="caseId" id="caseId">
                            
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                              <?php 
                                $stylesss = 'display:block';
                                $stylec = 'display:none';
                                $action = '';
                                /*if(!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))
                                {
                                    $stylesss  = 'display:none';
                                    $stylec = 'display:block';
                                    $action = base_url('bankInfo/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                                }*/
                                if(((($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0')) || ((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin')))
                                {
                                    $stylesss  = 'display:none';
                                    $stylec = 'display:block';
                                     $action = base_url('bankInfo/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                                }
                               if($CustomerInfo['cancel_id']=='0'){ ?>
                                <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>"  id="refrenceButton">SAVE AND CONTINUE</button>
                                <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1,.search_test').SumoSelect({csvDispCount: 3, search: true, searchText:'Enter here.',triggerChangeCombined: true});</script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>