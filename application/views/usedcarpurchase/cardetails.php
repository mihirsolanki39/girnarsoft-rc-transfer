
<script src="<?= base_url('assets/js/inventories.js'); ?>"></script>  
<style type="text/css">
    .plusMinus {
        line-height: 0;
        display: inline-block;
    }

    .pluss,.minuss {
        font-size: 30px;
    }

    .pluss:before {
        content: "+";
        display: inline-block;
        font-size: 30px;
        line-height: 0;
        margin-top: 19px;
    }
    
    .linkpluss:before{
        content: "+";
        display: inline-block;
        font-size: 30px;
        margin-top: 19px; 
    }
    
    .linkminuss:before{
      content: "-";
      display: inline-block;
      font-size: 50px;
      margin-top: 19px;
      margin-left: 2px;
    }

    .minus:before {
        content: "-";
        display: inline-block;
        font-size: 50px;
        line-height: 0;
        margin-top: 19px;
        margin-left: 2px;
    }

    .modal-body {
        height: 430px;
        overflow: auto;
    }

    .btn-default:hover{color: #e37a34!important;background-color: #fff!important;border-color: #e37a34!important; outline: none !important; text-transform: uppercase!important;}
    .abs-check-price{ position: absolute;top: 23px;right: 17px;z-index: 9999; height: 40px;width: 135px;line-height: 44px;}

</style>
<script> 
   
    var start_time =<?= strtotime(date('Y-m-d h:i:s')); ?>; 
    var timeInMs = Math.round(Date.now()/1000); 
    $(document).ready(function () { 
    var reg_type = $('#reg_type').val();
    $('.reg_type_div').attr('style','display:none !important');
    if(reg_type=='2')
    {
        $('.reg_type_div').attr('style','display:block !important');
    }
     var fitness_certi = $('#fitness_certi').val();
    $('.reg_fitness_valid').attr('style','display:none !important');
    if(fitness_certi=='2')
    {
        $('.reg_fitness_valid').attr('style','display:block !important');
    }
 var road_tx = $('#road_tx').val();
    $('.reg_roadtx_valid').attr('style','display:none !important');
    if(road_tx=='2')
    {
        $('.reg_roadtx_valid').attr('style','display:block !important');
    }
 var permit = $('#permit').val();
    $('.reg_permit_valid').attr('style','display:none !important');
    if(permit=='2')
    {
        $('.reg_permit_valid').attr('style','display:block !important');
    }
        
        $('#reg').keyup();
        var vals = jQuery('#insurances').val();
    //alert(vals);
    if(vals=='No Insurance')
    {
        $('#insd').attr('style','display:none');
    }
    else
    {
        $('#insd').attr('style','display:block');
    }

jQuery('#insurances').change(function()
{
    //alert('dsdsd');
    var vals = jQuery('#insurances').val();
    //alert(vals);
    if(vals=='No Insurance')
    {
        $('.insd').attr('style','display:none');
    }
    else
    {
        $('.insd').attr('style','display:block');
    }
});
        $("#inventory_start").val(timeInMs); 
        $('#event_type').val(<?=$event_type ?>); 
        $('#regshowhrlp').popover(); 
        var selectedData = {items: [<?php if (!empty($getZoneDetail)) { foreach ($getZoneDetail as $key => $val) { ?>{value: "<?= $val['id'] ?>", name: "<?= $val['localityname'] ?>"}, <?php } } ?>]}; 
        
        console.log(selectedData);
        $("#rcid").keydown(function (e) { 
            $('.regcityerror').html(''); 
            if (e.which == '9') 
            { 

                if (jQuery('#as-results-rcid').css('display') == 'block') 
                { 

                    jQuery('#as-result-item-0').trigger('click'); 
                    return false; 
                } 
            } 
        }); 
        $("#cid").keydown(function (e) { 
            $('#as-selections-cid').removeClass('has-error'); 
            $("#selareacover").css("display", "none"); 
        }) ;

        $('#as-values-cid').on('change', function () { 
            $('#as-selections-cid').removeClass('has-error'); 
            $("#selareacover").css("display", "none"); 
        }) ;

        $('#regcity').change(function () { 
            var regcity = jQuery('#regcity').val(); 
            if (regcity == "Other") 
            { 
                $("#otherplace").css("visibility", "visible"); 
            } else 
            { 
                $("#otherplace").css("visibility", "hidden"); 
            } 

          var make = $('#make').val(); 
          var model = $('#model').val(); 
          var version = $('#version').val(); 
          var reg_city_id = $('#regcity').val(); 

          if (reg_city_id!== '' && version !== '') 
          { //alert('trrrr');
              $.ajax({ 
                  type: 'POST', 
                  url: '<?= base_url() . "inventories/getOnRoadPrice" ?>', 
                  data: {reg_city_id: reg_city_id, version: version}, 
                  dataType: 'json', 
                  async: true, 
                  beforeSend: function (data) { 
                  }, 
                  success: function (responseData, status, XMLHttpRequest) { 
                      
                      if (responseData.data.OnRoadprice!='') { 
                         //alert(responseData.data.OnRoadprice);
                         // var integerValue = parseInt(responseData.data.OnRoadprice) 
                         // var num2words = new NumberToWords(); 
                         // num2words.setMode("indian"); 
                         // var indian = num2words.numberToWords(integerValue); 
                         // INR = indianCurrencyFormat(integerValue); 
                         
                          $("#orp_value").val(responseData.data.OnRoadprice);
                          $("#onRoadPrice").html('<b>On Road Price</b>:&nbsp;&nbsp;&nbsp; <i class="fa fa-inr" data-unicode="f156"></i> ' + responseData.data.price ); 
                      } else { 
                        //alert('sdsdsdss');
                          $("#onRoadPrice").html(" "); 
                          $("#orp_value").val('');
                      } 


                  } 
              }); 
            }
        }) ;

        $('#showroom').change(function () { 
            var elm = $(this); 
            var showroomid = jQuery('#showroom').val(); 
            var edit_car_id = '<?php if ($car_id) { echo $car_id; } else { echo '0'; } ?>';
            jQuery.ajax({ 
                type: 'POST', 
                url: "<?php echo base_url() . 'inventories/showroomchange?showroomid='; ?>"+ showroomid+'&c_id='+edit_car_id , 
                data: "", 
                dataType: 'html', 
                async: false, 
                beforeSend: function (data) { 
                }, 
                success: function (responseData, status, XMLHttpRequest) { 
                    $('#changeuponshowroom').html(responseData); 
                } 
            }); 
        });

       
    function chagcolor()
    {
        $('#color').val('0'); 
        //$('#color')[0].sumo.reload(); 
    }

        jQuery('#fuel').change(function () 
        {
            if (jQuery('#fuel').val() != '') 
            { 
                $('#selfueldiv').removeClass('has-error'); 
                $("#selfuel").css("display", "none"); 
            } 

            if (jQuery('#fuel').val() == 'Petrol') 
            { 
                var CNGAddHtml = ''; 
                CNGAddHtml += '<input type="checkbox"  name="cngfitment" id="cngfitment" value="yes" <?php if ($carDeatil['cngFitted'] == 1) 
                { 
                    echo 'checked'; 
                } ?> ><label for="cngfitment"><span></span> CNG Fitment</label>'; 
                $('#petrolcngfitment').html(CNGAddHtml); 
                $('#fueltypein').val('Petrol'); 
            } else 
            { 
                $('#petrolcngfitment').html(''); 
                $('#fueltypein').val('Diesel'); 
            } 
        });

        $(function () { 

            // intiliaze the modal but don't show it yet 
            $("#model-not_status").modal('hide'); 

            $('.autogeneratemodalpopup').click(function (event) { 
                //alert('here'); 
                event.preventDefault(); 
                //var elm = jQuery(this); 
                var regNo = $("#reg").val(); 
                //alert(regNo); 
                var myModal = $('#model-not_status'); 
                modalBody = myModal.find('.modal-body'); 
                // load content into modal 
                modalBody.load('<?php echo BASE_HREF; ?>user/ajax/check_car_regno_new.php?reg_no=' + encodeURIComponent(regNo)); 
                // display modal 
                myModal.modal('show'); 
            }); 
        }); 

        $(function () { 

            // intiliaze the modal but don't show it yet 
            $("#model-verify_status").modal('hide'); 

            $('.clickedId').click(function (event) { 
                //alert('here'); 
                event.preventDefault(); 
                var msg = $("#hiddenclickval").val(); 
                var myModal = $('#model-verify_status'); 
                modalBody = myModal.find('.modal-body'); 
                // load content into modal 
                modalBody.load('<?php echo BASE_HREF; ?>user/ajax/ajax_submit.php?msg=' + msg); 
                // display modal 
                myModal.modal('show'); 
            }); 
        }); 

        $(function () { 
            $("#model-uploadPhoto").modal('hide'); 
            $("#tagNewphots").click(function () { 
            //alert('hello'tagNewphots; 
            var myModal = $('#model-uploadPhoto'); 
            //alert(myModal); 
            modalBody = myModal.find('.modal-body'); 
            modalBody.load('<?php echo BASE_HREF; ?>user/ajax/tagNewphots.php?car_id=<?php echo $car_id; ?>'); 
                //alert('sss'); 
                myModal.modal('show'); 
                $('#againTagpage').addClass('active'); 
                $('#viewPhotos').removeClass('active'); 
            }); 
        }); 
     
        $(function () { 
            // intiliaze the modal but don't show it yet 
            $(".tabImage").modal('hide'); 
            $('#viewPhotos').click(function (event) { 
            //alert('ddd'); 
            //alert('hello'); 
            var myModal = $('.tabImage'); 
            //alert(myModal); 
            modalBody = myModal.find('.modal-body'); 
            // load content into modal 
            modalBody.load('<?php echo BASE_HREF; ?>user/ajax/viewSlider.php?car_id=<?php echo $car_id; ?>'); 
                // display modal 
                myModal.modal('show'); 
                $('.modal-backdrop').hide(); 
                //$('#model-uploadPhoto').removeAttr('style'); 
                $('#model-uploadPhoto').css('background', 'rgba(0, 0, 0, 0.5)'); 

                $('#viewPhotos').addClass('active'); 
                $('#againTagpage').removeClass('active'); 

            }); 
        }); 
 
        $(function () { 
            // intiliaze the modal but don't show it yet 
            $(".tabImage").modal('hide'); 
            $('#againTagpage').click(function (event) { 
            //alert('hello'); 
            var myModal = $('.tabImage'); 
            //alert(myModal); 
            modalBody = myModal.find('.modal-body'); 
            // load content into modal 
            modalBody.load('<?php echo BASE_HREF; ?>user/ajax/tagNewphots.php?car_id=<?php echo $car_id; ?>'); 
            // display modal 
            myModal.modal('show'); 
            $('#againTagpage').addClass('active'); 
            $('#viewPhotos').removeClass('active'); 
            }); 
        }); 
 
        jQuery('.ext, .bod, .int, .en, .su, .ti, .br').click(function () { 
            var elm = jQuery(this); 
            var thisClass = elm.attr('class'); 
            //alert('hello'); 
            if (thisClass == 'ext') 
            { 
                var length = $("input[name='exterior[]']:checked").length; 
                //alert(length); 
                if (length > 0) 
                { 

                    jQuery('.extCount').text(' (' + length + ')'); 
                } else 
                { 
                    jQuery('.extCount').text(''); 
                } 
            } 
            if (thisClass == 'bod') 
            { 
                var length = $("input[name='bodyframe[]']:checked").length; 

                if (length > 0) 
                { 

                    jQuery('.bodCount').text(' (' + length + ')'); 
                } else 
                { 
                    jQuery('.bodCount').text(''); 
                } 
            } 
            if (thisClass == 'int') 
            { 
                var length = $("input[name='interior[]']:checked").length; 

                if (length > 0) 
                { 

                    jQuery('.intCount').text(' (' + length + ')'); 
                } else 
                { 
                    jQuery('.intCount').text(''); 
                } 
            } 
            if (thisClass == 'en') 
            { 
                var length = $("input[name='etc[]']:checked").length; 

                if (length > 0) 
                { 

                    jQuery('.enCount').text(' (' + length + ')'); 
                } else 
                { 
                    jQuery('.enCount').text(''); 
                } 
            } 
            if (thisClass == 'su') 
            { 
                var length = $("input[name='susste[]']:checked").length; 

                if (length > 0) 
                { 

                    jQuery('.suCount').text(' (' + length + ')'); 
                } else 
                { 
                    jQuery('.suCount').text(''); 
                } 
            } 
            if (thisClass == 'ti') 
            { 
                var length = $("input[name='tires[]']:checked").length; 

                if (length > 0) 
                { 

                    jQuery('.tiCount').text(' (' + length + ')'); 
                } else 
                { 
                    jQuery('.tiCount').text(''); 
                } 
            } 
            if (thisClass == 'br') 
            { 
                var length = $("input[name='breaks[]']:checked").length; 

                if (length > 0) 
                { 

                    jQuery('.brCount').text(' (' + length + ')'); 
                } else 
                { 
                    jQuery('.brCount').text(''); 
                } 
            } 
        }) 

        $('#overcondition').change(function (event) { 


            var overtext = $('#overcondition').val(); 
            //alert(overtext);   
            <?php if (empty($carConditions['usedcar_exterior']) && empty($carConditions['usedcar_interior']) && empty($carConditions['usedcar_bodyframe']) && empty($carConditions['usedcar_etc']) && empty($carConditions['usedcar_susste']) && empty($carConditions['usedcar_acheater']) && empty($carConditions['usedcar_breaks']) && empty($carConditions['usedcar_tires']) && empty($carConditions['usedcar_battery']) && empty($carConditions['usedcar_electrical'])) 
            { ?> //setValues(overtext); 
            <?php } ?> 
        });
    });

    function claculate_dealerprice(carprice) 
    { 
        return false; 
        var RealerPrice = parseInt($('#realprice').val()); 
        var DealerPrice = parseInt($('#dealerrealprice').val()); 
        if (DealerPrice != '' && DealerPrice > RealerPrice) 
        { 
            document.getElementById("dealerrealprice").value = RealerPrice; 
            document.getElementById("dealerprice").value = carprice; 
        } 
        var makeTruePrice = document.getElementById("make").value; 
        var modelTruePrice = document.getElementById("model").value; 
        var versionTruePrice = document.getElementById("version").value; 
        var yearTruePrice = document.getElementById("year").value; 
        var ownerTruePrice = document.getElementById("owner").value; 
        var kmTruePrice = document.getElementById("realkm").value; 
        var priceTruePrice = document.getElementById("realprice").value; 

        var dealerCity = '<?= $_SESSION['city'] ?>'; 


        jQuery.ajax({ 
            type: 'POST', 
            url: "ajax/checkPrice.php?city=" + dealerCity + '&' + jQuery('#addinventory').serialize(), 
            data: "", 
            dataType: 'html', 
            async: true, 
            beforeSend: function (data) { // Are not working with dataType:'jsonp' 
                //$('#aCoverDiv').html('<img src="<? echo ASSET_PATH?>images/loader.gif">'); 
            }, 
            success: function (responseData, status, XMLHttpRequest) { 
                if (responseData) 
                { 
                    jQuery('.gaadipricecheck-text').text(responseData); 
                } else 
                { 
                    jQuery('.gaadipricecheck-text').text(responseData); 


                } 

            } 
        }); 
    } 

    function setValues(overtext) 
    { 
        $('.extCount').text(''); 
        $('.bodCount').text(''); 
        $('.enCount').text(''); 
        $('.suCount').text(''); 
        $('.tiCount').text(''); 
        $('.brCount').text(''); 
        $('.intCount').text(''); 

        $('.bod').prop('checked', ''); 
        $('.ext').prop('checked', ''); 
        $('.int').prop('checked', ''); 
        $('.en').prop('checked', ''); 
        $('.su').prop('checked', ''); 
        $('.ti').prop('checked', ''); 
        $('.br').prop('checked', ''); 
        $('#ee').val(0); 
        $('.het').val(0); 
        $('.ba').val(0); 

        if (overtext == '1') { 
            $('.extCount').text('(2)'); 
            $('#Exterior3').prop('checked', 'checked'); 
            $('#Exterior7').prop('checked', 'checked'); 

            $('.bodCount').text('(2)'); 
            $('#bodyframe2').prop('checked', 'checked'); 
            $('#bodyframe5').prop('checked', 'checked'); 

            $('.intCount').text('(2)'); 
            $('#interior2').prop('checked', 'checked'); 
            $('#interior3').prop('checked', 'checked'); 

            $('.enCount').text('(3)'); 
            $('#Engine3').prop('checked', 'checked'); 
            $('#Engine4').prop('checked', 'checked'); 
            $('#Engine5').prop('checked', 'checked'); 

            $('.suCount').text('(1)'); 
            $('#Suspension1').prop('checked', 'checked'); 

            $('.tiCount').text('(1)'); 
            $('#tires2').prop('checked', 'checked'); 

            $('.brCount').text('(1)'); 
            $('#brakes2').prop('checked', 'checked'); 

            $('#ee').val(4); 
            $('.het').val(1); 
            $('.ba').val(2); 

        } 
        if (overtext == '2') { 
            $('.extCount').text('(2)'); 
            $('#Exterior4').prop('checked', 'checked'); 
            $('#Exterior7').prop('checked', 'checked'); 


            $('.bodCount').text('(2)'); 
            $('#bodyframe3').prop('checked', 'checked'); 
            $('#bodyframe6').prop('checked', 'checked'); 

            $('.intCount').text('(2)'); 
            $('#interior2').prop('checked', 'checked'); 
            $('#interior3').prop('checked', 'checked'); 


            $('.enCount').text('(2)'); 
            $('#Engine4').prop('checked', 'checked'); 
            $('#Engine7').prop('checked', 'checked'); 


            $('.suCount').text('(2)'); 
            $('#Suspension2').prop('checked', 'checked'); 
            $('#Suspension4').prop('checked', 'checked'); 

            $('.tiCount').text('(1)'); 
            $('#tires4').prop('checked', 'checked'); 

            $('.brCount').text('(1)'); 
            $('#brakes3').prop('checked', 'checked'); 

            $('#ee').val(5); 
            $('.het').val(2); 
            $('.ba').val(3); 

        } 
        if (overtext == '3') { 
            $('.extCount').text('(1)'); 
            $('#Exterior5').prop('checked', 'checked'); 


            $('.bodCount').text('(2)'); 
            $('#bodyframe4').prop('checked', 'checked'); 
            $('#bodyframe7').prop('checked', 'checked'); 

            $('.intCount').text('(4)'); 
            $('#interior4').prop('checked', 'checked'); 
            $('#interior5').prop('checked', 'checked'); 
            $('#interior6').prop('checked', 'checked'); 
            $('#interior7').prop('checked', 'checked'); 

            $('.enCount').text('(3)'); 
            $('#Engine6').prop('checked', 'checked'); 
            $('#Engine8').prop('checked', 'checked'); 
            $('#Engine9').prop('checked', 'checked'); 

            $('.suCount').text('(2)'); 
            $('#Suspension3').prop('checked', 'checked'); 
            $('#Suspension5').prop('checked', 'checked'); 

            $('.tiCount').text('(1)'); 
            $('#tires5').prop('checked', 'checked'); 

            $('.brCount').text('(1)'); 
            $('#brakes4').prop('checked', 'checked'); 

            $('#ee').val(3); 
            $('.het').val(3); 
            $('.ba').val(4); 

        } 
        if (overtext == '4') { 
            $('.extCount').text('(2)'); 
            $('#Exterior1').prop('checked', 'checked'); 
            $('#Exterior2').prop('checked', 'checked'); 

            $('.bodCount').text('(1)'); 
            $('#bodyframe1').prop('checked', 'checked'); 

            $('.intCount').text('(1)'); 
            $('#interior1').prop('checked', 'checked'); 

            $('.enCount').text('(3)'); 
            $('#Engine1').prop('checked', 'checked'); 
            $('#Engine2').prop('checked', 'checked'); 
            $('#Engine3').prop('checked', 'checked'); 

            $('.suCount').text('(1)'); 
            $('#Suspension1').prop('checked', 'checked'); 

            $('.tiCount').text('(1)'); 
            $('#tires1').prop('checked', 'checked'); 

            $('.brCount').text('(1)'); 
            $('#brakes1').prop('checked', 'checked'); 

            $('#ee').val(1); 
            $('.het').val(1); 
            $('.ba').val(1); 

        } 
    } 
 
    $("#notdrag").mousedown(function(){ 
        return false; 
    }); 

    function removeStckImg(name,id='') {
        //alert(name+' = '+id);
        if(id != ''){                            
          if(confirm('Are You Sure You Want To Delete Image')){
              jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>inventories/ajax_image_delete/",
                data: {image_id: + id},
                dataType: "json",
                success: function (result) {
                    //alert(result);
                    $('#dz-div-' + id).remove();
                    //alert(result.response.data.error);
                }

            });
          }
        }else{
          jQuery.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>inventories/ajax_image_delete",
              data: {name:name},
              dataType: "json",
              success: function (result) {
                //$('#dz-div-' + imageId).remove();
                  //alert(result.response.data.error);
              }

          });
        }
    }


</script> 
<?php // echo '<pre>';print_r($CustomerInfo);die;?>
<div class="container-fluid">
    <div class="row">
      <a id="gototop"></a>
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Car Details</h2>
            <div class="white-section">
                <div class="row">
                    <div class="col-md-12">
                    <div id="er" class="error"></div>
                        <h2 class="sub-title first-title">Basic Details</h2>
                    </div>
                         <form method="post" id="addinventory" name="addinventory"> 
                            <input type='hidden' name='hiddenclickval' id='hiddenclickval'> 
                            <input type='hidden' name='previous_pricefrom' id='previous_pricefrom' value=""> 
                            <input type='hidden' name='previous_dealer_price' id='previous_dealer_price' value=""> 
                            <input type='hidden' name='body_style' id='body_style' value=""> 
                            <input type="hidden" name="sell_enq_id" value="" /> 
                            <input type='hidden' name='hiddenuploadimagefolder' id='hiddenuploadimagefolder' value=''> 
                            <input type='hidden'   name="token" id="token" value="" /> 
                             <input type='hidden' name='caseid' id='caseid' value="<?php if ($caseid) { echo $caseid; } else { echo '0'; } ?>">
                            <input type='hidden' name='carid' id='carid' value="<?php if ($car_id) { echo $car_id; } else { echo '0'; } ?>"> 
                    <div class="loan_read_only">
                                            <div class="col-sm-6"> 
                   <div class="form-group" id="errenginediv">
                      <label class="crm-label">Engine No* </label> 
                      <input type="text" autocomplete="off" name="engineno" maxlength="17" id="engineno" placeholder="Engine No*" class="form-control upperCaseLoan" onkeypress="return forceAlphaNumeric(event);" value="<?php echo !empty($carDeatil['engineno'])?strtoupper($carDeatil['engineno']):''; ?>" > 
                     
                     <label class="control-label" id="errengine" style="display:none;"></label>
                    
                  </div> 
                    </div>
                     <div class="col-sm-6"> 
                   <div class="form-group" id="errchassisdiv">
                      <label class="crm-label">Chassis No* </label> 
                      <input type="text" autocomplete="off" name="chassisno"  maxlength="17" id="chassisno" placeholder="Chassis No*" class="form-control upperCaseLoan" onkeypress="return forceAlphaNumeric(event);" value="<?php echo !empty($carDeatil['chassisno'])?strtoupper($carDeatil['chassisno']):''; ?>" > 
                     
                     
                      <label class="control-label" style="display:none;" id="errchassis" class="errchassis"></label> 
                  </div> 
                    </div>
                    <div class="col-md-6" id="selmonthdiv">
                        <div class="form-group">
                            <label class="crm-label">Make Month*</label>
                             <select class="form-control crm-form lead_source specialselect" id="month" name="month" <?php echo (($car_id > 0) ? 'disabled="disabled"' : '') ?>>
                                 <option value="">Select</option> 
                                  <option class="month" value="01" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 1) ? "selected" : ''; ?>>Jan</option> 
                                  <option class="month" value="02" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 2) ? "selected" : ''; ?>>Feb</option> 
                                  <option class="month" value="03" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 3) ? "selected" : ''; ?>>Mar</option> 
                                  <option class="month" value="04" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 4) ? "selected" : ''; ?>>Apr</option> 
                                  <option class="month" value="05" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 5) ? "selected" : ''; ?>>May</option> 
                                  <option class="month" value="06" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 6) ? "selected" : ''; ?>>Jun</option> 
                                  <option class="month" value="07" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 7) ? "selected" : ''; ?>>Jul</option> 
                                  <option class="month" value="08" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 8) ? "selected" : ''; ?>>Aug</option> 
                                  <option class="month" value="09" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 9) ? "selected" : ''; ?>>Sep</option> 
                                  <option class="month" value="10" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 10) ? "selected" : ''; ?>>Oct</option> 
                                  <option class="month" value="11" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 11) ? "selected" : ''; ?>>Nov</option> 
                                  <option class="month" value="12" <?php echo ($carDeatil['make_month'] != '' && $carDeatil['make_month'] == 12) ? "selected" : ''; ?>>Dec</option> 
                            </select>
                            <?php if ($car_id > 0) 
                              { ?> 
                              <input type="hidden" name="month" value="<?= $carDeatil['make_month'] ?>"> 
                              <?php } ?>     
                            <label class="control-label specialselect" id="selmonth" style="display:none;">Please Select Month</label>
                        </div>
                    </div>

                    <div class="col-md-6" id="selectyeardiv">
                        <div class="form-group">
                            <label class="crm-label">Make Year*</label>
                             <select name="year" id="year" class="form-control crm-form specialselect" <?php echo (($car_id > 0) ? 'disabled="disabled"' : '') ?>> 
                                  <option value="">Select</option> 
                                  <?php 
                                  $currentYear = date('Y'); 
                                  for ($i = $currentYear; $i >= 1985; $i--) 
                                  { 
                                  ?> 
                                      <option class="jyear" value="<?= $i ?>" <?php echo $carDeatil['make_year'] == $i ? "selected" : ''; ?>><?= $i ?></option> 
                                  <?php } ?>                              
                              </select>
                                  <?php if ($car_id > 0) 
                                  { ?> 
                                      <input type="hidden" name="year" value="<?= $carDeatil['make_year'] ?>"> 
                                  <?php } ?> 
                                  <label class="control-label" id="selyear" style="display:none;">Please Select Year</label> 
                        </div>
                    </div>
                   
                   <div class="col-md-6" id="selmakediv">
                        <div class="form-group">
                            <label class="crm-label">Make Model*</label>
                             <select name="make" id="make" class="form-control crm-form specialselect"<?php if(!empty($carDeatil['make'])) {echo 'disabled=disabled';}?>> 
                                  <option value="" class="jMake">Select</option> 
                                   <?php foreach($makeListArr as $key => $makeArray){ ?>
                                    <option class="jMake" value="<?php echo $makeArray['make'] ?>" <?php if($carDeatil['make'] == $makeArray['make']) { ?>selected="selected"<?php } ?> ><?php echo $makeArray['make'] ?></option>
                                  <?php } ?>                            
                              </select> 
                                 <input type="hidden" name="mk_id" id="mk_id" value='<?= $carDeatil['make_id'] ?>'> 
                                 <label class="control-label"  id="selmake" style="display:none;">Please Select Make</label> 
                        </div>
                    </div>
                   <div class="col-sm-6" id="selversiondiv"> 
                        <div class="form-group">
                            <label class="crm-label">Variant* </label> 
                      <select name="version" id="version" class="form-control crm-form specialselect"> 
                          <option class="jversion" value="">Variant</option>
                          <?php foreach($versionListArr as $key => $versionArrayTemp){ ?>

                            <optgroup id="fueltype<?php echo $versionArrayTemp['key']; ?>" label="<?php echo $versionArrayTemp['uc_fuel_type'] ?>" style="background:#eee;"></optgroup>

                            <?php foreach($versionArrayTemp['data'] as $key => $versionArray){ ?>
                              <?php if(intval($versionArray['Displacement']) > 0){ ?>
                              <option class="jversion_<?php echo $versionArray['db_version_id']; ?>" value="<?php echo $versionArray['db_version']; ?>" <?php if($carDeatil['version_id'] == $versionArray['db_version_id']) { ?>selected="selected"<?php } ?> ><?php echo $versionArray['db_version']; ?>(<?php echo $versionArray['Displacement']; ?> CC)</option>
                              <?php } else { ?>
                                <option class="jversion_<?php echo $versionArray['db_version_id'] ?>" value="<?php echo $versionArray['db_version'] ?>" <?php if($carDeatil['version_id'] == $versionArray['db_version_id']) { ?>selected="selected"<?php } ?> ><?php echo $versionArray['db_version'] ?></option>
                              <?php } ?>
                            <?php } ?>
                          <?php } ?>
                      </select> 
                      <input type="hidden" name="version_id" id="version_id" value='<?= $carDeatil['version_id'] ?>'>   <input type="hidden" name="version_chng" id="version_chng" value="">
                      <label class="control-label"  id="selversion" style="display:none;">Please Select version</label> 
                      
                  </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                            <label class="crm-label">Fuel Type* </label> 
                             <input type="text" name="fueltypein" class="jNumberonly form-control" id="fueltypein" value='<?= $carDeatil['version_id'] ?>' readonly="readonly"> 
                            </div>
                  <div class="pos-feul" id="petrolcngfitment"> 
                     
                      </div> 
                  </div>
                      <div class="col-sm-6" id="selkmdiv"> 
                   <div class="form-group">
                      <label class="crm-label">Kilometers Driven* </label> 
                      <input type="text" autocomplete="off" name="km" value="" maxlength="12" id="km" placeholder="Kilometers" class="jNumberonly form-control" onkeyup="addCommasdd(this.value, 'km', 'realkm');" onkeypress="return forceNumber(event);" value="<?php echo $carDeatil['km_driven']; ?>" > 
                      <input type="hidden" name='realkm' value="<?php echo $carDeatil['km_driven']; ?>" id='realkm'> 
                      <label class="control-label" id="selkm" style="visibility: hidden;">Please enter kilometers driven.</label> 
                      <span class="km-text"></span> 
                  </div> 
                    </div>

                  <div class="col-sm-6" id="selcolordiv"> 
                  <div class="form-group" id="selcolordivhide">
                      <label class="crm-label">Color* </label> 
                      <select name="color" id="color" class="form-control crm-form specialselect"> 
                          <option value="">Select</option> 
                          <?php 
                          foreach ($colArr as $col) 
                          { 
                              ?> 
                                      <option class="col" value="<?php echo $col; ?>" <?php echo $carDeatil['colour'] == $col ? "selected" : ''; ?>><?php echo $col; ?></option> 
                              <?php 
                          } 
                          ?>  
                          <option class="col" value="Other">Other</option> 
                      </select>    
                      <label class="control-label" id="selcolor" style="visibility: hidden;">Please select color.</label>                  
                  </div> 
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group" id="othercolors" style="display: none;"> 
                      <label>Please Enter Other Color </label> 

                      <input  type="text" autocomplete="off" id="othercolor" name="othercolor" class="form-control"  value=""> 

                      <label class="control-label" id="othercolors2" style="display: none;">Please enter other color.</label> 
                      </div>
                  </div>
                   <div class="col-sm-6"> 
                  <div class="form-group" id="othercolorsfirst" style="display: none;"></div>
                  </div> 
                
                  
                   
                  <input type="hidden" name="tranmission" id="tranmission"> 
                  <input type="hidden" name="fuel" id="fuel"> 
                  </div>

                            
                  <a id="gotoreg"></a>
                  <div class="clearfix"></div>
                  <div class="col-sm-12"> 
                          <div class="mrg-B15"> 
                              <input type="checkbox" value="1" name="registeredcar" id="registeredcar" <?php echo ($carDeatil['reg_no']!='') ? 'checked="checked"': '';?> /> 
                              <label for="registeredcar"><span></span> Registered car </label> 
                          </div> 
                      </div>
                    <div id="regshow" style="<?php echo ($carDeatil['reg_no']!='') ? 'display: block': 'display: none';?>">
                    <div class="col-md-12">
                        <h2 class="sub-title first-title">Registration Details</h2>
                    </div>
                    <div id="selregdiv">

                  <div class="col-sm-6"> 
                          <div class="form-group"> 
                              <label class="crm-label">Registration No.* </label> 
                              <input  type="text" placeholder="Ex. DL 3C 1 4526" value="<?= $carDeatil['reg_no'] ?>"   name="reg" autocomplete="off" id="reg" maxlength='11' class="form-control crm-form" style="text-transform:uppercase" onkeypress="return forceAlphaNumeric(event);"  onkeyup="return selectRto(this)"  /> 
                              <label class="control-label"  id="selreg" style="display:none;">Please enter registration number.</label> </div>
                  </div> 
                   <div class="col-sm-6" style="height: 84px"> 
                            <div class="mrg-T25">
                              <span class="mrg-R20"> 
                                  <a class="btn btn-default" onclick="copyRegNo()" data-clipboard-target="#reg" href="javascript:void(0)">Check RC Status</a>
                              </span> 

                              <span class="mrg-R20" id="errhypodiv"> 
                                  <a class="btn btn-default" onclick="challanStatus()" data-clipboard-target="#reg" href="javascript:void(0)">Check E-Challan</a>
                              </span>
                              
                          </div>
                   </div>
                           
                  </div>
                   <div class="col-sm-6">
                        <div class="form-group">
                            <label for="" class="crm-label">RTO</label>
                            <select class="form-control crm-form rto" onchange="test(this);" id="rto" name="rto" readonly="readonly">
                            <option value="">Please Select RTO</option>
                                <?php foreach ($rto as $key=>$value){ ?>
                                <option value="<?=$value['id']?>"  <?php echo !empty($carDeatil) && $carDeatil['rto']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['Registration_Index'].' '.$value['Place_of_Registration']?></option>
                            <?php } ?>
                            </select>
                            <!--<input type="text" onkeypress="return blockSpecialChar(event)" class="form-control upperCaseLoan crm-form" value="<?= !empty($CustomerInfo['regno'])?$CustomerInfo['regno']:''?>" placeholder="HR29" id="rto" name="rto">-->
                            <div class="error" id="err_rto"></div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">RTO State</label>
                            <input type="text" class="form-control upperCaseLoan crm-form" value="<?= !empty($carDeatil['rtostate'])?$carDeatil['rtostate']:''?>" placeholder="RTO State" id="rto_state" name="rto_state" readonly="readonly">
                            <input type="hidden" id="rtostate_id" value=""/>
                            <input type="hidden" id="central_city_id" value=""/>
                            <div class="error" id="err_rtostate"></div>
                        </div>
                    </div>
                    <div class="col-sm-6" id="selregcitydiv"> 
                    <div class="form-group">
                      <label class="crm-label">Registration City* </label> 
                      <select name="regcity" id="regcity" class="form-control crm-form specialselect"> 
                      <? foreach($regCityList as $reci => $revi){?>
                      <option value="<?=$revi['city_id']?>" <?=(!empty($carDeatil['reg_place_city_id']) && ($revi['city_id']==$carDeatil['reg_place_city_id']))?' selected="selected"':''?>><?=$revi['city_name']?></option>
                      <?}?>
                      </select>
                      <label class="control-label" id="selregcity" style="display:none;">Please Select registration place.</label> 
                  </div>  
                </div>
                   


                                            
                  <div class="col-sm-6" id="selregyeardiv"> 
                  <div class="form-group">
                      <label class="crm-label">Registration Date* </label> 
                      <div class="input-group date" id="dp1">
                                    <input type="text" class="form-control crm-form insdate crm-form_1" id="reg_year" name="reg_year" value="<?=(!empty($carDeatil['reg_date']) && ($carDeatil['reg_date'] !='0000-00-00'))?date('d-m-Y',strtotime($carDeatil['reg_date'])):'';?>"  placeholder="Registration Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>

                      
                      <label class="control-label" id="selregyear" style="display:none;">Please Select registration year.</label> 
                  </div>
                  </div>
                        <div class="col-sm-6" id="selownerdiv"> 
                  <div class="form-group">
                      <label class="crm-label">No. Of Owners* </label> 
                      <select name="owner" id="owner" class="form-control crm-form"  > 
                          <option value="0">Select</option> 
                          <option class="owner" value="1" <?php echo $carDeatil['owner_type'] == 1 ? "selected" : ''; ?>>1st</option> 
                          <option class="owner" value="2" <?php echo $carDeatil['owner_type'] == 2 ? "selected" : ''; ?>>2nd</option> 
                          <option class="owner" value="3" <?php echo $carDeatil['owner_type'] == 3 ? "selected" : ''; ?>>3rd</option> 
                          <option class="owner" value="4" <?php echo $carDeatil['owner_type'] == 4 ? "selected" : ''; ?>>4th</option> 
                          <option class="owner" value="5" <?php echo $carDeatil['owner_type'] == 5 ? "selected" : ''; ?>>More than 4</option> 
                      </select>   

                       <div class="d-arrow"></div>

                      <label class="control-label" id="selowner" style="visibility: hidden;">Please select no. of owners.</label> 
                  </div>
                      
                      
                  </div>
                        <div class="col-sm-6" id="selownerdiv"> 
                  <div class="form-group">
                      <label class="crm-label">Registration Type* </label> 
                      <select name="reg_type" id="reg_type" class="form-control crm-form"  > 
                          <option value="0">Select</option> 
                          <option class="owner" value="1" <?php echo $carDeatil['reg_type'] == 1 ? "selected" : ''; ?>>Private</option> 
                          <option class="owner" value="2" <?php echo $carDeatil['reg_type'] == 2 ? "selected" : ''; ?>>Commercial</option> 
                          
                      </select>   

                       <div class="d-arrow"></div>

                      <label class="control-label" id="selowner" style="visibility: hidden;">Please select no. of owners.</label> 
                  </div>
                      
                      
                  </div>
               </div>
               <a id="gotoother"></a>
                  <div class="clearfix"></div>
                    <div class="col-md-12">
                        <h2 class="sub-title first-title">Other Details</h2>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="crm-label">Insurance* </label> 
                                <select class="form-control" id="insurances" name="insurance">
                                    <option value="No Insurance" <?= ((strtolower($carDeatil['insurance']) == 'no insurance') ? 'selected="selected"' : '') ?>>No Insurance</option>
                                    <option value="Comprehensive"  <?= ((strtolower($carDeatil['insurance']) == 'comprehensive') ? 'selected="selected"' : '') ?>>Comprehensive</option>
                                    <option value="Third Party" <?= ((strtolower($carDeatil['insurance']) == 'third party') ? 'selected="selected"' : '') ?>>Third Party</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-6 insd" id="valid_till"  style="<?= ((strtolower($carDeatil['insurance']) == 'no insurance' || empty($carDeatil['insurance'])) ? 'display: none' : 'display: block') ?>">
                                <div class="form-group">
                                <label class="crm-label">Valid Till </label> 

                                 <div class="input-group date" id="dp1">
                                <input type="text" class="form-control crm-form insdate crm-form_1" id="insdate" name="insdate" autocomplete="off" value="<?php 
                                          if(!empty($carDeatil['insurance_date']) && ($carDeatil['insurance_date']>'0000-00-00') &&  ($carDeatil['insurance_date']>'1970-01-01'))
                                            {
                                                $dob = date('d-m-Y',strtotime($carDeatil['insurance_date'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>" readonly placeholder="Insurance Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                             <label class="control-label" id="selinsurancemonth" style="display: none;">Please select Insurance Expiry year.</label>
                            </div>
                        </div>
                            <div class="col-md-6 insd" id="ins_comp"  style="<?= ((strtolower($carDeatil['insurance']) == 'no insurance' || empty($carDeatil['insurance'])) ? 'display: none' : 'display: block') ?>">
                                <div class="form-group">
                                <label class="crm-label">Insurance Company</label> 
                                <select class="form-control" id="insurance_company" name="insurer_id">
                                    <option value="" >Select Insurer Name</option>
                                    <?php foreach($insurer_list as $ins_list){?>
                                    <option value="<?=$ins_list['id']?>" <?= (($carDeatil['insurer_id'] == $ins_list['id']) ? 'selected="selected"' : '') ?>><?=$ins_list['short_name']?></option>
                                    <?php } ?>
                                </select>
                             <label class="control-label" id="err_ins_comp" style="display: none;">Please select Insurance Company.</label>
                            </div>
                        </div>
                            <div class="col-md-6 insd" id="policy_no"  style="<?= ((strtolower($carDeatil['insurance']) == 'no insurance' || empty($carDeatil['insurance'])) ? 'display: none' : 'display: block') ?>">
                                <div class="form-group">
                                <label class="crm-label">Insurance Policy No.</label> 
                                 <input type="text"  name="insurance_pol_no"  id="insurance_pol_no" placeholder="Policy no." class="form-control"  value="<?php echo !empty($carDeatil['insurance_policy_no'])?$carDeatil['insurance_policy_no']:''; ?>" > 
                             <label class="control-label" id="err_pol_no" style="display: none;">Please select Policy no.</label>
                            </div>
                        </div>
                        </div>

                        
                    </div>

                    
                    <!--<div class="col-sm-12"> 

                    <div class="form-group">
                     <label class="crm-label">Insurance* </label> 
                      <span class="mrg-R20"> 
                          <input  id="NoInsurance" name="insurance"  type="radio" value="0" <?= (($carDeatil['insurance'] == 'No Insurance' || (!isset($carDeatil['insurance']))) ? 'checked="checked"' : '') ?>><label for="NoInsurance"><span></span>No Insurance</label> 
                      </span> 
                      <span class="mrg-R20"> 
                          <input id="Comprehensive" name="insurance" type="radio" value="1" <?= (($carDeatil['insurance'] == 'Comprehensive') ? 'checked="checked"' : '') ?>><label for="Comprehensive"><span></span>Comprehensive</label> 
                      </span>                           
                      <span class="mrg-R20"> 
                          <input id="thirdParty" name="insurance" type="radio" value="2" <?= (($carDeatil['insurance'] == 'Third Party') ? 'checked="checked"' : '') ?>><label for="thirdParty"><span></span> Third Party</label> 
                      </span>                           
                  </div> 
                  </div>
                  <?php 
                  $currentMonth     = date('m'); 
                  $currentYear      = date('Y'); 
                  //echo (int)$carDeatil[month]."-".(int)$currentMonth; 
                  $currentTimeStamp = time(); 
                  $nextMonth        = (int) $carDeatil['month'] + 1; 
                  $insuranceTimr    = strtotime($carDeatil['year'] . '-' . $nextMonth . '-01'); 
                  ?> 
                  <?php 
                  //echo $currentYear . $carDeatil[year]; 
                  if ($insuranceTimr < $currentTimeStamp && ((strtolower($carDeatil['insurance']) == 'third party' || strtolower($carDeatil['insurance']) == 'comprehensive' ))) 
                  { 
                      $val = 'insurance expired on ' . $nextMonth . '-' . $carDeatil['year']; 
                  } 
                  ?> 
                  <div class="col-sm-1 form-group year-field pad-L0 pad-R0" id="insurancemonth11" <?= (($carDeatil['insurance'] == 'Third Party' || $carDeatil['insurance'] == 'Comprehensive' ) ? 'style="display:block;"' : 'style="display:none;"') ?>><span style="padding-left:15px">Valid Till: </span> 

                  </div> 
                  <div class="col-sm-2 form-group year-field pad-R5" id="insurancemonth" <?= (($carDeatil['insurance'] == 'Third Party' || $carDeatil['insurance'] == 'Comprehensive' ) ? 'style="display:block;"' : 'style="display:none;"') ?>> 
                      <?php 
                      $currentMonth = date('m'); 
                      $currentYear  = date('Y'); 
                      ?> 
                      <input type="hidden" class="iyear" value="<?= $currentMonth . "_" . $currentYear ?>"> 
                      <select name="jiyear" id="jiyear" class="form-control"> 
                          <?php if ($carDeatil['year'] == '' || $carDeatil['year'] == 0) 
                          { ?> 
                              <option value="">Year</option> 
                          <?php } 
                          ?> 
                          <?php for ($i = $currentYear; $i < $currentYear + 2; $i++) 
                          { ?> 
                              <option value="<?= $i ?>" class="jiyear" <?php echo ($carDeatil['year'] == $i) ? 'selected' : '' ?>><?= $i ?></option> 
                          <?php } ?> 
                      </select> 
                      <label class="control-label" id="selinsurancemonth" style="display: none;">Please select year.</label> 
                  </div> 
                  <div class="col-sm-2 form-group year-field pad-L5" id="insuranceyear"  <?= (($carDeatil['insurance'] == 'Third Party' || $carDeatil['insurance'] == 'Comprehensive' ) ? 'style="display:block;"' : 'style="display:none;"') ?>> 
                      <select name="jimonth" id="jimonth" class="form-control select-mrg-10"> 
                          <?php if ($monthInsuraanceText == '') 
                          { ?> 
                              <option value="">Month</option> 
                          <?php } 
                          ?> 
                          <?php 
                          if ($currentYear == $carDeatil['year']) 
                          { 
                              $start = $currentMonth; 
                              $end   = '12'; 
                          } 
                          else 
                          { 
                              $start = '01'; 
                              $end   = $currentMonth; 
                          } 
                          for ($i = $start; $i <= $end; $i++) 
                          { 
                              if ($i == '01') 
                              { 
                                  $text = 'Jan'; 
                              } 
                              if ($i == '02') 
                              { 
                                  $text = 'Feb'; 
                              } 
                              if ($i == '03') 
                              { 
                                  $text = 'Mar'; 
                              } 
                              if ($i == '04') 
                              { 
                                  $text = 'Apr'; 
                              } 
                              if ($i == '05') 
                              { 
                                  $text = 'May'; 
                              } 
                              if ($i == '06') 
                              { 
                                  $text = 'Jun'; 
                              } 
                              if ($i == '07') 
                              { 
                                  $text = 'Jul'; 
                              } 
                              if ($i == '08') 
                              { 
                                  $text = 'Aug'; 
                              } 
                              if ($i == '09') 
                              { 
                                  $text = 'Sep'; 
                              } 

                              if ($i == '10') 
                              { 

                                  $text = 'Oct'; 
                              } 
                              if ($i == '11') 
                              { 
                                  $text = 'Nov'; 
                              } 

                              if ($i == '12') 
                              { 

                                  $text = 'Dec'; 
                              } 
                              ?> 

                              <option class="jimonth" value="<?= $i ?>" <?php echo ($monthInsuraanceText == $text) ? 'selected' : '' ?>><?= $text ?></option> 
                          <?php } ?> 
                      </select> 

                  </div> -->

                    <!--<div class="col-sm-12"> 
                    <div class="form-group">
                     <label class="crm-label">Tax* </label> 
                      <span class="mrg-R20">    <input name="tax" id="taxIndividual" type="radio" value="0" <?= (($carDeatil['tax'] == 'Individual' || (!isset($carDeatil['tax']))) ? 'checked="checked"' : '') ?> > 
                          <label for="taxIndividual"><span></span>Individual</label></span> 
                      <span class="mrg-R20 mrg-L20"> 
                          <input name="tax" id="taxCorporate"  type="radio" value="1" <?= (($carDeatil['tax'] == 'Corporate') ? 'checked="checked"' : '') ?> > 

                          <label for="taxCorporate"><span></span>Corporate</label></span>                           
                    </div> 
                    </div>-->
                    </div>
                   <!-- <div class="col-sm-6"> 
                          <div class=""> 
                              <label class="crm-label">Description</label> 
                              <textarea name="additionaldetail" id="additionaldetail" placeholder="Additional details about car" class="form-control en-textarea"><?php if ($resultModelInfo['additional_feature']) 
                              { echo $resultModelInfo['additional_feature']; } ?></textarea> 
                           </div> 
                    </div>-->

                       <!--<div class="col-sm-6"> 
                    <div class="form-group" id="errlistingpricediv"> 
                        <label class="crm-label">Listing Price*</label> 
                        <div class="input-group"> 
                            <span class="input-group-addon"><strong class=" text-primary"><i class="fa fa-inr" data-unicode="f156"></i></strong></span> 
                             <input type="text"   autocomplete="off" name="listingprice" id="listingprice" class="listingprice form-control" onkeyup="addCommased(this.value, 'listingprice', '');"  placeholder="Listing Price" onkeypress="return forceNumber(event);" value="<?= ((($car_id > 0 && $carDeatil['listing_price'] != '' && $carDeatil['listing_price'] != '0') ) ? $carDeatil['listing_price'] : '') ?>">
                        </div> 
                        <label class="control-label" id="errlistingprice" style="display:none;">Please enter listing price.</label> 
                    </div> 
                </div> -->
                <input type="hidden" name="dealermobile" id="dealermobile" value="<?= (($d2dmobile) > 0 ? $d2dmobile : '') ?>" /> 
                <!--<div class="col-sm-6"> 
                    <div class=""> 
                        <label class="crm-label">Special Offers <span class="small text-muted text-italic">(Other details to attract buyers):</span></label> 
                         <textarea name="offer" id="offer" placeholder="Special Offers" class="form-control en-textarea"><?= (($car_id > 0 && $carDeatil['special_offer'] != '' && $carDeatil['special_offer'] != '0') ? $carDeatil['special_offer'] : '') ?></textarea> 
                    </div> 
                </div> 
                <div class="clearfix"></div>
                 <div class="col-sm-12">
                        <h2 class="sub-title first-title mrg-T30">Other Details</h2>
                    </div>-->
              

                <div class="row">
<!--                    <div class="col-sm-6"> 
                        <div class="form-group" id="errtradediv">
                         <label class="crm-label">Trade in type* </label> 
                          <span class="mrg-R20"> 
                              <input  id="parksell" class="tradetype" name="tradetype" onclick="tradetypess('1')"  type="radio" value="1" <?= (($carDeatil['tradetype'] == '1' || (!isset($carDeatil['tradetype']))) ? 'checked="checked"' : '') ?> ><label for="parksell"><span></span>Park & Sell</label> 
                          </span> 
                          <span class="mrg-R20"> 
                              <input id="offload" onclick="tradetypess('2')" class="tradetype" name="tradetype" type="radio" value="2" <?= (($carDeatil['tradetype'] == '2') ? 'checked="checked"' : '') ?> ><label for="offload"><span></span>Off-Load</label> 
                          </span> 
                           <label class="control-label" style="display:none;" id="errtrade"></label>                          
                      </div> 
                      </div>
                      <div class="col-sm-6"> 
                        <div class="form-group" id="errrefurbdiv" >
                         <label class="crm-label">Refurb Required</label> 
                          <span class="mrg-R20 refurby"> 
                              <input  id="refurby" class="refurbtype" name="refurb"  type="radio" value="1" <?= (($carDeatil['refurb'] == '1' || (!isset($carDeatil['refurb']))) ? 'checked="checked"' : '') ?>><label id="rey" for="refurby"><span></span>Yes</label> 
                          </span> 
                          <span class="mrg-R20 refurbn"> 
                              <input id="refurbn" class="refurbtype" name="refurb" type="radio" value="2" <?= (($carDeatil['refurb'] == '2') ? 'checked="checked"' : 'checked="checked"') ?>><label id="ren" for="refurbn"><span></span>No</label> 
                          </span>
                           <label class="control-label" style="display:none;" id="errrefurb"></label>                                                          
                      </div> 
                      </div>-->
                </div>
                   <div class="row">
                        <div class="col-sm-6"> 
                            <div class="form-group" id="errhypodiv">
                             <label class="crm-label">Hypothecation</label> 
                              <span class="mrg-R20"> 
                                  <input  id="hypoy" name="hypo"  type="radio" value="1" <?= (($carDeatil['hypo'] == '1' || (!isset($carDeatil['hypo']))) ? 'checked="checked"' : '') ?>><label for="hypoy"><span></span>Yes</label> 
                              </span> 
                              <span class="mrg-R20"> 
                                  <input id="hypon" name="hypo" type="radio" value="2" <?= (($carDeatil['hypo'] == '2') ? 'checked="checked"' : '') ?>><label for="hypon"><span></span>No</label> 
                              </span>  
                                <label class="control-label" style="display:none;" id="errhypo"></label>                                                      
                          </div> 
                        </div>
                        
                   </div>
                  <div id="hyposhow" class="row">

                   <div class="col-md-6">
                        <div class="form-group" id="err_bnkdiv">
                            <label class="crm-label">Bank Name*</label>
                             <select class="form-control crm-form " id="bank_list" name="bank_list">
                                <option value="">Select Bank</option>
                                 <?php
                                if(!empty($banklist)){
                                     foreach($banklist as $ckey => $cval){?>
                                     <option value="<?=$cval['bank_id']?>"  <?= !empty($carDeatil) && $carDeatil['bank_id']==$cval['bank_id']?'selected=selected':''?>><?=$cval['bank_name']?></option>
                                   <?php } }?>
                            </select>
                           
                             <label class="control-label" style="display:none;" id="err_bnk"></label>
                        </div>
                    </div>
                    <div class="col-sm-6"> 
                    <div class="form-group" id="err_paidoffdiv">
                     <label class="crm-label">Has loan been paid off</label> 
                      <span class="mrg-R20"> 
                          <input  id="paidoffy" name="paidoff"  type="radio" value="1" <?= (($carDeatil['paidoff'] == '1' || (!isset($carDeatil['paidoff']))) ? 'checked="checked"' : '') ?>><label for="paidoffy"><span></span>Yes</label> 
                      </span> 
                      <span class="mrg-R20"> 
                          <input id="paidoffn" name="paidoff" type="radio" value="2" <?= (($carDeatil['paidoff'] == '2') ? 'checked="checked"' : '') ?>><label for="paidoffn"><span></span>No</label> 
                      </span> 
                       <label class="control-label" style="display:none;" id="err_paidoff"></label>                                                    
                  </div> 
                  </div>
                   <div class="col-sm-6"> 
                    <div class="form-group" id="err_nocdiv">
                     <label class="crm-label">Valid Form 35 NOC Available</label> 
                      <span class="mrg-R20"> 
                          <input  id="nocy" name="noc"  type="radio" value="1" <?= (($carDeatil['noc'] == '1' || (!isset($carDeatil['noc']))) ? 'checked="checked"' : '') ?>><label for="nocy"><span></span>Yes</label> 
                      </span> 
                      <span class="mrg-R20"> 
                          <input id="nocn" name="noc" type="radio" value="2" <?= (($carDeatil['noc'] == '2') ? 'checked="checked"' : '') ?>><label for="nocn"><span></span>No</label> 
                      </span> 
                        <label class="control-label" style="display:none;" id="err_noc"></label>                                                    
                  </div> 
    
                    </div>
</div>
  <div class="clearfix"></div>

                     <div class="row">
<div class="reg_type_div">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                <label class="crm-label">Permit </label> 
                                <select class="form-control" id="permit" name="permit">
                                    <option value="1" <?= (($carDeatil['permit'] == '1') ? 'selected="selected"' : '') ?>>Expired</option>
                                    <option value="2"  <?= (($carDeatil['permit'] == '2') ? 'selected="selected"' : '') ?>>Valid</option>
                                </select>
                            </div>
                            </div>

                 
                            <div class="col-md-6 reg_permit_valid">
                                    <div class="form-group">
                                        <label class="crm-label">Valid Till</label>
                                             <div class="input-group date" id="dp1">
                                        <input type="text" class="form-control crm-form permitvalid crm-form_1" id="permitvalid" name="permitvalid" autocomplete="off" value="<?php 
                                                  if(!empty($carDeatil['permitvalid']) && ($carDeatil['permitvalid']>'0000-00-00'))
                                                    {
                                                        $dob = date('d-m-Y',strtotime($carDeatil['permitvalid'])) ;
                                                    }
                                                    else
                                                    {
                                                        $dob = '';
                                                    }
                                                    echo trim($dob) ;
                                                    ?>" readonly placeholder="Valid Till">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                            </span>
                                        </span>
                                    </div>
                                        <!--<div class="d-arrow"></div>-->
                                        <div class="error" id="err_permitvalid"></div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 reg_type_div">
                                <div class="form-group">
                                <label class="crm-label">Road Tax </label> 
                                <select class="form-control" id="road_tx" name="road_tx">
                                    <option value="1" <?= (($carDeatil['road_tx'] == '1') ? 'selected="selected"' : '') ?>>Expired</option>
                                    <option value="2"  <?= (($carDeatil['road_tx'] == '2') ? 'selected="selected"' : '') ?>>Valid</option>
                                </select>
                            </div>
                            </div>

                    
                            <div class="col-md-6 reg_roadtx_valid">
                                    <div class="form-group">
                                        <label class="crm-label">Valid Till</label>
                                             <div class="input-group date" id="dp1">
                                        <input type="text" class="form-control crm-form road_txvalid crm-form_1" id="road_txvalid" name="road_txvalid" autocomplete="off" value="<?php 
                                                  if(!empty($carDeatil['road_txvalid']) && ($carDeatil['road_txvalid']>'0000-00-00'))
                                                    {
                                                        $dobs = date('d-m-Y',strtotime($carDeatil['road_txvalid'])) ;
                                                    }
                                                    else
                                                    {
                                                        $dobs = '';
                                                    }
                                                    echo trim($dobs) ;
                                                    ?>" readonly placeholder="Valid Till">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                            </span>
                                        </span>
                                    </div>
                                        <!--<div class="d-arrow"></div>-->
                                        <div class="error" id="err_road_txvalid"></div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 reg_type_div">
                            <div class="form-group">
                            <label class="crm-label">Fitness Certificate</label> 
                            <select class="form-control" id="fitness_certi" name="fitness_certi">
                                <option value="1" <?= (($carDeatil['fitness_certi'] == '1') ? 'selected="selected"' : '') ?>>Expired</option>
                                <option value="2"  <?= (($carDeatil['fitness_certi'] == '2') ? 'selected="selected"' : '') ?>>Valid</option>
                            </select>
                        </div>
                        </div>

                
                <div class="col-md-6 reg_fitness_valid">
                        <div class="form-group">
                            <label class="crm-label">Valid Till</label>
                                 <div class="input-group date" id="dp1">
                            <input type="text" class="form-control crm-form fitvalid crm-form_1" id="fitvalid" name="fitvalid" autocomplete="off" value="<?php 
                                      if(!empty($carDeatil['fitvalid']) && ($carDeatil['fitvalid']>'0000-00-00'))
                                        {
                                            $dobfit = date('d-m-Y',strtotime($carDeatil['fitvalid'])) ;
                                        }
                                        else
                                        {
                                            $dobfit = '';
                                        }
                                        echo trim($dobfit) ;
                                        ?>" readonly placeholder="Valid Till">
                            <span class="input-group-addon">
                                <span class="">
                                    <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                </span>
                            </span>
                        </div>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_fitvalid"></div>
                        </div>
                    </div>
                        </div>
                    </div>


                         


                     
                  </div></div>
                    <div class="clearfix"></div>

                     <div class="row">
                         <div class="col-sm-12" style="<?=$carDeatil['liquid_mode']==2?'display:none':''?>">
                        <h2 class="sub-title first-title">Price Details</h2>
                    </div>
                        <div class="col-sm-6" style="<?=$carDeatil['liquid_mode']==2?'display:none':''?>"> 
                        <div class="form-group" id="selpricegaddidiv"> 
                             <label class="crm-label">List Price</label> 
                            <div class="input-group"> 
                                <span class="input-group-addon bd"><strong class=" text-primary"><i class="fa fa-inr" data-unicode="f156"></i></strong></span> 
                                <input maxlength="12" type="text"   autocomplete="off" name="pricegaadi" id="pricegaadi" class="pricegaadi form-control" placeholder="Price" onblur="return claculate_dealerprice(this.value)" onkeyup="addCommasdd(this.value, 'pricegaadi', 'realprice');" onkeypress="return forceNumber(event);" value="<?= !empty($carDeatil['car_price'])? $carDeatil['car_price'] : '' ?>"> 
                                <input type='hidden' name='realprice' id='realprice' value="<?= !empty($carDeatil['car_price'])? $carDeatil['car_price'] : ''?>"> 
                            </div> 
                            <label class="control-label" id="selpricegaddi" style="display:none;">Please enter retail price.</label> 
                            <span class="gaadiprice-text clearfix " style="clear:both;"></span> 
                            <span class="gaadipricecheck-text"  ></span> 

                                <span id="onRoadPrice"class="gaadirealpricecheck-text clearfix " style="color:#661800;font-size:10px"></span> 
                                <input type="hidden"  id="orp_value" value="" /> 

                        </div> 

                        <a href="javascript:void(0);" class="abs-check-price" style="color: rgb(228, 101, 54)" id="similarca" >Check Market Price</a>

                    </div>
                   <?php if($_SESSION['userinfo']['is_admin'] == 1 || $_SESSION['userinfo']['role_id']==25 || $_SESSION['userinfo']['role_id']==24 || $_SESSION['userinfo']['role_id']==15){ ?>   
                   <div class="col-sm-6" style="<?=($carDeatil['liquid_mode']==2 || $carDeatil['tradetype']=='1')?'display:none':''?>"> 
                        <div class="form-group" id="selpricegaddidiv"> 
                             <label class="crm-label">Min Selling Price</label> 
                            <div class="input-group"> 
                                <span class="input-group-addon bd"><strong class=" text-primary"><i class="fa fa-inr" data-unicode="f156"></i></strong></span> 
                                <input maxlength="12" type="text"   autocomplete="off" name="min_selling_price" id="min_selling_price" class="min-sell-price form-control" placeholder="Min Selling Price" onkeyup="addCommasdd(this.value, 'min_selling_price', 'realprice');" readonly value="<?= !empty($usedCarInfo['min_selling_price'])?$usedCarInfo['min_selling_price']:"" ;?>"> 
                                <input type='hidden' name='realprice' id='realprice' value="<?= !empty($carDeatil['car_price'])? $carDeatil['car_price'] : ''?>"> 
                            </div> 
                            <label class="control-label" id="selpricegaddi" style="display:none;">Please enter max selling price.</label> 
                            <span class="mingaadiprice-text clearfix " style="clear:both;"></span> 
                            <span class="gaadipricecheck-text"  ></span> 
                   
                                <span id="onRoadPrice"class="gaadirealpricecheck-text clearfix " style="color:#661800;font-size:10px"></span> 
                                <input type="hidden"  id="orp_value" value="" /> 

                        </div> 
                    </div>
                   <?php } ?>
                        
                   

                            <input type="hidden" name="caseinfo" value="1" id="caseinfo">
                            <input type="hidden" name="tradetype" value="<?=$carDeatil['tradetype']?>"/>
                            <input type="hidden" name="stockId" value="<?= !empty($carDeatil['car_id'])?$carDeatil['car_id']:'' ?>" id="stockId">
                            
                     </div>
                    <div class="row mrg-T20">
                        
                       <div class="col-sm-12" style="<?=$carDeatil['liquid_mode']==2?'display:none':''?>">
                        <h2 class="sub-title first-title">Other Website Links</h2>
                    </div> 
                        <div id="add_more_website_link">   
                        <?php if(empty($website_link)){  ?>
                        <div class="col-sm-5">
                                <div class="form-group">
                                <label class="crm-label">Website </label> 
                                <select class="form-control" id="website" name="website[]">
                                    <option value="OLX">OLX</option>
                                    <option value="Droom">Droom</option>
                                    <option value="Cartrade">Cartrade</option>
                                </select>
                            </div>
                            </div>
                        <div class="col-sm-5"> 
                   <div class="form-group" id="errenginediv">
                      <label class="crm-label">Link </label> 
                      <input type="text" autocomplete="off" name="link[]" id="link" placeholder="Link" class="form-control" value="" > 
                     
                    
                    
                  </div> 
                    </div>
                        <div class="col-sm-2">
                            <a href="javascript:void(0);" class="linkpluss added" onclick="addwebsiteLink(this,'add_more_website_link')"></a>
                                </div>
                           <?php  }else{ 
                               foreach($website_link as $a => $b){
                               ?>
                            
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label class="crm-label">Website </label>
                                        <select class="form-control" id="website" name="website[]">
                                            <option value="OLX" <?= $b['website_name'] == "OLX"?"selected=selected":"" ?>>OLX</option>
                                            <option value="Droom" <?= $b['website_name'] == "Droom"?"selected=selected":"" ?>>Droom</option>
                                            <option value="Cartrade" <?= $b['website_name'] == "Cartrade"?"selected=selected":"" ?>>Cartrade</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group" id="errenginediv">
                                        <label class="crm-label">Link </label>
                                        <input type="text" autocomplete="off" name="link[]"  id="engineno" placeholder="Link" class="form-control upperCaseLoan" value="<?= $b['website_link']; ?>"></div></div><div class="col-sm-2"><a href="javascript:void(0);" class="linkminuss minuss"></a>
                                        </div>
                            
                            
                               <?php }} ?>
                            
                            
                             
                        </div>
                                          
 
                                                                                             
                        </div> 
                         <!---->
                              <input type="hidden" name="disn1[]" id="disn_in" value="">
                              <input type="hidden" name="disp1[]" id="disp_in" value="">
                              <input type="hidden" name="webname[]" id="web_name" value="">
                              <input type="hidden" name="weblink[]" id="web_link" value="">
                              <input type="hidden" name="purchase_amt" id="purchase_rate" value=""/>
                              <input type="hidden" name="commission" id="commission_add" value="<?=!empty($orderinfo['tcs'])?$orderinfo['tcs']:''?>">
                              <input type="hidden" name="insurance_add" id="insurance_add" value="<?=!empty($orderinfo['epc'])?$orderinfo['epc']:''?>">
                              <input type="hidden" name="rent" id="rent_add" value="<?=!empty($orderinfo['road_tax'])?$orderinfo['road_tax']:''?>">
                              <input type="hidden" name="refurb_cost" id="refurb_cost_add" value="<?=!empty($orderinfo['road_tax'])?$orderinfo['road_tax']:''?>">
                              <input type="hidden" name="misc_exp" id="misc_exp_add" value="<?=!empty($orderinfo['road_tax'])?$orderinfo['road_tax']:''?>">
                              <!---->
                        
                              <div class="row">
                            <div class="col-md-12">
                                <div class="btn-sec-width">
                                <?php
                                    if($accessLevel!=1){
                                    if ($_SESSION['updatedcarid']) 
                                    { ?> 
                                        <button style="display:none;" type="button" name="submit" id="savedetail" class=" formvalidatebeforesubmit btn-continue mrg-T0">SAVE AND CONTINUE</button> 
                                    <?php } 
                                    else 
                                    { ?> 
                                        <button type="button" name="submit" id="savedetail" class="btn-continue formvalidatebeforesubmit mrg-T0">SAVE AND CONTINUE</button> 
                                    <?php }
                                  
                                    }?>    
                                    <input type="hidden" name="inventory_start" id="inventory_start"> 
        <input type="hidden" name="event_type" id="event_type"> 
                 
                                    <!--<a href="javascript:void(0);" class="btn-continue" style="<?=$stylesss?>" id="saveContCaseInfo">SAVE AND CONTINUE</a>
                                    <a href="" class="btn-continue">SAVE AND CONTINUE</a>-->
                                </div>

                            </div>
                                  </div>
                     </div>
                    </form>

<a href="#" class="clickedId"    data-target="#model-verify_status"     ></a> 

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-verify_status"> 
    <div class="modal-dialog"> 
        <div class="modal-body text-center"> 

            <div class="modal-content"> 
                <div class="modal-header bg-gray"> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
                    <h4 class="modal-title">Status of 2nd hand vehicle stolen or not [HR26AV8890]</h4> 
                </div> 

                <i class="fa fa-car col-gray font-60" data-unicode="f1b9"></i> 
                <h2 class="col-gray mrg-T0 mrg-B0">This car is not stolen.</h2> 
                <p class="edit-text font-16">source : National Crime Records Bureau</p> 
            </div> 

        </div><!-- /.modal-content --> 
    </div> 

</div> 

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-not_status"> 
    <div class="modal-dialog"> 
        <div class="modal-body text-center"> 

            <div class="modal-content"> 

                <div class="modal-header bg-gray"> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
                    <h4 class="modal-title">Status of 2nd hand vehicle stolen or not [HR26AV8890]</h4> 
                </div> 

                <i class="fa fa-car col-gray font-60" data-unicode="f1b9"></i> 
                <h2 class="col-gray mrg-T0 mrg-B0">This car is not stolen.</h2> 
                <p class="edit-text font-16">source : National Crime Records Bureau</p> 
            </div> 

        </div><!-- /.modal-content --> 
    </div> 
</div> 


<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-competitive_inventory"> 
    <div class="modal-backdrop fade in" style="height: 100%;"></div>
    <div class="modal-dialog"> 
        <div class="modal-body text-center"> 

            <div class="modal-content"> 
                <div class="modal-header bg-gray"> 
                    <button type="button" class="con close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
                    <h4 class="modal-title">Market Price</h4> 
                </div> 

                   <div" id="competitive_inventory"></div> 
            </div> 

        </div><!-- /.modal-content --> 
    </div> 

</div> 




<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="my ModalLabel" aria-hidden="true" id="pricebreakup">
              <div class="modal-backdrop fade in" style="height: 100%;"></div>
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header bg-gray">
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg"><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Price Breakup</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-sm-6">
                        Purchase Amount
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'purchase_amount');" value="<?php echo (!empty($orderinfo['purchase_amount'])) ? $orderinfo['purchase_amount'] : '';?>" name="purchase_amount" id="purchase_amount" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <div class="col-sm-6">
                        Commission
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" maxlength="10" autocomplete="off" onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'commission');" value="<?php echo (!empty($usedCarInfo['commission'])) ? $usedCarInfo['commission'] : '';?>" name="commission" id="commission" class="form-control crm-form rupee-icon">
                        </div>
                     </div>


                     <div class="col-sm-6">
                        Insurance
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'insurance');" value="<?php echo (!empty($usedCarInfo['ins_pri'])) ? $usedCarInfo['ins_pri'] : '';?>" name="insurance" id="insurance" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <div class="col-sm-6">
                        Rent
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                          <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'rent');" value="<?php echo (!empty($usedCarInfo['rent'])) ? $usedCarInfo['rent'] : '';?>" name="rent" id="rent" class="form-control crm-form rupee-icon">
                        </div>
                     </div>
                      <div class="col-sm-6">
                        Estm. Refurb Cost
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                          <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'refurb_cost');" value="<?php echo (!empty($usedCarInfo['refurb_cost'])) ? $usedCarInfo['refurb_cost'] : '';?>" name="refurb_cost" id="refurb_cost" class="form-control crm-form rupee-icon">
                        </div>
                     </div>
                       <div class="col-sm-6">
                        Miscellaneous Expense
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                          <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'misc_exp');" value="<?php echo (!empty($usedCarInfo['misc_exp'])) ? $usedCarInfo['misc_exp'] : '';?>" name="misc_exp" id="misc_exp" class="form-control crm-form rupee-icon">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 mrg-B10"><h4> Add More Expense</h4></div>
                     <div class="row inputAppend1">
                      <?php  if(empty($price_breakup)) {?>
                        <div class="col-sm-12 appendItem">
                            <div class="">
                                <div class="col-sm-5">
                                          <div class="form-group">
                                              <input name="discountname1[]"  onkeypress="return alphaOnly(event);" type="text" class="form-control disn1">
                                          </div>
                                      </div>
                                      <div class="col-sm-5">
                                          <div class="form-group">
                                              <input name="discountprice1[]" maxlength="9"  onblur="saveGrossAmt()" onkeyup="formatnumber(this.value,'inputAppend1')" onkeypress="return isNumberKey(event);"  type="text" class="form-control disp1 rupee-icon">
                                          </div>
                                      </div>
                                <div class="col-sm-1 pad-L5 plusMinus">
                                    <a href="javascript:void(0);" class="pluss added" onclick="plusabc(this,'inputAppend1')"></a>
                                </div>
                            </div>
                        </div>
                        <?php } else{
                          foreach ($price_breakup as $pk => $pv) {?>
                            <div class="col-sm-12 appendItem">
                            <div class="">
                                <div class="col-sm-5">
                                          <div class="form-group">
                                              <input name="discountname1[]" onkeypress="return alphaOnly(event);" value="<?php echo (!empty($pv['price_name'])) ? $pv['price_name'] : '';?>" type="text" class="form-control disn1">
                                          </div>
                                      </div>
                                      <div class="col-sm-5">
                                          <div class="form-group">
                                              <input name="discountprice1[]" onkeypress="return isNumberKey(event);" value="<?php echo (!empty($pv['price_value'])) ? $pv['price_value'] : '';?>"  type="text" class="form-control disp1">
                                          </div>
                                      </div>
                                <div class="col-sm-1 pad-L5 plusMinus">
                                    <a href="javascript:void(0);" class="pluss added minus"></a>
                                </div>
                            </div>
                        </div>
                        <?  }

                          }?>
                    </div>
                  </div>
                   <div class="row">
                       <div class="col-sm-6">
                       Min Selling Price
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <input type="text" onkeyup="addCommas(this.value, 'grs_amt');" value="<?php echo (!empty($usedCarInfo['min_selling_price'])) ? $usedCarInfo['min_selling_price'] : '';?>" name="grs_amt" id="grs_amt" class="form-control crm-form rupee-icon" readonly="readonly">
                        </div>
                     </div>
                   </div>
               </div>
               <div class="modal-footer">
                  
                  <button type="button" onclick="saveGrossAmt(1);" class="btn btn-primary">SAVE</button>
               </div>
            </div>
            <!-- /.modal-comment -->
         </div>
      </div>


<div id="snackbar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/inv_stock.js" type="text/javascript"></script>      
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

<script> 
    var clipboard = new ClipboardJS('.btn');
       
// function tradetypess(abb){
//       
//       if(abb=='1')
//       {
//        $('#ren').trigger('clicked');
//        $('.refurby').attr('style','display:none');
//      }
//       else
//       {
//         $('#rey').trigger('clicked');
//         $('.refurby').attr('style','display:block');
//       }
//    }


$("input[name='hypo']").change(function(){
       var hypo = $("input[name='hypo']:checked").val();
      // alert(abb);
       if(hypo=='1')
       {
            $('#hyposhow').attr('style','display:block');
       }
       else if(hypo=='2')
       {
            $('#hyposhow').attr('style','display:none');
       }
    });


    $(document).ready(function() {
        var hypyy = "<?=!empty($carDeatil['id'])?$carDeatil['id']:'0';?>";
        //tradetypess(trdetypr);
        if(hypyy==0)
        {
            $('#hypon').trigger('click');
        }
        var hypo = $("input[name='hypo']:checked").val();

        $('.specialselect').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
        $('.bnkspec').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
       //alert(abb);
       if(hypo=='1')
       {
            $('#hyposhow').attr('style','display:block');
       }
       else if(hypo=='2')
       {
            $('#hyposhow').attr('style','display:none');
       }
       var bank_list = "<?=!empty($carDeatil['bank_id'])?$carDeatil['bank_id']:''?>";
      // alert();
      // $('#bank_list').val(bank_list);
      // $('#bank_list')[0].sumo.reload();

        $('#dob').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });

        $('#permitvalid').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
               // endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
         $('#road_txvalid').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
               // endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });

         $('#fitvalid').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
               // endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#pdate').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#ddate').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
                //endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
       // $('#')
       
       
        $('#year').change(function () { 
            //alert('hi');
            $('#petrolcngfitment').html('');
            $('#fueltypein').val(''); 
            yearVal = this.value; 
           // alert(yearVal);
            if (yearVal == '') { 
                 htmlMake ='<option class="jMake" value="">Select</option>'; 
                $('#make').html(htmlMake);
                $('#make')[0].sumo.reload();
                htmlVersion = '<option class="jversion" value="">Variant</option>'; 
                $('#version').html(htmlVersion);
                $('#version')[0].sumo.reload();
                return false; 
            } else { 
                $('#selectyeardiv').removeClass('has-error'); 
                $("#selyear").css("display", "none"); 
                var model_i = '<?=!empty($carDeatil['model_id'])?$carDeatil['model_id']:''?>';
                var ver_i = '<?=!empty($carDeatil['db_version_id'])?$carDeatil['db_version_id']:''?>';
              //  alert(ver_i);
                $.ajax({ 
                    type: "POST", 
                    url: "<?php echo base_url() . 'inventories/getmakemodelversionlist'; ?>?" + $('#bluk').serialize(), 
                    data: {type: 'model', year: yearVal}, 
                    dataType: "html", 
                    success: function (responseData, status, XMLHttpRequest) { 
                        var data = $.parseJSON(responseData); 
                        var makeHtml = ''; 
                        makeHtml += '<option class="jMake" value="">Select Make Model</option>'; 
                        $.each(data, function (i, item) { 
                            makeHtml += '<option class="jMake" value="' + item.model_id + '"  >' + item.make +" " + item.model +'</option>'; 
    });
                        $('#make').html(makeHtml);
                        $('#make').val(model_i);
                        $('#make')[0].sumo.reload();
                        $('#make').trigger('change');
                        htmlVersion = '<option class="jversion" value="">Variant</option>'; 
                        //alert(htmlVersion);
                        $('#version').html(htmlVersion); 
                        $('#version').val(ver_i); 
                        $('#version')[0].sumo.reload();
                    } 
                }); 
            } 
        }); 


        $('#make').change(function () { 
            $('#petrolcngfitment').html(''); 
            $('#fueltypein').val('');
            //$('#fuel').attr('value',''); 
            //$('#tranmission').attr('value',''); 
         
            var year = $("#year").val(); 
            mTempVal = this.value; 
            if (mTempVal == '') { 
               // alert('hii');
                html = '<option class="jversion" value="">Variant</option>'; 
                $('#version').html(html); 
                return false; 
            } 
            //$('#selmodeldiv').removeClass('has-error'); 
           // $("#selmodel").css("display", "none"); 
            //$('.modelerror').text(''); 
          
            var modelVal = $(this).val(); 
               var ver_i = '<?=!empty($carDeatil['carversion'])?$carDeatil['carversion']:''?>';
              // alert(ver_i);
            //$("#versiondiv_img").show(); 
            $.ajax({ 
                type: "POST", 
                url: "<?php echo base_url() . 'inventories/getmakemodelversionlist'; ?>?" + $('#bluk').serialize(), 
                data: {model_id: modelVal,type: 'version', year: year}, 
                dataType: "html", 
                success: function (responseData, status, XMLHttpRequest) { 
                    // $("#versiondiv_img").hide(); 
                    data = $.parseJSON(responseData); 
                    var versionHtml = ''; 
                    versionHtml += '<option class="jversion" value="">Variant</option>'; 
                    $.each(data, function (i, item) { 

                        versionHtml += '<optgroup id="fueltype' + i + '" label="' + item.uc_fuel_type + '" style="background:#eee;">'; 
                        versionHtml += '</optgroup>'; 
                        if(item.Displacement>0)
                        {
                        versionHtml += '<option class="jversion_' + item.db_version_id + '" value="' + item.db_version + '">' + item.db_version + ' (' + item.Displacement + ' CC)</option>'; 
                        }
                        else
                        {
                           versionHtml += '<option class="jversion_' + item.db_version_id + '" value="' + item.db_version + '">' + item.db_version ; 
                        }
                       
                    }); 
                    $('#version').html(versionHtml); 
                  
                    var label = ''; 
                    $('#version').find('optgroup').each(function () { 
                        var lbl = $(this).attr('label'); 
                        if (lbl == label && label != '') { 
                            $(this).remove(); 
                        } else { 
                            label = lbl; 
                        } 
                    }); 
                      $('#version').val(ver_i); 
                   // alert('hhhf');
                    $('#version')[0].sumo.reload();
                     $('#version').trigger('change'); 
                    $("#model_id").val(modelVal);

                    
                } 
            }) 
        }); 

        $('#version').change(function () { 
            $('#petrolcngfitment').html(''); 
            $('#fueltypein').val('');
            //var make = $('#make').val(); 
            var model = $('#make').val(); 
            var version = $('#version').val();
            var versionIId = $('#version_id').val();
            var versionedit = "<?=!empty($carDeatil['version_id'])?$carDeatil['version_id']:''?>";
            var colId = '';
            var version_change = $('#version_chng').val();
            var edit_car_id = '<?php if ($car_id) { echo $car_id; } else { echo '0'; } ?>'; 
            if (version) 
            { 
                $('#selversiondiv').removeClass('has-error'); 
                $("#selversion").css("display", "none"); 
            } 

            versionVal = $("option:selected", this).attr("class"); 
            versionVal = versionVal.split("_"); 
            versionVal = versionVal[1]; 
            
            if(version_change=='')
            {
             colId = '<?php if ($carDeatil['colour'] != '') { echo $carDeatil['colour']; } else { echo ''; } ?>';
            }
            else
            {
               // alert('hiiiii');
                colId = '0';
            }
            $.ajax({ 
                type: "POST", 
                url: "<?php echo base_url() . 'inventories/getmakemodelversionlist'; ?>?" + $('#bluk').serialize(), 
                data: {model: model, type: 'PrefillData', version: version, car_id:edit_car_id}, 
                dataType: "json", 
                success: function (responseData, status, XMLHttpRequest) { 
                    var fuelTrans = responseData.fuelTrans; 
                    var colors = responseData.colors; 
                    var features = responseData.features; 
                    var bodystyle = fuelTrans[0].body_style; 
                    jQuery('#body_style').val(bodystyle); 
                    jQuery('#othercolor').attr('value', ''); 
                    var ColorHtml = ''; 
                    ColorHtml += '<option  value="0">Select</option>'; 
                    
                    $.each(colors, function (i, item) { 

                        selected = '';
                        if(colId == item){ selected = "selected='selected'"; }
                        ColorHtml += '<option  value="' + item + '" '+selected+'>' + item + '</option>'; 
                    }); 
                    ColorHtml += '<option  value="Other">Other</option>'; 
                    $('#color').html(ColorHtml); 
                     $('#color')[0].sumo.reload(); 
                    if(features.length > 0) 
                    { 
                        $('#mod_cupHolders').prop('checked', false);
                        $('#mod_foldingRearSeat').prop('checked', false);
                        $('#mod_tachometer').prop('checked', false);
                        $('#mod_leatherSeats').prop('checked', false);
                        $('#mod_tubelessTyres').prop('checked', false);
                        $('#mod_sunRoof').prop('checked', false);
                        $('#mod_fogLights').prop('checked', false);
                        $('#mod_washWiper').prop('checked', false);
                        $('#mod_powerWindows').prop('checked', false);
                        $('#mod_powerSteering').prop('checked', false);
                        $('#mod_powerDoorLocks').prop('checked', false);
                        $('#mod_powerSeats').prop('checked', false);
                        $('#mod_steeringAdjustment').prop('checked', false);
                        $('#mod_carStereo').prop('checked', false);
                        $('#mod_displayScreen').prop('checked', false);
                        $('#mod_antiLockBrakingSystem').prop('checked', false);
                        $('#mod_driverAirBags').prop('checked', false);
                        $('#mod_pssengerAirBags').prop('checked', false);
                        $('#mod_immobilizer').prop('checked', false);
                        $('#mod_remoteBootFuelLid').prop('checked', false);
                        $('#mod_tractionControl').prop('checked', false);
                        $('#mod_childSafetyLocks').prop('checked', false);
                        $('#mod_centralLocking').prop('checked', false);

                        if (features[0].cupHolders == '1') 
                        { 
                          $('#mod_cupHolders').prop('checked', true); 
                          } 
                          if (features[0].foldingRearSeat == '1') 
                          { 
                              $('#mod_foldingRearSeat').prop('checked', true); 
                          } 
                          if (features[0].tachometer == '1') 
                          { 
                              $('#mod_tachometer').prop('checked', true); 
                          }
                          if (features[0].leatherSeats == '1') 
                          { 
                          $('#mod_leatherSeats').prop('checked', true); 
                        } 

                        if (features[0].tubelessTyres == '1') 
                        { 
                          $('#mod_tubelessTyres').prop('checked', true); 
                          } 
                          if (features[0].sunRoof == '1') 
                          { 
                              $('#mod_sunRoof').prop('checked', true); 
                          } 
                          if (features[0].fogLights == '1') 
                          { 
                              $('#mod_fogLights').prop('checked', true); 
                          } 
                          if (features[0].washWiper == '1') 
                          { 
                          $('#mod_washWiper').prop('checked', true); 
                        } 

                        if (features[0].powerWindows == '1') 
                        { 
                          $('#mod_powerWindows').prop('checked', true); 
                          } 
                          if (features[0].powerSteering == '1') 
                          { 
                              $('#mod_powerSteering').prop('checked', true); 
                          } 
                          if (features[0].powerDoorLocks == '1') 
                          { 
                              $('#mod_powerDoorLocks').prop('checked', true); 
                          } 
                          if (features[0].powerSeats == '1') 
                          { 
                          $('#mod_powerSeats').prop('checked', true); 
                        } 

                        if (features[0].steeringAdjustment == '1') 
                        { 
                          $('#mod_steeringAdjustment').prop('checked', true); 
                          } 
                          if (features[0].carStereo == '1') 
                          { 
                              $('#mod_carStereo').prop('checked', true); 
                          } 
                          if (features[0].displayScreen == '1') 
                          { 
                              $('#mod_displayScreen').prop('checked', true); 
                        } 

                        if (features[0].antiLockBrakingSystem == '1') 
                        { 
                          $('#mod_antiLockBrakingSystem').prop('checked', true); 
                          } 
                          if (features[0].driverAirBags == '1') 
                          { 
                              $('#mod_driverAirBags').prop('checked', true); 
                          } 
                          if (features[0].pssengerAirBags == '1') 
                          { 
                              $('#mod_pssengerAirBags').prop('checked', true); 
                          } 
                          if (features[0].immobilizer == '1') 
                          { 
                          $('#mod_immobilizer').prop('checked', true); 
                        }

                        if (features[0].remoteBootFuelLid == '1') 
                        { 
                          $('#mod_remoteBootFuelLid').prop('checked', true); 
                          } 
                          if (features[0].tractionControl == '1') 
                          { 
                              $('#mod_tractionControl').prop('checked', true); 
                          } 
                          if (features[0].childSafetyLocks == '1') 
                          { 
                              $('#mod_childSafetyLocks').prop('checked', true); 
                          } 
                          if (features[0].centralLocking == '1') 
                          { 
                          $('#mod_centralLocking').prop('checked', true); 
                        }
                         if (features[0].additional_feature != '') 
                         {
                             $('#additionaldetail').html(features[0].additional_feature); 
                         }
                    } else 
                    { 
                        $('#mod_cupHolders').prop('checked', false);
                        $('#mod_foldingRearSeat').prop('checked', false);
                        $('#mod_tachometer').prop('checked', false);
                        $('#mod_leatherSeats').prop('checked', false);
                        $('#mod_tubelessTyres').prop('checked', false);
                        $('#mod_sunRoof').prop('checked', false);
                        $('#mod_fogLights').prop('checked', false);
                        $('#mod_washWiper').prop('checked', false);
                        $('#mod_powerWindows').prop('checked', false);
                        $('#mod_powerSteering').prop('checked', false);
                        $('#mod_powerDoorLocks').prop('checked', false);
                        $('#mod_powerSeats').prop('checked', false);
                        $('#mod_steeringAdjustment').prop('checked', false);
                        $('#mod_carStereo').prop('checked', false);
                        $('#mod_displayScreen').prop('checked', false);
                        $('#mod_antiLockBrakingSystem').prop('checked', false);
                        $('#mod_driverAirBags').prop('checked', false);
                        $('#mod_pssengerAirBags').prop('checked', false);
                        $('#mod_immobilizer').prop('checked', false);
                        $('#mod_remoteBootFuelLid').prop('checked', false);
                        $('#mod_tractionControl').prop('checked', false);
                        $('#mod_childSafetyLocks').prop('checked', false);
                        $('#mod_centralLocking').prop('checked', false); 
                    } 

                    if (fuelTrans.length > 0) 
                    { 
                        $("#tranmission").val(fuelTrans[0].TransmissionType); 
                        $("#fuel").val(fuelTrans[0].FuelType); 
                        
                        if (fuelTrans[0].FuelType == 'Petrol') 
                        { 
                            var CNGAddHtml = ''; 
                            CNGAddHtml += '<input type="checkbox"  name="cngfitment" id="cngfitment" value="yes" <?php if ($carDeatil['is_cng_fitted'] == 1) 
                                { 
                                    echo 'checked'; 
                                } ?> ><label for="cngfitment"><span></span> CNG Fitment</label>'; 
                            $('#petrolcngfitment').html(CNGAddHtml);
                            $('#fueltypein').val('Petrol'); 
                        } else 
                        { 
                            $('#petrolcngfitment').html(''); 
                            $('#fueltypein').val('Diesel'); 

                        } 

                        var TransmissionHtml = ''; 
                        TransmissionHtml += '<option  value="' + fuelTrans[0].TransmissionType + '">' + fuelTrans[0].TransmissionType + '</option>'; 
                        $('#tranmission').html(TransmissionHtml); 

                        var FuelHtml = ''; 
                        FuelHtml += '<option  value="' + fuelTrans[0].FuelType + '">' + fuelTrans[0].FuelType + '</option>'; 
                        $('#fuel').html(FuelHtml); 
                    } 
                    //alert(versionVal);
                    $("#version_id").val(versionVal);
                    if((parseInt(versionVal)!=parseInt(versionedit))){
                          $('#version_chng').val('1'); 
                           chagcolor();
                        }


                } 
            }); 
        });
       
        function chagcolor()
    {
        $('#color').val('0'); 
        // $('#color').[0].sumo.reload(); 
    }
       
    });

     </script>
     <script> 
    $(window).load(function(){
        <?php  if($accessLevel==1){?>
        $('#iframeuploadphoto').contents().children().click(function(event) {
            alert("Your are not allowed to upload images!");
            event.preventDefault();
        }); 
        $("#addinventory").children().prop('disabled',true);
        <?php } ?>
    });
                                        
    $(document).ready(function(){  //alert();
        
         $('body').on('click', '.minus', function() {
            $(this).parents('.appendItem').remove();
        });
        
         $('body').on('click', '.minuss', function() {
            $(this).parents('.appendlink').remove();
        });
        
       var pricingTip = '<?=isset($_GET['pricing'])?$_GET['pricing']:''?>';
       if(pricingTip=='view'){
       setTimeout(function(){$("body").scrollTop(1250);},2500);
       }

        var car_id='<?=$car_id?>';
      //  alert(car_id);
            if(car_id!=''){
              $('#km').trigger('keyup');  
              $('#year').trigger('change');
            }
    }); 
        
    function setCharAt(str,index,chr) { 
        if(index > str.length-1) return str; 
        return str.substr(0,index) + chr + str.substr(index+1); 
    }  
      
    function pad (str, max) { 
        str = str.toString(); 
        return str.length < max ? pad("0" + str, max) : str; 
    } 
    /* 
    |    End of Reg No. Validation 
    */ 

         
     $('#model').change(function(){ 
         if(this.val!='' && $('#km').val()!=''){ 
             $('#km').trigger('keyup'); 
         } 
     }); 

     $('#version').change(function(){ 
         if(this.val!='' && $('#km').val()!=''){ 
             $('#km').trigger('keyup'); 
         } 
     }); 

    var car_id='<?=$car_id?>';
    if(car_id!=''){
      $('#km').trigger('keyup');  
      $('#year').trigger('change');
    }
    //competitive_inventory 
    $('#similarca').click(function(){ 
        $('#model-competitive_inventory').attr('style','display:block !important');
        $('#model-competitive_inventory').addClass(' in');

        //var dealer_owner="<?//=trim(strtolower($_SESSION['dealer_owner']))?>"; 
        var make=$('#make').val(); 
        var model=$('#model').val(); 
        var version=$('#version').val(); 
        var km=$('#km').val(); 
        var make_year=$('#year').val(); 
        
            $.ajax({ 
                url: "<?php echo base_url().'inventories/getCompetitiveInventory/'; ?>", 
                dataType: "html", 
                //data: {make:make,model:model,version:version,km:km,make_year:make_year}, 
                data: $("#addinventory").serialize(), 
                success: function (data) { 
                    $('#competitive_inventory').html(data); 
                } 
            }); 
         return false;
    }); 

    $('.con').click(function(){
        $('#model-competitive_inventory').attr('style','display:none !important');
        $('#model-competitive_inventory').removeClass(' in');
     });
      $('#min_selling_price').click(function(){
      var caseid = $('#caseid').val();
      var exshow = "<?=!empty($orderinfo['purchase_amount'])?$orderinfo['purchase_amount']:''?>";
      $('#pricebreakup').addClass(' in');
      $('#pricebreakup').attr('style','display:block;');
      $.ajax({
              type: 'POST',
              url : "<?php echo base_url(); ?>" + "UsedCarSale/getexshowprice/",
              data:{caseid:caseid},
              dataType: "json",
              success: function(response) 
              {
                  //alert(response);
                if(exshow==''){
                 $('#purchase_amount').val(response);
                }
                 $('#purchase_amount').trigger('onkeyup');

              }
            }); 
      $('#commission').trigger('onkeyup');
      $('#insurance').trigger('onkeyup');
       $('#rent').trigger('onkeyup');
        $('#refurb_cost').trigger('onkeyup');
         $('#misc_exp').trigger('onkeyup');
         $('#grs_amt').trigger('onkeyup');
            $('.disp1').trigger('onkeyup');
   });

   
     $('.close').click(function(){
      $('#pricebreakup').removeClass(' in');
      $('#pricebreakup').attr('style','display:none;');
       $('#showroombreakup').removeClass(' in');
      $('#showroombreakup').attr('style','display:none;');
       $('#discountbreakup').removeClass(' in');
      $('#discountbreakup').attr('style','display:none;');
    });

 function formatnumber(nStr,control) {
      // alert("aa");
        $("."+control).find(".disp1").each(function () {
            var val = $(this).val();
           // alert(val)
            var val_Comma = FormateAmount1(val,'1');
            //alert(val_Comma);
            $(this).val(val_Comma);
        })
    }

    function FormateAmount1(nStr,control,flag='')
{
 if(flag==''){
  nStr=nStr.replace(/,/g,'');
}else
{
    nStr=nStr;
}
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{2})/;
  var len;
  var x3="";
  len=x1.length;
  if(len>3){
    var par1=len-3;
    
    x3=","+x1.substring(par1,len);
    x1=x1.substring(0,par1);
    
    //alert(x3);
  }
  len=x1.length;
  if(len>=3 && x3!=""){
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  }
       var commavalue = x1 +x3+x2;
       return commavalue;
}
function plusabc(e,clas) {
        if(clas=='inputAppend1')
        {
            var ccc = "'inputAppend1'";
           // alert(ccc);
          var cl = 'disn1';
          var pl = 'disp1';
          var namen = 'discountname1[]';
          var namep = 'discountprice1[]';
          var nn = 'onkeypress="return alphaOnly(event)"';
          var nnf = ' onkeyup="formatnumber(this.value,'+ccc+')"';
          var funname = 'onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" '+nnf;
        }
        if(clas=='inputAppend2')
        {
          var cl = 'disn2';
          var pl = 'disp2';
          var namen = 'discountname2[]';
          var namep = 'discountprice2[]';
          var funname = 'onblur="saveShowAmt1()" ';
        }
        if(clas=='inputAppend3')
        {
          var cl = 'disn';
          var pl = 'disp';
          var namen = 'discountname[]';
          var namep = 'discountprice[]';
          var funname = ' onblur="saveShowAmt()"';
        }
        var oncl = "plusabc(this, '"+clas+"')";
        $('.' + clas).append('<div class="col-md-12 appendItem"><div class=""><div class="col-md-5"><div class="form-group"><input name="'+namen+'" '+nn+' value="" maxlength="10" type="text" class="form-control '+cl+' "></div></div><div class="col-md-5"><div class="form-group"><input '+ funname +' name="'+namep+'" value="" type="text" maxlength="9" class="form-control '+pl+' rupee-icon"></div></div><div class="col-md-1 pad-L5 class="plusMinus"><a href="javascript:void(0);" class="pluss added minus"></a></div></div></div>');
        setTimeout(function(){ 
        }, 10);
    }

    $(document).ready(function(){ 
//       $('input[type=text]').bind("cut copy paste",function(e) { 
//          e.preventDefault(); 
//       }); 
    }); 
                                             
    var selectIds = $('#panel1,#panel2,#panel3,#panel4'); 
    $(function ($) { 
        selectIds.on('show.bs.collapse hidden.bs.collapse', function () { 
            $(this).prev().find('.fa').toggleClass('fa-minus fa-plus'); 

        }) 
    }); 
     
     
    $("#open_suggestions").click(function(){ 
       //var event_type='GCD'+<?php //echo  "$event_type" ?>; 
       // _gaq.push(['_trackEvent', 'Add Inventory', 'Photo Suggestions',event_type ]); 
    }); 
</script> 
<script> 
  $("#makemodelauto").change(function () { 
      autoval = jQuery('#makemodelauto').val(); 
      //alert(autoval); 
      if (autoval == 'Please select make month and make year') 
      { 
          jQuery('#makemodelauto').val(''); 
      } else 
      { 
          var arr = autoval.split('   '); 
          jQuery('#make').val(arr[0]); 
          jQuery('#model').val(arr[1]); 
      } 
      $('.ui-helper-hidden-accessible').css('display', 'none'); 
  }); 

  $('#isclassified').change(function () { 
      if (this.checked) 
      { 
          $('#gaadilogo').show(); 
          $('#cdlogo').show(); 
          $('#zwlogo').show(); 
      } else 
      { 
          $('#gaadilogo').hide(); 
          $('#cdlogo').hide(); 
          $('#zwlogo').hide(); 

      } 
  }); 

  function addCommasdealerupdate(nStr) 
  { 
      if (nStr) { 
          nStr = nStr.replace(/,/g, ''); 
          nStr += ''; 
          x = nStr.split('.'); 
          x1 = x[0]; 
          x2 = x.length > 1 ? '.' + x[1] : ''; 
          var rgx = /(\d+)(\d{2})/; 
          var len; 
          var x3 = ""; 
          len = x1.length; 
          if (len > 3) { 
              var par1 = len - 3; 

              x3 = "," + x1.substring(par1, len); 
              x1 = x1.substring(0, par1); 

              //alert(x3); 
          } 
          len = x1.length; 
          if (len >= 3 && x3 != "") { 
              while (rgx.test(x1)) { 
                  x1 = x1.replace(rgx, '$1' + ',' + '$2'); 
              } 
          } 
      } 
  } 

  $(document).ready(function () { 
      <?php if ($car_id > 0 || $central_stock_id > 0) { ?> 
              addCommasdealerupdate('<?php if ($car_id > 0 && $carDeatil['dealer_price'] != '' && $carDeatil['dealer_price'] != '0') 
                  { 
                      echo $carDeatil['dealer_price']; 
                  } ?>'); 
              $("#pricegaadi").trigger('onkeyup'); 
              $("#km").val(<?php echo $carDeatil['km_driven']; ?>);
              $("#km").trigger('onkeyup'); 
              $("#fuel").trigger('change'); 
              $("#reg").trigger('onkeyup');
              $("#version").trigger('change'); 
              $("#showroom").trigger('change');
      <?php } ?> 
      $("#overcondition").trigger('change'); 

      /*--  Search textbox end */ 
      function NumberToWords() { 

          var units = ["", "One", "Two", "Three", "Four", "Five", "Six", 
              "Seven", "Eight", "Nine", "Ten"]; 
          var teens = ["Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", 
              "Sixteen", "Seventeen", "Eighteen", "Nineteen", "Twenty"]; 
          var tens = ["", "Ten", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", 
              "Seventy", "Eighty", "Ninety"]; 

          var othersIndian = ["Thousand", "Lakh", "Crore"]; 

          var othersIntl = ["Thousand", "Million", "Billion", "Trillion"]; 

          var INDIAN_MODE = "indian"; 
          var INTERNATIONAL_MODE = "international"; 
          var currentMode = INDIAN_MODE; 

          var getBelowHundred = function (n) { 
              if (n >= 100) { 
                  return "greater than or equal to 100"; 
              } 
              ; 
              if (n <= 10) { 
                  return units[n]; 
              }; 
              if (n <= 20) { 
                  return teens[n - 10 - 1]; 
              }; 
              var unit = Math.floor(n % 10); 
              n /= 10; 
              var ten = Math.floor(n % 10); 
              var tenWord = (ten > 0 ? (tens[ten] + " ") : ''); 
              var unitWord = (unit > 0 ? units[unit] : ''); 
              return tenWord + unitWord; 
          }; 

          var getBelowThousand = function (n) { 
              if (n >= 1000) { 
                  return "greater than or equal to 1000"; 
              }; 
              var word = getBelowHundred(Math.floor(n % 100)); 

              n = Math.floor(n / 100); 
              var hun = Math.floor(n % 10); 
              word = (hun > 0 ? (units[hun] + " Hundred ") : '') + word; 

              return word; 
          }; 

          return { 
              numberToWords: function (n) { 
                  if (isNaN(n)) { 
                      return "Not a number"; 
                  } 
                  ; 

                  var word = ''; 
                  var val; 

                  val = Math.floor(n % 1000); 
                  n = Math.floor(n / 1000); 

                  word = getBelowThousand(val); 

                  if (this.currentMode == INDIAN_MODE) { 
                      othersArr = othersIndian; 
                      divisor = 100; 
                      func = getBelowHundred; 
                  } else if (this.currentMode == INTERNATIONAL_MODE) { 
                      othersArr = othersIntl; 
                      divisor = 1000; 
                      func = getBelowThousand; 
                  } else { 
                      throw "Invalid mode - '" + this.currentMode 
                              + "'. Supported modes: " + INDIAN_MODE + "|" 
                              + INTERNATIONAL_MODE; 
                  } 
                  ; 

                  var i = 0; 
                  while (n > 0) { 
                      if (i == othersArr.length - 1) { 
                          word = this.numberToWords(n) + " " + othersArr[i] + " " 
                                  + word; 
                          break; 
                      } 
                      ; 
                      val = Math.floor(n % divisor); 
                      n = Math.floor(n / divisor); 
                      if (val != 0) { 
                          word = func(val) + " " + othersArr[i] + " " + word; 
                      } 
                      ; 
                      i++; 
                  } 
                  ; 
                  return word; 
              }, 
              setMode: function (mode) { 
                  if (mode != INDIAN_MODE && mode != INTERNATIONAL_MODE) { 
                      throw "Invalid mode specified - '" + mode 
                              + "'. Supported modes: " + INDIAN_MODE + "|" 
                              + INTERNATIONAL_MODE; 
                  } 
                  ; 
                  this.currentMode = mode; 
              } 
          } 
      } 

      //$('#version,#regcity').change(function (event) { 
       
      //}); 


      function indianCurrencyFormat(price) { 
          var x = ''; 
          x = price.toString(); 
          var lastThree = x.substring(x.length - 3); 
          var otherNumbers = x.substring(0, x.length - 3); 
          if (otherNumbers != '') 
              lastThree = ',' + lastThree; 
          var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree; 

          return res; 
      } 

      $('.jNumberonly,.pricegaadi,.dealerprice,.min-sell-price').keyup(function (event) { 
        //alert('iiiii');
          var elm = $(this); 
          var a = []; 
          var k = event.which; 
          for (i = 48; i < 58; i++) 
              a.push(i); 

          if (!(a.indexOf(k) >= 0)) 
          { 
              event.preventDefault(); 

          } 

          var integerValue = parseInt($('#realkm').val()); 
          //alert($('#realkm').val()); 
          if (elm.hasClass('jNumberonly')) 
          { 
              if ($('.jNumberonly').attr('value') == '') 
              { 
                  $('.km-text').text(''); 
              } 
              //alert(integerValue); 
              if (integerValue > 0) 
              { 
                  var num2words = new NumberToWords(); 
                  num2words.setMode("indian"); 
                  var indian = num2words.numberToWords(integerValue); 

                  $('.km-text').text(indian); 
              } 
          } 
          if (elm.hasClass('pricegaadi')) 
          { 

              if ($('.pricegaadi').attr('value') == '') 
              { 
                  $('#pricewebsite').attr('value', ''); 
                  $('.gaadiprice-text').text(''); 
              } 
              var integercarprice = parseInt($('#realprice').val()); 
              if (integercarprice > 0) 
              { 
                  var num2words = new NumberToWords(); 
                  num2words.setMode("indian"); 
                  var indian = num2words.numberToWords(integercarprice); 

                  $('.gaadiprice-text').text(indian); 
              } 
          }
          if (elm.hasClass('minpricegaadi')) 
          { 

              if ($('.minpricegaadi').attr('value') == '') 
              { 
                  $('#minpricewebsite').attr('value', ''); 
                  $('.mingaadiprice-text').text(''); 
              } 
              var integercarprice = parseInt($('#min-selling-price').val()); 
              if (integercarprice > 0) 
              { 
                  var num2words = new NumberToWords(); 
                  num2words.setMode("indian"); 
                  var indian = num2words.numberToWords(integercarprice); 

                  $('.mingaadiprice-text').text(indian); 
              } 
          } 
          if (elm.hasClass('pricewebsite')) 
          { 

              if ($('.pricewebsite').attr('value') == '') 
              { 
                  $('.websiteprice-text').text(''); 
              } 
              if (integerValue > 0) 
              { 
                  var num2words = new NumberToWords(); 
                  num2words.setMode("indian"); 
                  var indian = num2words.numberToWords(integerValue); 

                  $('.websiteprice-text').text(indian); 
              } 
          } 
          if (elm.hasClass('dealerprice')) 
          { 
              //$('#addtodealer').prop('checked','checked'); 
              if ($('.dealerprice').attr('value') == '') 
              { 
                  //$('#addtodealer').prop('checked',''); 
                  $('.dealerprice-text').text(''); 
              } 
              var integerdealerprice = parseInt($('#dealerrealprice').val()); 
              if (integerdealerprice > 0) 
              { 
                  var num2words = new NumberToWords(); 
                  num2words.setMode("indian"); 
                  var indian = num2words.numberToWords(integerdealerprice); 

                  $('.dealerprice-text').text(indian); 
              } 
          } 
      }); 
  });

  <?php 
  $serverhostname = $_SERVER['HTTP_HOST']; 
  if ($serverhostname != 'localhost') 
  { 
      ?> /*setTimeout(
          function () { 
              console.log('Jai Shree Krishina');
              var closediv = $(".multi-dropdwn").next(" .dropdown-menu"); 
              $(".multi-dropdwn").click(function (e) { 
                  $(this).next(" .dropdown-menu").toggle(); 
              }) 
              $(document).mouseup(function (e) { 
                  if (closediv.has(e.target).length == 0) { 
                      closediv.hide(); 
                  } 
              });
          } ,'5000' );*/
  <?php } ?> 
</script> 
<script type="text/javascript">
$("#reg_type").change(function(){
    var reg_type = $('#reg_type').val();
    $('.reg_type_div').attr('style','display:none !important');
    if(reg_type=='2')
    {
        $('.reg_type_div').attr('style','display:block !important');
    }
});

$("#permit").change(function(){
    var permit = $('#permit').val();
    $('.reg_permit_valid').attr('style','display:none !important');
    if(permit=='2')
    {
        $('.reg_permit_valid').attr('style','display:block !important');
    }
});
$("#road_tx").change(function(){
    var road_tx = $('#road_tx').val();
    $('.reg_roadtx_valid').attr('style','display:none !important');
    if(road_tx=='2')
    {
        $('.reg_roadtx_valid').attr('style','display:block !important');
    }
});
$("#fitness_certi").change(function(){
    var fitness_certi = $('#fitness_certi').val();
    $('.reg_fitness_valid').attr('style','display:none !important');
    if(fitness_certi=='2')
    {
        $('.reg_fitness_valid').attr('style','display:block !important');
    }
});

  $(".formvalidatebeforesubmit").click(function(event){
    var errorcount    =   0;
    var today         =   new Date();
    var curmm         =   today.getMonth();
    var curyy         =   today.getFullYear();
    var mm            =   today.getMonth();
    //alert('ew'+today);
    //var g             =   d.getMonth();
    var yyyy          =   today.getFullYear();
    var date          =   new Date(yyyy, mm, 1);
    date.setMonth(date.getMonth() - 3);
    mm                =   date.getMonth();
    yyyy              =   date.getFullYear();
    date              =   new Date(yyyy, mm, 1);
    var yyyy1         =   jQuery('#year').val();
    var mm1           =   jQuery('#month').val();
    var mm2           =   jQuery('#month').val();

    var reg_month     =   jQuery('#reg_month').val();
    var reg_year      =   jQuery('#reg_year').val();

    mm1               =   mm1-1;
        //alert(10-mm2);
       // alert(reg_year);
    if(mm2.length=='1')
    {
        //mm2 = mm2-1;
    }
    //alert(curmm);
    //club website link
    var website = [];
    var link = [];
     var inns = document.getElementsByName('website[]');
          for (var i = 0; i <inns.length; i++) {
          var inn=inns[i];
            website.push(inn.value);
          }
          
     var innsp = document.getElementsByName('link[]');
          for (var i = 0; i <inns.length; i++) {
          var inn=innsp[i];
            link.push(inn.value);
          }
          
       $("#web_name").val(website);
       $("#web_link").val(link);
          
    
    var date1         =   new Date(yyyy1, mm1, 1);
    var bank_list = $('#bank_list').val();
    //var tradetype =$('input[name=tradetype]:checked').length;
    var refurb =$('input[name=refurb]:checked').val();
    var hypo = $('input[name=hypo]:checked').val();
    var paidoff =$('input[name=paidoff]:checked').val();
    var noc =$('input[name=noc]:checked').val();
    $("#selkm").css("display", "none");
    $('#selkmdiv').removeClass('has-error');
    $("#selmonth").css("display", "none");
    $('#selmonthdiv').removeClass('has-error');
    $("#selregmonth").css("display", "none");
    $('#selregmonthdiv').removeClass('has-error');
    
     $('#valid_till').removeClass('has-error');
     $('#ins_comp').removeClass('has-error');
     $('#policy_no').removeClass('has-error');
     $('.control-label').css("display", "none");
     
    $('.hasError').each(function(){
      if(this.value==1){
        errorcount++;
      }
    });

 
    if(jQuery('#model').val()=='')
    {
      $('#selmodeldiv').addClass('has-error');
      $("#selmodel").css("display", "block");
      errorcount++;
    }

    if(jQuery('#version').val()=='')
    {
      $('#selversiondiv').addClass('has-error');
      $("#selversion").css("display", "block");
      errorcount++;
    }
    if(jQuery('#km').val()=='')
    {
      $('#selkmdiv').addClass('has-error');
      $("#selkm").html('Please enter kilometers driven.');
      $("#selkm").css("visibility", "visible");
      $("#selkm").css("display", "block");
      errorcount++;
    }

    if(jQuery('#realkm').val()!='' && jQuery('#realkm').val()<=100)
    {
      $('#selkmdiv').addClass('has-error');
      $("#selkm").html('Kilometers driven should be >100');
      $("#selkm").css("visibility", "visible");
      $("#selkm").css("display", "block");
      errorcount++;
    }

    if(jQuery('#realkm').val()!='' && jQuery('#month').val()!='' && jQuery('#year').val()!='' && date>date1 && jQuery('#realkm').val()<=1000)
    {
      $('#selkmdiv').addClass('has-error');
      $("#selkm").html('Kilometers driven should be >1000');
      $("#selkm").css("visibility", "visible");
      $("#selkm").css("display", "block");
      errorcount++;
    }
     if(jQuery('#color').val()=='' || jQuery('#color').val()=='0')
    {
      $('#selcolordiv').addClass('has-error');
      $("#selcolor").css("visibility", "visible");
      errorcount++;
    }

    if((jQuery('#color').val()=='Other') && (jQuery('#othercolor').val()==''))
    {
      $('#selcolordiv').removeClass('has-error');
      $("#selcolor").css("visibility", "block");
      $('#othercolors').addClass('has-error');
      $("#othercolors2").css("display", "block");
      errorcount++;
    }

    if((jQuery('#othercolor').val()!='') &&  (/^[a-zA-Z ]*$/.test(jQuery('#othercolor').val()) == false))
    {
      $('#selcolordiv').removeClass('has-error');
      $("#selcolor").css("visibility", "block");
      $('#othercolors').addClass('has-error');
      $("#othercolors2").html('Invalid Color name');
      $("#othercolors2").css("display", "block");
      errorcount++;
    }

    if((jQuery('#owner').val()=='0')&& ($("#registeredcar").is(":checked")))
    {
      $('#selownerdiv').addClass('has-error');
      $('#selowner').html("Please Select Owner");
      $("#selowner").css("visibility", "visible");
      $("#selowner").css("display", "block");
      errorcount++;
    }
     if(jQuery('#engineno').val()=='')
    {
        $('#errenginediv').addClass('has-error');
        $('#errengine').html("Please enter Engine No");
        $("#errengine").css("display", "block");
            errorcount++;
    }
    
    if((jQuery('#engineno').val()!='') && (jQuery('#engineno').val().length < 6 || jQuery('#engineno').val().length > 17))
    {
        $('#errenginediv').addClass('has-error');
        $('#errengine').html("Please enter valid Engine No ");
        $("#errengine").css("display", "block");
            errorcount++;   
        }
        if(jQuery('#chassisno').val()=='')
    {
        $('#errchassisdiv').addClass('has-error');
        $('#errchassis').html("Please enter Chassis No");
        $("#errchassis").css("display", "block");
            errorcount++;
    }
    if((jQuery('#chassisno').val()!='') && (jQuery('#chassisno').val().length < 6 || jQuery('#chassisno').val().length > 17))
    {
        $('#errchassisdiv').addClass('has-error');
        $('#errchassis').html("Please enter valid Chassis No ");
        $("#errchassis").css("display", "block");
            errorcount++;   
        }
//        if(tradetype=='')
//    {
//        $('#errtradediv').addClass('has-error');
//        $('#errtrade').html("Please select Tradetype");
//        $("#errtrade").css("display", "block");
//            errorcount++;
//    }
    if(errorcount >= 1)
    {
        $('html, body').animate({scrollTop: 100}, 2000);
        $('#er').html("Please rectify Errors");
        return ;
    }
    if((jQuery('#reg').val()=='' || jQuery('#reg').val()=='ex. Ex. DL 3C 1 4526')&& ($("#registeredcar").is(":checked")))
    {
       // alert('hii');
      $('#selregdiv').addClass('has-error');
      $("#selreg").css("display", "block");
      errorcount++;
    }
    if((jQuery('#reg').val()!='') && (!jQuery('#reg').val().match(regEX)))
    {
            //alert('eeeee');
        $('#selregdiv').addClass('has-error');
        $("#selreg").css("display", "block");
        $("#selreg").html("Please Enter Valid Regno.");
        errorcount++;
    }
    if((jQuery('#regcity').val()=='') && ($("#registeredcar").is(":checked")))
    {
      $('#selregcitydiv').addClass('has-error');
      $("#selregcity").css("display", "block");
      errorcount++;
    }
    if((reg_year=='') && ($("#registeredcar").is(":checked")))
    {
        $('#selregyeardiv').addClass('has-error');
        $("#selregyear").css("display", "block");
        errorcount++;
    }
    if((reg_year!='') && ($("#registeredcar").is(":checked")))
    {
        var regy = reg_year.split('-');
        var yr = $('#year').val();
        if(regy[2]<yr){
        $('#selregyeardiv').addClass('has-error');
        $("#selregyear").css("display", "block");
        errorcount++;
        }
    }
    
    /*if(reg_month>(parseInt(curmm)+1))
    {
      $("#selregmonth").html('Invalid Registrations month and Year.');
      $('#selregmonthdiv').addClass('has-error');
      $("#selregmonth").css("display", "block");
      errorcount++;
    }*/

    if((jQuery('#regcity').val()=='Other') && (jQuery('#otherregcity').val()==''))
    {
      $('#selregcitydiv').removeClass('has-error');
      $("#selregcity").css("display", "none");
      $('#otherplace').addClass('has-error');
      $("#otherplace2").css("visibility", "visible");
      errorcount++;
    }

     
    if($('#insurances').val()!='No Insurance' && $('#insdate').val()=='')
    {
   
      $('#valid_till').addClass('has-error');
      $("#selinsurancemonth").css("display", "block");
      errorcount++;
    }
    if($('#insurances').val()!='No Insurance' && $('#insurance_company').val()=='')
    {
      $('#ins_comp').addClass('has-error');
      $("#err_ins_comp").css("display", "block");
      errorcount++;
    }
    if($('#insurances').val()!='No Insurance' && $('#insurance_pol_no').val()=='')
    {
      $('#policy_no').addClass('has-error');
      $("#err_pol_no").css("display", "block");
      errorcount++;
    }

   

    if(jQuery('#pricegaadi').val()=='')
    {
      $('#selpricegaddidiv').addClass('has-error');
      $("#selpricegaddi").html('Please enter price of stock.');
      $("#selpricegaddi").css("display", "block");
      errorcount++;
    }

    if(jQuery('#realprice').val()!='' && jQuery('#realprice').val()<=10000)
    {
      $('#selpricegaddidiv').addClass('has-error');
      $("#selpricegaddi").html('Stock price should be grater than 10,000.');
      $("#selpricegaddi").css("display", "block");
      errorcount++;
    }

    if((jQuery('#dealerrealprice').val()=='' || jQuery('#dealerrealprice').val()=='0') && (jQuery("#addtodealer").is(":checked")))
    {
      $('#seldealerrealpricediv').addClass('has-error');
      $("#seldealerrealprice").css("display", "block");
      $("#seldealerrealprice").html('Dealer price should not be blank or Zero.');
      errorcount++;
    }

    if(jQuery('#realprice').val()!='' && jQuery('#orp_value').val()!='' &&  (parseInt(jQuery('#realprice').val()) > parseInt(jQuery('#orp_value').val())))
    {
      $('#selpricegaddidiv').addClass('has-error');
      $("#selpricegaddi").html('Stock Price Can\'t be more than On Road Price');
      $("#selpricegaddi").css("display", "block");
      errorcount++;
    }
    /*if(jQuery('#listingprice').val().replace(',','')=='')
    {
      $('#errlistingpricediv').addClass('has-error');
      $("#errlistingprice").html('Please enter listing price of stock.');
      $("#errlistingprice").css("display", "block");
      errorcount++;
    }
     if(jQuery('#listingprice').val().replace(',','')!='' && jQuery('#listingprice').val().replace(',','')<=10000)
    {
      $('#errlistingpricediv').addClass('has-error');
      $("#errlistingprice").html('Listing price should be grater than 10,000.');
      $("#errlistingprice").css("display", "block");
      errorcount++;
    }*/
     if(($('#permit').val()=='2') && ($('#permitvalid').val()==''))
    {
      $('#err_permitvalid').addClass('has-error');
      $('#err_paidoff').html("Please select Valid Date");
      $("#err_permitvalid").css("display", "block");
      errorcount++;
    }
    if(($('#road_tx').val()=='2') && ($('#road_txvalid').val()==''))
    {
      $('#err_road_txvalid').addClass('has-error');
      $('#err_road_txvalid').html("Please select Valid Date");
      $("#err_road_txvalid").css("display", "block");
      errorcount++;
    }
    if(($('#fitness_certi').val()=='2') && ($('#fitvalid').val()==''))
    {
      $('#err_fitvalid').addClass('has-error');
      $('#err_fitvalid').html("Please select Valid Date");
      $("#err_fitvalid").css("display", "block");
      errorcount++;
    }
    if(errorcount>=1)
    {
        $('html, body').animate({scrollTop: 600}, 2000);
        $('#er').html("Please rectify Errors");
        return false;
    }
//    if(refurb=='')
//    {
//        $('#errrefurbdiv').addClass('has-error');
//        $('#errrefurb').html("Please select Refurb");
//        $("#errrefurb").css("display", "block");
//            errorcount++;
//    }
if(hypo=='')
    {
        $('#errhypodiv').addClass('has-error');
        $('#errhypo').html("Please select Hypothecation");
        $("#errhypo").css("display", "block");
            errorcount++;
    }
//alert(hypo);
    if(hypo=='1')
{
    if(bank_list=='')
    {
        $('#err_bnkdiv').addClass('has-error');
        $('#err_bnk').html("Please select Bank");
        $("#err_bnk").css("display", "block");
            errorcount++;
    }
    if(paidoff=='')
    {
        $('#err_paidoffdiv').addClass('has-error');
        $('#err_paidoff').html("Please select Paid Off");
        $("#err_paidoff").css("display", "block");
            errorcount++;
    }
    if(noc=='')
    {
        $('#err_nocdiv').addClass('has-error');
        $('#err_noc').html("Please select NOC");
        $("#err_noc").css("display", "block");
            errorcount++;
    }
 
    if(errorcount>=1)
    {
        $('html, body').animate({scrollTop: $("#gotoother").offset().top}, 2000);
        $('#er').html("Please rectify Errors");
        return false
    }


}
if(errorcount!=0)
    {
      $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
      $("#errordiv").css("display", "block");
    }
    /* check duplicate car*/
    if(jQuery('#version_id').val()!='' && jQuery('#realkm').val()!='' && jQuery('#realprice').val()!='' )
    {
       
        var edit_car_id = '<?php if ($car_id) { echo $car_id; } else { echo ''; } ?>'; 

        var version =  jQuery('#version_id').val(); 
        var km =     jQuery('#realkm').val(); 
        //var color =     jQuery('#color').val(); 
        var car_price =     jQuery('#realprice').val();
        $.ajax({
            //url: "ajax/inventory_add.php",
            url: "<?php echo base_url().'inventories/checkDuplicateEntry/'; ?>",
            type: 'post',
            dataType: 'html',
            data:{version:version,km:km,car_price:car_price,car_id:edit_car_id},
            success: function(data)
            {
             //alert(data);
                if(data==1)
                {
                }
                else{
                    $("#errordiv").html('Car Already Exists');
                    $("#errordiv").css("display", "block");
                    errorcount++;
                 }   
            }
      });
    //return false;
    }
    
    /* end check duplicate car*/
    
//alert(errorcount);
    if(errorcount==0)
    {
      $("#errordiv").css("display", "none");
      $('#imageloder').show();
      $('#buttonclikaftersubmit').hide();

//alert('ggggg');
      $('.loaderClas').attr('style','display:block;');
     //console.log($("#addinventory").serialize());return false;
      $.ajax({
            //url: "ajax/inventory_add.php",
            url: "<?php echo base_url().'inventories/inventory_add/'; ?>",
            type: 'post',
            dataType: 'html',
            data: $("#addinventory").serialize(),
            success: function(response)
            {
           // alert(response);
            var data = $.parseJSON(response);
            console.log(data);
                $('.loaderClas').attr('style','display:none;');                 
            if (data.status == 'True') {
                snakbarAlert(data.message);
                setTimeout(function () {
                    window.location.href =data.Action;
                }, 2500);

                return true;
            } else {
                snakbarAlert(data.message);
                return false;
            }
        }
      });
    }
  });  



    var faCross ='<i class="fa fa-times-circle" aria-hidden="true"></i>';
    var ASSET_PATH= '<?=HOST_ROOT_STOCK?>';
    var APP_ENV= '<?=APPLICATION_ENV?>';
    $(document).on('click', '.browse', function ()
    {
        var file = $(this).parent().parent().parent().find('.file');
        file.trigger('click');
    });
    $(document).on('change', '.file', function ()
    {
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });

    $('input[type=file]').on('change', function (event)
    {
        var ids = '#' + this.id;
        $(ids).parent().find('.image-error-message').html('');
        var files = event.target.files;
        var data = new FormData();
        $.each(files, function (key, value)
        {
            data.append('file', value);
        });

        $.ajax({
            url: "<?php echo base_url() . 'inventories/upload_inventory_docs'; ?>",
            type: 'POST',
            data: data,
            cache: false,
            enctype: 'multipart/form-data',
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend:function(){
                $('#savedetail').prop('disabled',true);
                $('#Preview').prop('disabled',true);
                $(ids+'_view').css('display','none');
                $(ids).parent('.fg-docs').find('p.doc-image-name').html('<span style="color:grey" >uploading ...</span>');
            },
            success: function (data, textStatus, jqXHR)
            {
                $('#savedetail').prop('disabled',false);
                $('#Preview').prop('disabled',false);
                
                $('#doc_error_count').val(0);
                if (data.success == 1)
                {

                   // alert(ids);
                    //if(ids=='#rc_img_file'){
                       $(ids+'_view').css('display','block');
                    //}
                    $(ids).next().val(data.url);
                    $(ids + '_src').show();
                    $(ids + '_src').attr('src', data.url+'?t='+Date.now());
                    $(ids).parent('.fg-docs').find('p.doc-image-name').text(data.image_name);
                    $(ids).parent('.fg-docs').find('.docs-image-del').html(faCross);
                    $(ids).parent().find('.hasError').val(0);
                }
                if (data.success == 0)
                {
                  //  alert('abc');
                    $(ids).next().val(data.url);
                    $(ids + '_src').show();
                    $(ids + '_src').attr('src',ASSET_PATH+'noImageUploaded.png');
                    $(ids).parent('.fg-docs').find('p.doc-image-name').text(data.image_name);
                    $(ids).parent('.fg-docs').find('.docs-image-del').html('');
                    
                    $(ids).parent().find('.hasError').val(1);
                    $(ids).parent().find('.image-error-message').css('color', '#a94442');
                    $(ids).parent().find('.image-error-message').html('<span>'+data.message+' <i class="fa fa-times-circle upload-errors" aria-hidden="true"></i>');
                }
                //alert('dddddd');
                return false;

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
            }
        });
    });


    /*$('#carousel_editImg').carousel({
        pause: true,
        interval: false
    });
    */
    
    $('.docs-image-del').click(function(e){
    
       if(confirm('Are you sure you want to delete this image?')){
           $(this).siblings('p').html('');
           $(this).html('');
           var hiddenInputImgName=$(this).parents('.fg-docs').children('input.hidden-img-name');
           var imageFileInput=$(this).parents('.fg-docs').children('input[type=file]');
           var uploadImageInput=$(this).parents('.fg-docs').find('input.cs_form');
           var errorLabel=$(this).parents('.fg-docs').find('label.image-error-message');
           var modal_img_src= imageFileInput.attr('id')+'_src';
           
           $('#'+modal_img_src).attr('src',ASSET_PATH+'noImageUploaded.png');
           $('#'+$(this).attr('data-view')).css('display','none');
           errorLabel.html('');
           imageFileInput.val('');
           hiddenInputImgName.val('');
           uploadImageInput.val('');
           imageFileInput.attr('id');
       }
    });
    
    $('.image-error-message').click(function(){
       $(this).html('');
       $(this).parents('.fg-docs').find('input.cs_form').val('');
       $(this).siblings('input[type=file]').val('');
       $(this).parents('.fg-docs').children('input.hidden-img-name').val('');
       $(this).parent().find('.hasError').val(0);
       
    });
    
    $(document).ready(function(){
        $('#pricegaadi').trigger('onkeyup');
        $('#min_selling_price').trigger('onkeyup');
        var ca = $('#carid').val();
        if(ca==0){
        $('#registeredcar').attr('checked','checked');
        $('#regshow').attr('style','display:block;');
    }
       if($('.carousel-inner .item img').attr('src') == '') { 
          $('.carousel-control').css('display', 'none');
        }
    });
    if(APP_ENV!=='local'){
        $(document).keydown(function(e){
            if(e.which === 123){
         
               e.preventDefault();
               return false;
         
            }
         
        });
        $(document).bind("contextmenu",function(e) { 
          e.preventDefault();
         
        });
    }
    <?php if($checkmsg=='1'){ ?>
       // alert('hhhhhh');
        $('#isclassified').attr('checked', true);
        <?php } else{ ?> 
           // alert('dddd');
            $('#isclassified').removeAttr('checked');
            <?php } ?>


           // alert($('#stock-upload').hasClass('dz-started'));

  </script>
  <script>
    function test(sel)
    {
      var rto = sel.value;
      if(rto>0){
      $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getRtoState/",
            data:{rto:rto},
            dataType: "json",
            success: function(response) 
            {
                
                rtogetcity(rto);
                $('#rto_state').val(response.rto_state);
                $("#rtostate_id").val(response.rto_state_id);
                $("#central_city_id").val(response.central_city_id);
            }
            });
        }
    }
    function rtogetcity(rtos)
    {
          var rto_state_id =  $("#rtostate_id").val();
          var central_city_id = $("#central_city_id").val();
          if(rtos>0){
          $.ajax({
                type: 'POST',
                url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getRtoState/",
                data:{cntcity:rtos,state_id:rto_state_id},
                dataType: "json",
                success: function(response) 
                {
                     var data = response.city_list; 
                     var makeHtml = ''; 
                     makeHtml += '<option class="jCity" value="">Select City</option>'; 
                     $.each(data, function (i, item) {
                            if(item.central_city_id == central_city_id){
                             makeHtml += '<option id="cnt_'+item.central_city_id+'" class="jMake" selected value="' + item.city_id + '">' + item.city_name +'</option>';     
                            }else{
                            makeHtml += '<option id="cnt_'+item.central_city_id+'" class="jMake" value="' + item.city_id + '">' + item.city_name +'</option>'; 
                        }
    });
                        $('#regcity').html(makeHtml);
                     //   if(makeHtml)
                        $('#regcity')[0].sumo.reload();
                       // $("#regcity option#cnt_"+central_city_id).prop('selected', true);
                        
                    
                }
                });
            }

    }
    function centralStockExists(sel)
    {
      var engin_no =$('#engineno').val();
      var chassis_no =$('#chassisno').val();
      
        if(engin_no!='' && chassis_no!=''){
            
         $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "centralStockExists",
            data:{engin_no,chassis_no},
            dataType: "json",
            success: function(response) 
            {
                if(response.exist==='yes'){
                    location.href=location.href+'/?eng_no='+response.engine_no+'&chs_no='+response.chassis_no;
                }
            }
            });
        }
        
    }
    $('#chassisno').blur(function(){
          centralStockExists();
    });
    $('#engineno').blur(function(){
        //alert('gii');
       centralStockExists();
    });
   
    function selectRto(v)
    {
        $('#rto').val('');
        $('#rto_state').val('');
        
        var regg = v.value.replace(/ /g, '');
        if(regg.length<=4)
        {
           var regno = regg;
        }
        else
        {
             var regno = regg.substring(0, 4);
        }
        $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getRtoState/",
            data:{regno:regno},
            dataType: "html",
            success: function(response) 
            {
                //$('#rto_state').val(response.rto_state);
                //$('[name=rto]').val(response.rto);
                $('#rto').html(response);
                $('#rto').trigger('change');
                $('#regcity').val('');
                $('#regcity')[0].sumo.reload();
            }
            });
    }
     $('#insdate').datepicker({
                                format: 'dd-mm-yyyy',
                                startDate: 'd',
                                endDate:'+1y',
                                autoclose: true,
                                todayHighlight: true   
                             });


     /* $('#engineno').keyup(function() {
        var engno = $('#engineno').val();
       // alert(mob);
            //alert("<?php echo base_url(); ?>" + "Finance/getCustomerDetails/");
            if(engno.length==12)
        {
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/prefillcar/",
            data:{engno:engno},
            dataType: "json",
            success: function(response) 
            {
                //alert(response);
                if(response)
                {
                    $('#chassisno').val(response[0].chassis_no);
                    $('#month').val(response[0].mm);
                    $('#year').val(response[0].myear);
                    $('#make').val(response[0].make_id);
                    $('#model').val(response[0].model_id);
                    $('#version').val(response[0].version_id);
                }
                else
                {
                    $('#chassisno').val('');
                    $('#month').val('');
                    $('#year').val('');
                    $('#make').val('');
                    $('#model').val('');
                    $('#version').val('');
                }
            }   
            });
        }
        
    });
      $('#chassisno').keyup(function() {
        var chasno = $('#chassisno').val();
        if(chasno.length==12)
        {
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/prefillcar/",
            data:{chasno:chasno},
            dataType: "json",
            success: function(response) 
            {
              //  var response = responsed[0];
                //alert(response);
                if(response)
                {
                   // alert('hi');
                    $('#engineno').val(response[0].engine_no);
                    $('#month').val(response[0].mm);
                    $('#year').val(response[0].myear);
                    $('#make').val(response[0].make_id);
                    $('#model').val(response[0].model_id);
                    $('#version').val(response[0].version_id);
                }
                else
                {
                   // alert('ffff');
                    $('#engineno').val('');
                    $('#month').val('');
                    $('#year').val('');
                    $('#make').val('');
                    $('#model').val('');
                    $('#version').val('');
                   // $('#Cname').val('');
                   // $('#CEmail').val('');
                }
            }   
            });
        }
    });*/
    
    setTimeout(function(){
        var is_registered_car= $('#registeredcar').prop('checked');
       
       if(is_registered_car){
           $('#owner').prop('disabled',false);
       }
       else{
           $('#owner').prop('disabled',true);
       }
    },1000);
    
    
    function copyRegNo(){
        
       setTimeout(function(){
        window.open("https://vahan.nic.in/nrservices/faces/user/searchstatus.xhtml", "_blank");
    },100);
    }
    
    function challanStatus(){
       setTimeout(function(){
        window.open(" https://echallan.parivahan.gov.in/index/accused-challan", "_blank");
    },100);
    }
    
    function addwebsiteLink(e,id){
      $('#' + id).append('<div class="appendlink"><div class="col-sm-5"><div class="form-group"><label class="crm-label">Website </label><select class="form-control" id="website" name="website[]"><option value="OLX">OLX</option><option value="Droom">Droom</option><option value="Cartrade">Cartrade</option></select></div></div><div class="col-sm-5"><div class="form-group" id="errenginediv"><label class="crm-label">Link </label><input type="text" autocomplete="off" name="link[]" id="engineno" placeholder="Link" class="form-control upperCaseLoan" value=""></div></div><div class="col-sm-2"><a href="javascript:void(0);" class="linkminuss minuss"></a></div></div></div>');
        setTimeout(function(){ 
        }, 10);  
    }
    
     $('#reg_year').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
    
    
    
    function saveGrossAmt(flag = "")
    {
        var commission = 0; var purchase_amount = 0;var insurance  = 0;var rent = 0; var refurb_cost = 0; var misc_exp = 0;        
        purchase_amount = $('#purchase_amount').val().replace(/,/g,'');
        if($('#commission').val() != "")
           commission = $('#commission').val().replace(/,/g,'');
       if($('#insurance').val() != "")
           insurance = $('#insurance').val().replace(/,/g,'');
       if($('#rent').val() != "")
           rent = $('#rent').val().replace(/,/g,'');
       if($('#refurb_cost').val() != "")
           refurb_cost = $('#refurb_cost').val().replace(/,/g,'');
       if($('#misc_exp').val() != "")
           misc_exp = $('#misc_exp').val().replace(/,/g,'');
        var sum = 0;
        var price = [];
        var name = [];
        var inps = document.getElementsByName('discountprice1[]');
          for (var i = 0; i <inps.length; i++) {
          var inp=inps[i];    
          var str = 0;
          if(inp.value){
           str =  inp.value;
              str =  str.replace(',','');
              if(str != "")
                 price.push(str);
              sum = parseInt(sum) + parseInt(str);
          }
          }
          var inns = document.getElementsByName('discountname1[]');
          for (var i = 0; i <inns.length; i++) {
          var inn=inns[i];
            name.push(inn.value);
          }
        var gross = parseInt(purchase_amount)+parseInt(commission)+parseInt(insurance)+parseInt(rent)+parseInt(refurb_cost)+parseInt(misc_exp)+parseInt(sum);
        $('#grs_amt').val(gross);        
        $('#grs_amt').trigger('onkeyup');
        if(flag == 1){
 setTimeout(function(){
        var grs_amts = $('#grs_amt').val();
        var commissions = $('#commission').val();
        var insurances = $('#insurance').val();
        var rents = $('#rent').val();
        var refurb_costs = $('#refurb_cost').val();
        var misc_costs = $('#misc_exp').val();
        var disn1s = name;
        var disp1s = price;
        var p_amt = $("#purchase_amount").val();

        $('#disp_in').val(disp1s);
        $('#disn_in').val(disn1s);
        $('#min_selling_price').val(grs_amts);
        $('#commission_add').val(commissions);
        $('#insurance_add').val(insurances);
        $('#rent_add').val(rents);
        $('#refurb_cost_add').val(refurb_costs);
        $("#misc_exp_add").val(misc_costs);
        $('#min_selling_price').trigger('onkeyup');
        $("#purchase_rate").val(p_amt);
        setTimeout(function(){ $('.close').trigger('click'); }, 500);
        }, 500);
    }  
    }
   
    
</script>
