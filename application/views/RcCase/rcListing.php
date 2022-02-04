<style>
	.used__car-reset-btn {
		background: #fff;
		border: 1px solid #e77842;
		padding: 8px 20px;
		border-radius: 2px;
		height: 40px;
		line-height: 24px;
		display: inline-block;
	}

	.used__car-advancesrch {
		color: #e77842;
		text-transform: uppercase;
		position: absolute;
		cursor: pointer;
		display: block;
		font-size: 13px;
		margin-top: 4px;
		margin-left: 15px;
	}

	#buyer-lead label {
		color: #000000;
		opacity: 0.87;
		font-size: 14px !important;
		margin-bottom: 0px;
	}
</style>
<div id="content" class="row">
	<style type="text/css">
		.dot-sep {
			content: "";
			height: 4px;
			width: 4px;
			background: rgba(0, 0, 0, 0.3);
			border-radius: 15px;
			display: inline-block;
			margin: 3px 7px;
		}
	</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="cont-spc pad-all-20 pad-B30" id="buyer-lead">
					<form role="form" name="searchform" id="searchform">
						<div class="row advnce">
							<div class="col-md-2 pad-R0">
								<label for="" class="crm-label">Search By</label>
								<div class="select-box" style="width:80px">Select <span class="d-arrow d-arrow-new"></span></div>
								<ul class="drop-menu">
									<li><a href="javascript:" onclick="searchby(this)" id="searchsno">S.No</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchrefid">Loan reference id</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchloanno">Disbursed Loan No</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchcustname">Customer name</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchmobile">Mobile number</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchrto">RTO Slip No</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchreg">Reg No</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchbank">Bank Name</a></li>
									<li><a href="javascript:" onclick="searchby(this)" id="searchrtoagent">RTO Agent</a></li>

								</ul>
								<!-- /btn-group -->
								<div id="dropD">
									<input type="text" name="keyword" id="keyword" style="display:block!important" class="form-control crm-form drop-form abc2" readonly="readonly">
									<select name="searchbyvalbank" id="searchbyvalbank" class="form-control crm-form drop-form abc3" style="display: none; width:170px">
										<option value="">Select Bank</option>
									</select>
									<select class="form-control crm-form drop-form" name="agentrto" id="agentrto" style="display: none; width:111px">
										<option value="">Select</option>
										<?php foreach ($rtoList as $key => $value) { ?>
											<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
										<?php } ?>
									</select>
								</div>
								<input type="hidden" name="searchby" id="searchby" value="">
							</div>

							<div class="col-md-4">
								<div class="row">

									<div class="col-md-5 pad-R0">
										<label for="" class="crm-label">RC to be Transferred by</label>
										<select class="form-control crm-form testselect1" name="pending" id="pending">
											<option value="">Select</option>
											<option value="2">Self</option>
											<option value="1">Dealer</option>
										</select>
									</div>
									<div class="col-md-3 pad-R0">
										<label for="" class="crm-label">RC Status</label>
										<select class="form-control crm-form testselect1" name="rcStatus" id="rcStatus">
											<option selected="selected" value="">Select</option>
											<option value="1">Pending</option>
											<option value="2">In Process</option>
											<option value="3">Transferred</option>
										</select>
									</div>

									<div class="col-md-4 pad-R0">
										<label for="" class="crm-label">Payment Status</label>
										<select class="form-control crm-form testselect1" name="paymentStatus" id="paymentStatus">
											<option selected="selected" value="">Select</option>
											<option value="1">Pending</option>
											<option value="2">Paid</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4 pad-R0">
								<label class="crm-label">Date Type</label>
								<div class="row">
									<div class="col-md-3 pad-R0">
										<div class="select-box">Select <span class="d-arrow d-arrow-new"></span></div>
										<ul class="drop-menu drop-menu-1">
											<li><a href="#" onclick="searchby('',this)" id="deliverydate">Delivery date</a></li>
											<li><a href="#" onclick="searchby('',this)" id="transferredon">Transferred On</a></li>
											<li><a href="#" onclick="searchby('',this)" id="disbursedate">Disbursement Date</a></li>
										</ul>
									</div>
									<div class="col-md-4 new_lead pad-all-0 ">
										<input type="hidden" name="searchdate" id="searchdate" value="">
										<div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
											<input type="text" name="createStartDate" id="createStartDate" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From">
										</div>
									</div>
									<div class="col-md-4 new_lead pad-all-0 ">
										<div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
											<input type="text" name="createEndDate" id="createEndDate" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2 pad-R0 pad-L0">
								<span id="spnsearch">
									<input type="button" class="btn-save btn-save-new" value="Search" id="search">
									<a href="JavaScript:Void(0)" id="Reset" class="used__car-reset-btn">RESET</a>
									<input type="hidden" name="page" id="page" value="1">
									<input type="hidden" name="rc_id" id="rcdashId" value="<?php echo (!empty($rcId)) ? $rcId : ''; ?>">
									<span class="used__car-advancesrch">Advance Search <i class="fa fa-angle-down down-i"></i></span>
								</span>
							</div>
							<div class="mrg-T10" id="toggal_rc_filter" style="display: none">
								<div class="col-md-2 pad-R0 mrg-T10">
									<label for="" class="crm-label">Dealer Name</label>
									<select name="searchbyvaldealer" id="dealer_search" class="form-control crm-form testselect1">
										<option value="">Select Dealer Name</option>
										<?php
										foreach ($dealerlist as $dkey => $dval) {
											echo "<option value='" . $dval['id'] . "'>" . $dval['organization'] . "</option>";
										} ?>
									</select>
								</div>
								<div class="col-md-2 pad-R0 mrg-T10">
									<label for="" class="crm-label">Loan Case Type</label>
									<select class="form-control crm-form testselect1" name="casestatus" id="casestatus">
										<option value="">Select loan case type</option>
										<option value="3">Used Car Purchase</option>
										<option value="1">Used Car Refinance</option>
									</select>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid mrg-T20">
		<div class="row">
			<div class="col-md-12">
				<div class="background-ef-tab" id="loandetails">
					<div class="tabs loandetails">
						<div class="row pad-all-20">
							<div class="col-md-6">
								<h5 class=" font-20 col-black" style="line-height: 40px">RC Cases <span id="total_count"></span></h5>
							</div>
							<div class="col-md-6" style="text-align: right">
								<a href="<?= base_url() ?>rc_make_payment"> <input type="button" class="btn-save btn-save-new mrg-T0 mrg-R0" value="Make Payment" id="makepayment"></a>
							</div>
						</div>
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active tabn" id="finalized">
								<div class="container-fluid ">
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="row">
												<div class="table-responsive">
													<table class="table table-bordered font-13 table-hover enquiry-table mytbl">
														<thead>
															<tr>
																<th width="5%">S.No.</th>
																<th width="10%">Customer Details</th>
																<th width="18%">Car Details</th>
																<th width="20%">Loan Details</th>
																<th width="15%">Case Details</th>
																<th width="20%">RC Status</th>
																<th width="17%">Payment Status</th>
																<th width="10%">Action</th>
															</tr>
														</thead>
														<tbody id="buyer_list">
															<?php if (!empty($query['leads'])) {
																//echo count($query['leads']); exit;
																//$link='';

																foreach ($query['leads'] as $key => $val) {
																	$link = '';
																	if ((!empty($val["rc_status"]) && ($val["rc_status"] == '1'))) {
																		$link = (!empty($val["rcId"])) ? base_url('rcDetail/') . base64_encode('RcId_' . $val["rcId"]) : '';
																	} else if ((!empty($val["rc_status"]) && ($val["rc_status"] >= '2')) && ($val["pending_from"] == '2')) {
																		$link = (!empty($val["rcId"])) ? base_url('uploadRcDocs/') . base64_encode('RcId_' . $val["rcId"]) : '';
																	} else if ((($val["pending_from"] == '1') || ($val["rc_status"] == '3'))) {
																		$link = (!empty($val["rcId"])) ? base_url('uploadRcDocs/') . base64_encode('RcId_' . $val["rcId"]) . '/transferred' : '';
																	}
																	//echo $link;

															?>
																	<tr class="hover-section">
																		<td style="position:relative">
																			<div class="mrg-B5"><b><?php echo (($val['rcId'] != '') ? ucwords(strtolower($val['rcId'])) : 'NA'); ?></b></div>
																		</td>
																		<td style="position:relative">
																			<div class="mrg-B5"><b><?php echo (($val['customer_name'] != '') ? ucwords(strtolower($val['customer_name'])) : 'NA'); ?></b></div>
																			<div class="font-13 text-gray-customer"><span class="font-13"><?php echo $val['customer_mobile']; ?></span></div>
																		</td>
																		<td style="position:relative">
																			<?php if (!empty($val['parent_makeName'])) { ?>
																				<div class="mrg-B5"><b><?php echo (!empty($val['parent_makeName'])) ? $val['parent_makeName'] . ' ' . $val['parent_modelName'] . ' ' . $val['versionName'] : '' ?></b></div>

																			<?php } else if (!empty($val['makeName'])) { ?>
																				<div class="mrg-B5"><b><?php echo (!empty($val['makeName'])) ? $val['makeName'] . ' ' . $val['modelName'] . ' ' . $val['versionName'] : '' ?></b></div>

																			<?php } ?>
																			<div class="font-13 text-gray-customer"><span class="font-13"><?php echo ($val['regNo']) ? strtoupper($val['regNo']) : ''; ?> <span class="dot-sep"></span> <?php echo ($val['reg_year']) ? $val['reg_year'] : ''; ?> Model</span></div>
																			<?php if (!empty($val['delivery_date'])) { ?>
																				<div class="font-13 text-gray-customer"><span class="font-13">Delivered On - <?= $val['delivery_date']; ?></span></div>
																			<?php } ?>
																		</td>
																		<td style="position:relative">
																			<?php
																			if ($val['buyer_case_id'] > 0) {
																			?>
																				<div class="mrg-B5"><b>Cash Purchase</b></div>
																				<div class="font-13 text-gray-customer"><span class="font-13"><?php echo (!empty($val['created_date'])) ? 'Purchased On - ' . $val['created_date'] : ''; ?></span></div>
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
																				<div class="font-13 text-gray-customer"><span class="font-13"><?php echo (!empty($val['bank_name'])) ? 'Bank Name - ' . $val['bank_name'] : ''; ?></span></div>
																				<div class="font-13 text-gray-customer"><span class="font-13"><?php echo (!empty($loanCaseType)) ? 'Loan Case Type - ' . $loanCaseType : ''; ?></span></div>
																				<div class="font-13 text-gray-customer"><span class="font-13"><?php echo (!empty($val['loan_disbursement_date'])) ? 'Disbursement Date - ' . $val['loan_disbursement_date'] : ''; ?></span></div>
																				<div class="font-13 text-gray-customer"><span class="font-13"><?php echo (!empty($val['loan_delivery_date'])) ? 'Delivery Date - ' . $val['loan_delivery_date'] : ''; ?></span></div>
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
																			?>
																			<div class="font-13 text-gray-customer"><b><?php echo (!empty($source_type)) ? 'Source - ' . $source_type : ''; ?></b></div>
																			<div class="font-13 text-gray-customer"><?php
																													if ($val['source_type'] == '1') {
																														echo (!empty($val['dealername'])) ? 'Dealer Name - ' . ucfirst($val['dealername']) : '';
																													}  ?></div>
																			<div class="font-13 text-gray-customer"><?php
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
																			<div class="font-13 text-gray-customer"><?php echo (!empty($pending_from)) ? 'Pending From - ' . $pending_from : ((!empty($val['tranferred_date'])) ? 'Transferred On - ' . $val['tranferred_date'] : ''); ?></div>
																			<div class="font-13 text-gray-customer"><?php
																													if ($pending_from == 'Self') {
																														echo (!empty($val['rto_agent'])) ? 'Assigned To - ' . ucfirst($val['rtoName']) : '';
																													} ?></div>
																			<div class="font-13 text-gray-customer"><?php if ($pending_from == 'Self') {
																														echo (($val['assigned_on']) && ($val['rc_status'] != '3')) ? 'Assigned On - ' . $val['assigned_on'] : '';
																													} ?></div>
																			<div class="font-13 text-gray-customer"><span class="font-13"><?php echo (!empty($val['rto_slip_no'])) ? 'RTO Slip No - ' . $val['rto_slip_no'] : ''; ?></span></div>
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
																			if (!empty($val['rcpayid'])) {
																				$rcpay_status = "Paid";
																			}
																			?>
																			<div class="mrg-B5"><b><?= ($val['pending_from'] == '1') ? "Not Applicable" : "Status - " . $rcpay_status ?></b></div>
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
																<?php } ?>
																<td colspan="8" style="text-align: center !important;">
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
																						//this will print pages which will come after current page
																						for ($i = intval($page) + 1; $i <= $total_pages; $i++) {
																							//$pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='pagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 
																							$pagLink .= "<li onclick='pagination(" . $i . ");' ><a href='#'>" . $i . "</a></li>";
																							if ($i >= $page + 3) {
																								break;
																							}
																						}
																						// this is for next button
																						if ($page != $total_pages) {
																							$nextPage = (int)$page + 1;
																							$pagLink .= '<li onclick="pagination(' . $nextPage . ');"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
																						}
																					}
																					echo $pagLink;
																					?>
																				</ul>
																			</nav>
																		</div>
																	<?php } ?>
																</td><?php } else { ?>

																<span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
																	<img src="<?= base_url('assets/admin_assets/images/loader.gif') ?>">
																</span>
															<?php } ?>

														</tbody>
													</table>
												</div>
												<div id="loadmoreajaxloader" style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">

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
	</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>
<script src="<?= base_url('assets/admin_assets/js/rc_list.js') ?>"></script>
<script>
	$('.testselect1').SumoSelect({
		triggerChangeCombined: true,
		search: true,
		searchText: 'Search here.'
	});
	var date = new Date();
	var d = new Date();
	d.setDate(date.getDate());
	$(document).ready(function() {
		var date = new Date();
		var d = new Date();
		d.setDate(date.getDate());
		var dates = $('#daterange_to').val();
		$("#createStartDate").datepicker({
			format: 'dd-mm-yyyy',
			endDate: d,
			autoclose: true,
		}).on('changeDate', function(selected) {
			var startDate = new Date(selected.date.valueOf());
			$('#createEndDate').datepicker('setStartDate', startDate);
		}).on('clearDate', function(selected) {
			$('#createEndDate').datepicker('setStartDate', null);
		});
		$("#createEndDate ").datepicker({
			format: 'dd-mm-yyyy',
			endDate: d
		});
	});
	$(document).ready(function() {
		$('body').on('click', function() {
			$('.drop-menu').hide();
		});
		$('.select-box').click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).next().show();
		});
		$('.drop-menu li a').click(function() {
			var getText = $(this).text();
			$(this).parents('.drop-menu').prev().html(getText + '<span class="d-arrow d-arrow-new"></span>');
		});
	});
	$(".abc1").change(function() {
		var va = $(".abc1").val();
		$('#searchbyval').val(va);
	});

	function pagination(page) {
		$("#page").val(page);
		$("#dlist").html('');
		var start = $('#page').val();
		start++;
		$.ajax({
			url: base_url + "RcCase/ajax_getrc/3",
			type: 'post',
			dataType: 'html',
			data: $("#searchform").serialize(),
			success: function(responseData, status, XMLHttpRequest) {
				var html = $.trim(responseData);
				$('#page').attr('value', start);
				$('#buyer_list').html(html);
				$(window).scrollTop(0);
				footerBottom();
			}
		});
	}
	$('#total_count').text('(' + "<?= $total_count ?>" + ')');
	$(document).on('click', '#Reset', function(ev) {
		location.reload(true);
	});
	$('#keyword').keypress(function(event) {
		// / alert('hi');
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') {
			$('#search').trigger('click');
		}
	});


	$(".used__car-advancesrch").click(function() {
		$("#toggal_rc_filter").toggle();
		//$(this).parents(".advnce").next().toggleClass("hidden");
		$(this).find('i').toggleClass("fa-angle-down fa-angle-up");
	});
</script>
