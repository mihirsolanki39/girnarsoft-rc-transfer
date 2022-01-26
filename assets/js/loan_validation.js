var regMobil = /^[6-9][0-9]{9}$/;
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var ifci = /^[A-Za-z]{4}0[A-Z0-9]{6}$/;
var regEX = /^[A-Za-z]{2}[0-9]{1,2}[A-Za-z]{1,3}[0-9]{1,4}$/;
var alphanumeric = /^[a-z].*[0-9]|[0-9].*[a-z]/i;
var pan = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/;
function leadDetailErr() {
	error_flag = false;
	$('.error').html('');
	$('.form-group').removeClass('validClass');
	$('.form-control').removeClass('validClass');
	var btype = $('input[name=buyer_type]:checked').length;
	var lfor = $('input[name=loan_for]:checked').length;
	var ltype = $('input[name=loan_type]:checked').length;
	var case_discussed = $('input[name=case_discussed]:checked').length;
	var customer_name = $('#Cname').val();
	var customer_mobile = $('#Cmobile').val();
	var customer_addmobile = $('#Camobile').val();
	var customer_email = $('#CEmail').val(); // unique
	var lead_source = $('#lead_source').val();
	var meet_the_customer = $('.meet_the_customer').val();
	//$('.kid-age').SumoSelect();
	var dealerName = $('#dealerName').val();
	// var RctransferdoneBy=$('#RctransferdoneBy').val();
	var seen_customer_doc = $('#seen_customer_doc').val();
	var dealt_by = $('#dealt_by').val();
	var assign_case_to = $('#assign_case_to').val();
	//alert(meet_the_customer);

	if (btype <= 0) {
		$('input[name=buyer_type]').addClass('validClass');
		$('#err_buyer_type').html("Please Select Buyer Type");
		error_flag = true;
	}
	if (lfor <= 0) {
		$('input[name=loan_for]').addClass('validClass');
		$('#err_loan_for').html("Please Select Loan For");
		error_flag = true;
	}
	if (ltype <= 0) {
		$('#err_loan_type').addClass('validClass');
		$('#err_loan_type').html("Please Select Loan Type");
		error_flag = true;
	}
	if (customer_mobile == '') {
		$('#Cmobile').addClass('validClass');
		$('#err_mobile').html("Please Enter Mobile");
		error_flag = true;
	}
	if ((customer_mobile != '') && (!customer_mobile.match(regMobil))) {
		$('#Cmobile').addClass('validClass');
		$('#err_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
	}
	if ((customer_mobile != '') && (customer_mobile.length != 10)) {
		$('#Cmobile').addClass('validClass');
		$('#err_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
	}
	if ((customer_addmobile != '') && (!customer_addmobile.match(regMobil))) {
		$('#Camobile').addClass('validClass');
		$('#err_camobile').html("Please Enter Valid Mobile");
		error_flag = true;
	}
	if ((customer_addmobile != '') && (customer_addmobile.length != 10)) {
		$('#Camobile').addClass('validClass');
		$('#err_camobile').html("Please Enter Valid Mobile");
		error_flag = true;
	}
	if (customer_name == '') {
		$('#Cname').addClass('validClass');
		$('#err_name').html("Please Enter Name");
		error_flag = true;
	}
	if ((customer_name != '') && (customer_name.length < 3)) {
		$('#Cname').addClass('validClass');
		$('#err_name').html("Please Enter Name");
		error_flag = true;
	}
	if (customer_email == '') {
		$('#CEmail').addClass('validClass');
		$('#err_email').html("Please Enter Email");
		error_flag = true;
	}
	if ((customer_email != '') && (!customer_email.match(emailReg))) {
		$('#CEmail').addClass('validClass');
		$('#err_email').html("Please Enter valid Email");
		error_flag = true;
	}
	if (lead_source == '') {
		$('#lead_source').addClass('validClass');
		$('#err_lead_source').html("Please Select Lead source");
		error_flag = true;
	}
	if ((meet_the_customer == '') || (meet_the_customer == '0')) {
		$('#meet_the_customer').addClass('validClass');
		$('#err_meet_the_customer').html("Please Select Sales Executive");
		error_flag = true;
	}
	if (lead_source == '1') {
		if (dealerName == '') {
			$('#dealerName').addClass('validClass');
			$('#err_dealerName').html("Please Select Dealer");
			error_flag = true;
		}
		//if(RctransferdoneBy=='')
		//{
		//$('#RctransferdoneBy').addClass('validClass');
		//	$('#err_RctransferdoneBy').html("Please Select Rc transfer done by");
		//error_flag=true;
		//}
	}

	if (seen_customer_doc == '') {
		$('#seen_customer_doc').addClass('validClass');
		$('#err_seen_customer_doc').html("Please Select Documents verified by");
		error_flag = true;
	}
	/* if(case_discussed<=0){
		 $('#err_case_discussed').addClass('validClass');
		 $('#err_case_discussed').html("Please Select Case Discussed By");
		 error_flag=true;
	 }*/
	if (dealt_by == '') {
		$('#dealt_by').addClass('validClass');
		$('#err_dealt_by').html("Please Select Dealt By");
		error_flag = true;
	}
	if (assign_case_to == '') {
		$('#assign_case_to').addClass('validClass');
		$('#err_assign_case_to').html("Please Select Assign To");
		error_flag = true;
	}

	return error_flag;
}


function personalDetailErr() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var btype = $('#buyerType').val();
	var martial_status = $('input[name=martial_status]:checked').length;
	var gender = $('input[name=gender]:checked').length;
	var doi = $('#doi').val();
	var gst_number = $('#gst_number').val();
	var dob = $('#dob').val(); // unique
	var father_name = $('#father_name').val();
	var mother_name = $('#mother_name').val();
	var no_of_dependent = $('#no_of_dependent').val();
	var pan_number = $('#pan_number').val();
	var aadhar_no = $('#aadhar_no').val();

	if (btype == 1) {
		if (doi == '') {
			$('#doi').addClass('validClass');
			$('#err_dp').html("Please Select Date of Incorp.");
			error_flag = true;
		}
		if (gst_number == '') {
			//$('#gst_number').addClass('validClass');
			//$('#err_gst_number').html("Please Enter GST No.");
			//error_flag=true;
		}
		if ((gst_number != '') && (!gst_number.match(alphanumeric))) {
			$('#gst_number').addClass('validClass');
			$('#err_gst_number').html("Please Enter Alphanumeric GST Number");
			error_flag = true;
		}

	}
	if (btype == 2) {
		if (gender <= 0) {
			$('#err_gender').addClass('validClass');
			$('#err_gender').html("Please Select Gender");
			error_flag = true;
		}
		if (martial_status <= 0) {
			$('#err_martial_status').addClass('validClass');
			$('#err_martial_status').html("Please Select Maritial Status");
			error_flag = true;
		}
		if (dob == '') {
			$('#dob').addClass('validClass');
			$('#err_dp').html("Please Select Date of Birth");
			error_flag = true;
		}
		if (father_name == '') {
			$('#father_name').addClass('validClass');
			$('#err_father_name').html("Please Enter Father/Husband name");
			error_flag = true;
		}
		if (father_name != '') {
			if ((father_name.length < 3) && (/^[a-zA-z ]*$/.test(father_name) == false)) {
				$('#father_name').addClass('validClass');
				$('#err_father_name').html("Father/Husband name must have minimum 3 alphabets");
				error_flag = true;
			}
		}
		if (mother_name == '') {
			$('#mother_name').addClass('validClass');
			$('#err_mother_name').html("Please Enter Mother Maiden name");
			error_flag = true;
		}
		if (mother_name != '') {
			if ((mother_name.length < 3) && (/^[a-zA-z ]*$/.test(mother_name) == false)) {
				$('#mother_name').addClass('validClass');
				$('#err_mother_name').html("Mother Maiden name must have minimum 3 alphabets");
				error_flag = true;
			}
		}
		if (no_of_dependent == '') {
			$('#no_of_dependent').addClass('validClass');
			$('#err_no_of_dependent').html("Please Enter No. of dependent");
			error_flag = true;
		}
		if ((no_of_dependent != '') && (/^[0-9]*$/.test(no_of_dependent) == false)) {
			$('#no_of_dependent').addClass('validClass');
			$('#err_no_of_dependent').html("Please Enter Valid No. of dependent");
			error_flag = true;
		}
		/*if(aadhar_no=='')
	   {
		   $('#aadhar_no').addClass('validClass');
		   $('#err_aadhar_no').html("Please Enter Aadhar No.");
		   error_flag=true;	
	   }*/
		/* if(aadhar_no!='')
		 {
			 if (aadhar_no.length != 12) 
			 { 
				 $('#aadhar_no').addClass('validClass');
				 $('#err_aadhar_no').html("Please Enter valid Aadhar No.");
				 error_flag=true;
			 }
		 }
		 if((aadhar_no!='') && (/^[0-9]*$/.test(aadhar_no) == false))
		 {
			 if (aadhar_no.length != 12) 
			 { 
				 $('#aadhar_no').addClass('validClass');
				 $('#err_aadhar_no').html("Please Enter valid Aadhar No.");
				 error_flag=true;
			 }
		 }*/
	}

	if (pan_number == '') {
		$('#pan_number').addClass('validClass');
		$('#err_pan_number').html("Please Enter Pancard");
		error_flag = true;
	}
	if (pan_number != '') {
		var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/;
		if (pan_number.length == 10) {
			if (!pan_number.match(regExp)) {
				$('#pan_number').addClass('validClass');
				$('#err_pan_number').html('Not a valid PAN number');
				error_flag = true;
			}

		}
		else {
			$('#pan_number').addClass('validClass');
			$('#err_pan_number').html('Please enter 10 digits for a valid PAN number');
			error_flag = true;
		}

	}

	return error_flag;
}


function financeAcedmic() {
	error_flag = false;
	$('.error').html('');
	$('.form-group').removeClass('validClass');
	$('.form-control').removeClass('validClass');
	var d = new Date();
	var m = d.getMonth();
	var y = d.getFullYear();
	var highest_education = $('#highest_education').val();
	var employment_type = $('#employment_type').val()
	var employer_name = $('#employer_name').val();
	var date_of_joining = $('#date_of_joining').val();
	var total_experience = $('#total_experience').val();
	var monthly_income = $('#monthly_income').val();
	var notice_period = $('#notice_period').val();
	var type_of_vehicle_owned = $('#type_of_vehicle_owned').val();
	var vehicle_ownership = $('#vehicle_ownership').val();
	var bus_business_name = $('#bus_business_name').val();
	var bus_office_setup_type = $('#bus_office_setup_type').val();
	var bus_start_date_month = $('#bus_start_date_month').val();
	var bus_start_date_year = $('#bus_start_date_year').val();
	var bus_itr_income1 = $('#bus_itr_income1').val();
	var bus_itr_income2 = $('#bus_itr_income2').val();
	var pro_office_setup_type = $('#pro_office_setup_type').val();
	var pro_itr_income1 = $('#pro_itr_income1').val();
	var pro_itr_income2 = $('#pro_itr_income2').val();
	var pro_start_date_month = $('#pro_start_date_month').val();
	var pro_start_date_year = $('#pro_start_date_year').val();
	var oth_type = $('#oth_type').val();
	var others_followup = $('input[name=others_followup]:checked').length;
	var others_loan = $('input[name=others_loan]:checked').length;
	var office_address = $('#office_address').val();
	var office_cityList = $('#office_cityList').val();
	var office_pincode = $('#office_pincode').val();
	var office_phone = $('#office_phone').val();
	var office_mobile = $('#office_mobile').val();
	var office_email = $('#office_email').val();
	var buyerType = $('#buyerType').val();
	//var = $('#').val();\
	if (buyerType == 2) {
		if (highest_education == '0') {
			$('#highest_education').addClass('validClass');
			$('#err_highest_education').html("Please Select Highest Education");
			error_flag = true;
		}
		if (employment_type == '') {
			$('#employment_type').addClass('validClass');
			$('#err_employment_type').html("Please Select Employment Type");
			error_flag = true;
		}
		if (employment_type == '1') {
			if (employer_name == '') {
				$('#employer_name').addClass('validClass');
				$('#err_employer_name').html("Please Enter Employer Name");
				error_flag = true;
			}
			if (employer_name != '') {
				if (employer_name.length < 3) {
					$('#employer_name').addClass('validClass');
					$('#err_employer_name').html("Employer Name should have atleast 3 characters");
					error_flag = true;
				}
			}
			if (date_of_joining == '') {
				$('#date_of_joining').addClass('validClass');
				$('#err_dp').html("Please select Date of Joining");
				error_flag = true;
			}
			if (total_experience == '') {
				$('#total_experience').addClass('validClass');
				$('#err_total_experience').html("Please Enter Total Experience");
				error_flag = true;
			}
			if ((total_experience != '') && (total_experience > '60') && (/^[0-9]*$/.test(total_experience) == false)) {
				$('#total_experience').addClass('validClass');
				$('#err_total_experience').html("Please Enter Valid Total Experience");
				error_flag = true;
			}
			if (monthly_income == '') {
				$('#monthly_income').addClass('validClass');
				$('#err_monthly_income').html("Please Enter Monthly Income");
				error_flag = true;
			}
			if ((monthly_income < '10000') && (/^[0-9,]*$/.test(monthly_income) == false)) {
				$('#monthly_income').addClass('validClass');
				$('#err_monthly_income').html("Please Enter Valid Monthly Income");
				error_flag = true;
			}
			if (notice_period == '') {
				$('#notice_period').addClass('validClass');
				$('#err_notice_period').html("Please Enter Notice Period");
				error_flag = true;
			}
		}
		if (employment_type == '2') {
			if (bus_business_name == '') {
				$('#bus_business_name').addClass('validClass');
				$('#err_bus_business_name').html("Please Enter Business Name");
				error_flag = true;
			}
			if (bus_office_setup_type == '') {
				$('#bus_office_setup_type').addClass('validClass');
				$('#err_bus_office_setup_type').html("Please Select Office Setup Type");
				error_flag = true;
			}
			if (bus_start_date_month == '') {
				$('#bus_start_date_month').addClass('validClass');
				$('#err_bus_start_date_month').html("Please Select Business Start Month");
				error_flag = true;
			}
			if (bus_start_date_year == '') {
				$('#bus_start_date_year').addClass('validClass');
				$('#err_bus_start_date_year').html("Please Select Business Start Year");
				error_flag = true;
			}
			if ((bus_start_date_month != '') && (bus_start_date_year != '')) {
				if ((bus_start_date_year == y) && (bus_start_date_month > m)) {
					$('#bus_start_date_month').addClass('validClass');
					$('#bus_start_date_year').addClass('validClass');
					$('#err_bus_start_date_year').html("Please Select Valid Business Start Year");
					error_flag = true;
				}
			}
			if ((bus_start_date_year != '') && (bus_start_date_year != y)) {
				/*if(bus_itr_income1=='')
				{
					$('#bus_itr_income1').addClass('validClass');
					$('#err_bus_itr_income1').html("Please Enter Last Years ITR");
					error_flag=true;
				}*/
				//alert(bus_itr_income1);
				if ((bus_itr_income1 != '') && (/^[0-9,]*$/.test(bus_itr_income1) == false)) {
					$('#bus_itr_income1').addClass('validClass');
					$('#err_bus_itr_income1').html("Please Enter Valid Last Years ITR");
					error_flag = true;
				}
				/*if(bus_itr_income2=='')
				{
					$('#bus_itr_income2').addClass('validClass');
					$('#err_bus_itr_income2').html("Please Enter Last Years ITR");
					error_flag=true;
				}
				else */
				if ((bus_itr_income2 != '') && (/^[0-9,]*$/.test(bus_itr_income2) == false)) {
					$('#bus_itr_income2').addClass('validClass');
					$('#err_bus_itr_income2').html("Please Enter Valid Last Years ITR");
					error_flag = true;
				}
				if ((bus_itr_income1 != '') && (bus_itr_income1.replace(/,/g, '') < '10000')) {
					$('#bus_itr_income1').addClass('validClass');
					$('#err_bus_itr_income1').html("Please Enter Valid Last Years ITR  at Least 10,000");
					error_flag = true;
				}
				if ((bus_itr_income2 != '') && (bus_itr_income2.replace(/,/g, '') < '10000')) {
					$('#bus_itr_income2').addClass('validClass');
					$('#err_bus_itr_income2').html("Please Enter Valid Last Years ITR  at Least 10,000");
					error_flag = true;
				}

			}
		}
		if (employment_type == '3') {
			if (pro_office_setup_type == '') {
				$('#pro_office_setup_type').addClass('validClass');
				$('#err_pro_office_setup_type').html("Please Select Office Setup Type");
				error_flag = true;
			}
			/*if(pro_itr_income1=='')
			{
				$('#pro_itr_income1').addClass('validClass');
				$('#err_pro_itr_income1').html("Please Enter Last Years ITR");
				error_flag=true;
			}*/
			if ((pro_itr_income1.replace(/,/g, '') < '10000') && (/^[0-9,]*$/.test(pro_itr_income1) == false)) {
				$('#pro_itr_income1').addClass('validClass');
				$('#err_pro_itr_income1').html("Please Enter Valid Last Years ITR  at Least 10,000");
				error_flag = true;
			}
			/*if(pro_itr_income2=='')
			{
				$('#pro_itr_income2').addClass('validClass');
				$('#err_pro_itr_income2').html("Please Enter Last Years ITR ");
				error_flag=true;
			}*/
			if ((pro_itr_income2.replace(/,/g, '') < '10000') && (/^[0-9,]*$/.test(pro_itr_income2) == false)) {
				$('#pro_itr_income2').addClass('validClass');
				$('#err_pro_itr_income1').html("Please Enter Valid Last Years ITR at Least 10,000");
				error_flag = true;
			}
			if (pro_start_date_month == '') {
				$('#pro_start_date_month').addClass('validClass');
				$('#err_pro_start_date_month').html("Please Select Profession Start Month");
				error_flag = true;
			}
			if (pro_start_date_year == '') {
				$('#pro_start_date_year').addClass('validClass');
				$('#err_pro_start_date_year').html("Please Select Profession Start Year");
				error_flag = true;
			}
		}
		if (employment_type == '4') {
			if (oth_type == '') {
				$('#pro_oth_type').addClass('validClass');
				$('#err_oth_type').html("Please Select Other Type");
				error_flag = true;
			}
			if (others_followup == '') {
				$('#others_followup').addClass('validClass');
				$('#err_others_followup').html("Please Select Other Followup");
				error_flag = true;
			}
			if (others_loan == '') {
				$('#others_loan').addClass('validClass');
				$('#err_others_loan').html("Please Select Other Loan");
				error_flag = true;
			}

		}

		if (type_of_vehicle_owned == '') {
			$('#type_of_vehicle_owned').addClass('validClass');
			$('#err_type_of_vehicle_owned').html("Please Select Type of Vehicle Owned");
			error_flag = true;
		}
		if (vehicle_ownership == '') {
			$('#vehicle_ownership').addClass('validClass');
			$('#err_vehicle_ownership').html("Please Select Type of Vehicle Ownership");
			error_flag = true;
		}
	}
	//if((bus_office_setup_type=='2') && (employment_type=='2')){
	if ((((bus_office_setup_type == '2') || (pro_office_setup_type == '2')) && ((employment_type == '2') || (employment_type == '3'))) || (buyerType == '1')) {
		if (office_address == '') {
			$('#office_address').addClass('validClass');
			$('#err_office_address').html("Please Enter Office Address");
			error_flag = true;
		}
		if ((office_address != '') && (/^[\/a-zA-Z0-9,-._ ]*$/.test(office_address) == false)) {
			$('#office_address').addClass('validClass');
			$('#err_office_address').html("Please Enter Valid Office Address");
			error_flag = true;
		}
		if (office_cityList == '') {
			$('#office_cityList').addClass('validClass');
			$('#err_office_cityList').html("Please Select Office City");
			error_flag = true;
		}
		if (office_pincode == '') {
			$('#office_pincode').addClass('validClass');
			$('#err_office_pincode').html("Please Enter Office Pincode");
			error_flag = true;
		}
		if ((office_pincode != '') && (office_pincode.length != 6)) {
			$('#office_pincode').addClass('validClass');
			$('#err_office_pincode').html("Please Enter Valid Office Pincode");
			error_flag = true;
		}
	}
	return error_flag;
}
function isInt_number(v) {

	var num = /^-?[0-9]+$/;

	return num.test(v);
}


function isFloat_number(v) {
	var num = /^[-+]?[0-9]+\.[0-9]+$/;
	return num.test(v);
}

function loanExpectedErr() {
	error_flag = false;
	$('.error').html('');
	$('.form-group').removeClass('validClass');
	$('.form-control').removeClass('validClass');
	var loan_amt = $('#loan_amt').val().replace(/,/g, '');
	var roi = $('#roi').val();
	var tenor = $('#tenor').val();
	var financer = $('#financer').val();
	var make = $('#make').val();
	var model = $('#model').val();
	var versionId = $('#versionId').val();
	var regdate = $('#reg_year').val().split('-');
	var reg_year = regdate[2];
	var regno = $('#regno').val().replace(/\s/g, '');
	var loanFor = $('#loanFor').val();
	var engine_number = $('#engine_number').val();
	var chassis_number = $('#chassis_number').val();
	var rto = $('#rto').val();
	var rto_state = $('#rto_state').val();
	//var makemonth = $('#makemonth').val();
	var mmyear = $('#mmyear').val();
	//alert(mmyear);
	var mmyr = mmyear.split('-');
	var myear = mmyr[1];
	var makemonth = mmyr[0];
	//return false;
	/*if(makemonth=='')
			{
				$('#makemonth').addClass('validClass');
				$('#makemonth_error').html("Please Select Make Month.");
				error_flag=true;
			}
			if(myear=='')
			{
				$('#myear').addClass('validClass');
				$('#myear_error').html("Please Select Make Year.");
				error_flag=true;
			}*/
	if (makemonth < 10) {
		makemonth = '0' + makemonth;
	}
	if (loanFor != '1') {
		if (regno == '') {
			$('#regno').addClass('validClass');
			$('#err_regno').html("Please Enter Reg No.");
			error_flag = true;
		}
		if ((regno != '') && (!regno.match(regEX))) {
			$('#regno').addClass('validClass');
			$('#err_regno').html("Please Enter Valid Reg No. Format AP 00 AK 0000");
			error_flag = true;
		}
		if (reg_year == '') {
			$('#reg_year').addClass('validClass');
			$('#err_reg_year').html("Please Enter Reg Date");
			error_flag = true;
		}
		if ((rto == '') || (rto == null)) {
			$('#rto').addClass('validClass');
			$('#err_rto').html("Please Select RTO");
			error_flag = true;
		}
		if (rto_state == '') {
			$('#rto_state').addClass('validClass');
			$('#err_rtostate').html("Please Select Valid RTO");
			error_flag = true;
		}


	}
	//        else
	//	{
	//	if(engine_number=='')
	//	{
	//		$('#engine_number').addClass('validClass');
	//		$('#err_engine_number').html("Please Enter Engine Number");
	//		error_flag=true;
	//	}
	//	if((engine_number!='') && ((engine_number.length<'6') || (engine_number.length>'17')))
	//	{
	//		$('#engine_number').addClass('validClass');
	//		$('#err_engine_number').html("Please Enter Valid Engine Number");
	//		error_flag=true;
	//	}
	//	if((engine_number!='') && (!engine_number.match(alphanumeric)))
	//	{
	//		$('#engine_number').addClass('validClass');
	//		$('#err_engine_number').html("Please Enter Alphanumeric Engine Number");
	//		error_flag=true;	
	//	}
	//	if(chassis_number=='')
	//	{
	//		$('#chassis_number').addClass('validClass');
	//		$('#err_chassis_number').html("Please Enter Chassis Number");
	//		error_flag=true;
	//	}
	//	if((chassis_number!='') && ((chassis_number.length<'6') || (chassis_number.length>'17')))
	//	{
	//		$('#chassis_number').addClass('validClass');
	//		$('#err_chassis_number').html("Please Enter Valid Chassis Number");
	//		error_flag=true;
	//	}
	//	if((chassis_number!='') && (!chassis_number.match(alphanumeric)))
	//	{
	//		$('#chassis_number').addClass('validClass');
	//		$('#err_chassis_number').html("Please Enter Alphanumeric Chassis Number");
	//		error_flag=true;	
	//	}		
	//	}

	if ((regno != '') && (!regno.match(regEX))) {
		$('#regno').addClass('validClass');
		$('#err_regno').html("Please Enter Valid Reg No. Format AP 00 AK 0000");
		error_flag = true;
	}
	if (loan_amt == '') {
		$('#err_loan_amt').html("Please Enter Loan Amount");
		error_flag = true;
	}
	if ((loan_amt != '') && (parseInt(loan_amt) < 20000)) {
		$('#loan_amt').addClass('validClass');
		$('#err_loan_amt').html("Enter valid Loan Amount");
		error_flag = true;
	}
	if ((loan_amt != '') && (loan_amt.length > 8)) {
		$('#loan_amt').addClass('validClass');
		$('#err_loan_amt').html("Enter valid Loan Amount");
		error_flag = true;
	}
	if (tenor == '') {
		$('#tenor').addClass('validClass');
		$('#err_tenor').html("Please Enter Tenure");
		error_flag = true;
	}
	if (roi == '') {
		$('#roi').addClass('validClass');
		$('#err_roi').html("Please Enter Roi");
		error_flag = true;
	}
	if (roi == '0') {
		$('#roi').addClass('validClass');
		$('#err_roi').html("Please Enter Roi");
		error_flag = true;
	}
	if (roi > 0) {
		var abc = isInt_number(roi);
		if (abc == true) {
			roi = Number(roi).toString();

			if (parseInt(roi) > 99) {
				$('#roi').addClass('validClass');
				$('#err_roi').html("Please Enter Valid Roi");
				error_flag = true;
			}
			if (parseInt(roi) == 0) {
				$('#roi').addClass('validClass');
				$('#err_roi').html("Please Enter Valid Roi");
				error_flag = true;
			}
		}
		else {
			if (parseFloat(roi) == 0.0) {
				//alert('ggg');
				$('#roi').addClass('validClass');
				$('#err_roi').html("Please Enter Valid Roi");
				error_flag = true;
			}
			if (parseFloat(roi) >= 99.99) {
				//alert('gggee');
				$('#roi').addClass('validClass');
				$('#err_roi').html("Please Enter Valid Roi");
				error_flag = true;
			}
		}

	}
	if (financer == '') {
		$('#financer').addClass('validClass');
		$('#err_financer').html("Please Select Financer");
		error_flag = true;
	}
	if (make == '') {
		$('#make').addClass('validClass');
		$('#err_make').html("Please Select Make");
		error_flag = true;
	}
	if (model == '') {
		$('#model').addClass('validClass');
		$('#err_model').html("Please Select Model");
		error_flag = true;
	}
	if (versionId == '') {
		$('#versionId').addClass('validClass');
		$('#err_versionId').html("Please Select Version");
		error_flag = true;
	}
	var reg_year = reg_year + "/" + regdate[1] + "/" + '01';
	var newendDate = myear + "/" + makemonth + "/" + '01';
	if ((myear != '') && (reg_year != '') && (reg_year < newendDate)) {
		$('#reg_year').addClass('validClass');
		$('#err_reg_year').html("Please Enter Valid Registration Date.");
		error_flag = true;
	}
	return error_flag;
}

function residentialValidation() {
	error_flag = false;
	$('.error').html('');
	$('.form-group').removeClass('validClass');
	$('.form-control').removeClass('validClass');
	var residance_type = $('#residance_type').val();
	var length_of_stay = $('#length_of_stay').val();
	var residence_address = $('#residence_address').val();
	var state = $('#state').val();
	var residence_phone = $('#residence_phone').val();
	var residence_city = $('#residence_city').val();
	var residence_pincode = $('#residence_pincode').val();
	//alert(residence_pincode);

	var corres_address = $('#corres_address').val();
	var corres_state = $('#corres_state').val();
	var corres_city = $('#corres_city').val();
	var corres_pincode = $('#corres_pincode').val();
	var corres_phone = $('#corres_phone').val();
	var sameas = $('#sameas').val();
	if (length_of_stay == '') {
		$('#length_of_stay').addClass('validClass');
		$('#err_length_of_stay').html("Please Select Length Of Stay");
		error_flag = true;
	}
	if (residance_type == '') {
		$('#residance_type').addClass('validClass');
		$('#err_residance_type').html("Please Select Residence Type");
		error_flag = true;
	}
	if (residence_address == '') {
		$('#residence_address').addClass('validClass');
		$('#err_residence_address').html("Please Enter Residence Address");
		error_flag = true;
	}
	else if ((residence_address != '') && (/^[\/a-zA-Z0-9,-._ ]*$/.test(residence_address) == false)) {
		$('#residence_address').addClass('validClass');
		$('#err_residence_address').html("Please Enter Valid Residence Address");
		error_flag = true;
	}
	if (state == '') {
		$('#state').addClass('validClass');
		$('#err_state').html("Please Select State");
		error_flag = true;
	}
	if (residence_phone == '') {
		$('#residence_phone').addClass('validClass');
		$('#err_residence_phone').html("Please Enter Phone");
		error_flag = true;
	}
	if ((residence_phone != '') && (!residence_phone.match(regMobil))) {
		$('#residence_phone').addClass('validClass');
		$('#err_residence_phone').html("Please Enter Valid Phone");
		error_flag = true;
	}
	if ((residence_phone != '') && (residence_phone.length != 10)) {
		$('#residence_phone').addClass('validClass');
		$('#err_residence_phone').html("Please Enter Valid Phone");
		error_flag = true;
	}
	if (residence_city == '') {
		$('#residence_city').addClass('validClass');
		$('#err_residence_city').html("Please Select City");
		error_flag = true;
	}
	if (residence_pincode == '') {
		$('#residence_pincode').addClass('validClass');
		$('#err_residence_pincode').html("Please Enter Pincode");
		error_flag = true;
	}
	if ((residence_pincode != '') && ($.trim(residence_pincode).length != 6)) {
		//alert(residence_pincode.length);
		$('#residence_pincode').addClass('validClass');
		$('#err_residence_pincode').html("Please Enter Valid Pincode");
		error_flag = true;
	}
	if (sameas == 0) {
		if (corres_address == '') {
			$('#corres_address').addClass('validClass');
			$('#err_corres_address').html("Please Select Correspondence Address");
			error_flag = true;
		}
		else if ((corres_address != '') && (/^[\/a-zA-Z0-9,-._ ]*$/.test(corres_address) == false)) {
			$('#corres_address').addClass('validClass');
			$('#err_corres_address').html("Please Select Correspondence Address");
			error_flag = true;
		}
		if (corres_state == '') {
			$('#corres_state').addClass('validClass');
			$('#err_corres_state').html("Please Select Correspondence State");
			error_flag = true;
		}
		if (corres_phone == '') {
			$('#corres_phone').addClass('validClass');
			$('#err_corres_phone').html("Please Enter Correspondence Phone");
			error_flag = true;
		}
		if ((corres_phone != '') && (!corres_phone.match(regMobil))) {
			$('#corres_phone').addClass('validClass');
			$('#err_corres_phone').html("Please Enter Valid Correspondence Phone");
			error_flag = true;
		}
		if ((corres_phone != '') && (corres_phone.length != 10)) {
			$('#corres_phone').addClass('validClass');
			$('#err_corres_phone').html("Please Enter Valid  Correspondence Phone");
			error_flag = true;
		}
		if (corres_city == '') {
			$('#corres_city').addClass('validClass');
			$('#err_corres_city').html("Please Select Correspondence City");
			error_flag = true;
		}
		if (corres_pincode == '') {
			$('#corres_pincode').addClass('validClass');
			$('#err_corres_pincode').html("Please Enter Correspondence Pincode");
			error_flag = true;
		}
		if ((corres_pincode != '') && (corres_pincode.length != 6)) {
			$('#corres_pincode').addClass('validClass');
			$('#err_corres_pincode').html("Please Enter Valid Correspondence Pincode");
			error_flag = true;
		}
	}

	return error_flag;
}

function refrenceDetailsValidation() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	$('.form-group').removeClass('validClass');
	var ref_name_one = $('#ref_name_one').val();
	var ref_address_two = $('#ref_address_two').val();
	var ref_address_one = $('#ref_address_one').val();
	var ref_phone_one = $('#ref_phone_one').val();
	var ref_relationship_one = $('#ref_relationship_one').val();
	var ref_name_two = $('#ref_name_two').val();
	var ref_phone_two = $('#ref_phone_two').val();
	var ref_relationship_two = $('#ref_relationship_two').val();

	if (ref_name_one == '') {
		$('#ref_name_one').addClass('validClass');
		$('#err_ref_name_one').html("Please Enter First Reference Name");
		error_flag = true;
	}
	if ((ref_name_one != '') && (ref_name_one.length < 3)) {
		$('#ref_name_one').addClass('validClass');
		$('#err_ref_name_one').html("Name should have atleast 3 characters");
		error_flag = true;
	}
	if (ref_name_two == '') {
		$('#ref_name_two').addClass('validClass');
		$('#err_ref_name_two').html("Please Enter Second Reference Name");
		error_flag = true;
	}
	if ((ref_name_two != '') && (ref_name_two.length < 3)) {
		$('#ref_name_two').addClass('validClass');
		$('#err_ref_name_two').html("Name should have atleast 3 characters");
		error_flag = true;
	}
	if (ref_address_two == '') {
		$('#ref_address_two').addClass('validClass');
		$('#err_ref_address_two').html("Please Enter Second Reference Address");
		error_flag = true;
	}
	if (ref_address_one == '') {
		$('#ref_address_one').addClass('validClass');
		$('#err_ref_address_one').html("Please Enter First Reference Address");
		error_flag = true;
	}
	if (ref_phone_one == '') {
		$('#ref_phone_one').addClass('validClass');
		$('#err_ref_phone_one').html("Please Enter First Reference Phone");
		error_flag = true;
	}
	if ((ref_phone_one != '') && (!ref_phone_one.match(regMobil))) {
		$('#ref_phone_one').addClass('validClass');
		$('#err_ref_phone_one').html("Please Enter Valid Phone");
		error_flag = true;
	}
	if ((ref_phone_one != '') && (ref_phone_one.length != 10)) {
		$('#ref_phone_one').addClass('validClass');
		$('#err_ref_phone_one').html("Please Enter Valid  Phone");
		error_flag = true;
	}
	if (ref_phone_two == '') {
		$('#ref_phone_two').addClass('validClass');
		$('#err_ref_phone_two').html("Please Enter Second Reference Phone");
		error_flag = true;
	}
	if ((ref_phone_two != '') && (!ref_phone_two.match(regMobil))) {
		$('#ref_phone_two').addClass('validClass');
		$('#err_ref_phone_two').html("Please Enter Valid Phone");
		error_flag = true;
	}
	if ((ref_phone_two != '') && (ref_phone_two.length != 10)) {
		$('#ref_phone_two').addClass('validClass');
		$('#err_ref_phone_two').html("Please Enter Valid  Phone");
		error_flag = true;
	}
	if (ref_relationship_two == '') {
		$('#ref_relationship_two').addClass('validClass');
		$('#err_ref_relationship_two').html("Please Select Second Reference Relationship");
		error_flag = true;
	}
	if (ref_relationship_one == '') {
		$('#ref_relationship_two').addClass('validClass');
		$('#err_ref_relationship_one').html("Please Select First Reference Relationship");
		error_flag = true;
	}
	return error_flag;
}


function fileLoginValidation() {
	var counter = $('#countTotalFiles').val();
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	previous_ref = [];
	for (var i = 1; i <= counter; i++) {
		var loan_amt = $('#floanamount_' + i).val().replace(/,/g, '');
		var tenor = $('#ftenor_' + i).val();
		var roi = $('#froi_' + i).val();
		var reff = $('#fref_' + i).val();
		if (loan_amt == '') {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Please Enter Loan Amount");
			error_flag = true;
		}
		if ((loan_amt != '') && (parseInt(loan_amt) < 20000)) {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Enter Valid Loan Amount");
			error_flag = true;
		}
		if ((loan_amt != '') && (loan_amt.length > 8)) {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Enter Valid Loan Amount");
			error_flag = true;
		}
		if (tenor == '') {
			//alert(tenor);
			$('#ftenor_' + i).addClass('validClass');
			$('#errftenor_' + i).html("Please Enter Tenure");
			error_flag = true;
		}
		if (roi == '') {
			$('#froi_' + i).addClass('validClass');
			$('#errfroi_' + i).html("Please Enter Roi");
			error_flag = true;
		}
		if (roi == '0') {
			$('#froi_' + i).addClass('validClass');
			$('#errfroi_' + i).html("Please Enter Roi");
			error_flag = true;
		}
		if (roi > 0) {
			var abc = isInt_number(roi);
			if (abc == true) {
				roi = Number(roi).toString();

				if (parseInt(roi) > 99) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
				if (parseInt(roi) == 0) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
			}
			else {
				if (parseFloat(roi) == 0.0) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
				if (parseFloat(roi) >= 99.99) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
			}

		}
		if ($.inArray(reff, previous_ref) != '-1') {
			$('#fref_' + i).addClass('validClass');
			$('#errrefid_' + i).html("Reference Id already exist");
			error_flag = true;
		} else {
			previous_ref[i] = reff;
		}
		if (reff == '') {
			$('#fref_' + i).addClass('validClass');
			$('#errrefid_' + i).html("Please Enter Ref");
			error_flag = true;
		}
	}

	return error_flag;

}

function cpvDetailValidation() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var countTotal = $('#countTotal').val();

	var ar = [];
	for (var i = 1; i <= countTotal; i++) {
		var j = 0;
		var k = 0;
		var CPV = $("input[name='CPV_" + i + "']:checked").val();
		var cpvstatus = $('#cpvstatus_' + i).val();
		var cpvRemark = $('#cpvremark_' + i).val();
		if (CPV != '1') {
			$('#CPV_' + i).addClass('validClass');
			$('#errCPV_' + i).html("Please Complete CPV");
			error_flag = true;
		}
		if (cpvstatus == '0') {
			$('#cpvstatus_' + i).addClass('validClass');
			$('#errcpvstatus_' + i).html("Please Select CPV Status");
			error_flag = true;
		}
		else if (cpvstatus == '2') {
			//alert(cpvRemark);
			if ((cpvRemark == '') || (cpvRemark == undefined)) {
				$('#cpvremark_' + i).addClass('validClass');
				$('#errcpvremark_' + i).html("Please Enter Bank Remark");
				error_flag = true;
			}
		}
		else if ((CPV == '1') && (cpvstatus != '2') && (cpvstatus != '0')) {
			error_flag = false;
			return error_flag;
		}
	}

	return error_flag;
}

function decisionValidation() {
	error_flag = false;
	$('.error').html('');
	var countTotal = $('#countTotal').val();
	$('.form-control').removeClass('validClass');
	for (var i = 1; i <= countTotal; i++) {
		var loan_amt = $('#floanamount_' + i).val().replace(/,/g, '');
		var tenor = $('#ftenor_' + i).val();
		var roi = $('#froi_' + i).val();
		var paydates = $('#paydates_' + i).val();
		var filedate = $('#filedate_' + i).val();
		if (loan_amt == '') {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Please Enter Loan Amount");
			error_flag = true;
		} else if (loan_amt.length > 8) {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Invalid Loan Amount");
			error_flag = true;
		}
		if ((loan_amt != '') && (parseInt(loan_amt) < 20000)) {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Enter Valid Loan Amount");
			error_flag = true;
		}
		if (tenor == '') {
			$('#ftenor_' + i).addClass('validClass');
			$('#errftenor_' + i).html("Please Enter Tenure");
			error_flag = true;
		}
		if (roi == '') {
			$('#froi_' + i).addClass('validClass');
			$('#errfroi_' + i).html("Please Enter Roi");
			error_flag = true;
		}
		if (roi == '0') {
			$('#froi_' + i).addClass('validClass');
			$('#errfroi_' + i).html("Please Enter Roi");
			error_flag = true;
		}
		if (roi > 0) {
			var abc = isInt_number(roi);
			if (abc == true) {
				roi = Number(roi).toString();

				if (parseInt(roi) > 99) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
				if (parseInt(roi) == 0) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
			}
			else {
				if (parseFloat(roi) == 0.0) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
				if (parseFloat(roi) >= 99.99) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
			}

		}

		var d = filedate.split("-");
		var newcreateDate = d[2] + "-" + d[1] + "-" + d[0];
		var d1 = paydates.split("-");
		var newendDate = d1[2] + "-" + d1[1] + "-" + d1[0];
		if (newcreateDate > newendDate) {
			$('#errpaydate_' + i).addClass('validClass');
			$('#errpaydate_' + i).html("Please Enter Valid Decision Date");
			error_flag = true;
		}
	}

	return error_flag;
}

function disbursalValidation() {
	error_flag = false;
	$('.error').html('');
	var countTotal = $('#countTotal').val();
	$('.form-control').removeClass('validClass');
	var j = 0;
	var k = 0;
	for (var i = 1; i <= countTotal; i++) {
		var loan_amt = $('#floanamount_' + i).val().replace(/,/g, '');
		var tenor = $('#ftenor_' + i).val();
		var roi = $('#froi_' + i).val();
		var reff = $('#refid_' + i).val();
		var paydates = $('#paydates_' + i).val();
		var filedate = $('#filedate_' + i).val();
		if (loan_amt == '') {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Please Enter Loan Amount");
			error_flag = true;
		}
		if ((loan_amt != '') && (parseInt(loan_amt) < 20000)) {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Enter Valid Loan Amount");
			error_flag = true;
		}
		if ((loan_amt != '') && (loan_amt.length > 8)) {
			$('#floanamount_' + i).addClass('validClass');
			$('#errfloanamount_' + i).html("Enter Valid Loan Amount");
			error_flag = true;
		}
		if (tenor == '') {
			$('#ftenor_' + i).addClass('validClass');
			$('#errftenor_' + i).html("Please Enter Tenure");
			error_flag = true;
		}
		if (roi == '') {
			$('#froi_' + i).addClass('validClass');
			$('#errfroi_' + i).html("Please Enter Roi");
			error_flag = true;
		}
		if (roi == '0') {
			$('#froi_' + i).addClass('validClass');
			$('#errfroi_' + i).html("Please Enter Roi");
			error_flag = true;
		}
		if (roi > 0) {
			var abc = isInt_number(roi);
			if (abc == true) {
				roi = Number(roi).toString();

				if (parseInt(roi) > 99) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
				if (parseInt(roi) == 0) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
			}
			else {
				if (parseFloat(roi) == 0.0) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
				if (parseFloat(roi) >= 99.99) {
					$('#froi_' + i).addClass('validClass');
					$('#errfroi_' + i).html("Please Enter Valid Roi");
					error_flag = true;
				}
			}

		}
		var d = filedate.split("-");
		var newcreateDate = d[2] + "-" + d[1] + "-" + d[0];
		var d1 = paydates.split("-");
		var newendDate = d1[2] + "-" + d1[1] + "-" + d1[0];
		if (newcreateDate > newendDate) {
			$('#errpaydate_' + i).addClass('validClass');
			$('#errpaydate_' + i).html("Please Enter Valid Disbursal Date");
			error_flag = true;
		}
		else if ((loan_amt != '') && (tenor != '') && (roi != '')) {
			error_flag = false;
			return error_flag;
		}
	}

	return error_flag;
}


function postDetailValidation() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var invoice_no = $('#invoice_no').val();
	var invoice_date = $('#invoice_date').val();
	var invoice_received_as = $('#invoice_received_as').val();
	var invoice_received_from = $('#invoice_received_from').val();
	var invoice_received_on = $('#invoice_received_on').val();
	var rc_regNo = $('#rc_regNo').val();
	var rc_chassis_no = $('#rc_chassis_no').val();
	var rc_engine_no = $('#rc_engine_no').val();
	var rc_regDate = $('#rc_regDate').val();
	var rc_lein_mark = $('#rc_lein_mark').val();
	var rc_received_as = $('#rc_received_as').val();
	var rc_registration_from = $('#rc_registration_from').val();
	var rc_received_on = $('#rc_received_on').val();
	var insurance_company = $('#insurance_company').val();
	var insurance_by = $('#insurance_by').val();
	var icn_no = $('#icn_no').val();
	var insurance_expiry = $('#insurance_expiry').val();
	var delivery_date = $('#delivery_date').val();
	var filling_no = $('#filling_no').val();
	var loan_for = $('#loan_for').val();
	if (loan_for == '1') {
		if (invoice_no == '') {
			$('#invoice_no').addClass('validClass');
			$('#err_invoice_no').html("Please Enter Invoice No.");
			error_flag = true;
		}
		if (invoice_received_as == '') {
			$('#invoice_received_as').addClass('validClass');
			$('#err_invoice_received_as').html("Please Enter Invoice received as");
			error_flag = true;
		}
		if (invoice_received_from == '') {
			$('#invoice_received_from').addClass('validClass');
			$('#err_invoice_received_from').html("Please Enter Invoice received by");
			error_flag = true;
		}
		if (invoice_received_on == '') {
			$('#invoice_received_on').addClass('validClass');
			$('#err_invoice_received_on').html("Please Enter Invoice received on");
			error_flag = true;
		}
	}
	if (loan_for != '1') {
		if (rc_regNo == '') {
			$('#rc_regNo').addClass('validClass');
			$('#err_rc_regNo').html("Please Enter Reg no.");
			error_flag = true;
		}
		if (rc_regDate == '') {
			$('#rc_regDate').addClass('validClass');
			$('#err_rc_regDate').html("Please Enter Reg Date");
			error_flag = true;
		}
	}
	if (rc_chassis_no == '') {
		$('#rc_chassis_no').addClass('validClass');
		$('#err_rc_chassis_no').html("Please Enter Chassis no.");
		error_flag = true;
	}
	if ((rc_chassis_no != '') && ((rc_chassis_no.length < '6') || (rc_chassis_no.length > '17')) && (!rc_chassis_no.match(alphanumeric))) {
		$('#rc_chassis_no').addClass('validClass');
		$('#err_rc_chassis_no').html("Please Enter Valid Chassis no.");
		error_flag = true;
	}
	if (rc_engine_no == '') {
		$('#rc_engine_no').addClass('validClass');
		$('#err_rc_engine_no').html("Please Enter Engine no.");
		error_flag = true;
	}
	if ((rc_engine_no != '') && ((rc_engine_no.length < '6') || (rc_engine_no.length > '17')) && (!rc_engine_no.match(alphanumeric))) {
		$('#engine_number').addClass('validClass');
		$('#err_rc_engine_no').html("Please Enter Valid Engine Number");
		error_flag = true;
	}
	/*if(rc_lein_mark=='')
	{
		$('#err_rc_lein_mark').html("Please Enter Lein mark");
			  error_flag=true;
	}*/
	if (loan_for == '1') {
		if (rc_received_as == '') {
			$('#rc_received_as').addClass('validClass');
			$('#err_rc_received_as').html("Please Enter RC received as");
			error_flag = true;
		}
		if (rc_registration_from == '') {
			$('#rc_registration_from').addClass('validClass');
			$('#err_rc_registration_from').html("Please Enter Received From");
			error_flag = true;
		}
		if (rc_received_on == '') {
			$('#rc_received_on').addClass('validClass');
			$('#err_rc_received_on').html("Please Enter RC received on");
			error_flag = true;
		}
	}
	if (insurance_company == '') {
		$('#insurance_company').addClass('validClass');
		$('#err_insurance_company').html("Please Select Insurance Company");
		error_flag = true;
	}
	/*if(insurance_by=='')
	{
		$('#insurance_by').addClass('validClass');
		$('#err_insurance_by').html("Please Enter Insurance By");
			  error_flag=true;
	}*/
	if (icn_no == '') {
		$('#icn_no').addClass('validClass');
		$('#err_icn_no').html("Please Enter ICN No.");
		error_flag = true;
	}
	if (insurance_expiry == '') {
		$('#insurance_expiry').addClass('validClass');
		$('#err_insurance_expiry').html("Please Enter Insurance Expiry");
		error_flag = true;
	}
	if (delivery_date == '') {
		// $('#delivery_date').addClass('validClass');
		//$('#err_delivery_date').html("Please Enter Delivery Date");
		//	error_flag=true;
	}
	/*if(filling_no=='')
	{
		$('#filling_no').addClass('validClass');
		$('#err_filling_no').html("Please Enter Filling No.");
			  error_flag=true;
	}
*/

	return error_flag;
}

function paymentDetailValidation() {
	//alert('instrument_type');
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var instrument_type = $('#instrument_type').val();
	var instrument_no = $('#instrument_no').val();
	var cheque_from = $('#cheque_from').val();
	var cheque_to = $('#cheque_to').val();
	var drawn_bank = $('#drawn_bank').val();
	var account_no = $('#account_no').val();
	var favouring = $('#favouring').val();
	var signed_by = $('#signed_by').val();
	var amount = $('#amount').val().replace(/,/g, '');
	var instrument_date = $('#instrument_date').val();
	var entry = $("input[name='entry']:checked").val();
	//alert(instrument_type);
	if (instrument_type == '') {
		$('#instrument_type').addClass('validClass');
		$('#err_instrument_type').html("Please Select Instrument Type");
		error_flag = true;
	}
	if (instrument_type == '1') {
		if (cheque_from == '') {
			$('#cheque_from').addClass('validClass');
			$('#err_cheque_from').html("Please Enter Check From");
			error_flag = true;
		}
		if ((cheque_to == '') && (entry == 'batch')) {
			$('#cheque_to').addClass('validClass');
			$('#err_cheque_to').html("Please Enter Check To");
			error_flag = true;
		}
	}
	else if ((instrument_type == '1') || (instrument_type == '2') || (instrument_type == '3')) {
		if (drawn_bank == '') {
			$('#drawn_bank').addClass('validClass');
			$('#err_drawn_bank').html("Please Select Bank");
			error_flag = true;
		}
		if (account_no == '') {
			$('#account_no').addClass('validClass');
			$('#err_account_no').html("Please Enter Account No");
			error_flag = true;
		}
		if (favouring == '') {
			$('#favouring').addClass('validClass');
			$('#err_favouring').html("Please Enter Favouring");
			error_flag = true;
		}
		if (signed_by == '') {
			$('#signed_by').addClass('validClass');
			$('#err_signed_by').html("Please Enter Signed By");
			error_flag = true;
		}
		if (amount == '') {
			$('#amount').addClass('validClass');
			$('#err_amount').html("Please Enter Amount");
			error_flag = true;
		}
		if (amount.length > 8) {
			$('#amount').addClass('validClass');
			$('#err_amount').html("Please Enter valid Amount");
			error_flag = true;
		}
		if (instrument_date == '') {
			$('#instrument_date').addClass('validClass');
			$('#err_instrument_date').html("Please Enter Instrument Date");
			error_flag = true;
		}
	}
	return error_flag;
}

function loanDoValidation() {

	error_flag = false;
	$('.error').html('');
	//var do_status = $('input[name=do_status]:checked').length;
	//var do_status_val=$('input[name=do_status]:checked').val();
	var booking_done = $('input[name=booking_done]:checked').length;
	var booking_done_val = $('input[name=booking_done]:checked').val();
	var booking_slip_no = $('#booking_slip_no').val();
	var deliverySource = $('#deliverySource').val();
	var dealerName = $('#dealerName').val();
	var deliveryArg = $('#deliveryArg').val();
	var deliverySales = $('#deliveryTeam').val();
	var do_date = $('#do_date').val();
	var loan_taken = $('input[name=loan_taken]:checked').length;
	var loan_taken_val = $('input[name=loan_taken]:checked').val();
	var loan_taken_frln = $('input[name=loan_taken_from]:checked').length;
	var loan_taken_from = $('input[name=loan_taken_from]:checked').val();
	//alert(loan_taken_from);
	var loan_filled = $('input[name=loan_filled]:checked').length;
	var loan_filled_val = $('input[name=loan_filled]:checked').val();
	var application_no = $('#application_no').val();
	var do_no = $('#do_no').val();
	var do_amt = $('#do_amt').val();
	var do_amt_word = $('#do_amt_word').val();
	var showroomName = $('#showroomName').val();
	var showroom_address = $('#showroom_address').val();
	var kind_attn = $('#kind_attn').val();
	var showroom_disc = $('#showroom_disc').val().replace(/,/g, '');;
	var scheme_disc = $('#scheme_disc').val().replace(/,/g, '');;
	var delivery_date = $('#delivery_date').val();
	var exp_payment_date = $('#exp_payment_date').val();
	var customer_mobile_no = $('#customer_mobile_no').val();
	var customer_name = $('#customer_name').val();
	var customer_name_len = $('#customer_name').val().length;
	var customer_address = $('#customer_address').val();
	var make = $('#make').val();
	var model = $('#model').val();
	var variant = $('#versionId').val();
	var color = $('#color').val();
	var reg_req = $('#reg_req').val();
	var hp_to = $('#hp_to').val();
	var hp_tos = $('#hp_tos').val();

	if (hp_to) {
		hp_to = hp_to;
	} else if (hp_tos) {
		hp_to = hp_tos;
	} else {
		hp_to = '';
	}

	//alert(variant);
	/*for hp to mandatory end   */
	// var hp_to= $('#hp_to').val();
	var hypoto = $('#hypoto').val();
	//var booking_date= $('#booking_date').val();
	var new_car_price = $('#new_car_price').val();
	var insurance = $('#insurance').val();
	var insurance_pre = $('#insu_premium').val();
	var grs_do_amt = $('#grs_amt').val();

	var err = 0;
	if (booking_done == '') {

		$('#err_booking_done').html("Please Select Advance Booking Done");
		//$('#err_booking_done').focus();
		error_flag = true;
		err++;
	}


	if (booking_done_val == '1') {
		if (booking_slip_no == '') {
			$('#err_booking_slip_no').html("Please Enter Booking Slip No");
			error_flag = true;
			err++;
		}
	}
	/* if(do_status==''){

		  alert('4');
	   $('#err_do_status').html("Please Select Do Status");
	   //$('#err_booking_done').focus();
	   error_flag=true; 
	   err++;
	}*/
	if (deliverySource == '') {
		$('#err_deliverySource').html("Please Select Source");
		error_flag = true;
		err++;
	}
	if (deliverySource == '1') {
		//alert('6');
		if (dealerName == '') {
			$('#dealerName_error').html("Please Select Dealer");
			error_flag = true;
			err++;
		}
	}

	//gross do validation start  

	if (grs_do_amt == '') {
		$('#err_gross_do_amt').html("Please Enter gross-DO Amount");
		//$('#err_booking_done').focus();
		error_flag = true;
		err++;
	}
	//gross do validation end 

	if (deliverySales == '') {
		$('#err_deliverySales').html("Please Select Sales Executive");
		error_flag = true;
		err++;
	}
	if (deliveryArg == '') {
		$('#err_deliveryArg').html("Please Select Delivery Arranged By");
		error_flag = true;
		err++;
	}
	if (do_date == '') {
		$('#err_do_date').html("Please Enter Do Date");
		error_flag = true;
		err++;
	}
	if (loan_taken == 0) {
		$('#err_loan_taken').html("Please Select Loan Taken");
		error_flag = true;
		err++;
	}
	if ((loan_taken_frln == 0) && (loan_taken_val == '1')) {
		$('#err_loan_taken_from').html("Please Select Loan Taken From");
		error_flag = true;
		err++;
	}
	if ((loan_taken_from == '1') && (loan_taken_val == '1') && (loan_taken_frln != '0')) {
		//alert('13');
		if (loan_filled == 0) {
			$('#err_loan_filled').html("Please Select Loan Filled");
			error_flag = true;
			err++;
		}

	}
	if ((loan_filled_val == '1') && (loan_taken_val == '1') && (loan_taken_from == '1') && (loan_taken_frln != '0')) {
		if (application_no == '') {
			$('#err_application_no').html("Please Enter Application No");
			error_flag = true;
			err++;
		}

		//if(hypoto=='1'){

		//}  
	}

	/*  if((hp_to=='') && (loan_taken_val=='1') && (loan_taken_from=='1'))
	  {
		  $('#err_hp_to').html("Please Select HPto To");
		  error_flag=true;
		  err++;
	  }   
	  if((hp_tos=='') && (loan_taken_val=='1') && (loan_taken_from=='2'))
	  {
		  $('#err_hp_to').html("Please Select HPtos To");
		  error_flag=true;
		  err++;
	  } */


	if ((hp_to == '') && (loan_taken_val == '1')) {
		$('#err_hp_to').html("Please Select HP To");
		error_flag = true;
		err++;
	}

	if (err >= 1) {

		$('html, body').animate({ scrollTop: $("#gototop").offset().top }, 2000);
		return error_flag;
	}

	if (showroomName == '') {
		$('#err_showroomName').html("Please Select Showroom");
		error_flag = true;
		err++;
	}
	/*if(showroom_address=='')
		{
				$('#err_showroom_address').html("Please Enter Showroom Address");
			error_flag=true;
		}*/
	if (kind_attn == '') {
		$('#err_kind_attn').html("Please Enter Kind Attention");
		error_flag = true;
		err++;
	}
	if ((showroom_disc != '') && (showroom_disc.length >= 7)) {
		$('#err_showroom_disc').html("Please Enter Valid Showroom Discount");
		error_flag = true;
		err++;
	}
	if ((scheme_disc != '') && (scheme_disc.length >= 7)) {
		$('#err_scheme_disc').html("Please Enter Valid Discount Shared");
		error_flag = true;
		err++;
	}
	if (delivery_date == '') {
		$('#err_delivery_date').html("Please Enter Delivery Date");
		error_flag = true;
		err++;
	}
	// alert(do_date+' - '+delivery_date);
	/*  if(((do_date) > (delivery_date)) && (delivery_date!=''))
	  {
		  //$('#err_delivery_date').html("Please Enter Delivery Date");
			$('#err_delivery_date').html("Delivery Date Should be Greater or Equal To Delivery Order Date");
			  error_flag=true;
			  err++;
	  }*/
	if (do_date != '') {
		var dtdue = do_date.split("-");
		var fdtdueDate = dtdue[2] + '/' + dtdue[1] + '/' + dtdue[0];
	}
	if (delivery_date != '') {
		var dtissue = delivery_date.split("-");
		var fdtissueDate = dtissue[2] + '/' + dtissue[1] + '/' + dtissue[0];
	}
	if ((do_date != '' && delivery_date != '') && (fdtdueDate != '' && fdtissueDate != '') && (fdtdueDate > fdtissueDate)) {
		$('#err_delivery_date').html("Delivery Date Should be Greater or Equal To Delivery Order Date");
		error_flag = true;
		err++;
	}
	if (exp_payment_date == '') {
		$('#err_exp_payment_date').html("Please Enter Expected Payment Date");
		error_flag = true;
		err++;
	}
	//alert(exp_payment_date);
	/*if(((exp_payment_date) < (do_date)) && (exp_payment_date!=''))
	{
		//$('#err_exp_payment_date').html("Please Enter Expected Payment Date");
	    
		  $('#err_exp_payment_date').html("Expected Payment Date Should be Greater or Equal To Delivery Order Date");
			error_flag=true;
			err++;
	}*/
	if (exp_payment_date != '') {

		var dtissues = exp_payment_date.split("-");
		var fdtissueDates = dtissues[2] + '/' + dtissues[1] + '/' + dtissues[0];
	}
	if ((do_date != '' && exp_payment_date != '') && (fdtdueDate != '' && fdtissueDates != '') && (fdtdueDate > fdtissueDates)) {

		$('#err_exp_payment_date').html("Expected Payment Date Should be Greater or Equal To Delivery Order Date");
		error_flag = true;
		err++;
	}
	if (err >= 1) {

		$('html, body').animate({ scrollTop: $("#gotoshow").offset().top }, 2000);
		return error_flag;
	}
	if (customer_mobile_no == '') {

		$('#err_customer_mobile_no').html("Please Enter Customer Mobile No");
		error_flag = true;
		err++;
	}
	if (customer_mobile_no != '') {

		var IndNum = /^[0]?[6789]\d{9}$/;
		if (IndNum.test(customer_mobile_no)) {

			error_flag = false;
			//err++;
		} else {

			$('#err_customer_mobile_no').html("Please enter valid Customer Mobile");
			error_flag = true;
			err++;
		}
	}
	if (customer_name == '') {

		$('#err_customer_name').html("Please Enter Customer Name");
		error_flag = true;
		err++;
	}
	if ((customer_name_len > 0) && (customer_name_len < 3)) {

		$('#err_customer_name').html("Please Enter atleast 3 character Customer Name");
		error_flag = true;
		err++;
	} hp_to
	if (customer_address == '') {

		$('#err_customer_address').html("Please Enter Customer Address");
		error_flag = true;
		err++;
	}
	if (err >= 1) {

		$('html, body').animate({ scrollTop: $("#gotocustomer").offset().top }, 2000);
		return error_flag;
	}
	if (make == '') {

		$('#err_make').html("Please Select Make");
		error_flag = true;
		err++;
	}
	if (model == '') {

		$('#err_model').html("Please Select Model");
		error_flag = true;
		err++;
	}
	if (variant == '' || variant == null) {
		$('#err_variant').html("Please Select Version");
		error_flag = true;
		err++;
	}
	if (color == '') {

		$('#err_color').html("Please Enter Color");
		error_flag = true;
		err++;
	}
	if (reg_req == '') {

		$('#err_reg_req').html("Please Select Registration Required");
		error_flag = true;
		err++;
	}


	if (new_car_price == '') {

		$('#err_new_car_price').html("Please enter New Car Price");
		$('#new_car_price').focus();
		error_flag = true;
		err++;
	}
	if (insurance == '') {


		$('#err_insurance').html("Please Select Insurance");
		$('#insurance').focus();
		error_flag = true;
		err++;
	}
	if ((insurance == '2') && (insurance_pre == '')) {

		$('#err_insu_premium').html("Please enter Insurance Premium");
		$('#insu_premium').focus();
		error_flag = true;
		err++;
	}
	/*if(exp_payment_date!='' && delivery_date!=''){
	   var deliveryd = delivery_date.split("-").reverse().join("-");
	   var exp_payment_dated = exp_payment_date.split("-").reverse().join("-");
	   if(exp_payment_dated > deliveryd){
	   $('#err_exp_payment_date').html("Expected Payment Date can not be Greater than Delivery Date");
	   $('#err_exp_payment_date').focus();
	   error_flag=true;
		}

	}*/
	if (err >= 1) {

		$('html, body').animate({ scrollTop: $("#gotovehi").offset().top }, 2000);
		return error_flag;
	}
	return error_flag;
}
function loanReceiptValidation() {
	error_flag = false;
	$('.error').html('');
	var paymentBy = $('#paymentBy').val();
	var paymentType = $('#paymentType').val();
	var instrumentType = $('#instrumentType').val();
	var instrument_no = $('#instrument_no').val();
	var credited_amt = $('#credited_amt').val();
	var credited_date = $('#credited_date').val();
	var favouring_in = $('#favouring_in').val();
	var drawn_on = $('#drawn_on').val();
	var receipt_date = $('#receipt_date').val();
	var amount = $('#amount').val();
	if (paymentBy == '') {
		$('#err_paymentBy').html("Please Select Payment By");
		error_flag = true;
	}
	if (paymentBy == '1') {
		if (paymentType == '') {
			$('#err_paymentType').html("Please Select Payment Type");
			error_flag = true;
		}
		if (instrumentType == '') {
			$('#err_instrumentType').html("Please Select Instrument Type");
			error_flag = true;
		}
		if (instrumentType == '1' || instrumentType == '3') {
			if (instrument_no == '') {
				$('#err_instrument_no').html("Please Enter Instrument No");
				error_flag = true;
			}
			if (favouring_in == '') {
				$('#err_favouring_in').html("Please Enter Favouring");
				error_flag = true;
			}
			if (drawn_on == '') {
				$('#err_drawn_on').html("Please Select Drawn On");
				error_flag = true;
			}
		}
		if (credited_amt == '') {
			$('#err_credited_amt').html("Please Enter Credited Amt");
			error_flag = true;
		}
		if (credited_date == '') {
			$('#err_credited_date').html("Please Enter Credited Date");
			error_flag = true;
		}

		/*if(receipt_date=='')
			{
				$('#err_receipt_date').html("Please Enter Receipt Date");
				error_flag=true;
			}*/
		if (error_flag == true) {
			$('html, body').animate({ scrollTop: $("#gototop").offset().top }, 2000);
		}
	}
	if (paymentBy == '2') {
		if (amount == '') {
			$('#err_amount').html("Please Enter Amount");
			error_flag = true;
		}
	}

	return error_flag;
}

function bnkInfoValidation() {
	error_flag = false;
	$('.error').html('');
	var bank_name = $('#bank_name').val();
	var bank_branch = $('#bank_branch').val();
	var account_no = $('#account_no').val();
	var ifsc_code = $('#ifsc_code').val();
	var account_type = $('input[name=account_type]:checked').length;
	if (bank_name == '') {
		$('#err_bank_name').html('Please Select Bank Name');
		error_flag = true;
	}
	if (bank_branch == '') {
		$('#err_bank_branch').html('Please Enter Bank Branch');
		error_flag = true;
	}
	if (account_no == '') {
		$('#err_account_no').html('Please Enter Account No');
		error_flag = true;
	}
	if ((account_no != '') && (account_no.length < 8 || account_no.length > 18)) {
		$('#err_account_no').html('Please Enter Valid Account No');
		error_flag = true;
	}
	/*if(ifsc_code=='')
	{
		$('#err_ifsc_code').html('Please Enter Valid IFSC Code');
		error_flag=true;
	}*/
	if ((ifsc_code != '') && (ifsc_code.length != '11')) {
		$('#err_ifsc_code').html('Please Enter Valid IFSC Code');
		error_flag = true;
	}
	if ((ifsc_code != '') && (!ifsc_code.match(alphanumeric))) {
		//$('#chassis_number').addClass('validClass');
		$('#err_ifsc_code').html("Please Enter Alphanumeric IFSC Code");
		error_flag = true;
	}
	if (account_type == '') {
		$('#err_account_type').html("Please Select Account Type");
		error_flag = true;
	}
	return error_flag;
}

function rcDetailErr() {
	error_flag = false;
	$('.error').html('');
	var rc_status = $('#rc_status').val();
	var assign_to = $('#assign_to').val();
	var assigned_on = $('#assigned_on').val();
	var rto_slip_no = $('#rto_slip_no').val();
	var pndingfrm = $('#pndingfrm').val();

	if (rc_status == '') {
		$('#err_rc_status').html('Please Select RC Status');
		error_flag = true;
	}
	if (pndingfrm == '2') {
		if (assign_to == '') {
			$('#err_rc_assigned').html('Please Select Assigned To');
			error_flag = true;
		}
		if (assigned_on == '') {
			$('#err_on').html('Please Select Assigned On Date');
			error_flag = true;
		}
	}
	if ((rc_status == '3') && (rto_slip_no == '')) {
		$('#err_rto_slip_no').html("Please Enter RTO Slip No.");
		error_flag = true;
	}
	return error_flag;
}

function advbookingErr() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var source = $('#source').val();
	var customer_name = $('#customer_name').val();
	var customer_mobile = $('#mobile').val();
	var amount_paid_to = $('#amount_paid_to').val();
	var showroom = $('#showroom').val();
	var make = $('#make').val();
	var color = $('#color').val();
	var model = $('#model').val();
	var version = $('#versionId').val();
	var reg = $('#registration').val();
	var emp_id = $('#emp_id').val();
	var dealer_name = $('#dealer_name').val();
	var registration = $('#registration').val();
	var kind_attn = $('#kind_attn').val();
	var booking_amount = $('#booking_amount').val();
	var err = 0;
	/*
		if(model==''){
	   alert('blank');
		}else{
	 alert('not blank');
		}*/

	if (source == '') {
		$('#source').addClass('validClass');
		$('#source').focus();
		$('#err_source').html("Please Select Source");
		error_flag = true;
		return error_flag;
	}
	if ((source != '') && (source == '1')) {
		if (dealer_name == '') {
			$('#dealer_name').addClass('validClass');
			$('#dealer_name').focus();
			$('#err_dealer_name').html("Please Select Dealership Name");
			error_flag = true;
			return error_flag;
		}
	}
	if (emp_id == '') {
		$('#emp_id').addClass('validClass');
		$('#emp_id').focus();
		$('#err_emp_id').html("Please Select Sale Executive");
		error_flag = true;
		return error_flag;
	}
	if ((booking_amount != '') && (/^[0-9,]*$/.test(booking_amount) == false)) {
		$('#booking_amount').addClass('validClass');
		$('#booking_amount').focus();
		$('#err_booking_amount').html("Please Enter Valid Booking Amount");
		error_flag = true;
		return error_flag;
	}
	if (amount_paid_to == '') {
		$('#amount_paid_to').addClass('validClass');
		$('#amount_paid_to').focus();
		$('#err_amount_paid_to').html("Please Select Amount Paid To");
		error_flag = true;
		return error_flag;
	}
	if (showroom == '') {
		$('#showroom').addClass('validClass');
		$('#showroom').focus();
		$('#err_showroom').html("Please Select Showroom");
		error_flag = true;
		return error_flag;
	}
	if (kind_attn == '') {
		$('#kind_attn').addClass('validClass');
		$('#kind_attn').focus();
		$('#err_kind_attn').html("Please Enter Kind Attn");
		error_flag = true;
		return error_flag;
	}
	if ((kind_attn != '') && (kind_attn.length < 3) && (/^[a-zA-z ]*$/.test(kind_attn) == false)) {
		$('#kind_attn').addClass('validClass');
		$('#kind_attn').focus();
		$('#err_kind_attn').html("Please Enter Kind Attn");
		error_flag = true;
		return error_flag;
	}

	if (customer_mobile == '') {
		$('#mobile').addClass('validClass');
		$('#mobile').focus();
		$('#err_customer_mobile').html("Please Enter Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((customer_mobile != '') && (!customer_mobile.match(regMobil))) {
		$('#mobile').addClass('validClass');
		$('#mobile').focus();
		$('#err_customer_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((customer_mobile != '') && (customer_mobile.length != 10)) {
		$('#mobile').addClass('validClass');
		$('#mobile').focus();
		$('#err_customer_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
		return error_flag;
	}
	if (customer_name == '') {
		$('#customer_name').addClass('validClass');
		$('#customer_name').focus();
		$('#err_customer_name').html("Please Enter Name");
		error_flag = true;
		return error_flag;
	}
	if ((customer_name != '') && (customer_name.length < 3) && (/^[a-zA-z ]*$/.test(customer_name) == false)) {
		$('#customer_name').addClass('validClass');
		$('#customer_name').focus();
		$('#err_customer_name').html("Please Enter Name");
		error_flag = true;
		return error_flag;
	}

	/* if(make=='')
	 {
		 $('#make').addClass('validClass');
		 $('#make').focus();
		 $('#err_make').html("Please Select Make");
		 error_flag=true;
		 return error_flag;
	 }*/

	/*if(color=='')
	{
		$('#color').addClass('validClass');
		$('#err_color').html("Please Select Color");
		error_flag=true;
	}*/
	if (model == '') {
		$('#model').addClass('validClass');
		$('#model').focus();
		$('#err_model').html("Please Select Make Model");
		error_flag = true;
		return error_flag;
	}
	if (version == '') {
		$('#versionId').addClass('validClass');
		$('#versionId').focus();
		$('#err_variant').html("Please Select Version");
		error_flag = true;
		return error_flag;
	}
	if (registration == '') {
		$('#registration').addClass('validClass');
		$('#registration').focus();
		$('#err_registration').html("Please Select Registration Type");
		error_flag = true;
		return error_flag;
	}

	if (error_flag == false) {
		return error_flag;
	}
}


function usedCarCaseInfo() {
	//alert('ggggg');
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var source_cat = $('#source_cat').val();
	var source_name = $('#source_name').val();
	var dob = $('#dob').val();
	var evaluated_by = $('#evaluated_by').val();
	var overall_condition = $('#overall_condition').val();
	var evaluation_remark = $('#evaluation_remark').val();
	var purchased_by = $('#purchased_by').val();
	var closed_by = $('#closed_by').val();
	var pdate = $('#pdate').val();
	var ddate = $('#ddate').val();
	var tradetype = $('input[name=tradetype]:checked').val();
	var purchase_amt = $('#purchase_amt').val().replace(/,/g, '');
	var expected_amt = $('#expected_amt').val().replace(/,/g, '');
	var need_validation = $('#need_validation').val();
	var liquid_mode = $('input[name=liquid_mode]:checked').val();

	if (need_validation == 'n') {
		return false;
	}
	if (source_cat == '') {
		$('#source_cat').addClass('validClass');
		$('#top').focus();
		$('#err_source_cat').html("Please Select Source Category");
		error_flag = true;
	}
	if (source_name == '') {
		$('#source_name').addClass('validClass');
		$('#top').focus();
		$('#err_source_name').html("Please Select Source Name");
		error_flag = true;
	}
	//DONT VALIDATE EVALUATION DATA FOR AUCTION CARS

	if (source_cat != 1) {
		if (dob == '') {
			$('#dob').addClass('validClass');
			$('#top').focus();
			$('#err_dp').html("Please Select Evaluation Date");
			error_flag = true;
		}
		if (evaluated_by == '') {
			$('#evaluated_by').addClass('validClass');
			$('#top').focus();
			$('#err_evaluated_by').html("Please Select Evaluated By");
			error_flag = true;
		}
		if (overall_condition == '') {
			$('#overall_condition').addClass('validClass');
			$('#overall_condition').focus();
			$('#err_condition').html("Please Select Overall Condition");
			error_flag = true;
		}
		if (evaluation_remark == '') {
			$('#evaluation_remark').addClass('validClass');
			$('#evaluation_remark').focus();
			$('#err_evaluation_remark').html("Please Enter Evaluation Remark");
			error_flag = true;
		}
	}
	if (tradetype == '') {
		$('#errtradediv').addClass('has-error');
		$('#errtrade').html("Please select Tradetype");
		$("#errtrade").css("display", "block");
		error_flag = true;
	}
	if (liquid_mode == '') {
		$('#errtradediv1').addClass('has-error');
		$('#err_liquid_mode').html("Please Select Liquid Mode");
		$("#err_liquid_mode").css("display", "block");
		error_flag = true;
	}

	if (tradetype == '2') {
		if (purchased_by == '') {
			$('#purchased_by').addClass('validClass');
			$('#purchased_by').focus();
			$('#err_purchased_by').html("Please Select Purchased By");
			error_flag = true;
		}
		if (pdate == '') {
			$('#pdate').addClass('validClass');
			$('#pdate').focus();
			$('#err_pdp').html("Please Select Purchased Date");
			error_flag = true;
			return error_flag;
		}
		if (purchase_amt <= 0) {
			$('#purchase_amt').addClass('validClass');
			$('#purchase_amt').focus();
			$('#err_puramt').html("Please Enter Purchased Amount");
			error_flag = true;
		}
	}
	else if (tradetype == '1') {
		if (expected_amt <= 0) {
			$('#expected_amt').addClass('validClass');
			$('#expected_amt').focus();
			$('#err_expamt').html("Please Enter Expected Amount");
			error_flag = true;
		}
		if (closed_by == '') {
			$('#closed_by').addClass('validClass');
			$('#closed_by').focus();
			$('#err_closed_by').html("Please Select Closed By");
			error_flag = true;
		}
	}
	if (ddate == '') {
		$('#ddate').addClass('validClass');
		$('#ddate').focus();
		$('#err_ddp').html("Please Select Delivery Date");
		error_flag = true;
	}

	return error_flag;
}

function usedCarSellInfo() {

	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var seller_type = $('#seller_type').val();
	var category_id = $('#category_id').val();
	var seller_name = $('#name').val();
	var seller_mobile = $('#mobile').val();
	var seller_email = $('#email').val();
	var seller_address = $('#address').val();
	// alert(seller_email);
	//return true;
	if (seller_type == '') {
		$('#seller_type').addClass('validClass');
		$('#err_seller_type').html("Please Select Seller Type.");
		error_flag = true;
		return error_flag;
	}
	if (seller_name == '') {
		$('#name').addClass('validClass');
		$('#err_name').html("Please Enter Name.");
		error_flag = true;
		return error_flag;
	}
	if (seller_name != '') {
		if ((/^[a-zA-z ]*$/.test(seller_name) == false)) {
			$('#name').addClass('validClass');
			$('#err_name').html("Please Enter Valid Name.");
			error_flag = true;
			return error_flag;
		}
		else if ((seller_name.length < 3)) {
			$('#name').addClass('validClass');
			$('#err_name').html("Name Should Have Min. 3 Characters");
			error_flag = true;
			return error_flag;
		}
	}
	if (seller_mobile == '') {
		$('#mobile').addClass('validClass');
		$('#err_mobile').html("Please Enter Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((seller_mobile != '') && (!seller_mobile.match(regMobil))) {
		$('#mobile').addClass('validClass');
		$('#err_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((seller_mobile != '') && (seller_mobile.length != 10)) {
		$('#mobile').addClass('validClass');
		$('#err_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
		return error_flag;
	}
	if (seller_email == '') {
		$('#email').addClass('validClass');
		$('#err_email').html("Please Enter Email");
		error_flag = true;
		return error_flag;
	}
	//  alert(seller_email);
	if ((seller_email != '') && (!seller_email.match(emailReg))) {
		//alert('fffff');
		$('#email').addClass('validClass');
		$('#err_email').html("Please Enter valid Email");
		error_flag = true;
		return error_flag;
	}
	return error_flag;
}

function usedCarPayInfo() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var purchaseprice = $('#purchaseprice').val();
	var purchasedate = $('#purchasedate').val();
	var instrumenttype = $('#instrumenttype').val();
	var amount = $('#amount').val();
	var insno = $('#insno').val();
	var payment_bank = $('#payment_bank').val();
	var insdate = $('#insdate').val();
	var favouring = $('#favouring').val();
	var paydate = $('#paydate').val();
	//  var paydates = $('#paydates').val();
	if (purchaseprice == '') {
		$('#purchaseprice').addClass('validClass');
		$('#err_purchaseprice').html("Please Enter Purchase Price");
		error_flag = true;
		return error_flag;
	}
	if (purchasedate == '') {
		$('#purchasedate').addClass('validClass');
		$('#err_purchasedate').html("Please Enter Purchase Date");
		error_flag = true;
		return error_flag;
	}
	if (instrumenttype == '') {
		$('#instrumenttype').addClass('validClass');
		$('#err_instrumenttype').html("Please Enter Instrument Type");
		error_flag = true;
		return error_flag;
	}
	if (amount == '') {
		$('#amount').addClass('validClass');
		$('#err_amount').html("Please Enter Amount");
		error_flag = true;
		return error_flag;
	}
	if (instrumenttype == '2') {

		if (insno == '') {
			// $('#insno').addClass('validClass');
			// $('#err_insno').html("Please Enter Instrument No.");
			//  error_flag=true;
			//	return error_flag;
		}
		if (payment_bank == '') {
			// $('#payment_bank').addClass('validClass');
			// $('#err_bank_list').html("Please Enter Payment Bank");
			//  error_flag=true;
			//return error_flag;
		}
		if (insdate == '') {
			//$('#insdate').addClass('validClass');
			//  $('#err_insdate').html("Please Enter Instrument Date");
			//  error_flag=true;
			//	return error_flag;
		}
		if (favouring == '') {
			//  $('#favouring').addClass('validClass');
			// $('#err_favouring').html("Please Enter Favouring");
			//  error_flag=true;
			//	return error_flag;
		}
	} else {
		if (paydate == '') {
			$('#paydate').addClass('validClass');
			$('#err_paydate').html("Please Enter Payment Date");
			error_flag = true;
			return error_flag;
		}
	}
	return error_flag;
}

function usedCarRefurbInfo() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	/* var purchaseprice = $('#purchaseprice').val();
	 var purchasedate = $('#purchasedate').val();
	 var instrumenttype = $('#instrumenttype').val();
	 var amount = $('#amount').val();
	 var insno = $('#insno').val();
	 var payment_bank = $('#payment_bank').val();
	 var insdate = $('#insdate').val();
	 var favouring = $('#favouring').val();
	 var paydate = $('#paydate').val();
	 if(purchaseprice=='')
		 {
			 $('#purchaseprice').addClass('validClass');
			 $('#err_purchaseprice').html("Please Enter Purchase Price");
			 error_flag=true;
			 return error_flag;
		 }
		 if(purchasedate=='')
		 {
			 $('#purchasedate').addClass('validClass');
			 $('#err_purchasedate').html("Please Enter Purchase Date");
			 error_flag=true;
			 return error_flag;
		 }
		 if(instrumenttype=='')
		 {
			 $('#instrumenttype').addClass('validClass');
			 $('#err_instrumenttype').html("Please Enter Instrument Type");
			 error_flag=true;
			 return error_flag;
		 }
		 if(amount=='')
		 {
			 $('#amount').addClass('validClass');
			 $('#err_amount').html("Please Enter Amount");
			 error_flag=true;
			 return error_flag;
		 }
		 if(insno=='')
		 {
			 $('#insno').addClass('validClass');
			 $('#err_insno').html("Please Enter Instrument No.");
			 error_flag=true;
			 return error_flag;
		 }
		 if(payment_bank=='')
		 {
			 $('#payment_bank').addClass('validClass');
			 $('#err_bank_list').html("Please Enter Payment Bank");
			 error_flag=true;
			 return error_flag;
		 }
		 if(insdate=='')
		 {
			 $('#insdate').addClass('validClass');
			 $('#err_insdate').html("Please Enter Instrument Date");
			 error_flag=true;
			 return error_flag;
		 }
		 if(favouring=='')
		 {
			 $('#favouring').addClass('validClass');
			 $('#err_favouring').html("Please Enter Favouring");
			 error_flag=true;
			 return error_flag;
		 }
		 if(paydate=='')
		 {
			 $('#paydate').addClass('validClass');
			 $('#err_paydate').html("Please Enter Payment Date");
			 error_flag=true;
			 return error_flag;
		 }*/
	return error_flag;
}


function refurbWorkshopErr() {
	error_flag = false;
	$('.error').html('');
	$('.form-control').removeClass('validClass');
	var name = $('#name').val();
	var mobile = $('#mobile').val();
	var services = $('#service').val();
	var address = $('#address').val();
	var owner_name = $('#owner_name').val();
	var owner_mobile = $('#owner_mobile').val();
	if (name == '') {
		$('#name').addClass('validClass');
		$('#name').focus();
		$('#err_name').html("Please Enter Name.");
		error_flag = true;
		return error_flag;
	}
	if (name != '') {
		if ((name.length < 3) && (/^[a-zA-z ]*$/.test(name) == false)) {
			$('#name').addClass('validClass');
			$('#name').focus();
			$('#err_name').html("Please Enter Valid Name.");
			error_flag = true;
			return error_flag;
		}
	}
	if (mobile == '') {
		$('#mobile').addClass('validClass');
		$('#mobile').focus();
		$('#err_mobile').html("Please Enter Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((mobile != '') && (!mobile.match(regMobil))) {
		$('#mobile').addClass('validClass');
		$('#mobile').focus();
		$('#err_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((mobile != '') && (mobile.length != 10)) {
		$('#mobile').addClass('validClass');
		$('#mobile').focus();
		$('#err_mobile').html("Please Enter Valid Mobile");
		error_flag = true;
		return error_flag;
	}
	if (address == '') {
		$('#address').addClass('validClass');
		$('#address').focus();
		$('#err_address').html("Please Enter Address");
		error_flag = true;
		return error_flag;
	}
	if (services == '') {
		$('#service').addClass('validClass');
		$('#service').focus();
		$('#err_service').html("Please Select Service");
		error_flag = true;
		return error_flag;
	}
	if (owner_name == '') {
		$('#owner_name').addClass('validClass');
		$('#owner_name').focus();
		$('#err_owner_name').html("Please Enter Name.");
		error_flag = true;
		return error_flag;
	}
	if (owner_name != '') {
		if ((owner_name.length < 3) && (/^[a-zA-z ]*$/.test(owner_name) == false)) {
			$('#owner_name').focus();
			$('#owner_name').addClass('validClass');
			$('#err_owner_name').html("Please Enter Valid Owner Name.");
			error_flag = true;
			return error_flag;
		}
	}
	if (owner_mobile == '') {
		$('#owner_mobile').focus();
		$('#owner_mobile').addClass('validClass');
		$('#err_owner_mobile').html("Please Enter Owner Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((owner_mobile != '') && (!owner_mobile.match(regMobil))) {
		$('#owner_mobile').focus();
		$('#owner_mobile').addClass('validClass');
		$('#err_owner_mobile').html("Please Enter Valid Owner Mobile");
		error_flag = true;
		return error_flag;
	}
	if ((owner_mobile != '') && (owner_mobile.length != 10)) {
		$('#owner_mobile').focus();
		$('#owner_mobile').addClass('validClass');
		$('#err_owner_mobile').html("Please Enter Valid Owner Mobile");
		error_flag = true;
		return error_flag;
	}
	return error_flag;
}

function coapplicantForm() {
	error_flag = false;
	$('.error').html('');
	$('.form-group').removeClass('validClass');
	$('.form-control').removeClass('validClass');
	var d = new Date();
	var m = d.getMonth();
	var y = d.getFullYear();
	var highest_education = $('#highest_education').val();
	var employment_type = $('#employment_type').val()
	var employer_name = $('#employer_name').val();
	var date_of_joining = $('#date_of_joining').val();
	var total_experience = $('#total_experience').val();
	var monthly_income = $('#monthly_income').val();
	var notice_period = $('#notice_period').val();
	var type_of_vehicle_owned = $('#type_of_vehicle_owned').val();
	var vehicle_ownership = $('#vehicle_ownership').val();
	var bus_business_name = $('#bus_business_name').val();
	var bus_office_setup_type = $('#bus_office_setup_type').val();
	var bus_start_date_month = $('#bus_start_date_month').val();
	var bus_start_date_year = $('#bus_start_date_year').val();
	var bus_itr_income1 = $('#bus_itr_income1').val();
	var bus_itr_income2 = $('#bus_itr_income2').val();
	var pro_office_setup_type = $('#pro_office_setup_type').val();
	var pro_itr_income1 = $('#pro_itr_income1').val();
	var pro_itr_income2 = $('#pro_itr_income2').val();
	var pro_start_date_month = $('#pro_start_date_month').val();
	var pro_start_date_year = $('#pro_start_date_year').val();
	var oth_type = $('#oth_type').val();
	var others_followup = $('input[name=others_followup]:checked').length;
	var others_loan = $('input[name=others_loan]:checked').length;
	var office_address = $('#office_address').val();
	var office_cityList = $('#office_cityList').val();
	var office_pincode = $('#office_pincode').val();
	var office_phone = $('#office_phone').val();
	var office_mobile = $('#office_mobile').val();
	var office_email = $('#office_email').val();

	var bank_name = $('#bank_name').val();
	var bank_branch = $('#bank_branch').val();
	var account_no = $('#account_no').val();
	var ifsc_code = $('#ifsc_code').val();
	var account_type = $('input[name=account_type]:checked').length;

	//var buyerType = $('#buyerType').val();
	//var = $('#').val();\
	//alert('hiii');
	if (highest_education == '0') {
		$('#highest_education').addClass('validClass');
		$('#err_highest_education').html("Please Select Highest Education");
		error_flag = true;
	}
	if (employment_type == '') {
		$('#employment_type').addClass('validClass');
		$('#err_employment_type').html("Please Select Employment Type");
		error_flag = true;
	}
	if (employment_type == '1') {
		if (employer_name == '') {
			$('#employer_name').addClass('validClass');
			$('#err_employer_name').html("Please Enter Employer Name");
			error_flag = true;
		}
		if (employer_name != '') {
			if (employer_name.length < 3) {
				$('#employer_name').addClass('validClass');
				$('#err_employer_name').html("Employer Name should have atleast 3 characters");
				error_flag = true;
			}
		}
		if (date_of_joining == '') {
			$('#date_of_joining').addClass('validClass');
			$('#err_dp').html("Please select Date of Joining");
			error_flag = true;
		}
		if (total_experience == '') {
			$('#total_experience').addClass('validClass');
			$('#err_total_experience').html("Please Enter Total Experience");
			error_flag = true;
		}
		if ((total_experience != '') && (total_experience > '60') && (/^[0-9]*$/.test(total_experience) == false)) {
			$('#total_experience').addClass('validClass');
			$('#err_total_experience').html("Please Enter Valid Total Experience");
			error_flag = true;
		}
		if (monthly_income == '') {
			$('#monthly_income').addClass('validClass');
			$('#err_monthly_income').html("Please Enter Monthly Income");
			error_flag = true;
		}
		if ((monthly_income < '10000') && (/^[0-9,]*$/.test(monthly_income) == false)) {
			$('#monthly_income').addClass('validClass');
			$('#err_monthly_income').html("Please Enter Valid Monthly Income");
			error_flag = true;
		}
		if (notice_period == '') {
			$('#notice_period').addClass('validClass');
			$('#err_notice_period').html("Please Enter Notice Period");
			error_flag = true;
		}
	}
	if (employment_type == '2') {
		if (bus_business_name == '') {
			$('#bus_business_name').addClass('validClass');
			$('#err_bus_business_name').html("Please Enter Business Name");
			error_flag = true;
		}
		if (bus_office_setup_type == '') {
			$('#bus_office_setup_type').addClass('validClass');
			$('#err_bus_office_setup_type').html("Please Select Office Setup Type");
			error_flag = true;
		}
		if (bus_start_date_month == '') {
			$('#bus_start_date_month').addClass('validClass');
			$('#err_bus_start_date_month').html("Please Select Business Start Month");
			error_flag = true;
		}
		if (bus_start_date_year == '') {
			$('#bus_start_date_year').addClass('validClass');
			$('#err_bus_start_date_year').html("Please Select Business Start Year");
			error_flag = true;
		}
		if ((bus_start_date_month != '') && (bus_start_date_year != '')) {
			if ((bus_start_date_year == y) && (bus_start_date_month > m)) {
				$('#bus_start_date_month').addClass('validClass');
				$('#bus_start_date_year').addClass('validClass');
				$('#err_bus_start_date_year').html("Please Select Valid Business Start Year");
				error_flag = true;
			}
		}
		if ((bus_start_date_year != '') && (bus_start_date_year != y)) {
			/*if(bus_itr_income1=='')
			{
				$('#bus_itr_income1').addClass('validClass');
				$('#err_bus_itr_income1').html("Please Enter Last Years ITR");
				error_flag=true;
			}*/
			//alert(bus_itr_income1);
			if ((bus_itr_income1 != '') && (/^[0-9,]*$/.test(bus_itr_income1) == false)) {
				$('#bus_itr_income1').addClass('validClass');
				$('#err_bus_itr_income1').html("Please Enter Valid Last Years ITR");
				error_flag = true;
			}
			/*if(bus_itr_income2=='')
			{
				$('#bus_itr_income2').addClass('validClass');
				$('#err_bus_itr_income2').html("Please Enter Last Years ITR");
				error_flag=true;
			}
			else */
			if ((bus_itr_income2 != '') && (/^[0-9,]*$/.test(bus_itr_income2) == false)) {
				$('#bus_itr_income2').addClass('validClass');
				$('#err_bus_itr_income2').html("Please Enter Valid Last Years ITR");
				error_flag = true;
			}
			if ((bus_itr_income1 != '') && (bus_itr_income1.replace(/,/g, '') < '10000')) {
				$('#bus_itr_income1').addClass('validClass');
				$('#err_bus_itr_income1').html("Please Enter Valid Last Years ITR  at Least 10,000");
				error_flag = true;
			}
			if ((bus_itr_income2 != '') && (bus_itr_income2.replace(/,/g, '') < '10000')) {
				$('#bus_itr_income2').addClass('validClass');
				$('#err_bus_itr_income2').html("Please Enter Valid Last Years ITR  at Least 10,000");
				error_flag = true;
			}

		}
	}
	if (employment_type == '3') {
		if (pro_office_setup_type == '') {
			$('#pro_office_setup_type').addClass('validClass');
			$('#err_pro_office_setup_type').html("Please Select Office Setup Type");
			error_flag = true;
		}
		/*if(pro_itr_income1=='')
		{
			$('#pro_itr_income1').addClass('validClass');
			$('#err_pro_itr_income1').html("Please Enter Last Years ITR");
			error_flag=true;
		}*/
		if ((pro_itr_income1.replace(/,/g, '') < '10000') && (/^[0-9,]*$/.test(pro_itr_income1) == false)) {
			$('#pro_itr_income1').addClass('validClass');
			$('#err_pro_itr_income1').html("Please Enter Valid Last Years ITR  at Least 10,000");
			error_flag = true;
		}
		/*if(pro_itr_income2=='')
		{
			$('#pro_itr_income2').addClass('validClass');
			$('#err_pro_itr_income2').html("Please Enter Last Years ITR ");
			error_flag=true;
		}*/
		if ((pro_itr_income2.replace(/,/g, '') < '10000') && (/^[0-9,]*$/.test(pro_itr_income2) == false)) {
			$('#pro_itr_income2').addClass('validClass');
			$('#err_pro_itr_income1').html("Please Enter Valid Last Years ITR at Least 10,000");
			error_flag = true;
		}
		if (pro_start_date_month == '') {
			$('#pro_start_date_month').addClass('validClass');
			$('#err_pro_start_date_month').html("Please Select Profession Start Month");
			error_flag = true;
		}
		if (pro_start_date_year == '') {
			$('#pro_start_date_year').addClass('validClass');
			$('#err_pro_start_date_year').html("Please Select Profession Start Year");
			error_flag = true;
		}
	}
	if (employment_type == '4') {
		if (oth_type == '') {
			$('#pro_oth_type').addClass('validClass');
			$('#err_oth_type').html("Please Select Other Type");
			error_flag = true;
		}
		if (others_followup == '') {
			$('#others_followup').addClass('validClass');
			$('#err_others_followup').html("Please Select Other Followup");
			error_flag = true;
		}
		if (others_loan == '') {
			$('#others_loan').addClass('validClass');
			$('#err_others_loan').html("Please Select Other Loan");
			error_flag = true;
		}

	}

	if (type_of_vehicle_owned == '') {
		$('#type_of_vehicle_owned').addClass('validClass');
		$('#err_type_of_vehicle_owned').html("Please Select Type of Vehicle Owned");
		error_flag = true;
	}
	if (vehicle_ownership == '') {
		$('#vehicle_ownership').addClass('validClass');
		$('#err_vehicle_ownership').html("Please Select Type of Vehicle Ownership");
		error_flag = true;
	}

	//if((bus_office_setup_type=='2') && (employment_type=='2')){
	if ((((bus_office_setup_type == '2') || (pro_office_setup_type == '2')) && ((employment_type == '2') || (employment_type == '3')))) {
		if (office_address == '') {
			$('#office_address').addClass('validClass');
			$('#err_office_address').html("Please Enter Office Address");
			error_flag = true;
		}
		if ((office_address != '') && (/^[\/a-zA-Z0-9,-._ ]*$/.test(office_address) == false)) {
			$('#office_address').addClass('validClass');
			$('#err_office_address').html("Please Enter Valid Office Address");
			error_flag = true;
		}
		if (office_cityList == '') {
			$('#office_cityList').addClass('validClass');
			$('#err_office_cityList').html("Please Select Office City");
			error_flag = true;
		}
		if (office_pincode == '') {
			$('#office_pincode').addClass('validClass');
			$('#err_office_pincode').html("Please Enter Office Pincode");
			error_flag = true;
		}
		if ((office_pincode != '') && (office_pincode.length != 6)) {
			$('#office_pincode').addClass('validClass');
			$('#err_office_pincode').html("Please Enter Valid Office Pincode");
			error_flag = true;
		}
	}
	if (bank_name == '') {
		$('#err_bank_name').html('Please Select Bank Name');
		error_flag = true;
	}
	if (bank_branch == '') {
		$('#err_bank_branch').html('Please Enter Bank Branch');
		error_flag = true;
	}
	if (account_no == '') {
		$('#err_account_no').html('Please Enter Account No');
		error_flag = true;
	}
	if ((account_no != '') && (account_no.length < 8 || account_no.length > 18)) {
		$('#err_account_no').html('Please Enter Valid Account No');
		error_flag = true;
	}
	/*if(ifsc_code=='')
	{
		$('#err_ifsc_code').html('Please Enter Valid IFSC Code');
		error_flag=true;
	}*/
	if ((ifsc_code != '') && (ifsc_code.length != '11')) {
		$('#err_ifsc_code').html('Please Enter Valid IFSC Code');
		error_flag = true;
	}
	if ((ifsc_code != '') && (!ifsc_code.match(alphanumeric))) {
		//$('#chassis_number').addClass('validClass');
		$('#err_ifsc_code').html("Please Enter Alphanumeric IFSC Code");
		error_flag = true;
	}
	if (account_type == '') {
		$('#err_account_type').html("Please Select Account Type");
		error_flag = true;
	}
	return error_flag;
}


function guarantorForm() {
	error_flag = false;
	$('.error').html('');
	$('.form-group').removeClass('validClass');
	$('.form-control').removeClass('validClass');
	var d = new Date();
	var m = d.getMonth();
	var y = d.getFullYear();
	var highest_education = $('#highest_education').val();
	var employment_type = $('#employment_type').val()
	var employer_name = $('#employer_name').val();
	var date_of_joining = $('#date_of_joining').val();
	var total_experience = $('#total_experience').val();
	var monthly_income = $('#monthly_income').val();
	var notice_period = $('#notice_period').val();
	var type_of_vehicle_owned = $('#type_of_vehicle_owned').val();
	var vehicle_ownership = $('#vehicle_ownership').val();
	var bus_business_name = $('#bus_business_name').val();
	var bus_office_setup_type = $('#bus_office_setup_type').val();
	var bus_start_date_month = $('#bus_start_date_month').val();
	var bus_start_date_year = $('#bus_start_date_year').val();
	var bus_itr_income1 = $('#bus_itr_income1').val();
	var bus_itr_income2 = $('#bus_itr_income2').val();
	var pro_office_setup_type = $('#pro_office_setup_type').val();
	var pro_itr_income1 = $('#pro_itr_income1').val();
	var pro_itr_income2 = $('#pro_itr_income2').val();
	var pro_start_date_month = $('#pro_start_date_month').val();
	var pro_start_date_year = $('#pro_start_date_year').val();
	var oth_type = $('#oth_type').val();
	var others_followup = $('input[name=others_followup]:checked').length;
	var others_loan = $('input[name=others_loan]:checked').length;
	var office_address = $('#office_address').val();
	var office_cityList = $('#office_cityList').val();
	var office_pincode = $('#office_pincode').val();
	var office_phone = $('#office_phone').val();
	var office_mobile = $('#office_mobile').val();
	var office_email = $('#office_email').val();

	var bank_name = $('#bank_name').val();
	var bank_branch = $('#bank_branch').val();
	var account_no = $('#account_no').val();
	var ifsc_code = $('#ifsc_code').val();
	var account_type = $('input[name=account_type]:checked').length;

	//var buyerType = $('#buyerType').val();
	//var = $('#').val();\
	//alert('hiii');
	if (highest_education == '0') {
		$('#highest_education').addClass('validClass');
		$('#err_highest_education').html("Please Select Highest Education");
		error_flag = true;
	}
	if (employment_type == '') {
		$('#employment_type').addClass('validClass');
		$('#err_employment_type').html("Please Select Employment Type");
		error_flag = true;
	}
	if (employment_type == '1') {
		if (employer_name == '') {
			$('#employer_name').addClass('validClass');
			$('#err_employer_name').html("Please Enter Employer Name");
			error_flag = true;
		}
		if (employer_name != '') {
			if (employer_name.length < 3) {
				$('#employer_name').addClass('validClass');
				$('#err_employer_name').html("Employer Name should have atleast 3 characters");
				error_flag = true;
			}
		}
		if (date_of_joining == '') {
			$('#date_of_joining').addClass('validClass');
			$('#err_dp').html("Please select Date of Joining");
			error_flag = true;
		}
		if (total_experience == '') {
			$('#total_experience').addClass('validClass');
			$('#err_total_experience').html("Please Enter Total Experience");
			error_flag = true;
		}
		if ((total_experience != '') && (total_experience > '60') && (/^[0-9]*$/.test(total_experience) == false)) {
			$('#total_experience').addClass('validClass');
			$('#err_total_experience').html("Please Enter Valid Total Experience");
			error_flag = true;
		}
		if (monthly_income == '') {
			$('#monthly_income').addClass('validClass');
			$('#err_monthly_income').html("Please Enter Monthly Income");
			error_flag = true;
		}
		if ((monthly_income < '10000') && (/^[0-9,]*$/.test(monthly_income) == false)) {
			$('#monthly_income').addClass('validClass');
			$('#err_monthly_income').html("Please Enter Valid Monthly Income");
			error_flag = true;
		}
		if (notice_period == '') {
			$('#notice_period').addClass('validClass');
			$('#err_notice_period').html("Please Enter Notice Period");
			error_flag = true;
		}
	}
	if (employment_type == '2') {
		if (bus_business_name == '') {
			$('#bus_business_name').addClass('validClass');
			$('#err_bus_business_name').html("Please Enter Business Name");
			error_flag = true;
		}
		if (bus_office_setup_type == '') {
			$('#bus_office_setup_type').addClass('validClass');
			$('#err_bus_office_setup_type').html("Please Select Office Setup Type");
			error_flag = true;
		}
		if (bus_start_date_month == '') {
			$('#bus_start_date_month').addClass('validClass');
			$('#err_bus_start_date_month').html("Please Select Business Start Month");
			error_flag = true;
		}
		if (bus_start_date_year == '') {
			$('#bus_start_date_year').addClass('validClass');
			$('#err_bus_start_date_year').html("Please Select Business Start Year");
			error_flag = true;
		}
		if ((bus_start_date_month != '') && (bus_start_date_year != '')) {
			if ((bus_start_date_year == y) && (bus_start_date_month > m)) {
				$('#bus_start_date_month').addClass('validClass');
				$('#bus_start_date_year').addClass('validClass');
				$('#err_bus_start_date_year').html("Please Select Valid Business Start Year");
				error_flag = true;
			}
		}
		if ((bus_start_date_year != '') && (bus_start_date_year != y)) {
			/*if(bus_itr_income1=='')
			{
				$('#bus_itr_income1').addClass('validClass');
				$('#err_bus_itr_income1').html("Please Enter Last Years ITR");
				error_flag=true;
			}*/
			//alert(bus_itr_income1);
			if ((bus_itr_income1 != '') && (/^[0-9,]*$/.test(bus_itr_income1) == false)) {
				$('#bus_itr_income1').addClass('validClass');
				$('#err_bus_itr_income1').html("Please Enter Valid Last Years ITR");
				error_flag = true;
			}
			/*if(bus_itr_income2=='')
			{
				$('#bus_itr_income2').addClass('validClass');
				$('#err_bus_itr_income2').html("Please Enter Last Years ITR");
				error_flag=true;
			}
			else */
			if ((bus_itr_income2 != '') && (/^[0-9,]*$/.test(bus_itr_income2) == false)) {
				$('#bus_itr_income2').addClass('validClass');
				$('#err_bus_itr_income2').html("Please Enter Valid Last Years ITR");
				error_flag = true;
			}
			if ((bus_itr_income1 != '') && (bus_itr_income1.replace(/,/g, '') < '10000')) {
				$('#bus_itr_income1').addClass('validClass');
				$('#err_bus_itr_income1').html("Please Enter Valid Last Years ITR  at Least 10,000");
				error_flag = true;
			}
			if ((bus_itr_income2 != '') && (bus_itr_income2.replace(/,/g, '') < '10000')) {
				$('#bus_itr_income2').addClass('validClass');
				$('#err_bus_itr_income2').html("Please Enter Valid Last Years ITR  at Least 10,000");
				error_flag = true;
			}

		}
	}
	if (employment_type == '3') {
		if (pro_office_setup_type == '') {
			$('#pro_office_setup_type').addClass('validClass');
			$('#err_pro_office_setup_type').html("Please Select Office Setup Type");
			error_flag = true;
		}
		/*if(pro_itr_income1=='')
		{
			$('#pro_itr_income1').addClass('validClass');
			$('#err_pro_itr_income1').html("Please Enter Last Years ITR");
			error_flag=true;
		}*/
		if ((pro_itr_income1.replace(/,/g, '') < '10000') && (/^[0-9,]*$/.test(pro_itr_income1) == false)) {
			$('#pro_itr_income1').addClass('validClass');
			$('#err_pro_itr_income1').html("Please Enter Valid Last Years ITR  at Least 10,000");
			error_flag = true;
		}
		/*if(pro_itr_income2=='')
		{
			$('#pro_itr_income2').addClass('validClass');
			$('#err_pro_itr_income2').html("Please Enter Last Years ITR ");
			error_flag=true;
		}*/
		if ((pro_itr_income2.replace(/,/g, '') < '10000') && (/^[0-9,]*$/.test(pro_itr_income2) == false)) {
			$('#pro_itr_income2').addClass('validClass');
			$('#err_pro_itr_income1').html("Please Enter Valid Last Years ITR at Least 10,000");
			error_flag = true;
		}
		if (pro_start_date_month == '') {
			$('#pro_start_date_month').addClass('validClass');
			$('#err_pro_start_date_month').html("Please Select Profession Start Month");
			error_flag = true;
		}
		if (pro_start_date_year == '') {
			$('#pro_start_date_year').addClass('validClass');
			$('#err_pro_start_date_year').html("Please Select Profession Start Year");
			error_flag = true;
		}
	}
	if (employment_type == '4') {
		if (oth_type == '') {
			$('#pro_oth_type').addClass('validClass');
			$('#err_oth_type').html("Please Select Other Type");
			error_flag = true;
		}
		if (others_followup == '') {
			$('#others_followup').addClass('validClass');
			$('#err_others_followup').html("Please Select Other Followup");
			error_flag = true;
		}
		if (others_loan == '') {
			$('#others_loan').addClass('validClass');
			$('#err_others_loan').html("Please Select Other Loan");
			error_flag = true;
		}

	}

	if (type_of_vehicle_owned == '') {
		$('#type_of_vehicle_owned').addClass('validClass');
		$('#err_type_of_vehicle_owned').html("Please Select Type of Vehicle Owned");
		error_flag = true;
	}
	if (vehicle_ownership == '') {
		$('#vehicle_ownership').addClass('validClass');
		$('#err_vehicle_ownership').html("Please Select Type of Vehicle Ownership");
		error_flag = true;
	}

	//if((bus_office_setup_type=='2') && (employment_type=='2')){
	if ((((bus_office_setup_type == '2') || (pro_office_setup_type == '2')) && ((employment_type == '2') || (employment_type == '3')))) {
		if (office_address == '') {
			$('#office_address').addClass('validClass');
			$('#err_office_address').html("Please Enter Office Address");
			error_flag = true;
		}
		if ((office_address != '') && (/^[\/a-zA-Z0-9,-._ ]*$/.test(office_address) == false)) {
			$('#office_address').addClass('validClass');
			$('#err_office_address').html("Please Enter Valid Office Address");
			error_flag = true;
		}
		if (office_cityList == '') {
			$('#office_cityList').addClass('validClass');
			$('#err_office_cityList').html("Please Select Office City");
			error_flag = true;
		}
		if (office_pincode == '') {
			$('#office_pincode').addClass('validClass');
			$('#err_office_pincode').html("Please Enter Office Pincode");
			error_flag = true;
		}
		if ((office_pincode != '') && (office_pincode.length != 6)) {
			$('#office_pincode').addClass('validClass');
			$('#err_office_pincode').html("Please Enter Valid Office Pincode");
			error_flag = true;
		}
	}
	if (bank_name == '') {
		$('#err_bank_name').html('Please Select Bank Name');
		error_flag = true;
	}
	if (bank_branch == '') {
		$('#err_bank_branch').html('Please Enter Bank Branch');
		error_flag = true;
	}
	if (account_no == '') {
		$('#err_account_no').html('Please Enter Account No');
		error_flag = true;
	}
	if ((account_no != '') && (account_no.length < 8 || account_no.length > 18)) {
		$('#err_account_no').html('Please Enter Valid Account No');
		error_flag = true;
	}
	/*if(ifsc_code=='')
	{
		$('#err_ifsc_code').html('Please Enter Valid IFSC Code');
		error_flag=true;
	}*/
	if ((ifsc_code != '') && (ifsc_code.length != '11')) {
		$('#err_ifsc_code').html('Please Enter Valid IFSC Code');
		error_flag = true;
	}
	if ((ifsc_code != '') && (!ifsc_code.match(alphanumeric))) {
		//$('#chassis_number').addClass('validClass');
		$('#err_ifsc_code').html("Please Enter Alphanumeric IFSC Code");
		error_flag = true;
	}
	if (account_type == '') {
		$('#err_account_type').html("Please Select Account Type");
		error_flag = true;
	}
	return error_flag;
}