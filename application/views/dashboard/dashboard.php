<div id="content">
    <div id="left">
        <div class="left-menu" id="sidebar">
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

                .left-menu ul.li a:hover {
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
                    background: rgba(228, 101, 54, 0.2196078431372549);
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
                    margin: 0px 0px 0px 0px;
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

                tspan {
                    fill: #000000;
                    opacity: .67;
                }

                .highcharts-container {
                    width: 100% !important
                }

                .highcharts-root {
                    width: 100% !important
                }

                .highcharts-credits {
                    display: none !important
                }

                .highcharts-series-hover {
                    opacity: 1 !important;
                }

                .highcharts-point-inactive {
                    opacity: 1 !important;
                }

                .highcharts-label {
                    opacity: 1 !important;
                }

                #funnelchart {
                    min-width: 360px;
                    max-width: 600px;
                    height: 400px;
                    margin: 0 auto;
                }
                #add_rc_transfer_lead_msg .error {
                    font-size: 12px !important;
                    color: #900505 !important;
                    position: relative;
                    top: 0;
                }
                #add_rc_transfer_lead_msg .success {
                    font-size: 12px !important;
                    color: #449d44 !important;
                    position: relative;
                    top: 0;
                }
            </style>
            <?php
            if ($type == 1)
                $amount_trend_title = "Disbursed Amount";
            else
                $amount_trend_title = "OD Amount";

            ?>
            <div class="navbar navbar-default" role="navigation">
                <div class="navbar-collapse collapse sidebar-navbar-collapse pad-all-0">
                    <ul class="nav navbar-nav" id="sidenav011">
                        <!--<li><a href="#" id="ins_1"  class="collapsed active" onclick="getdocpage(1)"> Insurance</a></li>-->
                        <?php if (in_array(1, $modules)) { ?>
                            <li><a class="<?= ($type == 1) ? 'active' : "" ?>" href="<?= base_url("dashboard/1") ?>">Loan</a></li>
                        <?php }
                        if (in_array(2, $modules)) { ?>
                            <li><a class="<?= ($type == 2) ? 'active' : "" ?>" href="<?= base_url("dashboard/2") ?>">Insurance</a></li>
                        <?php }
                        if (in_array(6, $modules)) { ?>
                            <li><a class="<?= ($type == 6) ? 'active' : "" ?>" href="<?= base_url("dashboard/6") ?>">Delivery Order</a></li>
                        <?php }
                        if (in_array(10, $modules)) { ?>
                            <li><a class="<?= ($type == 10) ? 'active' : "" ?>" href="<?= base_url("dashboard/10") ?>">RC Transfer</a></li>
                        <?php }
                        if (in_array(4, $modules)) { ?>
                            <li><a class="<?= ($type == 4) ? 'active' : "" ?>" href="<?= base_url("dashboard/4") ?>">Stock</a></li>
                        <?php }
                        if (in_array(5, $modules)) { ?>
                            <li><a class="<?= ($type == 5) ? 'active' : "" ?>" href="<?= base_url("dashboard/5") ?>">Lead</a></li>
                        <?php } ?>
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
                            <?php
                            // echo current_url();
                            // exit;
                            // if(){
                            ?>
                            <p class="pull-right"><a class="btn btn-success font-14" onclick="$('.othercolors').hide();$('.add_seller_fuel_type').html('');" data-toggle="modal" data-target="#model-add-rc-transfer-case">ADD RC Case</a></p>
                            <p class="pull-right"><a class="btn btn-success font-14" href="<?php echo base_url(); ?>">ADD RC Case</a></p>
                            <?php //} 
                            ?>

                            <div class="col-md-12">
                                <?php if (!empty($progress_card)) { ?>
                                    <div class="row">
                                        <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="total-lead-recieved clearfix">
                                                        <ul class="mrg-all-0 pad-all-0">
                                                            <li class="pull-left font-16 col-black-o"><?= array_search(1, $cards) ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class=" col-md-12 total-lead-digit">
                                                    <div class="row mrg-all-0">
                                                        <?php
                                                        foreach ($progress_card as $key => $in_progress) { ?>
                                                            <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                                                                <a target="_blank" href="<?php echo (!empty($inprocess_count[$key])) ? base_url($progress_url[$key]) : '#'; ?>">
                                                                    <p class="font-60 col-red"> <span id="purchaseamt"><?= !empty($inprocess_count[$key]) ? $inprocess_count[$key] : "0"; ?></span></p>
                                                                    <p class="font-18 col-black-o"><?= $in_progress ?></p>
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($renewal_card)) { ?>
                                    <div class="row">
                                        <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="total-lead-recieved clearfix">
                                                        <ul class="mrg-all-0 pad-all-0">
                                                            <li class="pull-left font-16 col-black-o">Renewals</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class=" col-md-12 total-lead-digit">
                                                    <div class="row mrg-all-0">
                                                        <?php
                                                        foreach (RENEWAL_COUNT as $key => $renewal) { ?>
                                                            <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                                                                <a target="_blank" href="<?php echo base_url(RENEWAL_URL[$key]); ?>">
                                                                    <p class="font-60 col-red"> <span id="purchaseamt"><?= $renewal_count[$key] ?></span></p>
                                                                    <p class="font-18 col-black-o"><?= $renewal ?></p>
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <?php if (!empty($pending_case_count)) {

                                    ?>
                                        <div class="col-md-6 pad-L0">
                                            <div class="">
                                                <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="total-lead-recieved clearfix">
                                                                        <ul class="mrg-all-0 pad-all-0">
                                                                            <li class="pull-left font-16 col-black-o"><?= array_search(2, $cards) ?></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-12 total-lead-digit">
                                                                    <div class="row mrg-all-0">
                                                                        <?php foreach ($pending_card as $key => $pending) { ?>
                                                                            <div class="col-md-6 col-sm-3 col-xs-3 cus-col">
                                                                                <a target="_blank" href="<?php echo (!empty($pending_case_count[$key])) ? base_url($pending_url[$key]) : '#'; ?>">
                                                                                    <p class="font-60 col-red"> <span id="purchaseamt"><?= $pending_case_count[$key] ?></span></p>
                                                                                    <p class="font-18 col-black-o"><?= $pending ?></p>
                                                                                </a>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- for DO BALANCE START BY MASAWWAR ALI -->
                                    <?php if (!empty($doBalance)) { ?>
                                        <div class="col-md-6 pad-L0">
                                            <div class="">
                                                <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="total-lead-recieved clearfix">
                                                                        <ul class="mrg-all-0 pad-all-0">
                                                                            <li class="pull-left font-16 col-black-o"><?= array_search(3, $cards) ?></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-12 total-lead-digit">
                                                                    <div class="row mrg-all-0">
                                                                        <div class="col-md-6 col-sm-3 col-xs-3 cus-col">
                                                                            <a target="_blank" href="<?php echo base_url("orderListing/4"); ?>">

                                                                                <?php
                                                                                if (!empty($doBalance['showroomBal'])) {
                                                                                ?>
                                                                                    <p class="font-42 col-red">
                                                                                        <span id="purchaseamt"><?= $doBalance['showroomBal'] ?></span>
                                                                                    </p>
                                                                                <?php }

                                                                                if (!empty($doBalance['showroomBalCase'])) {
                                                                                ?>
                                                                                    <p class="font-16 col-black-o">( <?= $doBalance['showroomBalCase'] ?> cases)</p>
                                                                                <?php } ?>
                                                                                <p class="font-18 col-black-o">Showroom Balance</p>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-3 col-xs-3 cus-col">
                                                                            <a target="_blank" href="<?php echo base_url("orderListing/5"); ?>">
                                                                                <?php
                                                                                if (!empty($doBalance['customerBal'])) {
                                                                                ?>
                                                                                    <p class="font-42 col-yellow">
                                                                                        <span id="amtPaid"><?= $doBalance['customerBal'] ?></span>
                                                                                    </p>
                                                                                <?php }
                                                                                if (!empty($doBalance['customerBalCase'])) { ?>
                                                                                    <p class="font-16 col-black-o">(<?= $doBalance['customerBalCase'] ?> cases)</p>
                                                                                <?php } ?>
                                                                                <p class="font-18 col-black-o">Customer Balance</p>
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
                                    <?php } else if (in_array(3, $permissions) || ($this->session->userdata['userinfo']['is_admin'] == '1' && in_array(3, $cards) && empty($doBalance))) { ?>
                                        <div class="col-md-6 pad-L0">
                                            <div class="">
                                                <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="total-lead-recieved clearfix">
                                                                        <ul class="mrg-all-0 pad-all-0">
                                                                            <li class="pull-left font-16 col-black-o"><?= array_search(3, $cards) ?></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-12 total-lead-digit">
                                                                    <div class="row mrg-all-0">
                                                                        <?php foreach ($delay_card as $key => $delay) { ?>
                                                                            <div class="col-md-6 col-sm-3 col-xs-3 cus-col">
                                                                                <a target="_blank" href="<?php echo (!empty($payout_case_count[$key])) ? base_url($delay_url[$key]) : '#'; ?>">
                                                                                    <p class="font-60 col-red"> <span id="purchaseamt"><?= !empty($payout_case_count[$key]) ? $payout_case_count[$key] : "0" ?></span></p>
                                                                                    <p class="font-18 col-black-o"><?= $delay ?></p>
                                                                                </a>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                                $is_allowed = 0;
                                if ((in_array(6, $permissions) || ($this->session->userdata['userinfo']['is_admin'] == '1') && in_array(6, $cards))) {
                                    $is_allowed = 1;
                                }
                                if ((in_array(5, $permissions) || ($this->session->userdata['userinfo']['is_admin'] == '1') && in_array(5, $cards))) {
                                    $is_allowed = 1;
                                }
                                if ((in_array(4, $permissions) || ($this->session->userdata['userinfo']['is_admin'] == '1') && in_array(4, $cards))) {
                                    $is_allowed = 1;
                                }
                                ?>
                                <div class="row">
                                    <?php if ($is_allowed == 1) { ?>
                                        <div class="col-md-12 mrg-T20">
                                            <div class="row">
                                                <div class="col-md-6 pad-L0">
                                                    <h1 class="col-black-t">Performance</h1>
                                                </div>
                                                <div class="col-md-6 pad-R0">
                                                    <select class="form-control pull-right" style="width: auto;">
                                                        <option>Last 6 Months</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row" id="box" style="top: 50px">
                                        <?php if ((in_array(6, $permissions) || ($this->session->userdata['userinfo']['is_admin'] == '1') && in_array(6, $cards))) { ?>
                                            <div class="col-md-6">
                                                <div class="">
                                                    <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="total-lead-recieved clearfix">
                                                                            <ul class="mrg-all-0 pad-all-0">
                                                                                <li class="pull-left font-16 col-black-o"><?= $amount_trend_title ?> Trend</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class=" col-md-12 total-lead-digit">
                                                                        <div class="row mrg-all-0">
                                                                            <div class="col-md-12" id="odamount">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ((in_array(6, $permissions) || ($this->session->userdata['userinfo']['is_admin'] == '1') && in_array(6, $cards))) { ?>
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
                                        <?php } ?>
                                        <?php if ((in_array(5, $permissions) || ($this->session->userdata['userinfo']['is_admin'] == '1' && in_array(5, $cards)))) { ?>
                                            <div class="col-md-6">
                                                <div class="">
                                                    <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="total-lead-recieved clearfix">
                                                                            <ul class="mrg-all-0 pad-all-0">
                                                                                <li class="pull-left font-16 col-black-o">Cases Trend Chart</li>
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

                                        <?php } ?>
                                        <?php if (((in_array(2, $permissions) && $type == 10) || ($this->session->userdata['userinfo']['is_admin'] == '1' && in_array(2, $cards) && $type == 10))) { ?>
                                            <div class="col-md-12">
                                                <div class="">
                                                    <div class="background-efOne background-efTwo bgImgN mrg-T20">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="total-lead-recieved clearfix">
                                                                            <ul class="mrg-all-0 pad-all-0">
                                                                                <li class="pull-left font-16 col-black-o">Bank Limit Left</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class=" col-md-12 total-lead-digit">
                                                                        <div class="row mrg-all-0">
                                                                            <div class="col-md-12">
                                                                                <figure class="highcharts-figure">
                                                                                    <div id="container"></div>

                                                                                </figure>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
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
</div>



<!-- Popups Start -->
<!-- Add RC Transfer modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-add-rc-transfer-case">
    <form id="add_rc_transfer_form" method="post" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg modal-ku">
            <div class="modal-content">
                <div class="modal-header bg-gray">
                    <button type="button" class="close" onclick="$('#add_seller_reset').click();$('#add_rc_transfer_lead_msg').html('');" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Add RC Transfer Case</h4>
                </div>

                <div class="modal-body">
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">
                        <div class="col-md-6 col-sm-6 pad-LR tabpading" style="margin-bottom: 20px;">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Customer Name *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <input type="text" placeholder="Enter Customer Name" name="add_rc_customer_name" class="form-control search-form-select-box">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 pad-LR tabpading" style="margin-bottom: 20px;">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Mobile Number *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <input type="text" placeholder="Enter Mobile Number" onkeypress="return numbersonly(event)" maxlength="10" name="add_rc_customer_mobile" class="form-control search-form-select-box">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 pad-LR tabpading" style="margin-bottom: 20px;">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Email *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <input type="text" placeholder="Enter Email" name="add_rc_customer_email" class="form-control search-form-select-box">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 pad-LR tabpading" style="margin-bottom: 20px;">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Source</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <select id="status" class="form-control search-form-select-box" name="add_rc_customer_source">
                                        <option>Walk-In</option>
                                        <option>Gaadi</option>
                                        <option>Cardekho</option>
                                        <option>My Website</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix mrg-T15"></div>
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">
                        <div class="col-md-3 col-sm-6 pad-LR tabpading" style="display: none;">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Status</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <input type="hidden" value="Pending" name="add_rc_transfer_status" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comment-wrap  mCustomScrollbar scrolldivaddsell" data-mcs-theme="dark">
                        <div id="add_seller_car_details">
                            <div class="clearfix mrg-T15"></div>
                            <div class="firstt">
                                <div class="row mrg-all-0 mrg-B0 mrg-T0 appended-div2" style="border-top:0px solid #fff;padding:20px;background-color: #eee; border-radius: 4px;">
                                    
                                    <div class="col-md-6  col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Reg No*</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="text" placeholder="Reg No" name="add_rc_customer_regno" onkeyup="$(this).val(this.value.toUpperCase());" class="form-control search-form-select-box">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 pad-LR tabpading" style="margin-top: 10px;margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Generated Date</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <div>
                                                    <div class="input-append date" id="dp5" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                        <input style="cursor:pointer;" readonly="readonly" class="span2 form-control calender" size="16" type="text" value="" placeholder="" name="add_rc_transfer_follow_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="col-md-6  col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Aadhar Number</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="text" placeholder="Aadhar Number" name="add_aadhar_number" onkeyup="$(this).val(this.value.toUpperCase());" class="form-control search-form-select-box">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6  col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">RC Card Front</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="file" name="add_rc_card_front" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6  col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">RC Card Back</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="file" name="add_rc_card_back" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6  col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Vehicle Insurance</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="file" name="add_rc_vehicle_insurance" class="form-control">
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-md-6  col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Aadhar Card Front</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="file" name="add_aadhar_card_front" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Aadhar Card Back</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="file" name="add_aadhar_card_back" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6  col-sm-6 pad-LR tabpading mrg-T10" style="margin-bottom: 20px;">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Pan Card</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="file" name="add_pan_card" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>

                <?php
                $pageArrkk = explode('/', $_SERVER['PHP_SELF']);
                $uriPageNamekk = $pageArrkk[count($pageArrkk) - 1];
                //if($uriPageNamekk!='kwl_datas.php'){   
                ?>
                <?php //}  
                ?>
                <div class="modal-footer">
                    <span id="add_rc_transfer_lead_msg"></span>
                    <button type="button" class="btn btn-default add_lead_cancel" onclick="$('#add_seller_reset').click();
                    $('#add_rc_transfer_lead_msg').html('');" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="add_rc_transfer_lead()">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div>

    </form>
</div>
<!-- end Popups Start -->
<!-- end Add RC Transfer modal -->

<?php echo base_url('assets/admin_assets/js/waterfall-light.js'); ?>
<!-- <script type="text/javascript" src="http://dealercrm.com/assets/admin_assets/js/waterfall-light.js"></script> -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/funnel.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script type="text/javascript">
    var type = "<?php echo $type; ?>";
    Highcharts.chart('funnelchart', {
        chart: {
            type: 'funnel'
        },
        title: {
            text: ''
        },
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
            name: 'Cases',
            data: [<?php echo join($case_wise_count, ',') ?>],
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
    var months = <?php echo json_encode($case_trend['months']) ?>;
    if (type == 2) {
        var series_data = [{
            name: "Case Added",
            data: [<?php echo join($case_trend['new_case']['counts'], ',') ?>]
        }, {
            name: "Quote Shared",
            data: [<?php echo join($case_trend['quote_shared']['counts'], ',') ?>]
        }, {
            name: "Policy Issued",
            data: [<?php echo join($case_trend['issued']['counts'], ',') ?>]
        }];
    }
    if (type == 1) {
        var series_data = [{
            name: "Case Added",
            data: [<?php echo join($case_trend['new_case']['counts'], ',') ?>]
        }, {
            name: "Filed Cases",
            data: [<?php echo join($case_trend['filed']['counts'], ',') ?>]
        }, {
            name: "Approved Cases",
            data: [<?php echo join($case_trend['approved']['counts'], ',') ?>]
        }, {
            name: "Disbursed Case",
            data: [<?php echo join($case_trend['disbursed']['counts'], ',') ?>]
        }];
    }

    if (type == 6) {
        var series_data = [{
            name: "Case Added",
            data: [<?php echo join($case_trend['new_case']['counts'], ',') ?>]
        }];
    }


    Highcharts.chart('trendchart', {
        title: {
            text: ''
        },
        exporting: {
            enabled: false
        },
        xAxis: {
            categories: months
        },
        yAxis: [{
            title: {
                text: 'Count'
            }
        }],
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: series_data

    });
</script>

<script type="text/javascript">
    var months = <?php echo json_encode($amount_trend['months']) ?>;
    var role_id = "<?php echo $role_id; ?>";
    if (type == 1 && role_id == 6) {
        var series_data = [{
            type: 'column',
            name: 'Used Car Disbursal Amount',
            data: [<?php echo join($amount_trend['used']['counts'], ',') ?>]
        }, {
            type: 'spline',
            name: 'Total',
            data: [<?php echo join($amount_trend['average'], ',') ?>],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }, ];
    } else if (type == 1 && role_id == 5) {
        var series_data = [{
            type: 'column',
            name: 'New Car Disbursal Amount',
            data: [<?php echo join($amount_trend['new']['counts'], ',') ?>]
        }, {
            type: 'spline',
            name: 'Total',
            data: [<?php echo join($amount_trend['average'], ',') ?>],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }, ];
    } else if (type == 1) {
        var series_data = [{
            type: 'column',
            name: 'New Car Disbursal Amount',
            data: [<?php echo join($amount_trend['new']['counts'], ',') ?>]
        }, {
            type: 'column',
            name: 'Used Car Disbursal Amount',
            data: [<?php echo join($amount_trend['used']['counts'], ',') ?>]
        }, {
            type: 'spline',
            name: 'Total',
            data: [<?php echo join($amount_trend['average'], ',') ?>],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }, ];
    }
    if (type == 2) {
        var series_data = [{
            type: 'column',
            name: 'OD Amount',
            data: [<?php echo join($amount_trend['counts'], ',') ?>]
        }, ];
    }

    var trend_title = "<?php echo $amount_trend_title; ?>"
    Highcharts.chart('odamount', {
        title: {
            text: ''
        },
        xAxis: {
            categories: months
        },
        yAxis: [{
            title: {
                text: trend_title
            }
        }],
        exporting: {
            enabled: false
        },
        series: series_data
    });
</script>

<script>
    var length = $('#left').height() - $('#sidebar').height() + $('#left').offset().top;

    $(window).scroll(function() {

        var scroll = $(this).scrollTop();
        var height = $('#sidebar').height() + 'px';

        if (scroll < $('#left').offset().top) {

            $('#sidebar').css({
                'position': 'absolute',
                'top': '60px'
            });

        } else if (scroll > length) {

            $('#sidebar').css({
                //'position': 'absolute',
                //'bottom': '0',
                //'top': 'auto'
            });

        } else {

            $('#sidebar').css({
                'position': 'fixed',
                'top': '0',
                'height': height
            });
        }
    });
</script>
<script>
    var banks = <?php echo json_encode($bank['bank_name']) ?>;

    var series_data = [{
            name: 'Left Limit',
            data: [<?php echo join($bank['leftAmount'], ',') ?>]
        },
        {
            name: 'Used Limit',
            data: [<?php echo join($bank['usedAmount'], ',') ?>]
        },
    ];
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: banks
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Bank Limit'
            },
            stackLabels: {
                enabled: false,
                style: {
                    fontWeight: '',
                    color: ( // theme
                        Highcharts.defaultOptions.title.style &&
                        Highcharts.defaultOptions.title.style.color
                    ) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        exporting: {
            enabled: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false
                }
            }
        },
        series: series_data
    });
</script>

<script>
    jQuery(function() {
        var dd = "<?php echo date('d-m-Y H:00', strtotime(date('Y-m-d H:00')) + (3600));  ?>";
        var ddd = "<?php echo date('d-m-Y');  ?>";
        var dy = "<?php echo date('Y');  ?>";
        var cm = "<?php echo date('m');  ?>";
        var dm = "<?php echo date('H', strtotime(date('Y-m-d H:00')) + (3600));  ?>";
        var md = "<?php echo date('d-m-Y H:00', strtotime(date('Y-m-d H:00')) + (3600 * 25));  ?>";
        var search_calender_open = 0;

        jQuery('input[name=add_rc_transfer_follow_date]').datetimepicker({
            timepicker: true,
            format: 'd-m-Y H:i',
            minDate: dd ? dd : false,
            minTime: 0,
            onShow: function(ct) {
                search_calender_open = 1;
            },
            onClose: function(ct) {
                search_calender_open = 0;
            },
            onChangeDateTime: function() {
                var valArr = $('input[name=add_rctransfer_follow_date]').val().split(' ');
                if (valArr[0] == ddd) {
                    this.setOptions({
                        minTime: dm + ':00'
                    });
                    $('input[name=add_rctransfer_follow_date]').val(valArr[0] + ' ' + dm + ':00');

                } else {
                    this.setOptions({
                        minTime: '00:00'
                    });
                }
                var yArr = valArr[0].split('-');
                if (yArr[2] < dy || (yArr[1] < cm && yArr[2] == dy)) {
                    $('input[name=add_rctransfer_follow_date]').val(ddd + ' ' + dm + ':00');
                }
            }
        });
    });

    var add_lead = 0;

    function add_rc_transfer_lead() {
        if (add_lead == 0) {
            $(this).prop('disabled', true);
            // var formdata = $('#add_rc_transfer_form').serialize();            
            var form_data = new FormData(document.getElementById("add_rc_transfer_form"));            
            $.ajax({
                url: base_url + "RcCase/save_rctransfer_detail",
                type: 'POST',
                data: form_data,                
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {                    
                    $('#add_rc_transfer_lead_msg').html(data);
                    $(this).prop('disabled', false);
                    if (data.trim() == '<span class="success">RC Added Successfully</span>') {
                        //alert(data);
                        setTimeout(function() {
                            // $('.sell_form_reset').click();
                            // $('.add_lead_cancel').click();
                            window.location.reload();
                        }, 3000);
                    }
                    add_lead = 0;
                }
            });
        }
        add_lead = 1;
    }

    function numbersonly(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (unicode != 8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode < 48 || unicode > 57) //if not a number
                return false //disable key press
        }
    }


    // function add_more() {
    //     $('#add_seller_car_details').append($('#add_seller_car_details .firstt').html());
    //     $("select[name='add_seller_fuel_type[]']").last().prop('value', '');
    //     $("input[name='other_color[]']").last().prop('value', '');
    //     $(".othercolors").last().hide();
    // }
</script>