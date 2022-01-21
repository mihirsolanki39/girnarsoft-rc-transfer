<div id="content">
<div class="left-menu">
        <style>


/**===========HEADER===========*/


.left-menu {
    background-color: #ffffff;
    width: 200px;
    float: left;
    position: fixed;
    z-index: 1;
    height: 100vh;
    top: 60px;
}

.left-menu ul.leftMenuUl li a {
    display: block;
    padding: 20px;
    color: rgba(0, 0, 0, 0.54);
    position: relative;
    z-index: 9;
    font-size: 16px;
    font-weight: 400;
}

.left-menu ul.leftMenuUl li a:before {
    content: "";
    border-left: 1px dashed rgba(0, 0, 0, 0.12);
    position: absolute;
    height: 46px;
    top: 38px;
    display: inline-block;
    margin-left: 8px;
}

.left-menu ul.leftMenuUl li.subDropDown a:before {
    height: 171px;
}

.left-menu ul.leftMenuUl li:last-child a:before {
    display: none;
}

.left-menu ul. li a:hover {
    text-decoration: none;
}

.left-menu ul.leftMenuUl li a.completed:before {
    border: 1px solid #E46536;
}

.left-menu ul.leftMenuUl li a.completed i:before {
    content: "\f00c";
    border-radius: 50%;
    padding: 2px;
    font-size: 13px;
    position: relative;
    top: -3px;
    left: 1px;
    background: #e46536;
    color: #fff;
    font-weight: 100;
}

.left-menu ul.leftMenuUl li a.completed {
    color: #E46536;
}

.left-menu ul.leftMenuUl li a i {
    margin-right: 15px;
    font-size: 20px;
}

.left-menu ul.leftMenuUl li a.active {
    color: rgba(0, 0, 0, 0.87);
}

.left-menu ul.leftMenuUl li .childUL li a {
    padding: 10px 0px 10px 70px;
}

.left-menu ul.leftMenuUl li .childUL li a:before {
    display: none;
}

/**===========MAIN===========*/

main {
    padding: 20px;
    margin-top: 0px;
    margin-left: 200px;
    position: relative;
    z-index: 0;
}

.page-head {
    font-weight: 500;
    font-size: 22px;
    margin-bottom: 20px;

}

/*FORM*/

.inpt-label {
    font-size: 14px;
    color: rgba(0, 0, 0, 0.54);
    font-weight: 400;
    margin-bottom: 5px;
}

.inpt-form {
    font-size: 14px;
    color: rgba(0, 0, 0, 0.87);
    height: 40px;
    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 3px;
    box-shadow: none;
}

.inpt-form:focus {
    box-shadow: none;
    border-color: #E46536;
}

select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.whte-strip {
    background: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12);
    padding: 20px;
    border-radius: 3px;
    margin-top: 20px;
}

.whte-strip.whtStrpTable {
    padding: 10px 20px 20px;
}

/*FORM*/

            .pad-all-0{padding: 0px;}
            ul#sidenav011 li{width: 100%}
            ul#sidenav011 li a{color:#000000; border-left: 2px solid transparent;}
            ul#sidenav011 li .active{border-left:2px solid #e46536;}
            #sidenav011 ul.nav.nav-list {padding: 0px 15px;}
            #sidenav011 ul.nav.nav-list li a{color:#000000; opacity: .87; font-size: 14px; border-bottom: 3px solid transparent !important;}
            .table-striped>tbody>tr:nth-of-type(odd) {background-color: #ffff;}
            .table-striped>tbody>tr:nth-of-type(even) {background-color: #ffff;}
            .left-menu .navbar-default { background-color: #ffffff; border-color: #e7e7e7;}
            .left-menu .navbar-nav li a:hover {color: #000000 !important; opacity: 0.87;}
            .left-menu .navbar-nav>li>a {padding-top: 10px;padding-bottom: 10px; margin: 0px 10px 0px 0px;border-bottom: 3px solid transparent !important;}
             .left-menu .navbar-nav>li>a{font-size: 14px;}
             #sidenav011 .nav>li>a:hover, .nav>li>a:focus {text-decoration: none; background-color: #ffffff;  color: #e86335 !important;}
             .nav>li>a:hover, .nav>li>a:focus {text-decoration: none; background-color: #fff; }
             .nav-tabs {border-bottom: 0px solid #ddd;}
             .nav-tabs>li>a:hover {border-color: transparent;}
              ul#sidenav011 li .highclass a{color: #ed8156 !important;border: 0px solid #ed8156;}



        </style>
        <div class="navbar navbar-default" role="navigation">
            <div class="navbar-collapse collapse sidebar-navbar-collapse pad-all-0">
              <ul class="nav navbar-nav" id="sidenav011">
               <!--<li><a href="#" id="ins_1"  class="collapsed active" onclick="getdocpage(1)"> Insurance</a></li>-->
               <li>
                  <a href="#" id="ins_1" onclick="getdocpage(1)" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav02" class="collapsed">
                   Insurance<span class="caret caret mrg-L15"></span>
                  </a>
                  <div class="collapse" id="toggleDemo" style="height: 0px;">
                    <ul class="nav nav-list">
                      <li class="listdoc highclass" id="highclass_7"><a href="#"   onclick="getdocpage(7)">New Car</a></li>
                      <li class="listdoc" id="highclass_8"><a href="#"   onclick="getdocpage(8)">Used Car</a></li>
                      <li class="listdoc" id="highclass_9"><a href="#"  onclick="getdocpage(9)">Renewal</a></li>
                      <li class="listdoc" id="highclass_10" ><a href="#" onclick="getdocpage(10)">Policy Already Expired(&lt;90 days)</a></li>
                      <li class="listdoc" id="highclass_11"><a href="#"  onclick="getdocpage(11)">Policy Already Expired(>90 days)</a></li>
                    </ul>
                  </div>
                </li>
                <li>
                  <a href="#" id="ins_2" onclick="getdocpage(2)" data-toggle="collapse" data-target="#toggleDemo2" data-parent="#sidenav01" class="collapsed">
                   Loan<span class="caret mrg-L15"></span>
                  </a>
                  <div class="collapse" id="toggleDemo2" style="height: 0px;">
                    <ul class="nav nav-list">
                      <li class="listdoc" id="highclass_3"><a href="#"   onclick="getdocpage(3)">New Car</a></li>
                      <li class="listdoc" id="highclass_4"><a href="#"  onclick="getdocpage(4)">Used Car</a></li>
                    </ul>
                  </div>
                </li>
                  
                  <li><a href="#" id="ins_5" class="collapsed " onclick="getdocpage(5)">Stock</a></li>
                  <li><a href="#" id="ins_6" class="collapsed " onclick="getdocpage(6)">RC Transfer</a></li>
                
                
              </ul>
              </div><!--/.nav-collapse -->
            </div>
        
    </div>
    <main class="main-body" id="mainId">
       
    </main>
    <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
      <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>">
    </span>   
</div>
<button type="button" id="alertbox" class="btn btn-primary" style="display: none" data-toggle="modal" data-target="#exampleModal">
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Heads Up!</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <div class="modal-body">
       Changes made by you are not saved. Make sure you save your changes before leaving this page.
      </div>
      <div class="modal-footer">
      <input type="hidden" name="docty" value="" id="doctyf">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-secondary" onclick="dontsave()">Don't Save</button>
        <button type="button" class="btn btn-primary" onclick="docsave()">Save</button>
      </div>
    </div>
  </div>
</div>
 
<script>
$(document).ready(function() {
         getdocpage(7);
});
function getdocpage(pageid)
{  
  //alert(pageid);
  if((pageid!='1') && (pageid!='2')){
    //alert('fff');
  $('#doctyf').val(pageid);
  $('.listdoc').removeClass(' highclass');
  $('#highclass_'+pageid).addClass(' highclass');
}
  var chng = $('#cngs').val();
  if(chng=='1')
  {
    $('#alertbox').trigger('click');
    return false;
  }
  $('#imageloder').attr('style','display:block; position:absolute;left: 50%;border-radius: 20%;z-index:999;');
  $('.collapsed').removeClass(' active');
  $('#ins_'+pageid).addClass(' active');
  if(pageid=='3' || pageid=='4')
  {
    $('.collapsed').removeClass(' active');
    $('#ins_2').addClass(' active');
  } 
  if(pageid=='11' || pageid=='7' || pageid=='8' || pageid=='9' || pageid=='10')
  {
    $('.collapsed').removeClass(' active');
    $('#ins_1').addClass(' active');
  } 
  if(pageid=='1')
  {
      pageid = 7;
  }
  if(pageid=='2')
  {
      pageid = 3;
  }
    $.ajax({
           type : 'POST',
           url : "<?php echo base_url(); ?>" + "Docmanager/getdocpage/",
           dataType: 'html',
          // async:true,
           data:{pageId:pageid},
           success: function (response) 
           { 
              $('#mainId').html(response);
              //$('#snakbarAlert').html('Updates Save Successfully.');
              $('#imageloder').attr('style','display:none; position:absolute;left: 50%;border-radius: 20%;z-index:999;');
            }
           });
  
}
function dontsave()
{
   $('#cngs').val('0');
   var pageid = $('#doctyf').val();
   snakbarAlert('Changes Not Saved.'); 
   getdocpage(pageid);
   $('#exampleModal').attr('style','display:none');
   $('#exampleModal').removeClass('in');
}
function docsave()
{
   $('#imageloder').attr('style','display:block; position:absolute;left: 50%;border-radius: 20%;z-index:999;');
                               var formData=$('#forms').serialize();
                               var doctype = $("#docty").val();
                               var instype = $("#ins_type").val();
                               $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" +"Docmanager/saveDocsInfo",
                                data: formData,
                                async:false,
                                dataType: "html",
                                success: function (responseData)
                                {
                                 //alert('dd');
                                    snakbarAlert('Changes Saved Successfully.'); 
                                  //$('#snackbar').html('Updates Save Successfully.');
                                  $('#cngs').val('0');
                                  if(instype=='1')
                                  {
                                    var page = '7';
                                  }
                                  if(instype=='2')
                                  {
                                    var page = '8';
                                  }
                                  if(instype=='3')
                                  {
                                    var page = '9';
                                  }
                                  if(instype=='4')
                                  {
                                    var page = '10';
                                  }
                                  if(instype=='5')
                                  {
                                    var page = '11';
                                  }
                                   getdocpage(page);

                                   $('#imageloder').attr('style','display:none; position:absolute;left: 50%;border-radius: 20%;z-index:999;');
                                   $('#exampleModal').attr('style','display:none');
                                   $('#exampleModal').removeClass('in');
                                }
                              });
}
</script>