<?php //echo "<PRE>";print_r($getRcDetail);
$urlExplode = explode('/', current_url());
if (APPLICATION_ENV == 'local') {
	$url = !empty($urlExplode[3]) ? ($urlExplode[3]) : '';
	$urls =  !empty($urlExplode[5]) ? ($urlExplode[5]) : '';
} else {
	$url = !empty($urlExplode[4]) ? ($urlExplode[4]) : '';
	$urls =  !empty($urlExplode[6]) ? ($urlExplode[6]) : '';
}
$abc = '';
if (($getRcDetail['pending_from'] == '1')) {
	$abc = '1';
}

$make = !empty($getRcDetail['parent_makeName']) ? $getRcDetail['parent_makeName'] : $getRcDetail['make'];
$model = !empty($getRcDetail['parent_modelName']) ? $getRcDetail['parent_modelName'] : $getRcDetail['model'];

?>
<section class="all_details sticky">
	<div class="container-fluid">
		<div class="row">
			<div class="col-dc <?php echo (!empty($getRcDetail['customer_name'])) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">Customer Details</h3>
				<ul class="sub-value-list">
					<li> <?php echo (!empty($getRcDetail['customer_name'])) ? $getRcDetail['customer_name'] : 'NA'; ?>
					</li>
					<li><?php echo (!empty($getRcDetail['customer_mobile'])) ? $getRcDetail['customer_mobile'] : 'NA'; ?></li>
				</ul>
			</div>
			<div class="col-dc <?php echo (!empty($make)) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">Car details</h3>
				<ul class="sub-value-list">
					<li><?php if (!empty($make)) {
							echo $make;
						}
						if (!empty($model)) {
							echo ' ' . $model;
						}
						if (!empty($getRcDetail['version'])) {
							echo ' ' . $getRcDetail['version'];
						} ?></li>
					<?php if (!empty($getRcDetail['reg_no'])) {
						echo '<li>' . strtoupper($getRcDetail['reg_no']) . '</li>';
					} ?>

				</ul>
			</div>
			<div class="col-dc <?php echo (!empty($getRcDetail['rc_status'])) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">RC Status</h3>
				<ul class="sub-value-list">
					<li> <?php if (!empty($getRcDetail['rc_status'])) {
								if ($getRcDetail['rc_status'] == '1') {
									echo "Pending";
								} else if ($getRcDetail['rc_status'] == '2') {
									echo "In-Process";
								} else {
									echo "Transferred";
								}
							} ?>
					</li>
				</ul>
			</div>

			<div class="col-dc <?php echo (!empty($getRcDetail['pending_from'])) ? 'col-dc-width-auto' : ''; ?>">
				<h3 class="subheading">RC to be Transferred by</h3>
				<ul class="sub-value-list">
					<li> <?php if (!empty($getRcDetail['pending_from'])) {
								if ($getRcDetail['pending_from'] == '1') {
									echo "Dealer";
								} else {
									echo "Self";
								}
							} ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<div class="row mrg-all-0">
	<div class="col-crm-left sidenav sidebar-ins" id="sidebar">
		<ul class="par-ul">
			<li class="side_nav"><a href="<?= !empty($getRcDetail["rc_detail_form_update"]) ? base_url('rcDetail/') . base64_encode('RcId_' . $getRcDetail["rcid"]) : '#' ?>" class="sidenav-a <?= (!empty($getRcDetail["rc_detail_form_update"]) && ($getRcDetail["rc_detail_form_update"] == '1')) ? 'completed' : ((isset($url) && ($url == 'rcDetail')) ? 'active' : '#') ?>">
					<span class="img-type"></span> RC Details</a>
			</li>
			<? if (empty($abc)) { ?>
				<li class="side_nav"><a href="<?= (!empty($getRcDetail["rc_detail_form_update"])) ? base_url('uploadRcDocs/') . base64_encode('RcId_' . $getRcDetail["rcid"]) : '#' ?>" class="sidenav-a  <?= (!empty($getRcDetail["upload_rc_docs"]) && $getRcDetail["upload_rc_docs"] == '1') ? 'completed' : 'active' ?> ">
						<span class="img-type"></span> RC Document</a>
				</li>
			<? } ?>
			<li class="side_nav"><a href="<?= (!empty($getRcDetail["rc_transferred_docs"])) ? base_url('uploadRcDocs/') . base64_encode('RcId_' . $getRcDetail["rcid"]) . '/transferred' : '#' ?>" class="sidenav-a <?= ((!empty($getRcDetail["rc_transferred_docs"]) && $getRcDetail["rc_transferred_docs"] == '1')) ? 'completed' : (!empty($urls) ? 'active' : '  ') ?>">
					<span class="img-type"></span> RC Transferred Docs</a>
			</li>

			<!--<li class="side_nav"><a href="<?= (!empty($getRcDetail["rc_detail_form_update"])) ? base_url('uploadRcDocs/') . base64_encode('RcId_' . $getRcDetail["rcid"]) . '/transferred' : '#' ?>" class="sidenav-a <?= ((!empty($getRcDetail["rc_transferred_docs"]) && $getRcDetail["rc_transferred_docs"] == '1')) ? 'completed' : (!empty($urls) ? 'active' : '  ') ?>">
                  <span class="img-type"></span> RC Transferred Docs</a>
               </li>-->
		</ul>
	</div>
	<div class="col-crm-right">
		<div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url() ?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
		<div class="loaderoverlay loaderClas"></div>
		<script>
			$('.loaderClas').attr('style', 'display:none;');
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