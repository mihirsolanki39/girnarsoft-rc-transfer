<?php 
   // echo "<pre>";
   // print_r($uploadDocList);
   // exit;
?>
<div class="row">
            <div class="col-md-12">
                <h4 class="page-head">Set Permission</h4>
                <div class="whte-strip whtStrpTable">
                    <div class="tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#newcar" role="tab" onclick="tabpages('3','1');" data-toggle="tab">New Car</a>
                            </li>
                            <li role="presentation">
                                <a href="#usedcar" role="tab" onclick="tabpages('3','2');" data-toggle="tab">Used Car</a>
                            </li>
                            <li role="presentation">
                                <a href="#renewal" role="tab" onclick="tabpages('3','3');" data-toggle="tab">Renewal</a>
                            </li>
                             <li role="presentation">
                                <a href="#policyexpired" role="tab" onclick="tabpages('3','4');" data-toggle="tab">Policy Expired</a>
                            </li>
                            <li role="presentation">
                                <a href="#policyexpired2" role="tab" onclick="tabpages('3','5');" data-toggle="tab">Policy Expired2</a>
                            </li>

                            <!--<div class="pull-right">
                                <div class="dwnld-excel"><a href="javascript:void(0);">DOWNLOAD EXCEL</a></div>
                            </div>-->
                        </ul>
                    </div>
                    
                </div>
                
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active clearfix" id="newcar">
                              
                            </div>
                            <div role="tabpanel" class="tab-pane" id="usedcar">
                              
                            </div>

                            <div role="tabpanel" class="tab-pane" id="renewal">
                             
                            </div>
                            <div role="tabpanel" class="tab-pane" id="policyexpired">
                             
                            </div>
                            <div role="tabpanel" class="tab-pane" id="policyexpired2">
                             
                            </div>

                    <div class="col-md-12">
                        <div class="btn-sec-width">
                        <input type="hidden" name="doct" value="1" id="doct">
                        <button type="button" class="btn-continue saveCont" style="display:block" id="personalDetails">SAVE AND CONTINUE</button>
                        </div>
                    </div>
                </div>
        <script>
       /* $( document ).ready(function() {
            tabpages(3,1);
        });

        function tabpages(doctype,instype)
        {
             $('#newcar').html('');
             $('#usedcar').html('');
             $('#renewal').html('');
             $('#policyexpired').html('');
             $('#policyexpired2').html('');
            $.ajax({
              type: 'POST',
              url: "<?php echo base_url(); ?>" +"Docmanager/getDocInfo",
              data: {doctype: doctype,instype:instype,flag:'1'},
              dataType: "html",
              success: function (responseData)
              {
               // alert(responseData);
                  if(instype=='1')
                  {
                    $('#newcar').html(responseData);
                    $('#doct').val('1');
                  }
                  if(instype=='2')
                  {
                    $('#usedcar').html(responseData);
                    $('#doct').val('2');
                  }
                  if(instype=='3')
                  {
                    $('#renewal').html(responseData);
                    $('#doct').val('3');
                  }
                  if(instype=='4')
                  {
                    $('#policyexpired').html(responseData);
                    $('#doct').val('4');
                  }
                  if(instype=='5')
                  {
                    $('#policyexpired2').html(responseData);
                    $('#doct').val('5');
                  }
              }
            });
        }
        function onOffCategory(id)
          {
            //alert(id);
            var abe = $('input:checkbox[name=onoff_'+id+']').is(':checked');
            if(abe==true)
            {
              $("td.onoff_"+id).attr('style',"pointer-events: inline !important;");
              $("#prntid_"+id).val('1');
              $('.aa_'+id). prop("checked", true);
            }
            else
            {
               $("td.onoff_"+id).attr('style',"pointer-events: none  !important;");
               $("#prntid_"+id).val('0');
               $('.aa_'+id). prop("checked", false);
            }
          }
        $('.saveCont').click(function(){
             var formData=$('#forms').serialize();
             var doctype = $("#docty").val();
             var instype = $("#ins_type").val();
             $.ajax({
              type: 'POST',
              url: "<?php echo base_url(); ?>" +"Docmanager/saveDocsInfo",
              data: formData,
              dataType: "html",
              success: function (responseData)
              {
                tabpages(doctype,instype);
              }
            });
        });*/
        </script>