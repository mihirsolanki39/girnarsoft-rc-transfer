<!--modal-->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-gray">

            <button type="button" id="modal1" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

            <h4 class="modal-title">Inspection Report</h4>

            <button id="share" type="button" class="btn btn-primary pull-right" style="margin-bottom:10px;margin-top:20px;"data-toggle="modal" data-target="#model-link">Share</button>

        </div>
        <iframe align="center" width="100%" style="border:0px;" height="420px" src="<? echo $page; ?>"  
                frameborder="yes" scrolling="yes" name="myIframe" id="myIframe"> </iframe>
        <div class="modal-footer">

            <button type="button" class="btn btn-default dialogcancel" data-dismiss="modal">Close</button>

        </div>
    </div>
</div>



<!-- share inspection report Modal -->

<div class="modal fade bs-example-modal-sm" id="model-link" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content" >
            <div class="modal-header bg-gray">
                <button id="emailCloseModal"type="button" class="close" onclick="closeModal()">&times;</button>
                <h4 class="modal-title">Share Inspection Report</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body text-center">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa envelope" data-unicode="f0e0"></i></div>

                            <input name="txtEmail" type="email"  maxlength="100" placeholder="Enter Email" id="email-id" class="form-control search-form-select-box" value="">
                            <input type="hidden" id="link" value="<?php echo "user/ajax/inspection_report.php?car_id=" . $car_id . "&display=on" ?>">
                        </div>
                    </div>
                    <span class="errorClass" id="errorEmail"></span>
                    <span class="successClass"	id="successEmail"></span>			
                </div>
            </div>
            <div class="modal-footer">
                <img class="emailloader" style="display:none;width:30px;" src="origin-assets/boot_origin_asset_new/images/loader.gif" >
                <span style="color:red;" class="error"></span>
                <span style="color:green;" class="success"></span>
                <button id="can-btn" type="button" class="btn btn-default emailcancel" onclick="closeModal()" >Cancel</button>
                <input name="btnSubmit" type="button" id="btnSubmit" onclick="validateEmail();" class="btn btn-primary"  value="Send">
            </div>
        </div>

    </div>
</div>
<style>
    .errorClass {
        color: #E80000;

    }
    .successClass{
        color: #32CD32;
    }
</style>
<script>

    function closeModal() {
        $("#model-link").modal('hide');
    }


    function validateEmail() {
        var check = true;
        var email = $("#email-id").val();
        var multipleEmail = email.split(',');
        //alert(multipleEmail['0']+' '+multipleEmail['1'])
        var emailReg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        for (i = 0; i < multipleEmail.length; i++) {
            if (emailReg.test(multipleEmail[i]) == false || multipleEmail[i] == '' || multipleEmail[i] == null) {
                $("#errorEmail").html("Please enter a valid email address")
                setTimeout(function () {
                    $("#errorEmail").html("");
                }, 3000);
                check = false;
                return false;


            }
        }
        if (check == true) {

            var link = $("#link").val();
            $.ajax({
                type: "POST",
                url: 'user/ajax/inspection_report_send_email.php',
                data: {email: multipleEmail,link: link,carId:'<?= $car_id ?>',utm_source: '<?= $utm_source ?>',utm_medium: '<?= $utm_medium ?>'},
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.emailloader').hide();

                    $("#successEmail").html("Action performed successfully")
                    setTimeout(function () {
                        $("#model-link").modal('hide');
                        $("#successEmail").html(" ")
                    },
                            2000);

                }

            });
        }
    }
</script>


