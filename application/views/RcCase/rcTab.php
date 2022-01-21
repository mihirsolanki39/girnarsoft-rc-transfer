  <div id="content">
  	<style>
  		.process-step .btn:focus {
  			outline: none
  		}

  		.process {
  			display: table;
  			width: 70%;
  			position: relative;
  			margin-bottom: 20px
  		}

  		.process-row {
  			display: table-row
  		}

  		.process-step button[disabled] {
  			opacity: 1 !important;
  			filter: alpha(opacity=100) !important
  		}

  		.process-row:before {
  			top: 21px;
  			bottom: 0;
  			position: absolute;
  			content: " ";
  			width: 15%;
  			height: 2px;
  			border-bottom: 2px dashed #a0a0a0;
  			left: 28%;
  		}

  		.process-step {
  			display: table-cell;
  			text-align: left;
  			position: relative;
  			padding-left: 20px;
  		}

  		.process-step p {
  			margin-top: 4px
  		}

  		.btn-circle {
  			width: 40px;
  			height: 40px;
  			text-align: center;
  			font-size: 16px;
  			border-radius: 50%
  		}

  		.process-step .btn:focus {
  			border-radius: 50%;
  			background-color: #e86335 !important;
  			border: none;
  			padding: 8px;
  			text-align: center;
  			color: #fff !important;
  		}

  		.process-step .text-heading {
  			font-size: 20px;
  			display: inline-block;
  			vertical-align: sub;
  			margin-left: 10px
  		}

  		.process-step .btn {
  			padding: 8px;
  			background-color: #ffffff;
  			color: #ec6140;
  			border: 1px solid #ec6140;
  		}

  		#payout-total .bg-box {
  			background: #fff;
  			margin-top: 60px;
  			padding: 15px;
  		}

  		#payout-total .bg-box table {
  			border: none;
  		}

  		#payout-total .bg-box .table-bordered>tbody>tr>td {
  			border: none;
  			padding: 10px 0px;
  		}

  		#payout-total .bg-box .table-bordered>tbody>tr>td .cases {
  			font-size: 18px;
  			color: #000000;
  			opacity: 0.87;
  			padding: 0px
  		}

  		#payout-total .bg-box .table-bordered>tbody>tr>td .cases1 {
  			font-size: 18px;
  			color: #000000;
  			opacity: 0.87;
  			text-align: right
  		}

  		#payout-total .table-hover>tbody>tr:nth-child(even):hover,
  		#payout-total .table-hover>tbody>tr:nth-child(odd):hover {
  			background-color: #ffffff !important;
  		}

  		.mrg-B20 {
  			margin-bottom: 20px !important;
  		}

  		.spacers-t {
  			border-top: 1px solid #ddd;
  			padding: 10px 0px
  		}

  		.netpayout-t td {
  			color: #000000;
  		}

  		#payoutTable .arrow-details {
  			display: block;
  			margin-bottom: 10px;
  			text-transform: none;
  			padding: 0px 7px 2px;
  		}

  		.nav-tabs>li.active>a {
  			background: transparent !important;
  		}

  		.nav-tabs>li a:hover {
  			background: transparent !important;
  		}

  		.nav-tabs>li>a {
  			color: #444;
  			border: 0px;
  		}
  	</style>
  	<?php $source = !empty($source) ? $source : 3; ?>
  	<style type="text/css">
  		.loaderoverlay {
  			position: fixed;
  			left: 0;
  			right: 0;
  			top: 0;
  			bottom: 0;
  			background: rgba(0, 0, 0, 0.5);
  			z-index: 999;
  		}

  		.loaderClas {
  			position: fixed;
  			left: 0;
  			top: 0;
  			right: 0;
  			bottom: 0;
  			margin: auto;
  			z-index: 9999;
  		}
  	</style>
  	<div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url() ?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
  	<div class="loaderoverlay loaderClas"></div>

  	<div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
  		<div class="content">
  			<div class="container-fluid">
  				<div class="row">
  					<h5 class="cases mrg-B20">RC Listing</h5>
  					<ul class="nav nav-tabs">
  						<li id="stock_list" class="rcoptions <?php if (intval($source) == 3) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;">RC Cases</a></li>
  						<li id="work_list" class="rcoptions <?php if (intval($source) == 4) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;">RC Payment</a></li>
  					</ul>
  					<div class="tab-content RcContent">
  						<div id="rc_case_div" class="tab-pane fade in active">
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
  <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
  <script src="<?= base_url('assets/admin_assets/js/rc_list.js') ?>"></script>
  <script type="text/javascript">
  	$('.loaderClas').attr('style', 'display:none;');
  	$(document).ready(function() {
  		var ttype = "<?= $source ?>";
  		getListHtml(ttype);
  	});
  	$('.rcoptions').on('click', function() {
  		$(".rcoptions").removeClass('active');
  		$(this).addClass('active');
  		if ($(this).attr('id') == 'stock_list') {
  			getListHtml(3);
  		} else if ($(this).attr('id') == 'work_list') {
  			getListHtml(4);
  		}
  	});

  	function getListHtml(source, pay_id = '') {
  		$('.loaderClas').show();
  		var rc_id = "<?= $type ?>";

  		$.ajax({
  			url: base_url + "RcCase/ajax_getrc",
  			type: 'post',
  			dataType: 'html',
  			data: {
  				'source': source,
  				keyword: pay_id,
  				searchby: 'searchpayid',
  				rc_id: rc_id
  			},
  			success: function(response) {
  				$("#rc_case_div").html(response);
  				$('.loaderClas').hide();
  				if (parseInt(source) == 1) {
  					$('#carStatus').SumoSelect();
  				}
  				if (pay_id != "") {
  					$("#keyword").val(pay_id);
  					$("#keyword").attr('readonly', false);
  					$("#payment_select").html("Payment Id");
  					$("#work_list").addClass("active");
  					$("#stock_list").removeClass("active")
  				}
  			}
  		});
  		// alert(pay_id);

  	}

  	function getPaymentHistory(pay_id) {
  		getListHtml('4', pay_id);
  	}

  	function searchList() {
  		$('#page').val('1');
  		$('.loaderClas').show();
  		var formDataSearch = $('#search_form').serialize();
  		$.ajax({
  			type: 'POST',
  			url: base_url + "RcCase/ajax_getrc/3",
  			data: formDataSearch,
  			dataType: 'html',
  			success: function(responseData, status, XMLHttpRequest) {
  				if (responseData == 1) {
  					$('#total_count').text('(' + "0" + ')');
  					$('#payment_listing').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
  				} else {
  					$('#imageloder').hide();
  					$('#payment_listing').html(responseData);
  				}
  				footerBottom();
  				$('.loaderClas').hide();
  			}
  		});
  	}
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>