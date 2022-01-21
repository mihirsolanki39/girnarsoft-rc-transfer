<div class="tab-pane" id="ptabp-hoto4"><!--Tab4 -->
    <div class="row mrg-all-0 mrg-B0 mrg-T0">
        <?php
       
        if (!empty($getAllImage))
        {
            if (!empty(DEALER_ID))
            {
                ?>

            <?php } ?>
            <div class="col-md-12">

                <div id="carousel-main-img" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" id='carousel_inner'>
                        <div class="item active" id="item_0"><img style='min-height:400px' img_name="<?= $getAllImage[0]['image_name'] ?>" src="<?php echo $getAllImage[0]['image_url'] ?>" ></div>
                        <?php
                        $slideAllimage = $getAllImage;
                        $slideAllimages = array_shift($slideAllimage);
                        $counter       = 1;
                        foreach ($slideAllimage as $key => $vals)
                        {
                           if(!empty($vals['rejected_reason'])){ ?>                                                                                                                  
                            <strong class="tags-images" style="font-weight: 600;">Reason: <?= $vals['rejected_reason'] ?> </strong>
                           <?php } ?>
                            <div class="item" id="item_<?= ++$counter ?>"><img style='min-height:400px' img_name="<?= $vals['image_name'] ?>" src="<?= $vals['image_url'] ?>" ></div>
                        <?php } ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-main-img" data-slide="prev">
                        <span class="glyphicon-chevron-left"><img src="<?=base_url('assets/admin_assets/images/left-o.svg');?>"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-main-img" data-slide="next">
                        <span class="glyphicon-chevron-right"><img src="<?=base_url('assets/admin_assets/images/right-o.svg');?>"></span>
                    </a>
                </div>

                <div id="carousel-thumb-img" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">



                            <ul class=" list-unstyled row ucd-main-thumb">
                                <?php
                               //echo count($getAllImage); exit;
                                //$getAllThumbImage = array_unshift($getAllThumbImage,'');
                                $i = 0;
                                $k = 0;
                                foreach ($getAllImage as $key => $thumbvals)
                                {
                                    $k++;
                                    if ($i == 0)
                                    {
                                        $class = "selected";
                                    }
                                    else
                                    {
                                        $class = "";
                                    }
                                    ?>
                                    <li class="selected" id="carousel-selector-<?php echo $i ?>"><img src="<?php echo $thumbvals['image_url'] ?>?time=<?php echo time(); ?>" class="img-responsive"></li>
                                    <?php
                                    if ($k % 5 == 0)
                                    {
                                        $k = 0;
                                        echo "</ul></div><div class='item'><ul class='list-unstyled row ucd-main-thumb'>";
                                    }
                                    $i++;
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-thumb-img" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"><img src="<?=base_url('assets/admin_assets/images/left-o.svg');?>"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-thumb-img" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"><img src="<?=base_url('assets/admin_assets/images/right-o.svg');?>"></span>
                    </a>
                </div>

            </div>
            <?php
        }
        else
        {
            ?>
            <div style="text-align:center;padding-top:30px;">You have not upload any image yet. Please upload images.</div>
        <?php } ?> 
    </div>
</div>
<script>
    jQuery('#carousel-thumb-img').carousel({
        pause: true,
        interval: false
    });
    jQuery('#carousel-main-img').carousel({
        pause: true,
        interval: false
    });


// handles the carousel thumbnails
    jQuery('[id^=carousel-selector-]').click(function () {
        var id_selector = $(this).attr("id");
        //alert(id_selector.length);
        var idnew = id_selector.split('-');
        //alert(idnew);
       // var id = id_selector.substr(id_selector.length - 1);
        id = parseInt(idnew[2]);
         //alert(id);
        $('#carousel-main-img').carousel(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $(this).addClass('selected');
        $(".strip li:nth-child(3)").trigger('click');
    });

// when the carousel slides, auto update
    jQuery('#carousel-main-img').on('slid', function (e) {
        var id = $('.item.active').data('slide-number');
        id = parseInt(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $('[id^=carousel-selector-' + id + ']').addClass('selected');
    });

    $('#addshortlist').click(function () {
        $('#addshortlist>.fa-heart').toggleClass('fa-heart-fill');
    });

    var ucdnav = $('#ucdtabnav li a');
    ucdnav.click(function () {
        ucdnav.toggleClass(' darkgray');
    });
   
</script>
