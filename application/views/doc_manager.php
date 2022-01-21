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

            .pad-all-0{padding: 0px;}
            ul#sidenav011 li{width: 100%}
            ul#sidenav011 li a{color:#000000;}
            ul#sidenav011 li .active{border-left:2px solid #e46536;}
            #sidenav011 ul.nav.nav-list {padding: 0px 15px;}
            #sidenav011 ul.nav.nav-list li a{color:#000000; opacity: .87; font-size: 14px; border-bottom: 3px solid transparent !important;}
            .table-striped>tbody>tr:nth-of-type(odd) {background-color: #ffff;}
            .table-striped>tbody>tr:nth-of-type(even) {background-color: #ffff;}
            .left-menu .navbar-default { background-color: #ffffff; border-color: #e7e7e7;}
            .left-menu .navbar-nav li a:hover {color: #000000 !important; opacity: 0.87;}
            .left-menu .navbar-nav>li>a {padding-top: 10px;padding-bottom: 10px; margin: 0px 10px 0px 0px;border-bottom: 3px solid transparent !important;}
             .left-menu .navbar-nav>li>a{font-size: 14px;}
             #sidenav011 .nav>li>a:hover, .nav>li>a:focus {text-decoration: none; background-color: #ffffff;  color: #e86335 !important;}
             .nav>li>a:hover, .nav>li>a:focus {text-decoration: none; background-color: #fff; }
             .nav-tabs {border-bottom: 0px solid #ddd;}
             .nav-tabs>li>a:hover {border-color: transparent;}




        </style>
        <div class="navbar navbar-default" role="navigation">
            <div class="navbar-collapse collapse sidebar-navbar-collapse pad-all-0">
              <ul class="nav navbar-nav" id="sidenav011">
               <li><a href="#"> Insurance</a></li>
                <li>
                  <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01" class="collapsed active">
                   Loan<span class="caret pull-right"></span>
                  </a>
                  <div class="collapse" id="toggleDemo" style="height: 0px;">
                    <ul class="nav nav-list">
                      <li><a href="#">New Car</a></li>
                      <li><a href="#">Used Car</a></li>
                    </ul>
                  </div>
                </li>
                  
                  <li><a href="#">Stock</a></li>
                  <li><a href="#">RC Transfer</a></li>
                
                
              </ul>
              </div><!--/.nav-collapse -->
            </div>
        
        
        <!--<ul class="leftMenuUl">
            <li><a href="javascript:void(0);" class="completed"><i class="fa fa-circle-thin"></i>Account Verify</a></li>
            <li class="subDropDown">
                <a href="javascript:void(0);" class="active"><i class="fa fa-circle-thin"></i>Payment</a>
                <ul class="childUL">
                  <li>
                      <a href="javascript:void(0);" class="">Auction 
                          <span class="blink">2</span>
                          <span class="slash">/</span>
                          <span class="total-value">10</span> 
                      </a>
                  </li>
                  <li><a href="javascript:void(0);" class="">C2D
                          <span class="blink">2</span>
                          <span class="slash">/</span>
                          <span class="total-value">10</span>    
                      </a>
                  </li>
                  <li><a href="javascript:void(0);" class="">Insurance
                         <span class="blink">2</span>
                         <span class="slash">/</span>
                         <span class="total-value">10</span>
                      </a>
                  </li>
                </ul>
            </li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-thin"></i>Reconcilation</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-thin"></i>Accounts</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-thin"></i>Reports</a></li>
        </ul>-->
    </div>
    <main class="main-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head">Set Permission</h4>
                <div class="whte-strip whtStrpTable">
                    <div class="tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#logindocs" role="tab" data-toggle="tab">Login Docs</a>
                            </li>
                            <li role="presentation">
                                <a href="#predisbursaldocs" role="tab" data-toggle="tab">Pre Disbursal Docs</a>
                            </li>
                            <li role="presentation">
                                <a href="#postdeliverydocs" role="tab" data-toggle="tab">Post Delivery Docs</a>
                            </li>
                            <!--<div class="pull-right">
                                <div class="dwnld-excel"><a href="javascript:void(0);">DOWNLOAD EXCEL</a></div>
                            </div>-->
                        </ul>
                    </div>
                    
                </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active clearfix" id="logindocs">
                               <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                     <tbody>
                                         <tr>
                                            <td style="width: 20%">
                                                <input onclick="" type="checkbox" id="car-Premium" name="ispremium">
                                                <label for="car-Premium"><span></span>
                                                Registration Certificate</label>    
                                             </td>
                                            <td style="width: 20%">All Pages</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Not Required </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Optional </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Mandatory </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         <tr>
                                            <td rowspan="3" style="width: 20%">
                                            	<input onclick="" type="checkbox" id="car-Premium" name="ispremium">
                                                <label for="car-Premium"><span></span>
                                               	Previous Policy</label>
                                            </td>
                                            <td style="width: 20%">Pre Policy Image 1</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Not Required </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Optional </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Mandatory </label>
                                                  </span>
                                             </td>
                                            </tr>

                                            

                                            <tr>
	                                            <td style="width: 20%">Pre Policy Image 2</td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
	                                                      <label for="rec_195"><span class="dt-yes"></span> Not Required </label>
	                                                  </span>
	                                             </td>
	                                             <td style="width: 20%">
	                                                  <span class="">
	                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
	                                                      <label for="pen_195"><span class="dt-yes"></span> Optional </label>
	                                                  </span>
	                                             </td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
	                                                      <label for="na_195"><span class="dt-yes"></span> Mandatory </label>
	                                                  </span>
	                                             </td>
                                            </tr>


                                            <tr>
	                                            <td style="width: 20%">Pre Policy Image 3</td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
	                                                      <label for="rec_195"><span class="dt-yes"></span> Not Required </label>
	                                                  </span>
	                                             </td>
	                                             <td style="width: 20%">
	                                                  <span class="">
	                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
	                                                      <label for="pen_195"><span class="dt-yes"></span> Optional </label>
	                                                  </span>
	                                             </td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
	                                                      <label for="na_195"><span class="dt-yes"></span> Mandatory </label>
	                                                  </span>
	                                             </td>
                                            </tr>

                                            <tr>
	                                            <td rowspan="2" style="width: 20%">
	                                            	<input onclick="" type="checkbox" id="car-Premium" name="ispremium">
	                                                <label for="car-Premium"><span></span>
	                                               	Previous Policy</label>
	                                            </td>
	                                            <td style="width: 20%">Pre Policy Image 1</td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
	                                                      <label for="rec_195"><span class="dt-yes"></span> Not Required </label>
	                                                  </span>
	                                             </td>
	                                             <td style="width: 20%">
	                                                  <span class="">
	                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
	                                                      <label for="pen_195"><span class="dt-yes"></span> Optional </label>
	                                                  </span>
	                                             </td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
	                                                      <label for="na_195"><span class="dt-yes"></span> Mandatory </label>
	                                                  </span>
	                                             </td>
                                            </tr>

                                            <tr>
	                                            
	                                            <td style="width: 20%">Pre Policy Image 1</td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
	                                                      <label for="rec_195"><span class="dt-yes"></span> Not Required </label>
	                                                  </span>
	                                             </td>
	                                             <td style="width: 20%">
	                                                  <span class="">
	                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
	                                                      <label for="pen_195"><span class="dt-yes"></span> Optional </label>
	                                                  </span>
	                                             </td>

	                                             <td style="width: 20%">
	                                                 <span class="">
	                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
	                                                      <label for="na_195"><span class="dt-yes"></span> Mandatory </label>
	                                                  </span>
	                                             </td>
                                            </tr>
                                         
                                         
                                        </tbody>
                                    </table>
                              </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="predisbursaldocs">
                              <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                     <tbody>
                                         <tr>
                                            <td style="width: 20%">
                                                <input onclick="" type="checkbox" id="car-Premium" name="ispremium">
                                                <label for="car-Premium"><span></span>
                                                Registration Certificate</label>    
                                             </td>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         <tr>
                                            <td rowspan="6" style="width: 20%">
                                                 Car Document    </td>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                        </tbody>
                                    </table>
                              </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="postdeliverydocs">
                              <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                     <tbody>
                                         <tr>
                                            <td style="width: 20%">
                                                <input onclick="" type="checkbox" id="car-Premium" name="ispremium">
                                                <label for="car-Premium"><span></span>
                                                Registration Certificate</label>    
                                             </td>
                                            <td style="width: 20%">All Pages</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Not Required </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Optional </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Mandatory </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         <tr>
                                            <td rowspan="6" style="width: 20%">
                                                 Car Document    </td>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                         
                                         <tr>
                                            <td style="width: 20%"> RC Copy</td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="rec_195" value="1" class="trigger">
                                                      <label for="rec_195"><span class="dt-yes"></span> Received </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_195" id="pen_195" value="2" class="trigger" checked="checked">
                                                      <label for="pen_195"><span class="dt-yes"></span> Pending </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_195" id="na_195" value="3" class="trigger">
                                                      <label for="na_195"><span class="dt-yes"></span> Not Applicable </label>
                                                  </span>
                                             </td>
                                            </tr>
                                        </tbody>
                                    </table>
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="btn-sec-width">
		                    <button type="button" class="btn-continue saveCont" style="display:block" id="personalDetails">SAVE AND CONTINUE</button>
                        </div>
                    </div>
                </div>
        
    </main>

</div>