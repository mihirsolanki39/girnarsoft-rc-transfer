<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>">
	<title>Contactability Setting</title>
	<!-- Bootstrap core CSS -->
	<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
	<link href="<?= base_url('assets/css/' . CSS) ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/animate.css') ?>" rel="stylesheet">
	<!-- <link href="<?= base_url('assets/css/home_style.css') ?>" rel="stylesheet">
       HTML5 shim and Respond.js for IE8 support of
         HTML5 elements and media queries -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body class="bg-wallpaper ">
	<header>
		<style type="text/css">
			.bg-cd {
				background-color: #212121
			}

			.ac-cd {
				float: left;
				margin-left: 20px;
				margin-top: 10px;
			}

			.cd-cd {
				width: 65%;
				float: left;
				margin-top: 7px;
			}

			.bg-wallpaper:before {
				top: 73px;
			}
		</style>
		<div class="clearfix bg-cd bg-birmotor">
			<span class="ac-cd">
				<img src="<?= base_url(LOGO) ?>" style="text-align:left">
			</span>
			<span class="logoSec cd-cd">
				<img src="<?= base_url(CDLOGO) ?>" style="width: 120px">
			</span>
		</div>
		<!--<div class="logoSec"><img src="<?= base_url('assets/images/autocredits.png') ?>"><img src="<?= base_url('assets/images/assets.jpg') ?>"></div>-->
		<!--<div class="logoSec" style="color:Black;font-size:38px">Dealer Central <span style="color:#e86335 !important  ;" class="highlight">CRM</span></div>-->
	</header>
	<div class="container-fluid mrg-all-20 pad-all-0 mrg8 mrg-B0" id="ManagePage">

		<section>
			<div class="mysection clearfix">
				<div class="manage-head">
					<h1 class="lgHeading"> Sign In to your Digital Dealership</h1>
					<p class="sgHeading">

					</p>
				</div>
				<div class="">
					<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3  col-xs-12">
						<div class="sm mrg-30">
							<div class="row">
								<div class="col-md-12" id="form_design">
									<div class="signUp-container text-left">
										<p class="emilphne">
											<span class="btn-frm " type="button" id="sign_in_otpBtn">By Mobile</span>
											<?php if (DEALER_ID != '49') { ?><span class="btn-frm active" type="button" id="sign_inBtn">By Email</span><?php } ?>
										</p>

										<?php if (DEALER_ID != '49') {
											$attributes = array('name' => 'sign_in', 'id' => 'sign_in', 'data-os-animation-delay' => '0s', 'data-os-animation' => 'fadeInDown', 'class' => 'text-left os-animation');
											echo form_open('login/sign_in_login', $attributes);
										?>
											<?php
											$error = $this->session->flashdata('login_failed');
											if ($error) { ?>
												<div class="alert alert-dismissible alert-danger">
													<?= $error ?>
												</div>
											<?php }     ?>
											<?php echo form_hidden('form_type', '0'); ?>
											<!-- <form class="text-left os-animation" data-os-animation="fadeInDown" data-os-animation-delay="0s" id="sign_in">-->
											<div class="form-group">

												<?php
												$data = array(
													'name'          => 'username',
													'id'            => 'username',
													'value'         => set_value('username'),
													'maxlength'     => '100',
													'size'          => '50',
													'type'          => 'text',
													'placeholder'   => 'User Name',
													'class'         => 'form-control input-lg sign-txtbox dc-user',


												);

												echo form_input($data);
												echo form_error('username');
												?>
												<!--<input class="form-control input-lg sign-txtbox dc-user" type="text" placeholder="User Name">-->
												<img class="img-login" src="<?= base_url('assets/images/shape.svg') ?>">

											</div>
											<div class="form-group">
												<?php
												$datapass = array(
													'name'          => 'upass',
													'id'            => 'upass',
													'value'         => set_value('upass'),
													'maxlength'     => '20',
													'size'          => '50',
													'type'          => 'password',
													'placeholder'   => 'Password',
													'class'         => 'form-control input-lg sign-txtbox dc-pass',
													'autocomplete' => "off"
												);

												echo form_input($datapass);
												echo form_error('upass');
												?>
												<!--<input class="form-control input-lg sign-txtbox dc-pass" type="password" placeholder="Password">-->
												<img class="img-password" src="<?= base_url('assets/images/password.svg') ?>">
											</div>
											<!--<div class="form-group">
                                    <input checked type="checkbox" name="listdip" id="listdip" value=" List on Dealer Inventory Platform">
                                    <label for="listdip" class="mrg-B0 dc-remember"><span></span></label> Remember Me
                                    <!--<label class="mrg-B0 forgotP" id="forgotpass"><a href="#">FORGOT MY PASSWORD</a></label>-->
											<!--</div>-->
											<div class="form-group">
												<?php echo form_submit(['name' => 'submit', 'value' => 'SIGN IN', 'class' => 'btn btn-default btn-lg btn-block primaryBtn']); ?>
												<!--<button class="btn btn-default btn-lg btn-block primaryBtn" type="button">SIGN IN</button> -->
											</div>
										<?php echo form_close();
										}  ?>

										<?php
										$attributesotp = array('name' => 'sign_in_otp', 'id' => 'sign_in_otp', 'data-os-animation-delay' => '0s', 'data-os-animation' => 'fadeInDown', 'class' => 'text-left os-animation', 'style' => 'display:none;');
										echo form_open('login/sign_in_login', $attributesotp);
										?>
										<?php
										$otpError = $this->session->flashdata('otp_failed');
										if ($otpError['msg']) { ?>
											<div class="alert alert-dismissible alert-danger">
												<?= $otpError['msg'] ?>
											</div>
										<?php } ?>
										<?php echo form_hidden('form_type', '1'); ?>
										<!--<form class="text-left os-animation" data-os-animation="fadeInDown" data-os-animation-delay="0s" id="sign_Up" style="display:none;">-->
										<div class="form-group">
											<?php
											$datamobile = array(
												'name'          => 'mobile',
												'id'            => 'mobile',
												'value'         => set_value('mobile', $this->session->flashdata('mobile')),
												'maxlength'     => '10',
												'size'          => '50',
												'type'          => 'text',
												'placeholder'   => 'Mobile Number',
												'class'         => 'form-control input-lg sign-txtbox dc-mobile mrg-B15'


											);

											echo form_input($datamobile);
											echo form_error('mobile');
											?>
											<!--<input class="form-control input-lg sign-txtbox dc-mobile mrg-B15" type="text" placeholder="Mobile Number" maxlength="10">-->
											<!--<a href="#" class="invalid-user inv-mob hideon">Edit</a>-->
											<img class="img-mobile" src="<?= base_url('assets/images/mobile.svg') ?>">
											<span class="valid-otp" style="color:red;position: absolute;top: 44px;left: 0px;"></span>
										</div>

										<div class="form-group" id="showbutton">
											<?php echo form_submit(['name' => 'submit', 'value' => 'GET OTP', 'class' => 'btn btn-default btn-lg btn-block primaryBtn GetOtpBtn', 'id' => 'otp-login']); ?>
											<!--<button class="btn btn-default btn-lg btn-block primaryBtn GetOtpBtn" type="button">GET OTP</button> -->
										</div>
										<div class="otp-sec hideon">
											<div class="otp-modal">
												<div class="otp-text">Please enter OTP to verify</div>
												<div class="otp-box">
													<input type="text" class="otp-in" name='inp-1' maxlength="1" value="" onkeypress="return isNumber(event)" autocomplete='off'>
													<input type="text" class="otp-in" name='inp-2' maxlength="1" value="" onkeypress="return isNumber(event)" autocomplete='off'>
													<input type="text" class="otp-in" name='inp-3' maxlength="1" value="" onkeypress="return isNumber(event)" autocomplete='off'>
													<input type="text" class="otp-in" name='inp-4' maxlength="1" value="" onkeypress="return isNumber(event)" autocomplete='off'>
												</div>
												<div class="otp-error"></div>
												<div class="loading-img" style="position: absolute;    margin-left: 117px;">
													<img src="<?= base_url('assets/images/loading.gif') ?>" id="small-loader" style="display:none;width:63px" />
												</div>
											</div>
											<div class="otp-ntrecvd">Did’nt receive the verification code? <a href="#" class="resendbtn"> RESEND CODE</a></div>
											<div class="form-group">
												<?php echo form_submit(['name' => 'sign_in_otp', 'value' => 'SIGN IN', 'class' => 'btn btn-default btn-lg btn-block primaryBtn', 'id' => 'otp-process-send']); ?>
												<!--<button class="btn btn-default btn-lg btn-block primaryBtn" type="button">GET OTP</button> -->
											</div>

										</div>

										<?php echo form_close();  ?>

										<form class="text-left os-animation animated fadeInDown" data-os-animation="fadeInDown" data-os-animation-delay="0s" id="forgotpasword" style="animation-delay: 0s; display:none;">
											<div class="form-group"><span id="error_div_forgot" style="color:red;"></span>
											</div>
											<div class="form-group" style="color:rgba(0,0,0,0.8);">
												<h6>Can't sign in? Forgot your password?</h6>
												Enter your email address below and we'll send you password reset instructions.
											</div>
											<div class="form-group">
												<input class="form-control input-lg sign-txtbox email_forgot dc-forgotEmail dc-user" type="text" placeholder="Enter Your Email Address" name="email_forgot" id="email_forgot" value="">
											</div>
											<div class="form-group">
												<button class="btn btn-default btn-lg btn-block primaryBtn" onclick="return forgetForm(this)" type="submit">SEND ME RESET INSTRUCTIONS</button>
											</div>
										</form>
									</div>


								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div>
			<style>
				.filed-label {
					font-size: 12px;
					background-color: #f5a623;
					display: inline-block;
					padding: 2px 10px;
					border-radius: 2px;
				}

				.approved-label {
					font-size: 12px;
					background-color: #1fc056;
					display: inline-block;
					padding: 2px 10px;
					border-radius: 2px;
				}

				.reject-label {
					font-size: 12px;
					background-color: #f54019;
					display: inline-block;
					padding: 2px 10px;
					border-radius: 2px;
				}

				.disbursed-label {
					font-size: 12px;
					background-color: #0bbeb8;
					display: inline-block;
					padding: 2px 10px;
					border-radius: 2px;
				}

				#username:before {
					background-image: url(../images/shape.svg) !important;
					background-repeat: no-repeat;
					background-position: 11px 19px;
					padding-left: 40px;
					height: 48px;
					border: 1px solid #006600;
				}

				.img-login {
					vertical-align: middle;
					position: absolute;
					top: 20px;
					left: 12px;
				}

				.img-password {
					vertical-align: middle;
					position: absolute;
					top: 10px;
					left: 12px;
				}

				.img-mobile {
					vertical-align: middle;
					position: absolute;
					top: 11px;
					left: 10px;
				}
			</style>
			<!--<div class="filed-label">Filed</div>
              <div class="approved-label">Approved</div>
              <div class="reject-label">Reject</div>
              <div class="disbursed-label">Disbursed</div>-->
		</div>
		<div class="clearfix"></div>
		<footer>
			<div class="footer">
				<div class="foot-txt pull-left"><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> Copyright gaadi.com All Rights Reserved. <span class=""></span></div>
				<div class="terms pull-right">
					<ul>
						<li><a href="">Terms & Conditions</a></li>
						<li><a href="">Privacy Policy</a></li>
					</ul>
				</div>
			</div>
		</footer>
	</div>
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/waypoints.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/login-user.js') ?>"></script>
	<script>
		$(document).ready(function() {
			$('#sign_in_otpBtn').trigger('click');
			<?php if ($this->session->flashdata('form_type') == '1') {  ?>
				$('#sign_in_otpBtn').trigger('click');
			<?php } else if ($this->session->flashdata('form_type') == '2' && $otpError['status'] != 'F') { ?>
				$('#sign_in_otpBtn').trigger('click');
				$('.GetOtpBtn').hide();
				$('.GetOtpBtn').parent().next().removeClass("hideon");
				$(".invalid-user").removeClass("hideon");
			<?php } else if ($this->session->flashdata('form_type') == '2') { ?>
				$('#sign_in_otpBtn').trigger('click');
			<?php } ?>
		});
	</script>
</body>

</html>