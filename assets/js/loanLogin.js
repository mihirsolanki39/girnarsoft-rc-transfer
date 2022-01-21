          function disburseLoan(eve)
          {
            var lid = $(eve).attr('id');
            var res = lid.split("_");
            var updateId = $('#edit_'+res[1]).val();
            var refId = $('#loanno_'+res[1]).val();
            //var loanno = $('#loanno_'+res[1]).val();
            //alert(refId);
            var caseid = $('#caseid').val();
            var bank_id = $('#loanbnk_'+res[1]).val();
            var loanamt = $('#floanamount_'+res[1]).val();
            var netdis = $('#grossamount_'+res[1]).val();
            var ten = $('#ftenor_'+res[1]).val();
            var ro = $('#froi_'+res[1]).val();
            var remarkss = $('#frmk_'+res[1]).val();
            var paydates = $('#paydates_'+res[1]).val();
            var filedate = $('#filedate_'+res[1]).val();
            $('#idSelected').val(res[1]);
            var d=filedate.split("-");
            var newcreateDate=d[2]+"-"+d[1]+"-"+d[0];
            var d1=paydates.split("-");
            var newendDate=d1[2]+"-"+d1[1]+"-"+d1[0];
            if(newcreateDate > newendDate){
            $('#errpaydate_'+res[1]).addClass('validClass');
            $('#errpaydate_'+res[1]).html("Please Enter Valid Disbursal Date");
             return false;
            // error_flag=true;  
          }
            if((refId!=''))
            {
               $('#dis_ten').val(ten);
               $('#dis_roi').val(ro);
               $('#loan_dis_amt').val(loanamt);
               $('#gross_loan').val(loanamt);
               $('#net_disburse').val(loanamt);
               $('#remark').val(remarkss);
               var lm = loanamt.replace(/,/g, '');
               var monthlyInterestRatio = (ro/100)/12;
              if((lm !='') && (ten!='') && (ro!=''))
              {
                var top = Math.pow((1+monthlyInterestRatio),ten);
                var bottom = top -1;
                var sp = top / bottom;
                var emi = ((lm * monthlyInterestRatio) * sp);
               // alert(emi);
                emis = emi.toFixed();
               // addCommas(emis,'total_emi');
                //addCommas(emis,'dis_emi');
                $('#dis_emi').val(emis);
                $('#counter_emi').val('0');
              }
                $('#flg').val('1');
               $.ajax({
                      type : 'POST',
                      async: false,
                      url : base_url+ "Finance/updateDisburseLoan/",
                      data : {id:updateId,refId:refId,caseid:caseid,bank_id:bank_id,tensure:ten,roi:ro,flag:1},
                      dataType : 'json',
                      success: function(data)
                      {
                       
                        $('#flg').val('0');
                      }
                  });
              
             disburseDist();
            }
            else
            {
              snakbarAlert('Please Enter Loan No');
              $('#loanno_'+res[1]).focus();
              return false;
            }
          }
          function saveDisbursal(eve)
          {
            var updateId = $('#edit_'+eve).val();
            var refId = $('#refid_'+eve).val();
            var loanno = $('#loanno_'+eve).val();
            var caseid = $('#caseid').val();
            var bank_id = $('#loanbnk_'+eve).val();
               $.ajax({
                      type : 'POST',
                      url : base_url+ "Finance/updateDisburseLoan/",
                      data : {id:updateId,refId:refId,caseid:caseid,bank_id:bank_id,loanno:loanno},
                      dataType : 'json',
                      async: false,
                      success: function(data)
                      {
                       // alert(data);
                        if(data.status == 1)
                        {
                          $("#app_"+eve).text('Disbursed');
                          $(".disburse").attr('style','display:none');
                          $("#bankdiv_"+eve).attr("disabled","disabled").off('click');
                          $("#desid_"+eve).val('4');
                          var formData=$('#disburseLogin').serialize();
                            saveCaseInfoData(formData,1);
                          //$(".form-group").css('pointer-events','none');
                        }
                        else
                        {
                          snakbarAlert('Please Enter Reference Id');
                          $('#refid_'+eve).focus();
                          return false;
                        }
                    }
                  });
          }
          function checkRefId(refval,res,id,flag='')
          {
           // alert(flag);
            $.ajax({
                  type: "POST",
                  url: base_url +"Finance/checkRefnumbers",
                  data : {refid : refval,id:id,flag:flag},
                  dataType: 'json',
                  success: function(response){
                  if((response.status=='0') && (flag==''))
                      {
                        //alert('wrerwr');
                        $('#errrefid_'+res).html('Reference No. Already Exists.');
                        $('#disburse_'+res).attr('style','display:none;');
                        return false;
                      }
                      else if((response.status=='0') && (flag=='1'))
                      {
                        $('#errloannoid_'+res).html('Loan No. Already Exists.');
                        $('#disburse_'+res).attr('style','display:none;');
                        return false;
                      }
                      else if(response.status=='1')
                      {
                        //alert('ssssss');
                        $('#errrefid_'+res).html('');
                        $('#disburse_'+res).attr('style','display:block;');
                      }
                  }
                }); 
          }
          function disburseDist()
          {
            $(".info-box").hide();
            $('#disbusedModel').addClass(' in');
            $('#disbusedModel').attr('style','display:block;');
            $('#total_emi').trigger('onchange');
          }

            function deleteForm(event)
          {
            var did = $(event).attr('id');
            var d = did.split("_");
            var id = $('#edit_'+d[1]).val();
            var bankIds =$('#bankid').val();
            var bankIdsArr = bankIds.split(',');
            //alert(bankIdsArr.length);
            var removeBank = $('#loanbnk_'+d[1]).val();
            var posi = bankIdsArr.indexOf(removeBank);
            var posiCheck = parseInt(posi)+1;
            if(posiCheck==bankIdsArr.length)
            {
              var rrr = removeBank;
            }
            else
            {
              var rrr = removeBank+',';
            }
            //alert(rrr);
            var newbank = bankIds.replace(rrr,'');
            //alert(newbank);
            $.ajax({
                type : 'POST',
                async : false,
                url : base_url+ "Finance/deleteFormLogin/",
                data : {id:id},
                success: function (response) {
                 location.reload();
                }
            });
            var abnkcount = $('#totlcnt').val();
            $('#bankdiv_'+d[1]).remove();
            $('#bankid').val(newbank);
            var total = $('#countTotalFiles').val();
            //alert(total);
            var y = parseInt(total)-1;
            var next = parseInt(d[1])+1;
            if(total>0)
            {
               for(var a=d[1];a<=total;a++)
                {
                    //alert(a+' - '+abnkcount);
                    if(a<=abnkcount)
                    {
                        var tttt = 'addCommas(this.value, floanamount_'+a+');';
                       // alert(tttt);
                        $('#bankdiv_'+next).attr('id','bankdiv_'+a); 
                        $('#bnklogo_'+next).attr('id','bnklogo_'+a);
                        $('#delete_'+next).attr('id','delete_'+a);
                        $('#bnkeditlogo_'+next).attr('id','bnkeditlogo_'+a);
                        $('#editOne_'+next).attr('id','editOne_'+a);
                        $('#floanamount_'+next).attr('onkeydown',tttt);
                        $('#floanamount_'+next).attr('id','floanamount_'+a);
                        $('#errfloanamount_'+next).attr('id','errfloanamount_'+a);
                        $('#ftenor_'+next).attr('id','ftenor_'+a);
                        $('#errftenor_'+next).attr('id','errftenor_'+a);
                        $('#froi_'+next).attr('id','froi_'+a);
                        $('#errfroi_'+next).attr('id','errfroi_'+a);
                        $('#fref_'+next).attr('id','fref_'+a);
                        $('#errrefid_'+next).attr('id','errrefid_'+a);
                        $('#femi_'+next).attr('id','femi_'+a);
                        $('#editid_'+next).attr('id','editid_'+a);
                        $('#loanbnk_'+next).attr('id','loanbnk_'+a);

                        next++;
                        //alert(next);
                    }
                       
                }
            }
            
            $('#countTotalFiles').val(y);
            $('#bnkleft').val('2');
            $('.wow').attr('style','display:block !important;');

          }

          /* function deleteForm(event)
          {
            var did = $(event).attr('id');
            var d = did.split("_");
            var id = $('#edit_'+d[1]).val();
            var bankIds =$('#bankid').val();
            var removeBank = $('#loanbnk_'+d[1]).val();
            var posi = bankIds.indexOf(removeBank);
            if(posi==1)
            {
              var rrr = removeBank;
            }
            else
            {
              var rrr = removeBank+',';
            }
            var newbank = bankIds.replace(rrr,'');
            
            $.ajax({
                type : 'POST',
                async : false,
                url : base_url+ "Finance/deleteFormLogin/",
                data : {id:id},
            });
            var abnkcount = $('#totlcnt').val();
            $('#bankdiv_'+d[1]).remove();
            $('#bankid').val(newbank);
            var total = $('#countTotalFiles').val();
            //alert(total);
            var y = parseInt(total)-1;
            var next = parseInt(d[1])+1;
            if(total>0)
            {
               for(var a=d[1];a<=total;a++)
                {
                    //alert(a+' - '+abnkcount);
                    if(a<=abnkcount)
                    {
                        var tttt = 'addCommas(this.value, floanamount_'+a+');';
                       // alert(tttt);
                        $('#bankdiv_'+next).attr('id','bankdiv_'+a); 
                        $('#bnklogo_'+next).attr('id','bnklogo_'+a);
                        $('#delete_'+next).attr('id','delete_'+a);
                        $('#bnkeditlogo_'+next).attr('id','bnkeditlogo_'+a);
                        $('#editOne_'+next).attr('id','editOne_'+a);
                        $('#floanamount_'+next).attr('onkeydown',tttt);
                        $('#floanamount_'+next).attr('id','floanamount_'+a);
                        $('#errfloanamount_'+next).attr('id','errfloanamount_'+a);
                        $('#ftenor_'+next).attr('id','ftenor_'+a);
                        $('#errftenor_'+next).attr('id','errftenor_'+a);
                        $('#froi_'+next).attr('id','froi_'+a);
                        $('#errfroi_'+next).attr('id','errfroi_'+a);
                        $('#fref_'+next).attr('id','fref_'+a);
                        $('#errrefid_'+next).attr('id','errrefid_'+a);
                        $('#femi_'+next).attr('id','femi_'+a);
                        $('#editid_'+next).attr('id','editid_'+a);
                        $('#loanbnk_'+next).attr('id','loanbnk_'+a);

                        next++;
                        //alert(next);
                    }
                       
                }
            }
            
            $('#countTotalFiles').val(y);

          }
*/

         function updateStatus(eve){
            var did = $(eve).attr('id');
            var dclass = $(eve).attr('class');
            var caseid = $('#caseid').val();
            var dcl = dclass.split("_");
            var dcls = dcl[1].split(" ");
            var d = did.split("_");
            var datetimef  = $('#paydates_'+dcls[0]).val();
            if(d[0]=='approve')
            {
                 var tag_status = '2';
                 $("#filetag_"+dcls[0]).val('2');
                 $("#approve_"+d[0]).attr('class','btn-continue btn-approved');
                 $("#reject_"+d[0]).attr('class','btn-continue btn-reject');
                 $.ajax({
                  type : 'POST',
                  url : base_url + "Finance/deleteFormLogin/",
                  data : {id:d[1],tag_status:tag_status,datetime:datetimef,caseid:caseid},
                  dataType:'json',
                   success: function(data){
                    $('.xyz_'+dcls[0]).text('Approved');
                    $('.xyz_'+dcls[0]).addClass('approved');
                    $('.xyz_'+dcls[0]).attr('id','approve_'+d[1]);
                    $('.xyz_'+dcls[0]).attr('onclick','showRej(this)');
                    $("#rejcase_id").val(d[1]);
                    $("#reji_id").val(dcls[0]);
                    $(".hidee_"+dcls[0]).attr('style','display:none;');
                  }
                           
                });
            }
            else
            {
                var tag_status = '3';
                $("#filetag_"+dcls[0]).val('3');
                $("#reject_"+d[0]).attr('class','btn-continue btn-approved');
                $("#approve_"+d[0]).attr('class','btn-continue btn-reject');
                $("#rej_model").attr('style','display:block');
                $("#rej_model").attr('class','modal fade in');
                $("#rejcase_id").val(d[1]);
                $("#reji_id").val(dcls[0]);
                $('.xyz_'+dcls[0]).text('Reject');
                $('.xyz_'+dcls[0]).attr('id','reject_'+d[1]);
                $('.xyz_'+dcls[0]).attr('onclick','reloginStatus(this)');
                $(".hidee_"+dcls[0]).attr('style','display:none;');
            }
         }

            $(".close").click(function(){
              $("#rej_model").attr('style','display:none');
              $("#rej_model").attr('class','modal fade');
              $("#rej_"+d[1]).attr('style','display:none');
            });
            
            function showRej(eve='',e='')
            {
              if(eve!='')
              {
                var did = $(eve).attr('class');
                var d = did.split("_");
               // var caseid = $('#caseid').val();
                var ds = d[1].split(" ");
                $("#reje_"+ds[0]).attr('style','display:block');
                var casess = $('#edit_'+ds[0]).val();
               // alert(casess);
                $('#rejcase_id').val(casess);
              }
              else
              {
                var did = $(e).attr('id');
                var d = did.split("_");
                $("#reji_id").val(d[1]);
                $("#rej_model").attr('style','display:block');
                $("#rej_model").attr('class','modal fade in');
                $("#rej_"+d[1]).attr('style','display:none');
                $("#reje_"+d[1]).attr('style','display:none');
                $('#rejection_type').val('0');
                $('#rejection_category').val('0');

              }
            }

            function rejNow(){
              var rejectType = $('#rejection_type').val();
              var rejectReason = $('#rejection_category').val();
              var remark_reject = $('#rejection_category option:selected').text();
              var updateId = $('#rejcase_id').val();
              var i_id = $('#reji_id').val();
              var datetimef = $('#paydates_'+i_id).val();
               var caseid = $('#caseid').val();
             // alert(updateId);
              //var edit_id = $('#mappid_')
              if((rejectType>0)&&(rejectReason>0)&&(updateId>0))
              {
               // alert('frerferf');
                $.ajax({
                type : 'POST',
                url : base_url+ "Finance/deleteFormLogin/",
                data : {rejectReason:rejectReason,id:updateId,tag_status:'3',datetime:datetimef,caseid:caseid},  
                dataType: 'html',
                success: function(data){
                 $('#disburse_'+i_id).attr('style','display:none');
                  $("#rej_model").attr('style','display:none');
                  $("#rej_model").attr('class','modal fade');
                  $("#remark_"+i_id).val(remark_reject);
                  $("#remarkid_"+i_id).val(rejectReason);
                  $("#approve_"+data).html('Reject');
                  $(".appr_"+i_id).text('Reject');
                  $("#app_"+i_id).text('Reject');
                  $(".xyz_"+i_id).html('Reject');
                  $('.xyz_'+i_id).attr('id','reject_'+updateId);
                  $('.xyz_'+i_id).attr('onclick','reloginStatus(this)');
                  //$(".hidee_"+dcls[0]).attr('style','display:none;');
                  
                }   
                });
                var classs = 'xyz_'+i_id+' reject abc_'+i_id;
                $(".xyz_"+i_id).attr('class',classs);
              }
            };
             function closeModel()
             {
              $("#rej_model").attr('style','display:none');
              $("#rej_model").attr('class','modal fade');
              $("#relogin_model").attr('style','display:none');
              $("#relogin_model").attr('class','modal fade');
              $(".mark-rej").attr('style','display:none');
             }

           /* $(".close").click(function(){
              $("#rej_model").attr('style','display:none');
              $("#rej_model").attr('class','modal fade');
              $("#relogin_model").attr('style','display:none');
              $("#relogin_model").attr('class','modal fade');
              $(".mark-rej").attr('style','display:none');
            }); */

            function reloginStatus(eve)
            {
                var did = $(eve).attr('id');
                var dclass = $(eve).attr('class');
                
                var dcl = dclass.split("_");
                var dcls = dcl[1].split(" ");
                var d = did.split("_");
                $('#rej_'+dcls[0]).attr('style','display:block');
            }

            function relogin(e)
            {
                var did = $(e).attr('id');
                var d = did.split("_");
                var loanAmount = $('#floanamount_'+d[1]).val();
                var numberOfMonths = $('#ftenor_'+d[1]).val();
                var rateOfInterest = $('#froi_'+d[1]).val();
                var emi = $('#femi_'+d[1]).val();
                var case_id = $('#rejcase_'+d[1]).val();
                var bankid = $('#bnkid_'+d[1]).val();
                var module = $('.module').attr('name');
                $('#relogin_model').attr('style','display:block');
                $("#relogin_model").attr('class','modal fade in');
                $('#loanamount').val(loanAmount);
                $('#tenoramount').val(numberOfMonths);
                $('#roiamount').val(rateOfInterest);
                $('#emiamount').val(emi);
                $('#relogincase_id').val(case_id);
                $('#relogini_id').val(d[1]);
                $('#relogini_id').val(d[1]);
                $('#banid').val(bankid);
                $('#module').val(module);

            }

            function populateRejectionReason(event)
            {
                $.ajax({
                type : 'POST',
                url : base_url+ "Finance/getRejectReason/",
                data : {id:event},  
                dataType: 'html',
                success: function(data){
                 $('#rejection_category').html(data);
                }   
            });
            }

            function reloginNow()
            {

              var loanAmount = $('#loanamount').val();
              var numberOfMonths =  $('#tenoramount').val();
              var rateOfInterest = $('#roiamount').val();
              var case_id = $('#relogincase_id').val();
              var get_id = $('#relogini_id').val();
              var cl = $('.abc_'+get_id).attr('id');
              var dcl = cl.split("_");
              var id = dcl[1];
              var bank_id = $('#banid').val();
              var module =  $('#module').val();
              var customer_id = $('#customer_id').val();
              $.ajax({
                type : 'POST',
                url : base_url+"Finance/reloginFile/",
                data : {id:id,loanAmount:loanAmount,numberOfMonths:numberOfMonths,rateOfInterest:rateOfInterest,case_id:case_id,bank_id:bank_id,module:module,customer_id:customer_id},  
                success: function(response){
                   // alert(response);
                    var data = $.parseJSON(response);
                    console.log(data);
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
          function add_bankk(e)
          {
                var case_id = $('#caseid').val();
               // alert(case_id);
                $('#addBank').attr('style','display: block; padding-right: 15px;');
                $('#addBank').attr('class','modal fade in');
                var bank = $('#bankid').val();
                if((bank!='') || (bank==undefined)) {
                var spl = bank.split(',');
                var c = count(spl);
              }
                jQuery.ajax({
                type: "POST",
                url: base_url+"Finance/getBankList/",
                data: {bank_id:bank,case_id:case_id},
                dataType: 'html',
                success: function(datas){
                       var res = datas.split('@@');
                       if((res[1]!='') && (res[1]!=undefined))
                       {
                          var data = res[0];
                         // alert('fff');
                         $('#bnkleft').val('1');
                         // $('.wow').attr('style','display:none !important');
                       }
                       else
                       {
                        //alert('gg');
                          var data = datas;
                          $('#bnkleft').val('2');
                         // $('.wow').attr('style','display:block !important');
                       }
                       $("#bank_detail").html(data);
                       $('#bank_detail')[0].sumo.reload();
                       
                 }
              });
          }

           function count(array){

                var c = 0;
                for(i in array) // in returns key, not object
                    if(array[i] != undefined)
                        c++;

                return c;
            }
          function closeBank()
          {
            $('#addBank').attr('style','display: none; padding-right: 15px;');
            $('#addBank').attr('class','modal fade');
          }

           function editFileId(e)
          {
            
            var did = $(e).attr('id');
            var d = did.split("_");
            var id = $('#editOne_'+d[1]).val();
            $('#floanamount_'+d[1]).removeAttr("readonly");
            $('#ftenor_'+d[1]).removeAttr("readonly");
            $('#froi_'+d[1]).removeAttr("readonly");
            $('#fref_'+d[1]).removeAttr("readonly");
            $('#saveI').val('1');
          }
