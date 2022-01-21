   <link href="<?php echo base_url(); ?>assets/css/imageviewer.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/common_new.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/dropzone_loan.css" rel="stylesheet">
   <?php
	//  echo "<pre>";print_r($CustomerInfo); die; 
	if (!empty($postd) && (!empty($disbural)) || (!empty($CustomerInfo['upload_dis_doc_flag']) == '1')) {
		$onclick = 'disbursement();';
		$href = '#disbursement';
		$onclicks = 'postd();';
		$hrefs = '#postd';
	} else if ((!empty($disbural)) || (!empty($CustomerInfo['upload_dis_doc_flag']) == '1')) {
		$onclick = 'disbursement();';
		$href = '#disbursement';
	} else {
		$href = '#';
		$onclick = 'return false;';
	}
	?>
   <div class="container-fluid">
   	<div class="row">
   		<div class="col-md-12 pad-LR-10 mrg-B40">
   			<h2 class="page-title">Upload Docs</h2>
   			<div class="white-section upload-docs">
   				<div class="row">
   					<div class="col-md-12">
   						<!-- Nav tabs -->
   						<div class="card">
   							<ul class="nav nav-tabs" role="tablist">
   								<li role="presentation" class="active"><a href="#login" onclick="login();" aria-controls="login" role="tab" data-toggle="tab">Login</a></li>
   								<li role="presentation"><a id="diss" href="<?= $href ?>" onclick="<?= $onclick ?>" aria-controls="disbursement" role="tab" data-toggle="tab">Disbursement</a></li>
   								<?php if ($CustomerInfo['loan_for'] == '1') { ?>
   									<li role="presentation"><a id="dpost" href="<?= $hrefs ?>" onclick="<?= $onclicks ?>" aria-controls="postd" role="tab" data-toggle="tab">Post Delivery Docs</a></li>
   								<?php } ?>
   							</ul>
   							<div class="tab-content">
   								<div role="tabpanel" class="tab-pane active" id="login">
   								</div>
   								<div role="tabpanel" class="tab-pane" id="disbursement">
   								</div>
   								<div role="tabpanel" class="tab-pane" id="postd">
   								</div>
   							</div>
   						</div>
   						<input type="hidden" name="cust_id" value="<?= (!empty($CustomerInfo['customer_id'])) ? $CustomerInfo['customer_id'] : '' ?>" id="cust_id">
   						<input type="hidden" name="cases_id" value="<?= (!empty($CustomerInfo['customer_loan_id'])) ? $CustomerInfo['customer_loan_id'] : '' ?>" id="cases_id">
   						<input type="hidden" name="disbre" id="disbre" value="<?= (!empty($disbural) ? $disbural : '') ?>">
   						<input type="hidden" name="d_post" id="d_post" value="<?= (!empty($postd) ? $postd : '') ?>">
   					</div>
   				</div>
   			</div>
   		</div>
   	</div>
   </div>
   <script src="<?= base_url('assets/js/dropzone_loan.js'); ?>"></script>
   <!--<script src="<//?php echo base_url(); ?>assets/js/sorting.js"></script>-->
   <script src="<?php echo base_url(); ?>assets/js/imageviewer.js"></script>
   <script>
   	$(document).ready(function() {
   		/*  $('body').on('click','.del-btns',function(){
         $(this).parents('.dz-preview').hide();
     });
*/
   		var disbre = $('#disbre').val();
   		var d_post = $('#d_post').val();
   		if ((disbre == '') && (d_post == '')) {
   			login();
   		} else if ((disbre == '1') && (d_post != '1')) {
   			$('#diss').trigger('click');
   			// disbursement();
   		}
   		if (d_post == '1') {
   			$('#dpost').trigger('click');
   			// disbursement();
   		}


   	});

   	function login() {
   		//  $('.loaderClas').attr('style','display:block;');   
   		var customer_id = $('#cust_id').val();
   		var cases_id = $('#cases_id').val();
   		$.ajax({
   			type: "POST",
   			url: "<?php echo base_url(); ?>" + "Finance/logindoc",
   			dataType: 'html',
   			data: {
   				customer_id: customer_id,
   				cases_id: cases_id
   			},
   			success: function(data) {
   				$('#postd').html('');
   				$('#disbursement').html('');
   				$('#login').html(data);
   				//$('.loaderClas').attr('style','display:none;');   
   			}
   		});
   	}

   	function disbursement() {
   		//  $('.loaderClas').attr('style','display:block;');   
   		var customer_id = $('#cust_id').val();
   		var cases_id = $('#cases_id').val();
   		$.ajax({
   			type: "POST",
   			url: "<?php echo base_url(); ?>" + "Finance/disbursedoc",
   			dataType: 'html',
   			data: {
   				customer_id: customer_id,
   				cases_id: cases_id
   			},
   			success: function(data) {
   				$('#postd').html('');
   				$('#login').html('');
   				$('#disbursement').html(data);
   				//$('.loaderClas').attr('style','display:none;');   

   			}
   		});
   	}

   	function postd() {
   		//  $('.loaderClas').attr('style','display:block;');   
   		var customer_id = $('#cust_id').val();
   		var cases_id = $('#cases_id').val();
   		$.ajax({
   			type: "POST",
   			url: "<?php echo base_url(); ?>" + "Finance/postdisbursedoc",
   			dataType: 'html',
   			data: {
   				customer_id: customer_id,
   				cases_id: cases_id
   			},
   			success: function(data) {
   				$('#login').html('');
   				$('#disbursement').html('');
   				$('#postd').html(data);
   				//$('.loaderClas').attr('style','display:none;');   

   			}
   		});
   	}
   </script>