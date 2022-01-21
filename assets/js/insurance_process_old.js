/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getShowForm(frm,from,div){
    var datastring=$("#"+from).serialize();
    var caseid=$("#caseid").val();
    var errormsg=false;
    
    if(from=='frm1'){
        errormsg=checkform1();
        if(errormsg){
            return true;
        }
    }
    if(from=='frm2'){
        errormsg=checkform2();
        if(errormsg){
            return true;
        }
    }
            $.ajax({
		type: "POST",
		url: base_url+"insurance/addNewProcess",
		data:'type=validate_'+div+'&'+datastring,
                dataType:"json",
		success: function(r, s){
               //console.log(r[0]);
                   $("#caseid").val(r[0].id);
                   //$("#ins_category").val(r[0].ins_category);
                   $('select[name^="ins_category"] option[value='+r[0].ins_category+']').attr("selected","selected");
                   $("#case_status").val(r[0].customer_status);
                   
                    for(var i=1;i<4; i++)
                    {
                       $("#form"+i).hide();
                    }
                    $('ul.par-ul li a').removeClass('active');
                    $("#sid2").addClass('active');
                    $("#"+frm).show();
                
        }
        });
    
      
}

function checkform1()
{
    var customer_name=$("#customer_name").val();
    var customer_mobile=$("#customer_mobile").val();
    var customer_address=$("#customer_address").val();
    var customer_pincode=$("#customer_pincode").val();
    var customer_city=$("#customer_city").val();
    var customer_email=$("#customer_email").val();
    var customer_aadhar=$("#customer_aadhar").val();
    var customer_pan=$("#customer_pan").val();
    var isaddress=$("#isaddress").val();
    var nominee_customer_name=$("#nominee_customer_name").val();
    var nominee_customer_relation=$("#nominee_customer_relation").val();
    var nominee_customer_dob=$("#nominee_customer_dob").val();
    var reference_customer_name=$("#reference_customer_name").val();
    var reference_customer_mobile=$("#reference_customer_mobile").val();
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    var emailregex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var errorflag=false;
    if(customer_name==''){
        $('#customer_name_error').text('Please Enter Customer name');
        errorflag=true;
    }else{
       $('#customer_name_error').text('');
    }
    if(customer_mobile==''){
        $('#customer_mobile_error').text('Please Enter Customer mobile');
        errorflag=true;
    }else if(!numberRegex.test(customer_mobile)){
       $('#customer_mobile_error').text('Please Enter valid Customer mobile');
       errorflag=true;
    }else{
       $('#customer_mobile_error').text('');
    }
    if(customer_address==''){
        $('#customer_address_error').text('Please Enter Customer address');
        errorflag=true;
    }else{
       $('#customer_address_error').text('');
    }
    if(customer_pincode==''){
        $('#customer_pincode_error').text('Please Enter Customer pincode');
        errorflag=true;
    }else{
       $('#customer_pincode_error').text('');
    }
    if(customer_city==''){
        $('#customer_city_error').text('Please Enter Customer city');
        errorflag=true;
    }else{
       $('#customer_city_error').text('');
    }
    if(customer_email==''){
        $('#customer_email_error').text('Please Enter Customer email');
        errorflag=true;
    }else if(emailregex.test(customer_email)){
       $('#customer_email_error').text('Please Enter Customer valid email');
       errorflag=true;
    }else{
       $('#customer_email_error').text('');
    }
    if(customer_aadhar==''){
        $('#customer_aadhar_error').text('Please Enter Customer aadhar');
        errorflag=true;
    }else{
       $('#customer_aadhar_error').text('');
    }
    if(customer_pan==''){
        $('#customer_pan_error').text('Please Enter Customer pan');
        errorflag=true;
    }else{
       $('#customer_pan_error').text('');
    }
    if(nominee_customer_name==''){
        $('#nominee_customer_name_error').text('Please Enter Nominee Customer name');
        errorflag=true;
    }else{
       $('#nominee_customer_name_error').text('');
    }
    if(nominee_customer_relation==''){
        $('#nominee_customer_relation_error').text('Please Enter Nominee Customer relation');
        errorflag=true;
    }else{
       $('#nominee_customer_relation_error').text('');
    }
    if(nominee_customer_dob==''){
        $('#nominee_customer_dob_error').text('Please Enter Nominee Customer Date of birth');
        errorflag=true;
    }else{
        $('#nominee_customer_dob_error').text('');
    }
    if(reference_customer_name==''){
        $('#reference_customer_name_error').text('Please Enter Reference Customer name');
        errorflag=true;
    }else{
        $('#reference_customer_name_error').text('');
    }
    if(reference_customer_mobile==''){
        $('#reference_customer_mobile_error').text('Please Enter Reference Customer mobile');
        errorflag=true;
    }else if(!numberRegex.test(reference_customer_mobile)){
       $('#reference_customer_mobile_error').text('Please Enter valid Reference Customer mobile');
        errorflag=true;
    }else{
        $('#reference_customer_mobile_error').text('');
    }
    return (errorflag) ? true :false ;
}

function checkform2()
{
    var ins_category=$("#ins_category").val();
    var case_status=$("#case_status").val();
    var errorflag=false;
    if(ins_category==''){
        $('#ins_category_error').text('Please Select Insurance Category');
        errorflag=true;
    }else{
       $('#ins_category_error').text('');
    }
    if(case_status==''){
        $('#case_status_error').text('Please Select Case Status');
        errorflag=true;
    }else{
       $('#case_status_error').text('');
    }
    return (errorflag) ? true :false ;
}



    
   $("#sid1").click(function(){
    var ins_category=$("#ins_category").val();
    if(ins_category){
        $('ul.par-ul li a').removeClass('active');
        $("#sid1").addClass('active');
        for(var i=1;i<4; i++)
        {
           $("#form"+i).hide();
        }
        $("#form1").show();
    }
    });
    $("#sid2").click(function(){
        var customer_name=$("#customer_name").val();
        if(customer_name){
            $('ul.par-ul li a').removeClass('active');
            $("#sid2").addClass('active');
            for(var i=1;i<4; i++)
            {
               $("#form"+i).hide();
            }
            $("#form2").show();
        }
    });
    $("#sid3").click(function(){
        var customer_name=$("#customer_name").val();
        if(customer_name){
            $('ul.par-ul li a').removeClass('active');
            $("#sid3").addClass('active');
            for(var i=1;i<4; i++)
            {
               $("#form"+i).hide();
            }
            $("#form3").show();
        }
    });
    



