<style>
    .error{font-size:12;color:red;}
</style>	

<div class="modal-dialog">
    <form id="blukpremium" name="bluk">

        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?= $type ?> FEATURED</h4>
            </div>
            <div class="modal-body">

            <i class="fa info-circle col-gray font-60" data-unicode="f05a"></i>

            <p class="edit-text font-14 pad-L20 pad-R20">
                <?php
                $uploadPermission = 0;
                if ($HavepermissionforbringOnTop == '0')
                {

                    echo 'You Are Not Authorized to Use This Functionality.';
                    $totalAllowedInv = '0';
                }
                else if ($TotalBringToTop == '0')
                {

                    echo 'You are not subscribed to Featured package. Please contact your sales executive to get it activated.';
                    $totalAllowedInv = '0';
                }
                else if (empty($canCarAbleFeature['exitsimage']) && $TotalBringToTop != '0' && $type != 'Remove')
                {

                    echo 'Images are mandatory before making a stock as featured.';
                    $TotalBringToTop = '0';
                    $totalAllowedInv = '0';
                    $uploadPermission++;
                }
                else
                {

                    if ($restCanUpload == '0' && $TotalBringToTop != '0'  && $type != 'Remove')
                    {

                        echo 'You Have Exceeded Maximum Limit To Make Cars As Featured. Please Remove Other Cars From Featured Or Contact Your Service Executive To Increase Featured Inventory Limit.';
                    }
                    ?>
                    <?php
                    if ($isCapableforbringOnTop == '0' && $restCanUpload != 0 && $TotalBringToTop != 0)
                    {
                        ?>
                        <?php echo ucwords(convert_number_to_words($restCanUpload)); ?> Cars Can Be Marked As Featured. Please Select Only <?php echo convert_number_to_words($restCanUpload); ?> Cars To Proceed.
                    <?php } ?>

                    <?php
                    if ($totalClassifiedInv < $totalAllowedInv)
                    {
                        if ($isCapableforbringOnTop != '0' && $HavepermissionforbringOnTop != 0)
                        {
                            if ($type == 'Add' && $isClassified['isclassified'] == '0')
                            {
                                echo 'Non-Classified car cannot be made Featured. <br>Do you want to add this car to Classified Listing?';
                            }
                            else if ($type == 'Add' && $isClassified['isclassified'] == '1')
                            {
                                echo 'Are You Sure Want To Add Selected Car As Featured.';
                            }
                        }
                    }
                    else
                    {
                        echo "You can't make this inventory as Featured <br> because you have exhausted your Classified Listing limit.";
                    }
                }
                if ($type == 'Remove')
                {
                    echo 'Are You Sure Want To Remove Selected Car From Featured.';
                }
                ?>
            </p>
        </div>

            <div class="modal-footer">
                <img class="premiumloader" style="display:none;width:30px;" src="<?= BASE_HREF ?>origin-assets/boot_origin_asset_new/images/loader.gif" >
                <span style="color:green;" class="success"></span>

                <button type="button" class="btn btn-default makepremiumcancel" data-dismiss="modal">Cancel</button>
                <?php
                if (($totalClassifiedInv < $totalAllowedInv) || $type == 'Remove')
                { 
                    if ($isCapableforbringOnTop != '0' && $HavepermissionforbringOnTop != 0)
                    {
                        ?>
                        <input type="Button" value="YES" class="btn btn-primary" onclick="make_premium()" name="submit" id="submitbluk">
                        <?php
                    }
                }

                if ($uploadPermission > 0)
                {
                    ?>
                    <a data-dismiss="modal" data-toggle="modal" class="uploadimagepermission" href="#model-uploadPhoto"> <input type="Button" value="Upload Now" class="btn btn-primary"  name="imageredirect" id="imageredirect"></a>
                <?php } ?>
            </div>
        </div><!-- /.modal-content -->

        <input type="hidden" name="carids" id="carids" value="<?= $carID ?>">
        <input type="hidden" name="type" id="type" value="<?= $type ?>">

    </form>
</div>