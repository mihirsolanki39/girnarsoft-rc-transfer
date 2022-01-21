<?php
if (!empty($query['leads'])) {
	foreach ($query['leads'] as $key => $val) {
		$link = '';
		if ((!empty($val["rc_status"]) && ($val["rc_status"] == '1'))) {
			$link = (!empty($val["rcId"])) ? base_url('rcDetail/') . base64_encode('RcId_' . $val["rcId"]) : '';
		} else if ((!empty($val["rc_status"]) && ($val["rc_status"] >= '2')) || ($val["pending_from"] == '2')) {
			$link = (!empty($val["rcId"])) ? base_url('uploadRcDocs/') . base64_encode('RcId_' . $val["rcId"]) : '';
		} else if ((($val["pending_from"] == '1') || ($val["rc_status"] == '3'))) {
			$link = (!empty($val["rcId"])) ? base_url('uploadRcDocs/') . base64_encode('RcId_' . $val["rcId"]) . '/transferred' : '';
		}
		// echo $link; exit; 
?>
		<tr class="hover-section">
			<td style="position:relative">
				<div class="mrg-B5"><b><?php echo (($val['rcId'] != '') ? ucwords(strtolower($val['rcId'])) : 'NA'); ?></b></div>
			</td>
			<td style="position:relative">
				<div class="mrg-B5"><b><?php echo (($val['customer_name'] != '') ? ucwords(strtolower($val['customer_name'])) : 'NA'); ?></b></div>
				<div class="font-13 text-gray-customer"><span class="font-14"><?php echo $val['customer_mobile']; ?></span></div>
			</td>
			<td style="position:relative">
				<?php if (!empty($val['parent_makeName'])) { ?>
					<div class="mrg-B5"><b><?php echo (!empty($val['parent_makeName'])) ? $val['parent_makeName'] . ' ' . $val['parent_modelName'] . ' ' . $val['versionName'] : '' ?></b></div>

				<?php } else if (!empty($val['makeName'])) { ?>
					<div class="mrg-B5"><b><?php echo (!empty($val['makeName'])) ? $val['makeName'] . ' ' . $val['modelName'] . ' ' . $val['versionName'] : '' ?></b></div>

				<?php } ?>
				<div class="font-13 text-gray-customer"><span class="font-14"><?php echo ($val['regNo']) ? strtoupper($val['regNo']) : ''; ?> , <?php echo ($val['reg_year']) ? $val['reg_year'] : ''; ?> Model</span></div>
				<?php if (!empty($val['delivery_date'])) { ?>
					<div class="font-13 text-gray-customer"><span class="font-14">Delivered On - <?= $val['delivery_date']; ?></span></div>
				<?php } ?>
			</td>
			<td style="position:relative">
				<?php
				if ($val['buyer_case_id'] > 0) {
				?>
					<div class="mrg-B5"><b>Cash Purchase</b></div>
					<div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['created_date'])) ? 'Purchased On - ' . $val['created_date'] : ''; ?></span></div>
				<?php } else {
					$loanCaseType = '';
					if ($val['loan_case_type'] == '1') {

						$loanCaseType = 'Usedcar - Refinance';
					} else if ($val['loan_case_type'] == '3') {
						$loanCaseType = 'Usedcar - Purchase';
					}
				?>
					<div class="mrg-B5"><b><?php echo (!empty($val['loan_ref_id'])) ? 'Ref. Id - ' . $val['loan_ref_id'] : ''; ?></b></div>
					<div class="mrg-B5"><b><?php echo (!empty($val['loanno'])) ? 'Disbursed Loan No  - ' . $val['loanno'] : ''; ?></b></div>
					<div class="mrg-B5"><b><?php echo (!empty($val['loan_sno'])) ? 'Loan S.No - ' . $val['loan_sno'] : ''; ?></b></div>
					<div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['bank_name'])) ? 'Bank Name - ' . $val['bank_name'] : ''; ?></span></div>
					<div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($loanCaseType)) ? 'Loan Case Type - ' . $loanCaseType : ''; ?></span></div>
					<div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['loan_disbursement_date'])) ? 'Disbursement Date - ' . $val['loan_disbursement_date'] : ''; ?></span></div>
					<div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['loan_delivery_date'])) ? 'Delivery Date - ' . $val['loan_delivery_date'] : ''; ?></span></div>
				<?php } ?>
			</td>
			<td style="position:relative">
				<?php
				$source_type = '';
				if (($val['source_type'] == '2')) {
					$source_type = 'Inhouse';
				} else if (($val['source_type'] == '1')) {
					$source_type = 'Dealer';
				}
				//  echo $val['salesexe']
				?>

				<div class="font-14 text-gray-customer"><b><?php echo (!empty($source_type)) ? 'Source - ' . $source_type : ''; ?></b></div>
				<div class="font-14 text-gray-customer"><?php
														if ($val['source_type'] == '1') {
															echo (!empty($val['dealername'])) ? 'Dealer Name - ' . ucfirst($val['dealername']) : '';
														}  ?></div>
				<div class="font-14 text-gray-customer"><?php
														echo ((!empty($val['salesexe'])) && ($val['salesexe'] != 'admin')) ? 'Sales Executive - ' . ucfirst($val['salesexe']) : 'Sales Executive - Self';
														?></div>

			</td>
			<td style="position:relative">
				<?php
				$rc_status = '';
				if ($val['rc_status'] == '1') {
					$rc_status = 'Pending';
				} elseif ($val['rc_status'] == '2') {
					$rc_status = 'In-Process';
				} elseif ($val['rc_status'] == '3') {
					$rc_status = 'Transferred';
				}
				$pending_from = '';
				if (($val['pending_from'] == '2') && ($val['rc_status'] != '3')) {
					$pending_from = 'Self';
				} else if (($val['pending_from'] == '1') && ($val['rc_status'] != '3')) {
					$pending_from = 'Dealer';
				}
				?>
				<div class="mrg-B5"><b><?php echo (!empty($rc_status)) ? 'Status - ' . $rc_status : ''; ?></b></div>
				<div class="font-14 text-gray-customer"><?php echo (!empty($pending_from)) ? 'Pending From - ' . $pending_from : ((!empty($val['tranferred_date'])) ? 'Transferred On - ' . $val['tranferred_date'] : ''); ?></div>
				<div class="font-14 text-gray-customer"><?php
														if ($pending_from == 'Self') {
															echo (!empty($val['rto_agent'])) ? 'Assigned To - ' . ucfirst($val['rtoName']) : '';
														}  ?></div>
				<div class="font-14 text-gray-customer"><?php if ($pending_from == 'Self') {
															echo (($val['assigned_on']) && ($val['rc_status'] != '3')) ? 'Assigned On - ' . $val['assigned_on'] : '';
														} ?></div>
				<div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['rto_slip_no'])) ? 'RTO Slip No - ' . $val['rto_slip_no'] : ''; ?></span></div>
				<? if (($val['upload_rc_docs'] == '0') && ($val['rc_transferred_docs'] == '0')) { ?>
					<div class="arrow-details alert-btn">
						<span class="font-10">Documents pending</span>
					</div>
				<? } ?>
			</td>
			<td style="position:relative">
				<?php
				$rcpay_status = "Pending";
				$dateLable = $datetime = "";
				if (!empty($val['payment_rnd_id'])) {
					$rcpay_status = "Paid";
				}
				?>
				<div class="mrg-B5"><b>Status - <?= $rcpay_status ?></b></div>
				<?php if (!empty($val['payment_rnd_id'])) { ?>
					<div class="font-13 text-gray-customer"><span class="font-13" style="cursor: pointer;" onclick='getPaymentHistory("<?= $val['payment_rnd_id'] ?>")'>Payment ID - <?= $val['payment_rnd_id'] ?></span></div>
				<?php } ?>
			</td>
			<td style="position:relative">
				<a href="<?php echo $link; ?>"><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
				</br>
				<div class="mrg-T5"><a href="Javascript:void(0);" class="text-link font-13" id="comment_history"><button class="btn btn-default history-more" data-target="#trackrc" data-toggle="modal" data-id="<?php echo $val["rcId"]; ?>" title="timeline">TIMELINE</button></a></div>
			</td>
		</tr>
	<?php
	} ?>
	<td colspan="7" style="text-align: center !important;">
		<?php if (($total_count) > 0) { ?>
			<div class="col-lg-12 col-md-6">
				<nav aria-label="Page navigation">
					<ul class="pagination">
						<?php
						$total_pages = ceil($total_count / $limit);
						$pagLink = "";
						if ($total_pages < 1) {
							$total_pages = 1;
						}

						if ($total_pages != 1) {                                                                         //this is for previous button
							if (intval($page) > 1) {
								$prePage = intval($page) - 1;
								$pagLink .= '<li onclick="pagination(' . $prePage . ');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>';
								//this for loop will print pages which come before the current page
								for ($i = $page - 6; $i < $page; $i++) {
									if ($i > 0) {
										$pagLink .= "<li onclick='pagination(" . $i . ");'><a href='#'>" . $i . "</a></li>";
									}
								}
							}
							$pagLink .= "<li class='active' onclick='pagination(" . $i . ");'><a href='#'>" . $page . "</a></li>";
							for ($i = intval($page) + 1; $i <= $total_pages; $i++) {
								$pagLink .= "<li onclick='pagination(" . $i . ");' ><a href='#'>" . $i . "</a></li>";
								if ($i >= $page + 3) {
									break;
								}
							}
							if ($page != $total_pages) {
								$nextPage = (int)$page + 1;
								$pagLink .= '<li onclick="pagination(' . $nextPage . ');"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
							}
						}
						echo $pagLink;
						?> </ul>
				</nav>
			</div>
		<?php } ?>
	</td>
<?php } ?>
<?php if (empty($query['leads'])) {
	echo "<tr><td align='center' colspan='8'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
} ?>
<script>
	var $j = jQuery.noConflict();
	$(function() {

		//
		//$j(".case-followup-date").datetimepicker({timepicker: true, format: 'j M Y g:i a', constrainInput: true,minDate:0,defaultDate: new Date()});

	});
	$('#total_count').text('(' + "<?= $total_count ?>" + ')');
</script>
<style>
	.modal-dialog {
		width: 550px !important;
	}
</style>