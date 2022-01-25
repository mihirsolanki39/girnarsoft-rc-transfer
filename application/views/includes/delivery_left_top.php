<?php //echo "<PRE>";print_r($orderinfo); exit;
$urlExplode = explode('/', current_url());
$url = !empty($urlExplode[3]) ? ($urlExplode[3]) : '';
?>
<section class="all_details sticky">
	<div class="container-fluid">
		<div class="row">
			<div class="col-dc <?php echo (!empty($orderinfo['customer_name'])) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">Customer Details</h3>
				<div class="sub-value">
					<ul class="sub-value-list">
						<?php echo (!empty($orderinfo['customer_name'])) ? '<li>' . $orderinfo['customer_name'] . '</li>' : '<li>NA</li>'; ?>
						<?php echo (!empty($orderinfo['customer_mobile_no'])) ? '<li>' . $orderinfo['customer_mobile_no'] . '</li>' : ''; ?>
					</ul>
				</div>
			</div>
			<div class="col-dc <?php echo (!empty($orderinfo['makeName'])) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">Car details</h3>
				<div class="sub-value">
					<ul class="sub-value-list">
						<?php
						$mk = !empty($orderinfo['parentmakeName']) ? $orderinfo['parentmakeName'] : $orderinfo['makeName'];
						$md = !empty($orderinfo['parentmodelName']) ? $orderinfo['parentmodelName'] : $orderinfo['modelName'];
						if (!empty($orderinfo['makeName'])) {
							if (!empty($orderinfo['makeName'])) {
								echo '<li>' . $mk;
							}
							if (!empty($orderinfo['modelName'])) {
								echo ' ' . $md;
							}
							if (!empty($orderinfo['versionName'])) {
								echo ' ' . $orderinfo['versionName'] . '</li>';
							}
						?>
						<?php //if(!empty($orderinfo['regNo'])) { echo ' . '. strtoupper($orderinfo['regNo']); }
						} else {
							echo '<li>NA</li>';
						}
						?>
				</div>
			</div>
			<div class="col-dc <?php echo (!empty($orderinfo['organization'])) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">Showroom Details</h3>
				<div class="sub-value">
					<ul class="sub-value-list">
						<?php echo (!empty($orderinfo['organization'])) ? '<li>' . $orderinfo['organization'] . '</li>' : '<li>NA</li>'; ?>
					</ul>
				</div>
			</div>
			<div class="col-dc <?php echo (!empty($orderinfo['do_amt'])) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">Net DO amount</h3>
				<div class="sub-value">
					<ul class="sub-value-list">

						<?php echo (!empty($orderinfo['net_do_amt'])) ? '<li> <i class="fa fa-rupee"></i> ' . $orderinfo['net_do_amt'] . '</li>' : '<li>NA</li>'; ?>

					</ul>
				</div>
			</div>
			<?php if (!empty($orderinfo['deliverySource'])) {
				if (empty($orderinfo['cancel_id'])) { ?>
					<a class="pull-right" id="idexportpdf" style="padding-right: 30px;padding-top: 22px;">
						<button title="generate do" onclick="renderpdfdo(<?php echo $orderinfo['orderId'] ?>,<?php echo DEALER_ID ?>);" class="btn btn-default">GENERATE DO</button>
					</a>
				<? } ?>
				<a class="pull-right" id="canceldo" style="padding-right: 30px;padding-top: 22px;">
					<button title="Cancel Do" <?php if ($orderinfo['cancel_id'] == 0) { ?>onclick="cancelDo(<?php echo $orderinfo['orderId'] ?>,<?php echo DEALER_ID ?>);" <? } ?> class="btn btn-default"><?= (!empty($orderinfo['cancel_id']) ? 'Marked As Cancelled' : 'Cancel DO') ?></button>
				</a>
			<?php } ?>
		</div>

	</div>
</section>
<div class="row mrg-all-0">
	<div class="col-crm-left sidenav sidebar-ins" id="sidebar">
		<ul class="par-ul">
			<li class="side_nav"><a href="<?= !empty($orderinfo["deliverySource"]) ? base_url('loanDoInfo/') . base64_encode('OrderId_' . $orderinfo["orderId"]) : '#' ?>" class="sidenav-a <?= !empty($orderinfo["deliverySource"]) ? 'completed' : 'active' ?>">
					<span class="img-type"></span>DO Information</a>
			</li>
			<!-- <li class="side_nav"><a href="<?= !empty($orderinfo["deliverySource"]) ? base_url('loanReceiptDetail/') . base64_encode('OrderId_' . $orderinfo["orderId"]) : '#' ?>" class="sidenav-a <?= !empty($orderinfo["paymentBy"]) ? 'completed' : ((isset($url) && ($url == 'loanReceiptDetail')) ? 'active' : '#') ?>">  
                  <span class="img-type"></span>Receipt Details</a>
               </li>-->
			<li class="side_nav"><a href="<?= !empty($orderinfo["deliverySource"]) ? base_url('dopayment/') . base64_encode('OrderId_' . $orderinfo["orderId"]) : '#' ?>" class="sidenav-a <?= !empty($orderinfo["payment_by"]) ? 'completed' : ((isset($url) && ($url == 'dopayment')) ? 'active' : '#') ?>">
					<span class="img-type"></span>Do Payment</a>
			</li>
		</ul>
	</div>
	<div class="col-crm-right">
		<div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url() ?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
		<div class="loaderoverlay loaderClas"></div>
		<script>
			$('.loaderClas').attr('style', 'display:none;');

			function cancelDo(orderid) {

				$('#cancel_do').attr('style', 'display:block;');
				$('#cancel_do').addClass(' in');
				$('#do_id').val(orderid);
			}

			function closeDoModel() {
				// alert('ddd');
				$('#cancel_do').attr('style', 'display:none;');
				$('#cancel_do').removeClass(' in');
			}
		</script>
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
		<script src="<?= base_url('assets/admin_assets/js/order_lead.js') ?>"></script>