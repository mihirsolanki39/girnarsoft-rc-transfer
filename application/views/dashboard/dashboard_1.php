<?php
	// echo '1';
	// exit;
?>

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

			.pad-all-0 {
				padding: 0px;
			}

			ul#sidenav011 li {
				width: 100%
			}

			ul#sidenav011 li a {
				color: #000000;
			}

			ul#sidenav011 li .active {
				border-left: 2px solid #e46536;
			}

			#sidenav011 ul.nav.nav-list {
				padding: 0px 15px;
			}

			#sidenav011 ul.nav.nav-list li a {
				color: #000000;
				opacity: .87;
				font-size: 14px;
				border-bottom: 3px solid transparent !important;
			}

			.table-striped>tbody>tr:nth-of-type(odd) {
				background-color: #ffff;
			}

			.table-striped>tbody>tr:nth-of-type(even) {
				background-color: #ffff;
			}

			.left-menu .navbar-default {
				background-color: #ffffff;
				border-color: #e7e7e7;
			}

			.left-menu .navbar-nav li a:hover {
				color: #000000 !important;
				opacity: 0.87;
			}

			.left-menu .navbar-nav>li>a {
				padding-top: 10px;
				padding-bottom: 10px;
				margin: 0px 10px 0px 0px;
				border-bottom: 3px solid transparent !important;
			}

			.left-menu .navbar-nav>li>a {
				font-size: 14px;
			}

			#sidenav011 .nav>li>a:hover,
			.nav>li>a:focus {
				text-decoration: none;
				background-color: #ffffff;
				color: #e86335 !important;
			}

			.nav>li>a:hover,
			.nav>li>a:focus {
				text-decoration: none;
				background-color: #fff;
			}

			.nav-tabs {
				border-bottom: 0px solid #ddd;
			}

			.nav-tabs>li>a:hover {
				border-color: transparent;
			}

			ul#sidenav011 li .highclass a {
				color: #ed8156 !important;
				border: 0px solid #ed8156;
			}

			.col-black-t {
				color: #000000;
				opacity: 0.87;
				font-size: 22px
			}

			.col-yellow {
				color: #FBC100;
			}

			rect.highcharts-point.highcharts-color-0 {
				fill: #BFEB9F;
			}

			tspan {
				fill: #000000;
				opacity: .54;
			}

			.highcharts-container {
				width: 100% !important
			}

			.highcharts-root {
				width: 100% !important
			}

			#funnelchart {
				min-width: 360px;
				max-width: 600px;
				height: 400px;
				margin: 0 auto;
			}
		</style>
		<div class="navbar navbar-default" role="navigation">
			<div class="navbar-collapse collapse sidebar-navbar-collapse pad-all-0">
				<ul class="nav navbar-nav" id="sidenav011">
					<!--<li><a href="#" id="ins_1"  class="collapsed active" onclick="getdocpage(1)"> Insurance</a></li>-->
					<li>
						<a href="#" id="ins_1" onclick="getdocpage(1)" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav02" class="collapsed">
							Insurance
						</a>
					</li>
					<li>
						<a href="#" id="ins_2" onclick="getdocpage(2)" data-toggle="collapse" data-target="#toggleDemo2" data-parent="#sidenav01" class="collapsed">
							Loan
						</a>
					</li>

					<li><a href="#" id="ins_5" class="collapsed " onclick="getdocpage(5)">Stock</a></li>
					<li><a href="#" id="ins_6" class="collapsed " onclick="getdocpage(6)">RC Transfer</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>

	</div>
	<main class="main-body" id="mainId">
		<div class="container-fluid pad-all-0 bg-container-new mrg-T70" id="maincontainer">
			<div class="row">
				<div id="payment_stock_div" class="">
					<div class="col-lg-12 col-md-12 mrgBatM clearfix pad-R15 pad-L15" id="topSection">
						<h1 class="col-black-t">Pending Work</h1>
						<div class="col-md-12">
							<div class="row">
								<div class="background-efOne background-efTwo bgImgN mrg-T20">
									<div class="row">
										<div class="col-md-12">
											<div class="total-lead-recieved clearfix">
												<ul class="mrg-all-0 pad-all-0">
													<li class="pull-left font-16 col-black-o">Work in Progress</li>
												</ul>
											</div>
										</div>
										<div class=" col-md-12 total-lead-digit">
											<div class="row mrg-all-0">
												<div class="col-md-3 col-sm-3 col-xs-3 cus-col">
													<a href="javascript:void(0);">
														<p class="font-60 col-red"> <span id="purchaseamt">22</span></p>
														<p class="font-18 col-black-o">Active Cases</p>
													</a>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3 cus-col">
													<a href="javascript:void(0);">
														<p class="font-60 col-yellow"> <span id="amtPaid">0</span></p>
														<p class="font-18 col-black-o">Awating Login</p>
													</a>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3 cus-col">
													<a href="javascript:void(0);">
														<p class="font-60 col-yellow"> <span id="leftPaid">0</span></p>
														<p class="font-18 col-black-o">Awaiting Decision</p>
													</a>
												</div>


												<div class="col-md-3 col-sm-3 col-xs-3 cus-col">
													<a href="javascript:void(0);">
														<p class="font-60 col-yellow"> <span id="leftPaid">0</span></p>
														<p class="font-18 col-black-o">Awaiting Disbursal</p>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 pad-L0">
									<div class="">
										<div class="background-efOne background-efTwo bgImgN mrg-T20">
											<div class="row">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-12">
															<div class="total-lead-recieved clearfix">
																<ul class="mrg-all-0 pad-all-0">
																	<li class="pull-left font-16 col-black-o">Pending Activities Cases</li>
																</ul>
															</div>
														</div>
														<div class=" col-md-12 total-lead-digit">
															<div class="row mrg-all-0">
																<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																	<a href="javascript:void(0);">
																		<p class="font-60 col-red"> <span id="purchaseamt">22</span></p>
																		<p class="font-18 col-black-o">Document Upload</p>
																	</a>
																</div>
																<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																	<a href="javascript:void(0);">
																		<p class="font-60 col-yellow"> <span id="amtPaid">0</span></p>
																		<p class="font-18 col-black-o">Loan Payment</p>
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>


								<div class="col-md-6 pad-R0">
									<div class="">
										<div class="background-efOne background-efTwo bgImgN mrg-T20">
											<div class="row">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-12">
															<div class="total-lead-recieved clearfix">
																<ul class="mrg-all-0 pad-all-0">
																	<li class="pull-left font-16 col-black-o">Payout Pending Cases</li>
																</ul>
															</div>
														</div>
														<div class=" col-md-12 total-lead-digit">
															<div class="row mrg-all-0">
																<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																	<a href="javascript:void(0);">
																		<p class="font-60 col-red"> <span id="purchaseamt">25</span></p>
																		<p class="font-18 col-black-o">To Pay</p>
																	</a>
																</div>
																<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																	<a href="javascript:void(0);">
																		<p class="font-60 col-yellow"> <span id="amtPaid">0</span></p>
																		<p class="font-18 col-black-o">To Recieve </p>
																	</a>
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

							<div class="row">
								<div class="col-md-12 mrg-T20">
									<div class="row">
										<div class="col-md-6 pad-L0">
											<h1 class="col-black-t">Performance</h1>
										</div>
										<div class="col-md-6 pad-R0">
											<select class="form-control pull-right" style="width: auto;">
												<option>Last 6 Months</option>
												<option>Last 12 Months</option>
											</select>
										</div>
									</div>
								</div>



								<div class="row" id="box" style="top: 50px">

									<div class="col-md-6">
										<div class="">
											<div class="background-efOne background-efTwo bgImgN mrg-T20">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-12">
																<div class="total-lead-recieved clearfix">
																	<ul class="mrg-all-0 pad-all-0">
																		<li class="pull-left font-16 col-black-o">Disbursal Amount</li>
																	</ul>
																</div>
															</div>
															<div class=" col-md-12 total-lead-digit">
																<div class="row mrg-all-0">
																	<div class="col-md-12" id="chartdisbursal">

																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>


									<div class="col-md-6">
										<div class="">
											<div class="background-efOne background-efTwo bgImgN mrg-T20">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-12">
																<div class="total-lead-recieved clearfix">
																	<ul class="mrg-all-0 pad-all-0">
																		<li class="pull-left font-16 col-black-o">Cases Funnel</li>
																	</ul>
																</div>
															</div>
															<div class=" col-md-12 total-lead-digit">
																<div class="row mrg-all-0">
																	<div class="col-md-12" id="funnelchart">

																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>


									<div class="col-md-6">
										<div class="">
											<div class="background-efOne background-efTwo bgImgN mrg-T20">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-12">
																<div class="total-lead-recieved clearfix">
																	<ul class="mrg-all-0 pad-all-0">
																		<li class="pull-left font-16 col-black-o">Trend Chart</li>
																	</ul>
																</div>
															</div>
															<div class=" col-md-12 total-lead-digit">
																<div class="row mrg-all-0">
																	<div class="col-md-12" id="trendchart">

																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>


									<div class="col-md-6">
										<div class="">
											<div class="background-efOne background-efTwo bgImgN mrg-T20">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-12">
																<div class="total-lead-recieved clearfix">
																	<ul class="mrg-all-0 pad-all-0">
																		<li class="pull-left font-16 col-black-o">Disbursal Amount</li>
																	</ul>
																</div>
															</div>
															<div class=" col-md-12 total-lead-digit">
																<div class="row mrg-all-0">
																	<div class="col-md-12" id="amountdisbursal">

																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>




									<div class="col-md-6">
										<div class="">
											<div class="background-efOne background-efTwo bgImgN mrg-T20">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-12">
																<div class="total-lead-recieved clearfix">
																	<ul class="mrg-all-0 pad-all-0">
																		<li class="pull-left font-16 col-black-o">Payout Amount</li>
																	</ul>
																</div>
															</div>
															<div class=" col-md-12 total-lead-digit">
																<div class="row mrg-all-0">
																	<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																		<a href="javascript:void(0);">
																			<p class="font-60 col-red"> <span id="purchaseamt">25</span> <span class="font-24">cr.</span></p>
																			<p class="font-18 col-black-o">To Pay</p>
																		</a>
																	</div>
																	<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																		<a href="javascript:void(0);">
																			<p class="font-60 col-yellow"> <span id="amtPaid">110</span><span class="font-24">cr.</span></p>
																			<p class="font-18 col-black-o">To Recieve </p>
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="">
											<div class="background-efOne background-efTwo bgImgN mrg-T20">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-12">
																<div class="total-lead-recieved clearfix">
																	<ul class="mrg-all-0 pad-all-0">
																		<li class="pull-left font-16 col-black-o">Amount Reconcilliation</li>
																	</ul>
																</div>
															</div>
															<div class=" col-md-12 total-lead-digit">
																<div class="row mrg-all-0">
																	<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																		<a href="javascript:void(0);">
																			<p class="font-60 col-red"> <span id="purchaseamt">25</span> <span class="font-24">cr.</span></p>
																			<p class="font-18 col-black-o">To Pay</p>
																		</a>
																	</div>
																	<div class="col-md-6 col-sm-3 col-xs-3 cus-col">
																		<a href="javascript:void(0);">
																			<p class="font-60 col-yellow"> <span id="amtPaid">110</span><span class="font-24">cr.</span></p>
																			<p class="font-18 col-black-o">To Recieve </p>
																		</a>
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
				</div>
			</div>

		</div>
	</main>
	<span id="imageloder" style="display:none; position:absolute;left: 40%;border-radius: 50%;z-index:999; ">
		<img src="<?= base_url('assets/admin_assets/images/loader.gif') ?>">
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

<script type="text/javascript" src="http://dealercrm.com/assets/admin_assets/js/waterfall-light.js"></script>>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/funnel.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<script type="text/javascript">
	$('#box').waterfall({
		col: true,
		gridWidth: [600, 600]

	});

	Highcharts.chart('chartdisbursal', {
		chart: {
			zoomType: 'xy'
		},

		xAxis: [{
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
				'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
			],
			crosshair: true
		}],
		yAxis: [{ // Primary yAxis
			labels: {
				format: '{value}°C',
				style: {
					color: Highcharts.getOptions().colors[2]
				}
			},
			title: {
				text: 'Disbursal Amount',
				style: {
					color: Highcharts.getOptions().colors[2]
				}
			},
			opposite: true

		}, { // Secondary yAxis
			gridLineWidth: 0,
			title: {
				text: 'Disbursal Count',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			labels: {
				format: '{value}',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			}

		}],
		tooltip: {
			shared: true
		},
		exporting: {
			enabled: false
		},

		legend: {
			layout: 'vertical',
			align: 'left',
			x: 80,
			verticalAlign: 'top',
			y: 55,
			floating: true,
			backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || // theme
				'rgba(255,255,255,0.25)'
		},
		series: [{
			name: 'Disbursal Count',
			type: 'column',
			yAxis: 1,
			data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
			tooltip: {
				valueSuffix: ''
			}

		}, {
			name: 'Disbursal Amount',
			type: 'spline',
			data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
			tooltip: {
				valueSuffix: ''
			}
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						floating: false,
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom',
						x: 0,
						y: 0
					},
					yAxis: [{
						labels: {
							align: 'right',
							x: 0,
							y: -6
						},
						showLastLabel: false
					}, {
						labels: {
							align: 'left',
							x: 0,
							y: -6
						},
						showLastLabel: false
					}, {
						visible: false
					}]
				}
			}]
		}
	});
</script>

<script type="text/javascript">
	Highcharts.chart('funnelchart', {
		chart: {
			type: 'funnel'
		},
		//title: {
		//  text: 'Sales funnel'
		//},
		plotOptions: {
			series: {
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b> ({point.y:,.0f})',
					softConnector: true
				},
				center: ['40%', '50%'],
				neckWidth: '30%',
				neckHeight: '25%',
				width: '80%'
			}
		},
		legend: {
			enabled: false
		},

		exporting: {
			enabled: false
		},
		series: [{
			name: 'Unique users',
			data: [
				['Cases Added', 4000],
				['Filed', 3000],
				['Approved', 3000],
				['Disbursed', 2000]
			]
		}],

		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					plotOptions: {
						series: {
							dataLabels: {
								inside: true
							},
							center: ['50%', '50%'],
							width: '100%'
						}
					}
				}
			}]
		}
	});
</script>


<script type="text/javascript">
	Highcharts.chart('trendchart', {

		exporting: {
			enabled: false
		},

		// yAxis: {
		// title: {
		//    text: 'Number of Employees'
		//  }
		//},


		xAxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
		},
		//yAxis: {
		// title: {
		// text: 'Temperature (°C)'
		//   }
		//},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
		series: [{
				name: 'Disbursal Amount',
				data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 1.9, 9.6]
			}, {
				name: 'Disbursal Count',
				data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
			},

			{
				name: 'Disbursal Amount',
				data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 9.3, 4.3, 13.9, 9.6]
			}, {
				name: 'Disbursal Count',
				data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 0.3, 6.6, 4.8]
			}

		]

	});
</script>

<script type="text/javascript">
	Highcharts.chart('amountdisbursal', {

		yAxis: {
			categories: ['0', '50', '100', '150', '200', '250', '300', '350', '400', '500']
		},

		xAxis: {
			categories: ['Jun', 'July', 'August', 'Sept', 'Oct']
		},

		exporting: {
			enabled: false
		},
		series: [{
			type: 'column',
			name: 'New Car Disbursal Amount',
			data: [100, 200, 300, 400, 430]
		}, {
			type: 'column',
			name: 'Used Car Disbursal Amount',
			data: [200, 100, 400, 490, 450]
		}, {
			type: 'spline',
			name: 'Average',
			data: [100, 200, 300, 400, 480],
			marker: {
				lineWidth: 2,
				lineColor: Highcharts.getOptions().colors[3],
				fillColor: 'white'
			}
		}, ]
	});
</script>