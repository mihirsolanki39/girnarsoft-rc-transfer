
<script src="<?= base_url('assets/js/inventories.js'); ?>"></script> 

<style>
    .cs_form{height: 40px;}
    .validtill {width: 73px;padding-right: 0;margin-top: 7px;}
</style>
 
  
<script> 
    var start_time =<?= strtotime(date('Y-m-d h:i:s')); ?>; 
    var timeInMs = Math.round(Date.now()/1000); 
    $(document).ready(function () { 
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

        /*$("#areacover").autoSuggest("<?php echo base_url() . 'inventories/zones_inventory'; ?>", { 
            startText: "Enter Location Here", 
            selectedValuesProp: "value", 
            selectedItemProp: "name", 
            searchObjProps: "name", 
            asHtmlID: "cid", 
            extraParams: "&cityid=<?php echo $city; ?>", 
            preFill: selectedData.items, 
            minChars: 1, matchCase: false 
        }); */

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
                      
                      if (responseData.data.OnRoadprice>0) { 
                         //alert(responseData.data.OnRoadprice);
                         // var integerValue = parseInt(responseData.data.OnRoadprice) 
                         // var num2words = new NumberToWords(); 
                         // num2words.setMode("indian"); 
                         // var indian = num2words.numberToWords(integerValue); 
                         // INR = indianCurrencyFormat(integerValue); 
                         
                          $("#orp_value").val(responseData.data.OnRoadprice);
                          $("#onRoadPrice").html('<b>On Road Price</b>:&nbsp;&nbsp;&nbsp; <i class="fa fa-inr" data-unicode="f156"></i> ' + responseData.data.OnRoadprice + '&nbsp;&nbsp;&nbsp;(' + responseData.data.OnRoadprice + ')'); 
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

        $('#year').change(function () { 
           // alert('hi');
            $('#petrolcngfitment').html(''); 
            yearVal = this.value; 
            if (yearVal == '') { 
                 htmlMake ='<option class="jMake" value="">Select</option>'; 
                $('#make').html(htmlMake); 
                htmlModel ='<option class="jmodel" value="">Model</option>'; 
                 $('#model').html(htmlModel); 
                htmlVersion = '<option class="jversion" value="">Variant</option>'; 
                $('#version').html(htmlVersion); 
                return false; 
            } else { 
                $('#selectyeardiv').removeClass('has-error'); 
                $("#selyear").css("display", "none"); 
                $.ajax({ 
                    type: "POST", 
                    url: "<?php echo base_url() . 'inventories/getmakemodelversionlist'; ?>?" + $('#bluk').serialize(), 
                    data: {type: 'make', year: yearVal}, 
                    dataType: "html", 
                    success: function (responseData, status, XMLHttpRequest) { 
                        data = $.parseJSON(responseData); 
                        var makeHtml = ''; 
                        makeHtml += '<option class="jMake" value="">Select</option>'; 
                        $.each(data, function (i, item) { 
                            makeHtml += '<option class="jMake" value="' + item.make + '">' + item.make + '</option>'; 
                        }); 
                        $('#make').html(makeHtml); 
                        htmlModel = '<option class="jmodel" value="">Model</option>'; 
                        $('#model').html(htmlModel); 
                        htmlVersion = '<option class="jversion" value="">Variant</option>'; 
                        $('#version').html(htmlVersion); 

                    } 
                }); 
            } 
        }); 

        $('#make').change(function () { 
            $('#petrolcngfitment').html(''); 
            //$('#fuel').attr('value',''); 
            //$('#tranmission').attr('value',''); 

            makeVal = this.value; 
            year = $("#year").val(); 
            if (year == '') { 
                alert("Please select year first"); 
                return false; 
            } 
            $('#selmakediv').removeClass('has-error'); 
            $("#selmake").css("display", "none"); 
            htmlModel = '<option class="jmodel" value="">Model</option>'; 
            $('#model').html(htmlModel); 
            htmlVersion = '<option class="jversion" value="">Variant</option>'; 
            $('#version').html(htmlVersion); 
            $.ajax({ 
                type: "POST", 
                url: "<?php echo base_url() . 'inventories/getmakemodelversionlist'; ?>?" + $('#bluk').serialize(), 
                data: {make: makeVal, type: 'model', year: year}, 
                dataType: "html", 
                success: function (responseData, status, XMLHttpRequest) { 
                    //$("#modeldiv_img").hide(); 
                    data = $.parseJSON(responseData); 
                    var modelHtml = ''; 
                    modelHtml += '<option class="jmodel" value="">Model</option>'; 
                    $.each(data, function (i, item) { 
                        modelHtml += '<option class="jmodel_' + item.id + '" value="' + item.model + '">' + item.model + '</option>'; 
                    }); 
                    make_id = data[0].make_id; 
                    $("#mk_id").val(make_id); 
                    $('#model').html(modelHtml); 
                } 
            }) 
        }); 

        $('#model').change(function () { 
            $('#petrolcngfitment').html(''); 
            //$('#fuel').attr('value',''); 
            //$('#tranmission').attr('value',''); 
         
            year = $("#year").val(); 
            mTempVal = this.value; 
            if (mTempVal == '') { 
                html = '<option class="jversion" value="">Variant</option>'; 
                $('#version').html(html); 
                return false; 
            } 
            $('#selmodeldiv').removeClass('has-error'); 
            $("#selmodel").css("display", "none"); 
            //$('.modelerror').text(''); 
            modelVal = $("option:selected", this).attr("class"); 
            modelVal = modelVal.split("_"); 
            modelVal = modelVal[1]; 
            mkId = $("#mk_id").val(); 
            makeText = $("#make").val(); 
            //$("#versiondiv_img").show(); 
            $.ajax({ 
                type: "POST", 
                url: "<?php echo base_url() . 'inventories/getmakemodelversionlist'; ?>?" + $('#bluk').serialize(), 
                data: {model_id: modelVal, mk_id: mkId, type: 'version', year: year, make: makeText}, 
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

                    $("#model_id").val(modelVal);

                    
                } 
            }) 
        }); 

        $('#version').change(function () { 
            $('#petrolcngfitment').html(''); 
            var make = $('#make').val(); 
            var model = $('#model').val(); 
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
                data: {make: make, model: model, type: 'PrefillData', version: version, car_id:edit_car_id}, 
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
                        } else 
                        { 
                            $('#petrolcngfitment').html(''); 
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
            }) 
        }) 
    function chagcolor()
    {
        $('#color').val('0'); 
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
            } else 
            { 
                $('#petrolcngfitment').html(''); 
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
                //$('#aCoverDiv').html('<img src="<?php echo ASSET_PATH?>images/loader.gif">'); 
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
<?php 
    $tooltipclass="mrg-T20";  
?>

<div class="container-fluid" id="maincontainer" > 
  <h1 class="page-title "><?php if ($car_id) { echo "Edit"; } else { echo 'Add'; } ?> Inventory</h1>    
  <div class="white-section1" style="margin:20px">
  <fieldset class="fieldset pad-B0"> 
      <legend class="text-warning pad-T0 mrg-B10"><strong>Upload Photos</strong></legend> 
  </fieldset> 
  <div class="row form-group"> 
    <div class="col-sm-2 text-right"> 
      <img href="javascript:void(0)" src="<?= base_url('assets/images/main-car-photo.png'); ?>" class="main-img"  id="notdrag" onmousedown="return false" draggable="false"> 
    </div> 
    <div class="col-sm-6 iframe-div"> 
        <?php
          if($car_id) { 
            $upload_action = 'inventories/upload_new_image/'.$car_id;    
          } else {
            $upload_action = 'inventories/upload_new_image/';
          }
        
        ?>
        <form action="<?php echo base_url().$upload_action; ?>" class="dropzone dz-clickable clearfix dropzone-E ab_browse" id="stock-upload">
          <?php
          //print_r($showroom->images);
          foreach ($imageMapArray as $images)
          {
              if ($images['id'] != '')
              {
              ?>
              <div id="dz-div-<?= $images['id'] ?>" class="dz-preview dz-file-preview">
                  <div class="dz-details">
                      <div class="dz-filename"><span data-dz-name></span></div>
                      <div class="dz-size" data-dz-size></div>
                      <img data-dz-thumbnail src="<?= $images['image_url'] ?>"/>
                  </div>
                  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                  <div class="dz-success-mark"><span>✔</span></div>
                  <div class="dz-error-mark"><span>✘</span></div>
                  <div class="dz-error-message">
                      <span data-dz-errormessage></span>
                  </div>
                  <a class="dz-remove" href="javascript:removeStckImg('<?= $images['image_name'] ?>',<?= $images['id'] ?>);" data-dz-remove="">Remove</a>
              </div>
              <?php
              }
          }
          ?>
          <div id="file" <?php if(count($imageMapArray) > 0) { ?> style="display:none" <?php } ?> class="dz-default dz-message"><span>Drop files here to upload</span></div>
        </form>
    </div> 

    <div class="col-sm-3"> 

      <div id="" class="bg-usfulltips"> 
        <h4><img src="<?= base_url('assets/images/shape.png'); ?>"> Some Useful Tips</h4> 
        <ul> 
          <li>Upload minimum 15 high quality images. Size of images should be between 25kb and 8MB</li> 
          <li>First image should be front right side angle view of car</li> 
          <li>Exterior images should be from 8 - 12ft away No bright-light background</li> 
        </ul> 
        <div class="text-center">
          <a href="#"  id="open_suggestions" data-target="#model-suggestions" data-toggle="modal"><button class="btn btn-primary bottom-btn2 mrg-T10 " type="button">VIEW SUGGESTIONS</button></a>
        </div> 
      </div> 
    </div> 
  </div> 
  <!-- See Suggestions --> 
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-suggestions"> 
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content"> 
            <div class="modal-header bg-gray"> 
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
                <h4 class="modal-title">Photo Suggestions</h4> 
            </div> 
            <div class="modal-body suggest-model"> 
                <div class="row"> 
                    <div class="col-sm-12"> 
                        <h4>Exterior</h4> 
                        <p>Give buyers a virual walk around your car. Be sure to take the photos in good lighing, and avoid having objects in the background that could cause distraction.</p> 
                    </div> 
                    <div class="col-sm-12"> 
                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/front-view.png'); ?>">                 
                            </div> 
                            <div class="font-12 height30">Front View</div> 
                        </div> 
                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Front-Right-Angle-View.png'); ?>">                 
                            </div> 
                            <div class="font-12 height30">Front Right Angle View</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Right-Side-View.png'); ?>">             
                            </div> 
                            <div class="font-12 height30">Right Side View</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Rear-View.png'); ?>">             
                            </div> 
                            <div class="font-12 height30">Rear View</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Left-Side-View.png'); ?>">                 
                            </div> 
                            <div class="font-12 height30">Left Side View</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Front-Left-Angle-View.png'); ?>">             
                            </div> 
                            <div class="font-12 height30">Front Left Angle View</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Engine-Compartment.png'); ?>">         
                            </div> 
                            <div class="font-12 height30">Engine Compartment</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Tyres.png'); ?>">     
                            </div> 
                            <div class="font-12 height30">Tyres</div> 
                        </div> 

                    </div> 

                    <div class="col-sm-12 clearfix"> 
                        <h4>Interior</h4> 
                        <p>Think what a buyer would see if he is sitting in the car. Good lighting and unique angle are a plus.</p> 
                    </div> 
                    <div class="col-sm-12 clearfix"> 
                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Steering.png'); ?>">     
                            </div> 
                            <div class="font-12 height30">Steering </div> 
                        </div> 
                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Odometer-Reading.png'); ?>">     
                            </div> 
                            <div class="font-12 height30">Odometer Reading</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/ABC-Pedals.png'); ?>">     
                            </div> 
                            <div class="font-12 height30">ABC Pedals</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Rear-Seats.png'); ?>">     
                            </div> 
                            <div class="font-12 height30">Rear Seats</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Gear-Shift-Lever.png'); ?>">     
                            </div> 
                            <div class="font-12 height30">Gear Shift Lever</div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Dashboard.png'); ?>">     
                            </div> 
                            <div class="font-12 height30">Dashboard </div> 
                        </div> 

                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?=base_url("/images/cars angles/Driver's-Seat.png"); ?>">         
                            </div> 
                            <div class="font-12 height30">Driver's Seat</div> 
                        </div> 



                    </div> 

                    <div class="col-sm-12"> 
                        <h4>Extras</h4> 
                        <p>Show off the special features of your car, including mechanical and attractive upgrades.</p> 
                    </div> 
                    <div class="col-sm-12"> 
                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Upgraded-Wheels.png'); ?>">                 
                            </div> 
                            <div class="font-12 height30">Upgraded Wheels </div> 
                        </div> 
                        <div class=" thunb-text"> 
                            <div class="thumbnail"> 
                                <img src="<?= base_url('assets/images/cars angles/Music-System.png'); ?>">                 
                            </div> 
                            <div class="font-12 height30">Music System</div> 
                        </div> 
                    </div> 

                </div> 

            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary mrg-L15"  data-dismiss="modal">Got It</button> 
            </div> 
        </div><!-- /.modal-content --> 
    </div> 
  </div> 
  <!-- Form start --> 
  <a id="gototop"></a> 
  <div align="center" id="errordiv" style="display:none;color:red;">Please Rectify The Errors In Red.</div> 

  <form method="post" id="addinventory" name="addinventory"> 
    <input type='hidden' name='hiddenclickval' id='hiddenclickval'> 
    <input type='hidden' name='previous_pricefrom' id='previous_pricefrom' value=""> 
    <input type='hidden' name='previous_dealer_price' id='previous_dealer_price' value=""> 
    <input type='hidden' name='body_style' id='body_style' value=""> 
    <input type="hidden" name="sell_enq_id" value="" /> 
    <input type='hidden' name='hiddenuploadimagefolder' id='hiddenuploadimagefolder' value=''> 
    <input type='hidden'   name="token" id="token" value="" /> 
    <input type='hidden' name='carid' id='carid' value="<?php if ($car_id) { echo $car_id; } else { echo '0'; } ?>"> 

    <!--  Car Details --> 
    <fieldset class="fieldset"> 
      <legend class="text-warning"><strong>Car Details</strong></legend> 
      <div class=" clearfix "> 
          <div class="col-sm-2 text-right"> 
              <?php 
              $carMonth = $carDeatil['make_month']; 
           
              if ($carMonth[0] == 0 && $carMonth <= 10) 
              { 
                  $carDeatil['make_month'] = $carMonth[1]; 
              } 
              ?> 
              <label><strong>Make Month and Year*</strong></label> 
          </div> 
          <div class="col-sm-8"> 
              <div class="row "> 
                  <div class="col-sm-4"> 
                      <div class="row"> 
                          <div class="col-sm-6 form-group" id="selmonthdiv"> 
                              <select name="month" id="month" class="form-control" <?php echo (($car_id > 0) ? 'disabled="disabled"' : '') ?>> 
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
                           
                              <label class="control-label" id="selmonth" style="display:none;">Please Select Month</label> 
                          </div> 
                          <div class="col-sm-6 form-group" id="selectyeardiv"> 
                              <select name="year" id="year" class="form-control" <?php echo (($car_id > 0) ? 'disabled="disabled"' : '') ?>> 
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
                  </div> 
              </div> 
          </div> 
      </div> 

      <div class="clearfix form-group"> 
          <div class="col-sm-2 text-right"> 
              <label><strong>Select Make/Model</strong></label> 
          </div> 
          
          <div class="col-sm-8"> 
              <div class="row  "> 
                  <div class="col-sm-4 form-group" id="selmakediv"> 
                      <label>Make* </label>  

                      <select name="make" id="make" class="form-control" <?php if(!empty($carDeatil['make'])) {echo 'disabled=disabled';}?> > 
                          <option value="" class="jMake">Select</option> 
                          <?php foreach($makeListArr as $key => $makeArray){ ?>
                            <option class="jMake" value="<?php echo $makeArray['make'] ?>" <?php if($carDeatil['make'] == $makeArray['make']) { ?>selected="selected"<?php } ?> ><?php echo $makeArray['make'] ?></option>
                          <?php } ?>
                      </select>   
                       
                      <input type="hidden" name="mk_id" id="mk_id" value='<?= $carDeatil['make_id'] ?>'>  
                      <label class="control-label"  id="selmake" style="display:none;">Please Select make</label> 
                  </div> 

                  <div class="col-sm-4 form-group" id="selmodeldiv"> 
                      <label>Model* </label> 
                      <select name="model" id="model" class="form-control" <?php if(!empty($carDeatil['model_id'])) {echo 'disabled=disabled';}?>> 
                          <option class="jmodel" value="">Model</option>
                          <?php foreach($modelListArr as $key => $modelArray){ ?>
                            <option class="jmodel_<?php echo $modelArray['id'] ?>" value="<?php echo $modelArray['model'] ?>" <?php if($carDeatil['model_id'] == $modelArray['id']) { ?>selected="selected"<?php } ?> ><?php echo $modelArray['model'] ?></option>
                          <?php } ?>
                      </select> 
                      
                      <input type="hidden" name="model_id" id="model_id" value='<?= $carDeatil['model_id'] ?>'>
                      <label class="control-label"  id="selmodel" style="display:none;">Please Select model</label>                              
                  </div> 

                  <div class="col-sm-4 form-group" id="selversiondiv"> 
                      <label>Version* </label> 
                      <select name="version" id="version" class="form-control"> 
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
                      <div class=" form-group" id="petrolcngfitment"> 
                     
                      </div> 
                  </div>  
              </div>                         
          </div> 
      </div>

      <div class="clearfix form-group"> 
          <div class="col-sm-2 text-right"> 
              <label><strong>Registration Details</strong></label> 
          </div> 
          <div class="col-sm-8"> 
              <div class="row  "> 
                  <div class="col-sm-12" id="selregdiv"> 
                      <div class="row"> 
                          <div class="col-sm-4"> 
                              <label>Registration No.* </label> 

                              <input  type="text" placeholder="Ex. DL 3C 1 4526" value="<?= $carDeatil['reg_no'] ?>"   name="reg" autocomplete="off" id="reg" maxlength='11' class="form-control" style="text-transform:uppercase" onkeypress="return forceAlphaNumeric(event);"   /> 
                              <label class="control-label"  id="selreg" style="display:none;">Please enter registration number.</label> 
                               
                              <div class=" form-group mrg-T10"> 
                                  <input type="checkbox" value="1" name="registeredcar" id="registeredcar" <?php echo ($carDeatil['reg_no']!='') ? 'checked="checked"': '';?> /> 
                                  <label for="registeredcar"><span></span> Registered car </label> 
                              </div> 
                          </div> 

                          <!--<div class="col-sm-8 mrg-T30 pad-B5"> 
                               
                                  <input type="checkbox" value="1" onclick="_gaq.push(['_trackEvent', 'Add Inventory', 'Show on Site Check', '<?= $event_type ?>'])" name="showsite" id="showsite" /> 

                                  <label for="showsite"><span></span>Show on Site </label> 
                                  <a href="#" id="regshowhrlp"  data-trigger="hover" data-container="body"  data-toggle="popover" data-placement="right" data-content="If you don't want to show the registration number to the customers you can keep &quot;show on site&quot; check box unchecked."> 

                                      <span class="fa fa-question-circle pad-L10 " ></span></a> 
                          </div> -->
                      </div> 
                  </div> 

                  <div class="col-sm-4 form-group" id="selregcitydiv"> 
                      <label>Registration Place* </label> 
                      <select name="regcity" id="regcity" class="form-control" > 
                          <option value="">Select</option> 
                          <option  class="regcitylist" style="color:blue;" disabled="disabled">Top Cities</option> 
                          <?php 
                          $counter = 1; 
                          foreach ($regCityList as $res) 
                          { 
                          ?> 
                              <option class="regcitylist" value="<?= $res['city_id']; ?>" <?php if($carDeatil['reg_place_city_id'] == $res['city_id']) { ?>selected="selected"<?php } ?> ><?= $res['city_name']; ?></option> 
                              <?php if ($counter == '15') 
                              { ?> 
                                  <option  class="regcitylist" disabled="disabled">--------------------------------</option> 
                                  <option  class="regcitylist" style="color:blue;" disabled="disabled">Other Cities</option> 

                                  <?php
                              } $counter++;
                          }?> 
                      </select> 
                       

                      <label class="control-label" id="selregcity" style="display:none;">Please Select registration place.</label> 
                  </div>  
 
                 <!-- <div class="col-sm-8 form-group"> 
                      <label>RTO <span class="small text-muted">(Regional Transport Office)</span></label> 
                      <input type="text" value="<?php echo $carDeatil['reg_rto_city']; ?>" class="form-control"  name="regcityrto" id="regcityrto" autocomplete="off"    maxlength="100" size="80" /> 
                  </div> -->

                  <div class="col-sm-4 form-group" id="selregmonthdiv"> 
                      <label>Registration Month* </label> 
                      <select name="reg_month" id="reg_month" class="form-control" > 
                        <option value="">Select</option> 
                        <option class="month11" value="01" <?php if(intval($carDeatil['reg_month']) == 1) { ?>selected="selected"<?php } ?> >Jan</option> 
                        <option class="month11" value="02" <?php if(intval($carDeatil['reg_month']) == 2) { ?>selected="selected"<?php } ?>>Feb</option> 
                        <option class="month11" value="03" <?php if(intval($carDeatil['reg_month']) == 3) { ?>selected="selected"<?php } ?>>Mar</option> 
                        <option class="month11" value="04" <?php if(intval($carDeatil['reg_month']) == 4) { ?>selected="selected"<?php } ?>>Apr</option> 
                        <option class="month11" value="05" <?php if(intval($carDeatil['reg_month']) == 5) { ?>selected="selected"<?php } ?>>May</option> 
                        <option class="month11" value="06" <?php if(intval($carDeatil['reg_month']) == 6) { ?>selected="selected"<?php } ?>>Jun</option> 
                        <option class="month11" value="07" <?php if(intval($carDeatil['reg_month']) == 7) { ?>selected="selected"<?php } ?>>Jul</option> 
                        <option class="month11" value="08" <?php if(intval($carDeatil['reg_month']) == 8) { ?>selected="selected"<?php } ?>>Aug</option> 
                        <option class="month11" value="09" <?php if(intval($carDeatil['reg_month']) == 9) { ?>selected="selected"<?php } ?>>Sep</option> 
                        <option class="month11" value="10" <?php if(intval($carDeatil['reg_month']) == 10) { ?>selected="selected"<?php } ?>>Oct</option> 
                        <option class="month11" value="11" <?php if(intval($carDeatil['reg_month']) == 11) { ?>selected="selected"<?php } ?>>Nov</option> 
                        <option class="month11" value="12" <?php if(intval($carDeatil['reg_month']) == 12) { ?>selected="selected"<?php } ?>>Dec</option> 
                      </select> 

                      <label class="control-label" id="selregmonth" style="display:none;">Please Select registration month.</label> 
                  </div>  
                                                   
                  <div class="col-sm-4 form-group" id="selregyeardiv"> 
                      <label>Registration Year* </label> 
                      <select name="reg_year" id="reg_year" class="form-control" > 
                          <option value="">Select</option> 
                              <?php 
                              $currentYear = date('Y'); 
                              for ($i = $currentYear; $i >= 1985; $i--) 
                              { 
                                  ?> 
                          <option class="jyear11" value="<?= $i ?>" <?php if(intval($carDeatil['reg_year']) == $i) { ?>selected="selected"<?php } ?> ><?= $i ?></option> 
                              <?php } ?> 
                      </select> 
                      <label class="control-label" id="selregyear" style="display:none;">Please Select registration year.</label> 
                  </div>  

              </div>                         
          </div> 
      </div>

      <div class="clearfix form-group"> 
          <div class="col-sm-2 text-right"> 
              <label><strong>Other Details</strong></label> 
          </div> 
           
          <div class="col-sm-8"> 
              <div class="row  "> 
                  <div class="col-sm-4 form-group" id="selkmdiv" style="height:80px;"> 
                      <label>Kilometers Driven* </label> 
                      <input type="text" autocomplete="off" name="km" value="" maxlength="12" id="km" placeholder="Kilometers" class="jNumberonly form-control" onkeyup="addCommas(this.value, 'km', 'realkm');" onkeypress="return forceNumber(event);" value="<?php echo $carDeatil['km_driven']; ?>" > 
                      <input type="hidden" name='realkm' value="<?php echo $carDeatil['km_driven']; ?>" id='realkm'> 
                      <label class="control-label" id="selkm" style="visibility: hidden;">Please enter kilometers driven.</label> 
                      <span class="km-text"></span> 
                  </div> 
                  <div class="col-sm-4 form-group" id="selcolordiv"> 
                      <label>Color* </label> 
                      <select name="color" id="color" class="form-control"> 
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
                  <div class="col-sm-4 form-group" id="selownerdiv"> 
                      <label>No. Of Owners* </label> 
                      <select name="owner" id="owner" class="form-control" > 
                          <option value="0">Select</option> 
                          <option class="owner" value="1" <?php echo $carDeatil['owner_type'] == 1 ? "selected" : ''; ?>>First</option> 
                          <option class="owner" value="2" <?php echo $carDeatil['owner_type'] == 2 ? "selected" : ''; ?>>Second</option> 
                          <option class="owner" value="3" <?php echo $carDeatil['owner_type'] == 3 ? "selected" : ''; ?>>Third</option> 
                          <option class="owner" value="4" <?php echo $carDeatil['owner_type'] == 4 ? "selected" : ''; ?>>Fourth</option> 
                          <option class="owner" value="5" <?php echo $carDeatil['owner_type'] == 5 ? "selected" : ''; ?>>More Than Four</option> 
                      </select>    
                      <label class="control-label" id="selowner" style="visibility: hidden;">Please select no. of owners.</label> 
                  </div> 
                  <div class="col-sm-4 form-group" id="othercolorsfirst" style="display: none;"> 
                  </div> 
                  <div class="col-sm-4 form-group" id="othercolors" style="display: none;"> 
                      <label>Please Enter Other Color </label> 

                      <input  type="text" autocomplete="off" id="othercolor" name="othercolor" class="form-control"  value=""> 

                      <label class="control-label" id="othercolors2" style="display: none;">Please enter other color.</label> 
                  </div> 
                  <input type="hidden" name="tranmission" id="tranmission"> 
                  <input type="hidden" name="fuel" id="fuel"> 
                  
              </div>  
          </div> 
      </div>

      <div class="clearfix form-group"> 
          <div class="col-sm-2 text-right"><label><strong>Insurance</strong></label></div> 
          <div class="col-sm-8"> 
              <div class="row  "> 
                  <div class="col-sm-12 form-group"> 
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
                  if ($insuranceTimr < $currentTimeStamp && (($carDeatil['insurance'] == 'Third Party' || $carDeatil['insurance'] == 'Comprehensive' ))) 
                  { 
                      $val = 'insurance expired on ' . $nextMonth . '-' . $carDeatil['year']; 
                  } 
                  ?> 
                  <div class="col-sm-2 form-group year-field" id="insurancemonth11" <?= (($carDeatil['insurance'] == 'Third Party' || $carDeatil['insurance'] == 'Comprehensive' ) ? 'style="display:block;"' : 'style="display:none;"') ?>><span style="padding-left:35px">Valid Till: </span> 

                  </div> 
                  <div class="col-sm-2 form-group year-field" id="insurancemonth" <?= (($carDeatil['insurance'] == 'Third Party' || $carDeatil['insurance'] == 'Comprehensive' ) ? 'style="display:block;"' : 'style="display:none;"') ?>> 
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
                  <div class="col-sm-2 form-group year-field" id="insuranceyear"  <?= (($carDeatil['insurance'] == 'Third Party' || $carDeatil['insurance'] == 'Comprehensive' ) ? 'style="display:block;"' : 'style="display:none;"') ?>> 
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
                  </div> 
              </div> 
          </div> 
      </div> 

      <div class="clearfix form-group"> 
          <div class="col-sm-2 text-right"> 
              <label><strong>Tax Details</strong></label> 
          </div> 
          <div class="col-sm-8"> 
              <span class="mrg-R20">    <input name="tax" id="taxIndividual" type="radio" value="0" <?= (($carDeatil['tax'] == 'Individual' || (!isset($carDeatil['tax']))) ? 'checked="checked"' : '') ?> > 
                  <label for="taxIndividual"><span></span>Individual</label></span> 
              <span class="mrg-R20 mrg-L20"> 
                  <input name="tax" id="taxCorporate"  type="radio" value="1" <?= (($carDeatil['tax'] == 'Corporate') ? 'checked="checked"' : '') ?> > 

                  <label for="taxCorporate"><span></span>Corporate</label></span>                           
          </div> 
      </div> 

     <div class="clearfix form-group"> 
          <div class="col-sm-2 text-right"> 
              <label><strong>Description</strong></label> 
          </div> 
          <div class="col-sm-6"> 
              <textarea name="additionaldetail" id="additionaldetail" placeholder="Additional details about car" class="form-control en-textarea"><?php if ($resultModelInfo['additional_feature']) 
              { echo $resultModelInfo['additional_feature']; } ?></textarea> 

          </div> 
      </div>
 
    </fieldset>
 
    <!--  Price Details --> 
    <fieldset class="fieldset"> 
        <legend class="text-warning"><strong>Price Details</strong></legend> 
        <div class=" clearfix "> 
            <div class="col-md-6"> 
                <div class="col-sm-4 text-right"> 
                    <label><strong>Price*</strong></label> 
                </div> 
                <div class="col-sm-8"> 
                    <div class=" form-group" id="selpricegaddidiv"> 
                        <div class="input-group"> 
                            <span class="input-group-addon"><strong class=" text-primary"><i class="fa fa-inr" data-unicode="f156"></i></strong></span> 
                             <input type="text"   autocomplete="off" name="pricegaadi" id="pricegaadi" class="pricegaadi form-control" placeholder="Price" onblur="return claculate_dealerprice(this.value)" onkeyup="addCommas(this.value, 'pricegaadi', 'realprice');" onkeypress="return forceNumber(event);" value="<?= ((($car_id > 0 && $carDeatil['car_price'] != '' && $carDeatil['car_price'] != '0') ) ? $carDeatil['car_price'] : '') ?>"> 
                            <input type='hidden' name='realprice' id='realprice' value="<?= ((($car_id > 0 && $carDeatil['car_price'] != '' && $carDeatil['car_price'] != '0')) ? $carDeatil['car_price'] : '') ?>"> 
                        </div> 
                        <label class="control-label" id="selpricegaddi" style="display:none;">Please enter retail price.</label> 
                        <span class="gaadiprice-text clearfix " style="clear:both;"></span> 
                        <span class="gaadipricecheck-text"  ></span> 

                            <span id="onRoadPrice"class="gaadirealpricecheck-text clearfix " style="color:#661800;font-size:10px"></span> 
                            <input type="hidden"  id="orp_value" value="" /> 
                    </div> 
                </div> 
                <input type="hidden" name="dealermobile" id="dealermobile" value="<?= (($d2dmobile) > 0 ? $d2dmobile : '') ?>" /> 
                <div class="clearfix form-group"> 
                    <div class="col-sm-4 text-right"> 
                        <label><strong>Special Offers</strong> <div class="small text-muted text-italic">(Other details to attract buyers):</div></label> 
                    </div> 
                    <div class="col-sm-8"> 
                        <textarea name="offer" id="offer" placeholder="Special Offers" class="form-control en-textarea"><?= (($car_id > 0 && $carDeatil['special_offer'] != '' && $carDeatil['special_offer'] != '0') ? $carDeatil['special_offer'] : '') ?></textarea> 
                    </div> 
                </div> 
            </div> 
            <div class="col-md-4" id="competitive_inventory"></div> 
        </div> 
        <?php if ($_SESSION['dealer_owner'] == 'xxxxxx') { ?> 
            <div class="clearfix "> 
                <div class="col-sm-2 text-right"> 
                    <label><strong>Dealer Mobile*</strong></label> 
                </div> 
                <div class="col-sm-6"> 
                    <div class="row"> 
                        <div class="col-sm-4" id="seldealerrealpricediv"> 
                            <label>Dealer Price</label> 
                            <input type="text" autocomplete="off" maxlength="12" name="dealerprice" id="dealerprice" class="form-control dealerprice" placeholder="Price" onkeypress="return forceNumber(event);" onkeyup="addCommasdealer(this.value,'dealerprice','dealerrealprice');"  value=""> 
                            <input type='hidden' name='dealerrealprice' id='dealerrealprice' value=""> 
                            <label class="control-label" id="seldealerrealprice" style="display:none;">Dealer price should be less than retail price.</label> 
                        </div> 
                        <div class="col-sm-5" id="seldealermobilediv"> 

                            <input type="text" maxlength="10" autocomplete="off" name="dealermobile" id="dealermobile" value="<?= (($d2dmobile) > 0 ? $d2dmobile : '') ?>" class="form-control" placeholder="Mobile" onkeypress="return forceNumber(event);"  /> 
                            <label class="control-label" id="seldealermobile" style="display:none;">Please enter dealer mobile.</label>  
                        </div> 
                        <div class="col-sm-12">  
                            <div class=" form-group"> 
                                <?php 
                                $selldealer = ''; 
                                if ($car_id > 0) 
                                { 
                                    if ($carDeatil['sell_dealer'] == '1') 
                                    { 
                                        $selldealer = 'checked="checked"'; 
                                    } 
                                } 
                                ?> 
                                   <input type="checkbox" onclick="_gaq.push(['_trackEvent','Add Inventory', 'List on dealer inventory', '<?= $event_type ?>'])"  value="1" name="addtodealer" id="addtodealer" <?= $selldealer; ?> > 
                                    <label for="addtodealer"><span></span> List on Dealer Inventory Platform</label><br> 
                                    <span class="dealerprice-text"></span> 
                            </div> 
                        </div> 
                    </div>                
                </div> 
            </div> 
        <?php } ?> 
    </fieldset>

    <!--  Upload Registration Certificate (RC) and Service History --> 
    <fieldset class="fieldset"> 
        <legend class="text-warning"  style="margin-bottom: -10px !important"  ><strong>Upload Registration Certificate (RC) and Service History</strong>  
        <i data-toggle="tooltip" title="Upload RC and Service Record to improve your car listing score on Cardekho.com " class="fa fa-info-circle" aria-hidden="true"></i></legend> 
        <i style="font-size:85%;color:#777">* Uploaded RC and Service history will be used for internal verification purpose only. It will not be shown on website or shared with anyone.</i>
<div class=" clearfix " style="margin-top: 32px" onmousedown="return false"> 
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6" >
            <div class="form-group mrg-B29">
                <label for="" class="customize-label">Upload RC Doc</label>
                <div class="form-group fg-docs">
                    <input type="file" id="rc_img_file" name="rc_img_file[]" class="file invt-docs">
                    <input type="hidden" name="rc_img_url" id="rc_img_url" class='hidden-img-name' value='<?= isset($inventory_docs['rc_img_url']) ?  $inventory_docs['rc_img_url'] : '' ?>'>

                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control customize-form cs_form" disabled placeholder="Upload Image">
                        <span class="input-group-btn">
                            <button class="browse btn btn-primary btn-B upload-doc" type="button">Browse</button>
                        </span>
                    </div>
                    <input type="hidden" value="0" class="hasError" id="hasRcError" />
                    <label class="image-error-message"></label>
                    <div><p class="doc-image-name"><?= isset($inventory_docs['rc_img_url']) ? end(explode('/', $inventory_docs['rc_img_url'])) : '' ?></p>
                    <div class="docs-image-del  delete-logo-banner" data-view="rc_img_file_view" id="rc_img-del"><?= !empty($inventory_docs['rc_img_url']) ?'<i class="fa fa-times-circle" aria-hidden="true"></i>' : '' ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group mrg-B29">
                <div class="up_image captailize" style="display:<?= !empty($inventory_docs['rc_img_url']) ?'block' : 'none' ?>" id="rc_img_file_view"><a  href="#" data-toggle="modal" data-target="#view-rc-doc">View RC Image</a></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6" >
            <div class="form-group mrg-B29">
                <label for="" class="customize-label">Upload Service History Images#1</label>
                <div class="form-group fg-docs">
                    <input type="file" id="supporting_doc_1_file" name="supporting_doc_1_file[]" class="file invt-docs" >
                    <input type="hidden" name="supporting_doc_1_url" class='hidden-img-name' id="supporting_doc_1_url" value='<?= isset($inventory_docs['supporting_doc_1_url']) ? $inventory_docs['supporting_doc_1_url']: '' ?>' >

                    <div class="input-group col-xs-12">
                       <!--<span class="input-group-addon custom-group"><i class="glyphicon glyphicon-picture font-20"></i></span>-->
                        <input type="text" class="form-control customize-form cs_form" disabled placeholder="Upload Image">
                        <span class="input-group-btn">
                            <button class="browse btn btn-primary btn-B upload-doc" type="button">Browse</button>
                        </span>
                    </div>
                    <input type="hidden" value="0" class="hasError" id="hasSH1Error" />
                    <label class="image-error-message"></label>
                    <div><p class="doc-image-name"><?= isset($inventory_docs['supporting_doc_1_url']) ? end(explode('/', $inventory_docs['supporting_doc_1_url'])) : '' ?></p>
                     <div class="docs-image-del  delete-logo-banner" data-view="supporting_doc_1_file_view"  id="supporting_doc_1"><?= !empty($inventory_docs['supporting_doc_1_url']) ?'<i class="fa fa-times-circle" aria-hidden="true"></i>' : '' ?></div>
                    </div>
                    </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group mrg-B29">
                <div class="up_image captailize"  id="supporting_doc_1_file_view" style="display:<?= !empty($inventory_docs['supporting_doc_1_url']) ?'block' : 'none' ?>" ><a href="#"   data-toggle="modal" data-target="#view-sh-doc1">View Service History Images #1</a></div>
            </div>
        </div>


    </div>
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-6" >
            <div class="form-group mrg-B29">
                <label for="" class="customize-label">Upload Service History Images#2</label>
                <div class="form-group fg-docs">
                    <input type="file" id="supporting_doc_2_file" name="supporting_doc_2_file[]" class="file invt-docs">
                    <input type="hidden" name="supporting_doc_2_url" class='hidden-img-name' id="supporting_doc_2_url" value='<?= isset($inventory_docs['supporting_doc_2_url']) ? $inventory_docs['supporting_doc_2_url']: '' ?>'>

                    <div class="input-group col-xs-12">
                       <!--<span class="input-group-addon custom-group"><i class="glyphicon glyphicon-picture font-20"></i></span>-->
                        <input type="text" class="form-control customize-form cs_form" disabled placeholder="Upload Image">
                        <span class="input-group-btn">
                            <button class="browse btn btn-primary btn-B upload-doc" type="button">Browse</button>
                        </span>
                    </div>
                    <input type="hidden" value="0" class="hasError" id="hasSH2Error" />
                    <label class="image-error-message"></label>
                    <div><p class="doc-image-name"><?= isset($inventory_docs['supporting_doc_2_url']) ? end(explode('/', $inventory_docs['supporting_doc_2_url'])) : '' ?></p>
                     <div class="docs-image-del  delete-logo-banner" data-view="supporting_doc_2_file_view"  id="supporting_doc_2"><?= !empty($inventory_docs['supporting_doc_2_url']) ?'<i class="fa fa-times-circle" aria-hidden="true"></i>' : '' ?></div>
                    </div>
                    </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group mrg-B29">
                <div class="up_image captailize" id="supporting_doc_2_file_view" style="display:<?= !empty($inventory_docs['supporting_doc_2_url']) ?'block' : 'none' ?>"  ><a href="#"   data-toggle="modal" data-target="#view-sh-doc2">View Service History Images #2</a></div>
            </div>
        </div>
    </div>
</div> 


<!-- Modal starts-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view-rc-doc">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Uploaded RC Doc Image</h4>
            </div>
            <div class="modal-body">
                <div class="up-img-preview">
                    <img src="<?= isset($inventory_docs['rc_img_url']) ? $inventory_docs['rc_img_url']:base_url('assets/images/noImageUploaded.png')   ?>"  class="img-responsive doc-files-imges" id='rc_img_file_src'>
                </div>
            </div>
        </div>
        <!-- /.modal-comment -->
    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view-sh-doc1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Uploaded Service History Images #1</h4>
            </div>
            <div class="modal-body">
                <div class="up-img-preview">
                    <img src="<?= isset($inventory_docs['supporting_doc_1_url']) ? $inventory_docs['supporting_doc_1_url']:base_url('assets/images/noImageUploaded.png')   ?>"  class="img-responsive doc-files-imges" id='supporting_doc_1_file_src'>
                </div>
            </div>
        </div>
        <!-- /.modal-comment -->
    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view-sh-doc2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Uploaded Service History Images #2</h4>
            </div>
            <div class="modal-body">
                <div class="up-img-preview">
                    <img src="<?= isset($inventory_docs['supporting_doc_2_url']) ? $inventory_docs['supporting_doc_2_url']:base_url('assets/images/noImageUploaded.png')   ?>"  class="img-responsive doc-files-imges" id='supporting_doc_2_file_src'>
                </div>
            </div>
        </div>
        <!-- /.modal-comment -->
    </div>
</div>

    </fieldset>

    <!--  Add Stock To       
    <fieldset class="fieldset"> 
        <legend class="text-warning"><strong>Add Stock To</strong></legend> 

        <div class="clearfix form-group"> 
            <div class="col-sm-2 text-right"> 
                <label><strong>Classified Platforms</strong></label> 
            </div> 
            <div class="col-sm-2"> 
                <ul class="list-unstyled list-inline stocklist"> 
                    <li><input type="checkbox" <?php echo $checkmsg ?> name="isclassified" id="isclassified" value="1"> 
                        <label for="isclassified"><span></span>  
                            <img src="<?= base_url('assets/images/gaadi-logo.png'); ?>" id="gaadilogo" <?php echo $checkmsg1 ?>> 
                            <img src="<?= base_url('assets/images/cd-logo.png'); ?>" id="cdlogo" <?php echo $checkmsg2 ?>>  
                            <?php if ($upload_inventory_zigwheels['upload_inventory_zigwheels'] > 0) 
                            { 
                                ?> 
                                <img src="<?= base_url('assets/images/zw-logo.png'); ?>" id="zwlogo" <?php echo $checkmsg3 ?>> 
                            <?php } ?> 
                        </label>    </li> 

                </ul> 
            </div> 
            <div class="col-sm-8"> 
                <style> 
                    .msg-box-new{width:500px; padding:15px; border:1px dotted #ddd;} 
                    .ic-Gaadi-cardekho-zigwheels { width: 130px; height: 18px; background-position: -72px -145px; text-indent: -9999px;} 
                </style> 
                <!--<div class="msg-box-new" id="showmsgbox" ><?php echo $msg ?></div> 


            </div> 
        </div> 
    </fieldset>-->  

    <!--  Features Of Car 
    <fieldset class="fieldset fieldset-new pad-T20 border-none"> 
        <style> 
        </style> 
        <div class="panel-group" id="accordion"> 
            <div class="panel panel-default"> 
                <div class="panel-heading"> 
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#panel1"><h4 class="panel-title text-warning" style="padding: 10px;"> 
                            Features Of Car <i class="fa fa-plus pull-right"></i> 

                        </h4> 
                    </a> 

                </div> 
                <div id="panel1" class="panel-collapse border-none collapse"> 
                    <div class="panel-body bdr-top-n"> 
                        <fieldset class="fieldset border-none"> 
                            <div class="clearfix form-group"> 
                                <div class="col-sm-2 text-right"> 
                                    <label><strong>Interiors / Exterior</strong></label> 
                                </div> 
                                <div class="col-sm-8"> 
                                    <ul class="list-unstyled row"> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox" name="mod_cupHolders" id="mod_cupHolders" <?php if ($resultModelInfo['cupHolders'] || (isset($addEditType) && ($carFeature['cup_holders'] != ''))) { echo "checked"; } ?> value="1"><label for="mod_cupHolders"><span></span> Cup Holders<sup>Front</sup></label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_foldingRearSeat" id="mod_foldingRearSeat" <?php if ($resultModelInfo['foldingRearSeat']) { echo "checked"; 
                                        } ?>  value="1" class="reg-no-label"> <label for="mod_foldingRearSeat"><span></span>  Folding Rear-Seat</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox" <?php if ($resultModelInfo['tachometer'] || (isset($addEditType) && strtolower($carFeature['tachometer']) == 'yes')) { echo "checked"; } ?> name="mod_tachometer" id="mod_tachometer" value="1" class="reg-no-label"> 
                                            <label for="mod_tachometer"> <span></span> Tachometer</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_leatherSeats" id="mod_leatherSeats" <?php if ($resultModelInfo['leatherSeats'] || (isset($addEditType) && strtolower($carFeature['leather_seats']) == 'yes')){ echo "checked"; } ?> value="1"for=""> 
                                            <label for="mod_leatherSeats"><span></span>  Leather Seats</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_tubelessTyres" id="mod_tubelessTyres" <?php if ($resultModelInfo['tubelessTyres']) 
                                        { 
                                            echo "checked"; 
                                        } ?> value="1"for=""> 
                                            <label for="mod_tubelessTyres"><span></span>  Tubeless Tyres</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_sunRoof" id="mod_sunRoof" <?php if ($resultModelInfo['sunRoof'] || (isset($addEditType) && strtolower($carFeature['sunroof']) == 'yes')) 
                                                { 
                                                    echo "checked"; 
                                                } ?> value="1"for=""> 
                                            <label for="mod_sunRoof"><span></span>  Sun-Roof</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_fogLights" id="mod_fogLights" <?php if ($resultModelInfo['fogLights'] || (isset($addEditType) && strtolower($carFeature['fog_lights']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1"for=""> 
                                            <label for="mod_fogLights"><span></span>  Fog Lights</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_washWiper" id="mod_washWiper" <?php if ($resultModelInfo['washWiper'] || (isset($addEditType) && strtolower($carFeature['rear_wiper']) == 'yes')) 
                                                { 
                                                    echo "checked"; 
                                                } ?> value="1" for=""> 
                                            <label for="mod_washWiper"><span></span>  Wash Wiper</label></li> 
                                    </ul> 
                                </div> 
                            </div> 

                            <div class="clearfix form-group"> 
                                <div class="col-sm-2 text-right"> 
                                    <label><strong>Comfort and convenience</strong></label> 
                                </div> 
                                <div class="col-sm-8"> 
                                    <ul class="list-unstyled row"> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox" name="mod_powerWindows" id="mod_powerWindows" <?php if ($resultModelInfo['powerWindows'] || (isset($addEditType) && ($carFeature['power_windows'] != ''))) 
                                            { 
                                                echo "checked"; 
                                            } ?>  value="1" class="reg-no-label"> 
                                            <label for="mod_powerWindows"><span></span> Power Windows<sup>All</sup></label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_powerSteering" id="mod_powerSteering" <?php if ($resultModelInfo['powerSteering'] || (isset($addEditType) && strtolower($carFeature['power_steering']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?>  value="1" class="reg-no-label"> 
                                            <label for="mod_powerSteering"><span></span> Power Steering</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_powerDoorLocks" id="mod_powerDoorLocks" <?php if ($resultModelInfo['powerDoorLocks'] || (isset($addEditType) && strtolower($carFeature['keyless_entry']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_powerDoorLocks"><span></span>  Power door locks</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_powerSeats" id="mod_powerSeats" <?php if ($resultModelInfo['powerSeats'] || (isset($addEditType) && strtolower($carFeature['power_seats']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_powerSeats"><span></span> Power seats</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_steeringAdjustment" id="mod_steeringAdjustment" <?php if ($resultModelInfo['steeringAdjustment'] || (isset($addEditType) && strtolower($carFeature['tilt_steering']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_steeringAdjustment"><span></span> Steering Adjustment</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_carStereo" id="mod_carStereo" <?php if ($resultModelInfo['carStereo'] || (isset($addEditType) && strtolower($carFeature['audio_system']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?>  value="1" class="reg-no-label"> 
                                        <label for="mod_carStereo"><span></span> Car Stereo</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_displayScreen" id="mod_displayScreen" <?php if ($resultModelInfo['displayScreen']) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_displayScreen"><span></span> Display Screen</label></li> 

                                    </ul> 
                                </div> 
                            </div> 

                            <div class="clearfix form-group"> 
                                <div class="col-sm-2 text-right"> 
                                    <label><strong>Safety and Security</strong></label> 
                                </div> 
                                <div class="col-sm-8"> 
                                    <ul class="list-unstyled row"> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox" name="mod_antiLockBrakingSystem" id="mod_antiLockBrakingSystem" <?php if ($resultModelInfo['antiLockBrakingSystem'] || (isset($addEditType) && strtolower($carFeature['abs']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_antiLockBrakingSystem"><span></span> Anti-Lock Braking System</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_driverAirBags" id="mod_driverAirBags" <?php if ($resultModelInfo['driverAirBags'] || (isset($addEditType) && strtolower($carFeature['airbags']) == 'driver')) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_driverAirBags"><span></span> Driver Air-Bags</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_pssengerAirBags" id="mod_pssengerAirBags" <?php if ($resultModelInfo['pssengerAirBags']) 
                                        { 
                                            echo "checked"; 
                                        } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_pssengerAirBags"><span></span>  Passenger Air-Bags</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_immobilizer" id="mod_immobilizer" <?php if ($resultModelInfo['immobilizer'] || (isset($addEditType) && strtolower($carFeature['immobilizer']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?>  value="1" class="reg-no-label"> 
                                            <label for="mod_immobilizer"><span></span>  Immobilizer</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_tractionControl" id="mod_tractionControl" <?php if ($resultModelInfo['tractionControl'] || (isset($addEditType) && strtolower($carFeature['traction_control']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?> value="1" class="reg-no-label"> 
                                            <label for="mod_tractionControl"><span></span> Traction Control</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_childSafetyLocks" id="mod_childSafetyLocks" <?php if ($resultModelInfo['childSafetyLocks'] || (isset($addEditType) && strtolower($carFeature['child_safety_lock']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?>  value="1" class="reg-no-label"> 
                                            <label for="mod_childSafetyLocks"><span></span> Child Safety Locks</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_centralLocking" id="mod_centralLocking" <?php if ($resultModelInfo['centralLocking'] || (isset($addEditType) && strtolower($carFeature['central_locking']) == 'yes')) 
                                                { 
                                                    echo "checked"; 
                                                } ?>  value="1" class="reg-no-label"> 
                                            <label for="mod_centralLocking"><span></span>  Central Locking</label></li> 
                                        <li class="col-sm-4 col-lg-3"><input type="checkbox"  name="mod_remoteBootFuelLid" id="mod_remoteBootFuelLid" <?php if ($resultModelInfo['remoteBootFuelLid'] || (isset($addEditType) && strtolower($carFeature['remote_boot_release']) == 'yes')) 
                                            { 
                                                echo "checked"; 
                                            } ?>  value="1" class="reg-no-label"> 
                                            <label for="mod_remoteBootFuelLid"><span></span> Remote Boot</label></li> 
                                    </ul> 
                                </div> 
                            </div> 
                        </fieldset> 
                    </div> 
                </div> 
            </div> 

            <!--<div class="panel panel-default"> 
                <div class="panel-heading"> 
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#panel2"><h4 class="panel-title text-warning"> 
                            Condition of Stock <i class="fa fa-plus pull-right"></i> 

                        </h4> 
                    </a> 
                </div> 
                <div id="panel2" class="panel-collapse border-none collapse"> 
                    <div class="panel-body bdr-top-n"> 
                        <fieldset class="fieldset border-none"> 
                            <div class="clearfix "> 
                                <div class="col-sm-2 text-right"> 
                                    <label><strong>Overall Condition </strong></label> 
                                </div> 
                                <div class="col-sm-8"> 
                                    <div class="row"> 
                                        <div class="col-sm-4 form-group"> 
                                            <select name="overcondition" id="overcondition" class="form-control"> 
                                                <option value="0" >Overall Condition</option> 
                                                <?php 
                                                foreach ($conditionsdata as $key => $val) 
                                                { 
                                                    $sel = ''; 
                                                    if ($condition == $val['id']) 
                                                    { 
                                                        $sel = "selected"; 
                                                    } 
                                                    ?> 
                                                    <option value="<?= $val['id'] ?>" <?= $sel ?>><?= $val['condition_name'] ?></option> 
                                                <?php } ?> 
                                            </select> 
                                        </div> 
                                    </div> 
                                    <div class="row"> 
                                        <div class="col-sm-4 form-group"> 
                                            <div class="posrelative text-left"> 
                                                <div class="multi-dropdwn form-control"> 
                                                    Exterior  <span class="extCount"><?= (((count($exteriors) > 0) && $exteriors[0] != '0') ? ' (' . count($exteriors) . ')' : '') ?></span><span class="pull-right caret"></span> 
                                                </div> 

                                                <ul class="dropdown-menu" role="menu"> 
                                                    <?php foreach ($exterior as $key => $val) 
                                                    { ?> 
                                                        <li class="pad-L5"><input type="checkbox" class="ext" name="exterior[]" id="Exterior<?= $val['id'] ?>" value="<?= $val['id'] ?>" <?php if (in_array($val['id'], $exteriors)) 
                                                        { 
                                                        echo 'checked="checked"'; 
                                                        } ?> ><label for="Exterior<?= $val['id'] ?>"><span></span> <?= $val['exterior_name'] ?></label></li>  
                                                    <?php } ?> 
                                                </ul> 
                                            </div> 
                                        </div> 

                                        <div class="col-sm-4 form-group"> 
                                            <div class="posrelative text-left"> 
                                                <div class="multi-dropdwn form-control"> 
                                                    Body and Frame <span class="bodCount"><?= (((count($bodyTypes) > 0) && $bodyTypes[0] != '0') ? ' (' . count($bodyTypes) . ')' : '') ?></span><span class="pull-right caret"></span> 
                                                </div> 
                                                <ul class="dropdown-menu" role="menu">  
                                                <?php foreach ($bodyframe as $key => $val) 
                                                { ?> 
                                                        <li class="pad-L5"><input type="checkbox" class="bod" name="bodyframe[]" id="bodyframe<?= $val['id'] ?>" value="<?= $val['id'] ?>" <?php if (in_array($val['id'], $bodyTypes)) 
                                                { 
                                                echo 'checked="checked"'; 
                                                } ?> ><label for="bodyframe<?= $val['id'] ?>"><span></span><?= $val['bodyframe_name'] ?></label></li> 

                                                <?php } ?> 

                                                </ul> 
                                            </div> 
                                        </div> 

                                        <div class="col-sm-4 form-group"> 
                                            <div class="posrelative text-left"> 
                                                <div class="multi-dropdwn form-control"> 
                                                    Engine/Transmission/Clutch <span class="enCount"><?= (((count($etcs) > 0) && $etcs[0] != '0') ? ' (' . count($etcs) . ')' : '') ?></span><span class="pull-right caret"></span> 
                                                </div> 
                                                <ul class="dropdown-menu" role="menu">
                                                    <?php foreach ($etc as $key => $val) 
                                                    { ?> 
                                                            <li class="pad-L5"><input class="en" type="checkbox" id="Engine<?= $val['id'] ?>" <?php if (in_array($val['id'], $etcs)) 
                                                    { 
                                                    echo 'checked="checked"'; 
                                                    } ?>  name="etc[]" value="<?= $val['id'] ?>"><label for="Engine<?= $val['id'] ?>"><span></span> <?= $val['etc_name'] ?></label></li> 
                                                    <?php } ?> 
                                                </ul> 
                                            </div> 
                                        </div> 

                                        <div class="col-sm-4 form-group"> 
                                            <div class="posrelative text-left"> 
                                                <div class="multi-dropdwn form-control"> 
                                                Suspension/Steering  <span class="suCount"><?= (((count($susstes) > 0) && $susstes[0] != '0') ? ' (' . count($susstes) . ')' : '') ?><span class="pull-right caret"></span> 
                                                </div> 
                                                <ul class="dropdown-menu" role="menu">
                                                    <?php foreach ($usedcar_susste as $key => $val) 
                                                    { ?> 
                                                        <li class="pad-L5">
                                                            <input type="checkbox" class="su"  id="Suspension<?= $val['id'] ?>"  name="susste[]" value="<?= $val['id'] ?>"  <?php if (in_array($val['id'], $susstes)) { echo 'checked="checked"'; } ?>>
                                                            <label for="Suspension<?= $val['id'] ?>">
                                                                <span></span> <?= $val['susste_name'] ?>
                                                            </label>
                                                        </li> 
                                                    <?php } ?> 
                                                </ul> 
                                            </div> 
                                        </div> 

                                        <div class="col-sm-4 form-group"> 
                                            <div class="posrelative text-left"> 
                                                <div class="multi-dropdwn form-control"> 
                                                    Tires  <span class="tiCount"><?= (((count($tires) > 0) && $tires[0] != '0') ? ' (' . count($tires) . ')' : '') ?></span><span class="pull-right caret"></span> 
                                                </div> 
                                                <ul class="dropdown-menu" role="menu">   
                                                    <?php foreach ($usedcar_tires as $key => $val) 
                                                    { ?> 
                                                        <li class="pad-L5"><input type="checkbox" class="ti"  id="tires<?= $val['id'] ?>"  name="tires[]" value="<?= $val['id'] ?>" <?php if (in_array($val['id'], $tires)) 
                                                    { 
                                                    echo 'checked="checked"'; 
                                                    } ?>><label for="tires<?= $val['id'] ?>"><span></span> <?= $val['tires_name'] ?></label></li> 
                                                    <?php } ?>     
                                                </ul> 
                                            </div> 
                                        </div> 

                                        <div class="col-sm-4 form-group"> 
                                            <select name="ee" id="ee" class="form-control"> 
                                                <option value="0" >Electrical & Electronics</option> 
                                                    <?php 
                                                    foreach ($usedcar_electrical as $key => $val) 
                                                    { 
                                                    $sel = ''; 
                                                    if ($usedcar_electricals == $val['id']) 
                                                    { 
                                                    $sel = "selected"; 
                                                    } 
                                                    ?> 
                                                    <option value="<?= $val['id'] ?>" <?= $sel ?>><?= $val['electrical_name'] ?></option> 
                                                    <?php } ?> 
                                            </select>         
                                        </div> 


                                        <div class="col-sm-4 form-group"> 
                                            <select  name="heater" class="het form-control" id="heater"  > 
                                                <option value="0" >AC/Heater</option> 
                                                <?php 
                                                foreach ($usedcar_acheater as $key => $val) 
                                                { 
                                                $sel = ''; 
                                                if ($heatershow == $val['id']) 
                                                { 
                                                $sel = "selected"; 
                                                } 
                                                ?> 
                                                    <option value="<?= $val['id'] ?>" <?= $sel ?>><?= $val['acheater_name'] ?></option> 
                                                <?php } ?> 
                                            </select>                                    
                                        </div> 


                                        <div class="col-sm-4 form-group">                        
                                            <select name="battery" id="ba" class="form-control ba"> 
                                                <option value="0" >Battery</option> 
                                                    <?php 
                                                    foreach ($usedcar_battery as $key => $val) 
                                                    { 
                                                    $sel = ''; 
                                                    if ($batteris == $val['id']) 
                                                    { 
                                                    $sel = "selected"; 
                                                    } 
                                                    ?> 
                                                    <option value="<?= $val['id'] ?>" <?= $sel ?>><?= $val['battery_name'] ?></option> 
                                                    <?php } ?> 
                                            </select> 
                                        </div> 

                                        <div class="col-sm-4 form-group"> 
                                            <div class="posrelative text-left"> 
                                                <div class="multi-dropdwn form-control"> 
                                                    Brakes  <span class="brCount"><?= (((count($breaks) > 0) && $breaks[0] != '0') ? ' (' . count($breaks) . ')' : '') ?></span><span class="pull-right caret"></span> 
                                                </div> 
                                                <ul class="dropdown-menu" role="menu">  
                                                    <?php foreach ($usedcar_breaks as $key => $val) 
                                                    { ?> 
                                                        <li class="pad-L5"><input type="checkbox" class="br"  id="brakes<?= $val['id'] ?>"  name="breaks[]" value="<?= $val['id'] ?>"  <?php if (in_array($val['id'], $breaks)) 
                                                        { 
                                                        echo 'checked="checked"'; 
                                                        } ?>><label for="brakes<?= $val['id'] ?>"><span></span> <?= $val['breaks_name'] ?></label></li> 
                                                    <?php } ?>     
                                                </ul> 
                                            </div> 
                                        </div> 


                                        <div class="col-sm-4 form-group"> 
                                            <div class="posrelative text-left"> 
                                                <div class="multi-dropdwn form-control"> 
                                                    Interior  <span class="intCount"><?= (((count($interiors) > 0) && $interiors[0] != '0') ? ' (' . count($interiors) . ')' : '') ?></span><span class="pull-right caret"></span> 
                                                </div> 
                                                <ul class="dropdown-menu" role="menu">   
                                                    <?php foreach ($interior as $key => $val) 
                                                    { ?> 
                                                        <li class="pad-L5"><input type="checkbox" class="int"  id="interior<?= $val['id'] ?>"  name="interior[]"  value="<?= $val['id'] ?>" <?php if (in_array($val['id'], $interiors)) 
                                                        { 
                                                        echo 'checked="checked"'; 
                                                        } ?>><label for="interior<?= $val['id'] ?>"><span></span> <?= $val['interior_name'] ?></label></li> 
                                                    <?php } ?> 
                                                </ul> 
                                            </div> 
                                        </div> 
                                    </div> 

                                </div> 
                            </div> 
                        </fieldset> 
                    </div> 
                </div> 
            </div> //
        </div> 
    </fieldset>--> 

    <?php if ($certificationsId) 
    { ?>  
        <fieldset class="fieldset"> 
            <legend class="text-warning"><strong>Certification Report</strong></legend> 
            <div class="clearfix"> 
                <div class="col-sm-2 text-right"> 
                    <label><strong>Car Certification</strong></label> 
                </div> 
                <div class="col-sm-8"> 
                    <div class="row  "> 
                        <div class="col-sm-4 form-group"> 
                            <label>Car Certification</label> 
                            <select name="certification" id="certification" class="form-control"> 
                                <option value="0" <?php if ($carcertificationData['car_certification'] == '0') 
                                { 
                                    echo 'selected'; 
                                } ?>>None</option> 
                                <?php foreach ($certifiedcarlists as $key => $val) 
                                { ?> 
                                    <option value="<?= $val['id'] ?>" <?php if ($carcertificationData['car_certification'] == $val['id']) 
                                    { 
                                        echo 'selected'; 
                                    } ?>><?= $val['name'] ?></option> 
                                <?php } ?> 
                            </select> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </fieldset> 
    <?php } ?>

    <div class="pad-B20"> 
        <!--<span id="imageloder" style="display:none;position: absolute;left: 50%;border-radius: 50%;">    <img src="<?= base_url('assets/images/loader.gif'); ?>"></span> -->
        <div class="clearfix pad-L50 " id="buttonclikaftersubmit"> 
            <div class="col-sm-8 col-sm-offset-4 form-group "> 

                <input type='hidden' name="clickbtton" id="clickbtton"> 
          
                <?php
                if($accessLevel!=1){
                if ($_SESSION['updatedcarid']) 
                { ?> 
                    <button style="display:none;" type="button" name="submit" id="savedetail" class="btn btn btn-primary btn-lg formvalidatebeforesubmit">Save Detail</button> 
                <?php } 
                else 
                { ?> 
                    <button type="button" name="submit" id="savedetail" class="btn btn btn-primary btn-lg formvalidatebeforesubmit">Save Detail</button> 
                <?php }
              
                }?>            
            </div> 
        </div> 
    </div> 
    <input type="hidden" name="inventory_start" id="inventory_start"> 
    <input type="hidden" name="event_type" id="event_type"> 
     
  </form> 
 
<!-- Form End --> 
</div><!--/Container Fluid --> 
</div>
<!-- Upload Photo modal --> 
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-uploadPhoto" > 
    <div class="modal-dialog modal-lg" > 
        <div class="modal-content"> 
            <div class="modal-header bg-gray"> 
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
                <h4 class="modal-title">VIEW PHOTOS</h4> 
            </div>     
            <div class="row"> 
                <div class="col-sm-12"> 
                    <div class="tabbable mrg-B20"> 
                        <div class="row mrg-B10"> 
                            <div class="col-sm-12 col-md-12"> 
                                <div class="btn-group float-ini mrg-L15 mrg-T20" role="group" aria-label="First group"> 
                                    <a href=".tabImage" role="tab" class="btn btn-default active" id="againTagpage" data-toggle="tab" aria-controls="profile" aria-expanded="false">Tag Photos</a> 
                                    <a  href=".tabImage" role="tab" class="btn btn-default"  data-toggle="tab"  aria-controls="profile" aria-expanded="false" id="viewPhotos">View Photos</a> 
                                </div>                                 
                            </div> 
                        </div>      
                        <div class="tab-content mrg-T20 tabImage">                          
                            <div class="modal-body" > 

                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div>       
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
            </div> 
        </div><!-- /.modal-content --> 
    </div> 
</div> 

<!-- Verify Status modal --> 

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
<div id="snackbar"></div>
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
       var pricingTip = '<?=isset($_GET['pricing'])?$_GET['pricing']:''?>';
       if(pricingTip=='view'){
       setTimeout(function(){$("body").scrollTop(1250);},2500);
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

    //competitive_inventory 
    $('#km').keyup(function(){ 
      return true;
        /*var dealer_owner="<?=trim(strtolower($_SESSION['dealer_owner']))?>"; 
        var make=$('#make').val(); 
        var model=$('#model').val(); 
        var version=$('#version').val(); 
        var km=$('#km').val(); 
        var make_year=$('#year').val(); 
        //alert(dealer_owner+' - '+make+' - '+model+' -'+version+' -'+km+' -'+make_year);
        $.ajax({ 
            url: "http://beta.usedcarsin.in/user/ajax/getCompetitiveInventory.php", 
            dataType: "html", 
            data: {make:make,model:model,version:version,km:km,make_year:make_year}, 
            success: function (data) { 
                $('#competitive_inventory').html(data); 
            } 
        }); */
    }); 

    var car_id='<?=$car_id?>';
    if(car_id!=''){
      $('#km').trigger('keyup');  
    }

    $(document).ready(function(){ 
       $('input[type=text]').bind("cut copy paste",function(e) { 
          e.preventDefault(); 
       }); 
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
      <?php if ($car_id > 0 || $_REQUEST['sell_enq_id'] > 0) { ?> 
              addCommasdealerupdate('<?php if ($car_id > 0 && $carDeatil['dealer_price'] != '' && $carDeatil['dealer_price'] != '0') 
                  { 
                      echo $carDeatil['dealer_price']; 
                  } ?>'); 
              $("#pricegaadi").trigger('onkeyup'); 
              $("#km").val(<?php echo $carDeatil['km_driven']; ?>);
              $("#km").trigger('onkeyup'); 
              $("#fuel").trigger('change'); 
              $("#regcity").trigger('change');
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

      $('.jNumberonly,.pricegaadi,.dealerprice').keyup(function (event) { 
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
    if(mm2.length=='1')
    {
        mm2 = '0'+mm2-1;
    }
    //alert(curmm);
    var date1         =   new Date(yyyy1, mm1, 1);

    $("#selkm").css("display", "none");
    $('#selkmdiv').removeClass('has-error');
    $("#selmonth").css("display", "none");
    $('#selmonthdiv').removeClass('has-error');
    $("#selregmonth").css("display", "none");
    $('#selregmonthdiv').removeClass('has-error');

    $('.hasError').each(function(){
      if(this.value==1){
        errorcount++;
      }
    });

    if(jQuery('#month').val()=='')
    {
      $("#selmonth").html('Please Select Month.');
      $('#selmonthdiv').addClass('has-error');
      $("#selmonth").css("display", "block");
      errorcount++;
    }

    if(jQuery('#year').val()=='')
    {
      $('#selectyeardiv').addClass('has-error');
      $("#selyear").css("display", "block");
      errorcount++;
    }

    if(jQuery('#year').val()!='' && jQuery('#month').val()!='' && yyyy1==curyy && mm1>curmm) 
    {
      $("#selmonth").html('Invalid Make month and Year.');
      $('#selmonthdiv').addClass('has-error');
      $("#selmonth").css("display", "block");
      errorcount++;
    }

    if(jQuery('#make').val()=='')
    {
      $('#selmakediv').addClass('has-error');
      $("#selmake").css("display", "block");
      errorcount++;
    }

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

    /*if(is_reg_no_valid===false && jQuery('#reg').val()!='')
    {
      $("#invalidRegNo").remove();
      $('#selreg').after('<label class="control-label " style="color:#a94442" id="invalidRegNo" >Please Enter Valid Reg No.</label>');
      errorcount++;
    }

*/
    if((jQuery('#reg').val()=='' || jQuery('#reg').val()=='ex. Ex. DL 3C 1 4526')&& ($("#registeredcar").is(":checked")))
    {
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

    if((jQuery('#reg_month').val()=='') && ($("#registeredcar").is(":checked")))
    { 
      $('#selregmonthdiv').addClass('has-error');
      $("#selregmonth").css("display", "block");
      errorcount++;
    }

    if((jQuery('#reg_year').val()=='') && ($("#registeredcar").is(":checked")))
    {
      $('#selregyeardiv').addClass('has-error');
      $("#selregyear").css("display", "block");
      errorcount++;
    }
    if((jQuery('#year').val()!='' && jQuery('#month').val()!='' && jQuery('#reg_year').val()!='' && jQuery('#reg_month').val()!='' && (yyyy1>reg_year || ((yyyy1==reg_year) && (reg_month<mm2))))) 
    {
      $("#selregmonth").html('Invalid Registration month and Year.');
      $('#selregmonthdiv').addClass('has-error');
      $("#selregmonth").css("display", "block");
      errorcount++;
    }
    //alert(reg_month+','+parseInt(curmm)+1);
    if(reg_month>(parseInt(mm2)))
    {
      $("#selregmonth").html('Invalid Registration month and Year.');
      $('#selregmonthdiv').addClass('has-error');
      $("#selregmonth").css("display", "block");
      errorcount++;
    }
   /* if((jQuery('#year').val()!='' && jQuery('#month').val()!='' && jQuery('#reg_year').val()!='' && jQuery('#reg_month').val()!='' && (yyyy1>reg_year || (yyyy1==reg_year && reg_month<mm2+1)))) 
    {
      $("#selregmonth").html('Invalid Registration month and Year.');
      $('#selregmonthdiv').addClass('has-error');
      $("#selregmonth").css("display", "block");
      errorcount++;
    }
    //alert(reg_month+','+parseInt(curmm)+1);
    if(reg_month>(parseInt(curmm)+1))
    {
      $("#selregmonth").html('Invalid Registration month and Year.');
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


    if(($('#thirdParty').prop('checked') || $('#Comprehensive').prop('checked')) && (jQuery('#jiyear').val()==''))
    {
      $('#insurancemonth').addClass('has-error');
      $("#selinsurancemonth").css("display", "block");
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
      $("#selowner").css("visibility", "visible");
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
    if(errorcount!=0)
    {
      $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
      $("#errordiv").css("display", "block");
    }

    if(errorcount==0)
    {
      $("#errordiv").css("display", "none");
      $('#imageloder').show();
      $('#buttonclikaftersubmit').hide();



      $.ajax({
            //url: "ajax/inventory_add.php",
            url: "<?php echo base_url().'inventories/inventory_add/'; ?>",
            type: 'post',
            dataType: 'html',
            data: $("#addinventory").serialize(),
            success: function(data)
            {
               $('#snackbar').html('Inventory saved successfully.');
                var x = document.getElementById("snackbar");
                x.className = "show";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 30000);
               // return true;
                window.location.href="<?php echo base_url().'inventoryListing'; ?>";
            }
      });
    }
  });

</script>
<script src="<?=base_url('assets/js/uploading_docs.js'); ?>"></script>
<script>
    
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
        var ca = $('#carid').val();
        if(ca==0){
        $('#registeredcar').attr('checked','checked');
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
