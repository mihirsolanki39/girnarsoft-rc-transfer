<div class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-mark_as_Sold" style="display: block;">
    <div class="modal-body text-left">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popup-black-window-send-email">
                    <div class="send-email-content">


                        <div class="modal-header bg-gray" id="need_remove">
                            <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"></button>
                            <h4 class="modal-title"><div id="changetitle">Select a reason for removing the car</div></h4>
                        </div>
                        <form id="bluk_new" name="bluk_new">
                            <div class="modal-content" id="cardekho_delete11">

                                <div class="form-group modal-body" style="margin-bottom:0px">
                                    <?php
                                    foreach ($reasons as $key => $val)
                                    {
                                        $addCo      = "addCommas(this.value, 'sold_price');";
                                        $reasonId   = $val['id'];
                                        $reasonName = $val['name'];
                                        ?>
                                        <div class="mrg-B10">
                                            <label>&nbsp;</label>
                                            <input name="reason" type="radio" id="remove_<?= $reasonId ?>" value='<?= $reasonId ?>' class="custom-checkbox" ><label for="remove_<?= $reasonId ?>" class="text-bold"><span class="mrg-R10"></span><?= $reasonName ?></label> 
                                        </div>
                                    <?php } ?>



                                    <div class="clearfix mrg-T15"></div>
                                    <div style="display: none;" id="soldpricediv">
                                        <div class="input-group " id="searchdiv">

                                            <div class="input-group-addon "><i class="fa fa-search" aria-hidden="true"></i></div>
                                            <input class="form-control search-form-select-box ui-autocomplete-input ui-autocomplete-loading" maxlength="30" autocomplete="Off" type="text" name="search_customer" id="search_customer"   placeholder="search By Customer Name or mobile">


                                        </div>
                                        <div class="clearfix mrg-T30"></div>
                                        <div class="input-group" style="margin-left: 33%;" id="nofound" >
                                        </div>
                                        <div class="input-group " id="leadinfo_name">

                                            <div class="input-group-addon"><i data-unicode="f007" class="fa fa-user font-18"></i></div>
                                            <input class="form-control search-form-select-box" type="text" name="cust_name" id="cust_name" autocomplete="Off" maxlength="30" placeholder="Name">

                                        </div>
                                        <div class="clearfix mrg-T15"></div>
                                        <div class="input-group " id="leadinfo_mobile">


                                            <div class="input-group-addon"><i data-unicode="f10b" class="fa fa-mobile font-18"></i></div>
                                            <input class="form-control search-form-select-box" type="text" name="cust_mobile" autocomplete="Off" id="cust_mobile" maxlength="10" onkeypress="return forceNumber(event)" placeholder="Mobile">
                                        </div>
                                        <div class="clearfix mrg-T15"></div>
                                        <div class="input-group " id="sold_price_div">

                                            <div class="input-group-addon"><i data-unicode="f156" class="fa fa-inr font-18"></i></div>
                                            <input class="form-control search-form-select-box" type="text" name="sold_price" id="sold_price" autocomplete="Off" maxlength="9" onkeypress="return forceNumber(event)" onkeyup="'<?php echo $addCo ?>'" placeholder="Please enter the selling price of the car">
                                        </div>
                                        <span id="spnDealerPrice" class="error error-msg-align"></span>
                                        <!--<p class="text-left pad-T15">We are developing a pricing index to help you sell your car faster by pricing it right, in order to do so we need the selling price of your car. The selling price is not saved against any dealership name or car id, this data is saved anonymously. Help us to serve you better.</p>-->
                                        <!--<div class="mrg-T15">
                                            <button type="button" class="btn btn-primary btn-popup" id="savesellstatus" style="width:100%">SAVE</button>
                                         </div>-->
                                    </div>
                                </div> 

                                <div class="modal-footer">
                                    <img class="soldloader" style="display:none;width:30px;" src="<?= base_url() ?> 'assets/admin_assets/images/loader.gif">
                                    <span style="color:red;" class="error"></span>
                                    <span style="color:green;" class="success"></span>
                                    <a type="button" class="mrg-R10" data-dismiss="modal">CANCEL</a>
                                    <button type="button" class="btn btn-primary send-email-send-btn" onclick="mark_as_sold()" name="submit" id="submitbluk">Submit</button>
                                </div>         
                                <div id="parentsus" style="padding-left: 160px;">           
                                    <div id="susM" class="msg10">
                                    </div>
                                </div></div>
                            <input type="hidden" value="<?= $type ?>" id="type" name="type">
                            <input type="hidden" value="<?= $carID ?>" name="car_id">
                            <input type="hidden" value="yes" name="ajaxPost">
                        </form>
                    </div>
                </div>
            </div></div>
    </div>
</div>