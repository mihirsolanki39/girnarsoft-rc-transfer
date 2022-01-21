<link rel="stylesheet" href="<?=base_url()?>assets/js/sort/sort.css" />
<script src="<?=base_url()?>assets/js/sort/jquery-1.9.1.js"></script>
	<script src="<?=base_url()?>assets/js/sort/jquery-ui.js"></script>
	<script>
	<?php 
	$ie=0;
	$ImageUpdateStatus=2;
	$isImageUpdateAllowed = 2;
	if($ImageUpdateStatus>1 && $isImageUpdateAllowed!=1)
				{
				?>
	$(function() {
	
		/*$( "#sortable" ).sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("updateDB.php", order, function(theResponse){
				$("#contentRight").html(theResponse);*/
			$(function() {			
		$(".middle ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var imgname='';
			var i=0;
			$( "li.template-download" ).each(function(i) {
			var newimgname=$(this).find('img').attr('src');
			imgname+=newimgname+'#~#';		
			 	});	
			var order ='&action=updateRecordsListings'+'&imgname='+ imgname;
		$.post("updateDB_new.php", order, function(theResponse){
		//alert(theResponse);return false;
				//$("#contentRight").html(theResponse);	 	
		 })
	
setTimeout('sort()',100);			
		}								  
		});
	});		
		//$( "#sortable" ).disableSelection();
	});
	<?php }	?>
	function sort()
	{
		var elm;
		$( "li.template-download" ).each(function(index) {
		elm=$(this);
		//alert('hi');return false;
		//alert(this);
			//alert(".c"+(index+1));
			//alert($(".c"+index).text());
				elm.children('div .number').text((index+1));
			});
	}
	</script>
	  <style>
.top_head{ 
	font:24px Arial,Helvetica,sans-serif;
	padding: 5px 0;}
.btm_note {
	clear: both;
	font: 13px Arial,Helvetica,sans-serif;
	padding: 5px 0;
}
.dd_images{float:left; margin:10px 10px 10px 50px;}
#sortable { list-style-type: none; margin: 0; padding: 0; width: 450px;}
#sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; position: relative;  }
#sortable li div.number { 
	cursor: pointer;
	display: block;
	font: 70px arial;
	height: 90px;
	left: 0;
	position: absolute;
	text-align: center;
	top: 0;
	width: 100px;
	z-index: 100;
	opacity: 0.5;
}

.files{
	background:#eee !important;
	border-radius:3px;
	border:5px solid #fff;
	-webkit-box-shadow: 0 0 2px rgba(0,0,0,0.33);
	box-shadow: 0 0 2px rgba(0,0,0,0.33);
	float:left;
	width:95%;
	padding-left: 10px;
	list-style:none;
	font-family:Gotham, "Arial", Helvetica, sans-serif;
	margin-left: 10px;
	min-height:270px;
}

.browse-bg{
	background:#eee url(../../assets/images/browse-bg.png) no-repeat center center !important;
}

.browse-more{
	background:#eee url(../../assets/images/browse.png) no-repeat bottom right !important;
}

.template-download{
	background-color:#fff;
	float:left;
	text-align:center;
	height:104px;
	padding:0px;
	margin:10px;
	-webkit-box-shadow: 0 0 2px rgba(0,0,0,0.33);
	box-shadow: 0 0 2px rgba(0,0,0,0.33);
	border:4px solid #fff;
}
.template-download img{
	width:108px !important;
	height:80px !important;
}
.template-download:first-child{ border: 4px solid #8DD068  !important;  box-shadow: none;}
.remove{ font-size:12px;color: #40BCE1; background-color:transparent; border:1px solid #40BCE1; border-radius:2px; padding:5px 10px; cursor:pointer;}
.remove a{ font-size:12px;color: #40BCE1; text-decoration:none; background-color:transparent;}
.remove a:hover{ font-size:12px;color: #40BCE1; background-color:transparent;}
.success-icon{color:#fff; position: absolute; border-radius: 100%; margin: -8px 0px 0px 95px; font-size: 12px !important; cursor:pointer;  background:#8dd068 !important; padding:3px;}
.success-icon:hover{background:#44A110 !important;}
.error-icon{position: absolute;	margin: -8px 0px 0px 70px; cursor:pointer; display:none;}
.error-icon:hover{}
.rotate-icon{color:#fff; position: absolute; border-radius: 100%; margin: -8px 0px 0px -6px; font-size: 12px !important; cursor:pointer;  background:#40BCE1 !important; padding:3px;}
.rotate-icon:hover{background:#009AC8 !important;}
.icon-w-set{/*width:20px; height:20px;*/}
.error-msg{border:1px solid red; color:red; width: 108px; height:110px;}
.error-msg-txt{ color:red; padding:10px 0px; font-size:12px; height: 64px;}
.ui-button-text-icon-primary .ui-button-text, .ui-button-text-icons .ui-button-text {
	padding: 0px !important; 
}

.btn-primary {
	background-color: #E66437;
	border-color: #C94619;
	color: #FFFFFF;
}

.mrg-L15 {
margin-left: 15px !important;
}

.btn {
	-moz-user-select: none;
	background-image: none;
	border: 1px solid rgba(0, 0, 0, 0);
	border-radius: 2px;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	font-weight: normal;
	line-height: 1.42857;
	margin-bottom: 0;
	padding: 4px 10px;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
}
.same-all{float:right; margin-right:13px;}
.error-msgTxt{ float:left; color:green; font-family:Gotham, "Arial", Helvetica, sans-serif; color: #3c763d;  background-color: #dff0d8;  border: 1px solid #d6e9c6; padding: 4px 20px 2px; margin-left:10px;}

.dlt-btn{padding: 3px 10px 2px !important; font-size: 12px !important;}


@media (max-width: 767px)
.files .delete {
    width: 110px;
}

.error-msg-txt {
    color: red;
    padding: 10px 0px;
    font-size: 11px;
    height: 54px;
}

.template-download img {
    width: 103px !important;
    height: 80px !important;
}

.template-download {
    background-color: #fff;
    float: left;
    text-align: center;
    height: 104px;
    padding: 0px;
    margin: 5px;
    -webkit-box-shadow: 0 0 2px rgba(0,0,0,0.33);
    box-shadow: 0 0 2px rgba(0,0,0,0.33);
    border: 4px solid #fff;
    width: 102px;
}
.files .delete {
    width: 100px !important;
}
</style>
<!--<link rel="stylesheet" href="<?php echo ASSET_PATH?>imageuploader_new/css/jquery.fileupload-ui.css">-->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<table   width="100%">
    <tr align="center" id='count'></tr>
</table>
<div class="middle"> 
   <!--<div class="error-msgTxt">You can upload images of size greater than 25kb and less than 8MB</div>-->
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
	<input type='hidden' name='hiddenuploadimagefolder1' id='hiddenuploadimagefolder1'>
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7" style="display:none;">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" id="files" name="files[]" multiple>(25 KB To 8 MB)
                </span>
                <!--<button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>-->
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
				
				
					
				<button type="button" class="btn btn-danger setprofile ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">
                    <i class="icon-plus icon-white"></i>
                    <span class="ui-button-text">Set as profile</span>
                </button>
				
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
       
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped" width="100%">
		<?php 		
		if(empty($selectedData)  && count($getImageinedit)==0){
		?>
        <ul class="files browse-bg"  id="testing" style="margin-top:1px;" data-toggle="modal-gallery" data-target="#modal-gallery" ></ul>
		<?php }else{ ?>
		<ul class="files browse-more" id="testing" data-toggle="modal-gallery" data-target="#modal-gallery" ></ul>
		<?php } ?>
		</table>
    </form>
   
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">


{% for (var i=0, file; file=o.files[i]; i++) { %}
    <li class="template-download fade error-msg">
		{% if (file.error) { %}
					<div class="error-icon"><i class="fa fa-times" data-unicode="f00d"></i></div>
				<?php if($ImageUpdateStatus>1 && $isImageUpdateAllowed!=1){?><div class="delete"> 
{% if (file.error) { %}
				
				<div class="error-msg-txt"> {%=file.error%}</div>
	{% } %}
	<!--<div class="number rec_{%=i%}">{%=i%}</div>-->
				<button class="btn btn-default remove dlt-btn" data-type="<?php if(strtolower($_SESSION[dealer_owner])=="axis"){ echo "OPTIONS";}else{ echo "DELETE";}?>" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <span>Delete</span>
            </button>
</div><?php }?>
				 {% } else { %}
				<div class="success-icon"><i class="fa fa-check" data-unicode="f00c"></i></div>
				 {% } %}
				 
    </li>
{% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">

{%  for (var i=0, file; file=o.files[i]; i++) { %}
    <li class="template-download fade" rel="rec_{%=i%}">
				{% if (file.error) { %}
				<div class="fail-icon"><i class="fa fa-check" data-unicode="f00c"></i></div>
				<?php if($ImageUpdateStatus>1 && $isImageUpdateAllowed!=1){?><div class="delete">   <button class="btn btn-default remove dlt-btn" data-type="<?php if(strtolower($_SESSION[dealer_owner])=="axis"){ echo "OPTIONS";}else{ echo "DELETE";}?>" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <span>Delete</span>
            </button>
</div><?php }?>
				
        {% } else { %}
				<div class="success-icon"><i class="fa fa-check" data-unicode="f00c"></i></div>
					
				
			<?php if($ImageUpdateStatus>1 && $isImageUpdateAllowed!=1)
				{
				?>
				<div class="rotate-icon" rel="{%=file.thumbnail_url%}"><i class="fa fa-repeat" data-unicode="f01e"></i></div>
				<?php }?>
                <a href="javascript:void(0)" title="{%=file.name%}"  download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
				<!--<div class="number rec_{%=i%}">{%=i%}</div>-->

				<?php if($ImageUpdateStatus>1 && $isImageUpdateAllowed!=1){?><div class="delete changedelete">   <button class="btn btn-danger remove dlt-btn" data-type="<?php if(strtolower($_SESSION[dealer_owner])=="axis"){ echo "OPTIONS";}else{ echo "DELETE";}?>" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>

				<span>Delete</span>
            </button>
</div><?php }?>
				 {% } %}     
    </li>
{%  } %}

                
</script>
<script> 
function getImageUploadedCount()
{
    var count_li=0;//SET INITIAL IMAGE COUNT TO 0
    
    $("#testing li").each(function(){
      //GET THE CLASS OF EACH IMAGE li
      var li_class=$(this).attr('class');
      //IF IMAGE IS VALID THEN COUNT THE IMAGE
      if(li_class==='template-download fade')
      {
          count_li++;
      }
    });
    var msg = '';
    if(count_li<=15){
        msg = count_li<=1?' of 15 Photo Uploaded':' of 15 Photos Uploaded';
    }
    else{
        msg= ' Photos Uploaded';
    }
    
    
    $('#count').html(count_li+msg); 
      
}
setInterval(getImageUploadedCount, 500);
                           
                        </script>
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery-ui.min.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?=base_url()?>assets/imageuploader_new/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?=base_url()?>assets/imageuploader_new/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?=base_url()?>assets/imageuploader_new/js/canvas-to-blob.min.js"></script>
<!-- jQuery Image Gallery -->
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery.image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<?php /*if($dealerType!='1'){?>
<script src="<?=base_url()?>imageuploader_new/js/jquery.fileupload-ui.js?343243244"></script>

<?php } else { */?>
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery.fileupload-ui1.js?3243243244"></script>
<?php //} ?>
<!-- The File Upload jQuery UI plugin -->
<script src="<?=base_url()?>assets/imageuploader_new/js/jquery.fileupload-jui.js"></script>
<!-- The main application script -->

<?php /* if($ie!='1'){?>
<script src="<?=base_url()?>imageuploader_new/js/main.js"></script>
<?php } else {?>
<script src="<?=base_url()?>imageuploader_new/js/main1.js"></script>
<?php //}*/ ?>
<script src="<?=base_url()?>assets/imageuploader_new/js/main.js"></script>

<script>
jQuery(document).ready(function(){
$("#testing").on('click', function(){ //enables click event
 $("#testing").attr('disabled','disabled');
 //$("#testing").removeClass("files");
});



window.parent.$('#savedetail').show();	
window.parent.$('#Preview').show();
	jQuery('.files').click(function(event){
	<?php if($ImageUpdateStatus>1 && $isImageUpdateAllowed!=1)
	{
	?>
	if(event.target.nodeName.toLowerCase()=='ul')
		{
			jQuery('#files').trigger('click');
		}	
		<?php }?>
	})
	jQuery('.rotate-icon').click(function(){
		alert('Bye');
	})
//alert('Test');
	$(".setprofile").click(function(){
		
		var value=$('input:radio[name=profileimage]:checked').val();
		if(value!=undefined)
		{
			$.ajax({
				type: "POST",
				url: "ajax/setprofile.php?value="+value,
				data: "",
				dataType:"html",
					 beforeSend: function () {
					
				},
				success:function (responseData, status, XMLHttpRequest) { 
					
				alert('Profile Image reflect in system after 10 minutes');
				
				}

			})
		}	
	})
})
</script>
