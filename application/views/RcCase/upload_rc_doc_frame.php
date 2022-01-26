  <link href="<?php echo base_url(); ?>assets/css/imageviewer.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/common_new.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/dropzone_loan.css" rel="stylesheet">
  <?php
	$urlExplode = explode('/', current_url());
	
	if (APPLICATION_ENV == 'local') {
		$url = !empty($urlExplode[5]) ? ($urlExplode[5]) : '';
	} else {
		$url = !empty($urlExplode[6]) ? ($urlExplode[6]) : '';
	}
	if ((!empty($url)) || (!empty($CustomerInfo['rc_detail_form_update']) == '1')) {
		$onclick = 'rctransferred();';
		$href = '#rctransferred';
	} else {
		$href = '#';
		$onclick = 'return false;';
	}
	
	?>
  <div class="container-fluid">
  	<div class="row">
  		<div class="col-md-12 pad-LR-10 mrg-B40">
  			<h2 class="page-title">Upload RC Docs1</h2>
  			<div class="white-section upload-docs">
  				<div class="row">
  					<div class="col-md-12">
  						<!-- Nav tabs -->
  						<div class="card">

  							<ul class="nav nav-tabs" role="tablist">
  								<?php if (($getRcDetail['pending_from'] != '1')) { ?>
  									<li role="presentation" class="active"><a href="#login" onclick="login();" aria-controls="login" role="tab" data-toggle="tab">RC Docs</a></li>
  								<?php } ?>
  								<?php if ($href != '#') { ?>
  									<li role="presentation"><a id="diss" href="<?= $href ?>" onclick="<?= $onclick ?>" aria-controls="rctransferred" role="tab" data-toggle="tab">RC Transferred</a></li>
  								<?php } ?>
  							</ul>
  							<div class="tab-content">
  								<div role="tabpanel" class="tab-pane active" id="login"></div>
  								<?php if ($href != '#') { ?>
  									<div role="tabpanel" class="tab-pane" id="rctransferred"></div>
  								<?php } ?>
  							</div>
  						</div>
  						<input type="hidden" name="case_id" value="<?= (!empty($rcId)) ? $rcId : '' ?>" id="case_id">
  						<input type="hidden" name="rc_id" value="<?= (!empty($rcId)) ? $rcId : '' ?>" id="rc_id">
  					</div>

  					<div class="col-md-12">
  						<div class="btn-sec-width tag-btn-complete">
  							<?php
								$stylesss = 'display:block';
								$stylec = 'display:none';
								$action = '';
								?>
  							<a onclick="savelogindoc()" style="<?= $stylesss ?>" class="btn-continue saveCont final-submit">SAVE AND CONTINUE</a>

  							<a class="btn-continue" onclick="countinue('<?= $action ?>')" style="<?= $stylec ?>">CONTINUE</a>

  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
  </div>
  </div>
  </div>

  </div>
  <script src="<?= base_url('assets/js/dropzone_loan.js'); ?>"></script>
  <script src="<?php echo base_url(); ?>assets/js/sorting.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/imageviewer.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin_assets/js/rc_list.js"></script>
  <?php if ((!empty($url)) || (!empty($CustomerInfo['rc_detail_form_update']) == '1')) { ?>
  	<script>
  		$(document).ready(function() {
  			$('#diss').trigger('click');
  			//rctransferred();
  		});
  	</script>
  <?php } else { ?>
  	<script>
  		$(document).ready(function() {
  			login();
  		});
  	</script>
  <? } ?>

  <script>
  	function login() {
  		var customer_id = $('#rc_id').val();
  		$.ajax({
  			type: "POST",
  			url: "<?php echo base_url(); ?>" + "RcCase/logindoc",
  			dataType: 'html',
  			data: {
  				rc_id: customer_id
  			},
  			success: function(data) {
  				$('#rctransferred').html('');
  				$('#login').html(data);
  			}
  		});
  	}

  	function rctransferred() {
  		// alert('ddddd');
  		var customer_id = $('#rc_id').val();
  		$.ajax({
  			type: "POST",
  			url: "<?php echo base_url(); ?>" + "RcCase/rctransferreddoc",
  			dataType: 'html',
  			data: {
  				rc_id: customer_id
  			},
  			success: function(data) {
  				$('#login').html('');
  				$('#rctransferred').html(data);
  			}
  		});
  	}
  </script>