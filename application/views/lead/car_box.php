<?php
if (!empty($getEnquiryListDetail) && (count($getEnquiryListDetail) > 0) && $typee != 'custom') {
?>

    <script>
        $(".img_thumb").click(function() {
            var chkid = this.id;
            var crid = chkid.split('_');
            var checked = $("#cs_" + crid[1]).is(':checked')
            if (checked == false) {
                $("#cs_" + crid[1]).prop('checked', true);
            } else {
                $("#cs_" + crid[1]).prop('checked', false);
            }

        });
    </script>
    <ul class="row list-unstyled similarlist">
        <?php
        $k = 1;
        foreach ($getEnquiryListDetail as $key => $value) {
        ?>
            <li class="col-sm-4 col-md-3 col-lg-2 checkgreen">
                <div class="thumbnail posrelative">
                    <input type="hidden" id="car_id" name="car_id" value="<?php echo $value['car_id']; ?>">
                    <div class="img_thumb" id="img_<?php echo $value['car_id']; ?>">
                        <?php if (!empty($value['img_icon'])) { ?>
                            <a href="javascript:void();">
                                <img alt="100%x200" class=" img-responsive" src="<?= !empty($value['img_icon']) ? $value['img_icon'] : ''; ?>" /></a>
                        <?php } ?>
                    </div>
                    <div class="selectCheckbox">
                        <input type="checkbox" class="simchack" name="cs[]" id="cs_<?php echo $value['car_id']; ?>" value="<?php echo $value['car_id']; ?>"><label for="cs_<?php echo $value['car_id']; ?>">
                            <span>

                            </span></label>
                    </div>
                    <div class="caption">
                        <h4 class="media-heading font-16 bold "><?php echo $value['model'] . "   " . $value['carversion']; ?> </h4>
                        <div class="text-primary font-16">
                            <strong style="color:#e66437 !important"><i data-unicode="f156" class="fa fa-inr"></i> <?php $price = explode('.', number_format('%!i', str_replace(",", "", $value['price'])));
                                                                                                                    echo $price[0]; ?>
                            </strong>
                        </div>
                        <ul class="list-unstyled list-inline small pipelist">
                            <li class="text-muted"><?php echo $value['transmission']; ?></li>
                            <?php if (!empty($value['kms']) && $value['kms'] > 0) { ?>
                                <li class="text-muted"><?php
                                                        echo $value['kms'];
                                                        if (!empty($value['kms']) && $value['kms'] > 1) {
                                                            echo " kms";
                                                        };
                                                        ?></li>

                            <?php } else { ?>
                                <li class="text-muted"><?php
                                                        echo $value['Kms'];
                                                        if (!empty($value['kms']) && $value['Kms'] > 1) {
                                                            echo " kms";
                                                        };
                                                        ?></li>
                            <?php } ?>
                            <li class="text-muted"><?php
                                                    if (!empty($value['mm']) && $value['mm'] != '') {
                                                        echo date("M", mktime(0, 0, 0, $value['mm']));
                                                    }
                                                    echo "  " . $value['myear'];
                                                    ?></li>

                            <li class="text-muted"><?php echo $value['fuel_type']; ?></li>
                        </ul>
                    </div>
                </div>
            </li>

        <?php
            $k++;
        }
        ?>

    </ul>
<?php } else if ($typee == 'custom') { ?>
    <script type="text/javascript" src="http://www.gaadicdn.com/js/min.js"></script>
    <div class="mCustomScrollbar" data-mcs-theme="dark" id="add_Buyer_Lead" style="overflow-y:scroll; height:180px; margin-top:10px; margin-bottom:10px; background-color:#eee;">
        <div class="row add-lead-bg row-append2">
            <div class="col-md-4">
                <div class="form-group text-left">
                    <label class="control-label search-form-label" for="inputSuccess2">Select Make</label>
                    <select name="make[]" id="make0" class="form-control search-form-select-box" placeholder="Select Make ">
                        <option selected="selected" value="">Select Make</option>
                        <?php
                        foreach ($makeList as $res) {
                        ?>
                            <option value="<?= $res['make']; ?>">
                                <?= $res['make']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group text-left">
                    <label class="control-label search-form-label" for="inputSuccess2">Select Model</label>
                    <select name="model[]" id="model0" disabled="disabled" class="form-control search-form-select-box" placeholder="Select Model" onchange='getUsedVersionList(this.value, this.form.version0)'>
                        <option value="">Select Model</option>

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group text-left">
                    <label class="control-label search-form-label" for="inputSuccess2">Select Version</label>
                    <select name="version[]" id="version0" class="form-control search-form-select-box" disabled>
                        <option selected="selected" value="">--Select Version--</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


<?php 
    } else {
        echo "1";
    }
    echo "@@###$$"; 
?>
<?php echo count($getEnquiryListDetail) . "@==========@" . count($getEnquiryListDetail); ?>