<?php //print_r($similar_cars);die;?>
<div class="close close-mp">
    <img src="<?= BASE_HREF ?>user/modules/stock/images/close.svg" alt="">
</div>
<p class="mrg-T15">Similar car prices in your area for <strong><?=$make_model_name?></strong></p>
<!--div class="price">&#8377;  4,50,000</div-->
<!--p class="light">Based on our research</p-->
<div class="table-responsive mrg-T10">
    <table class="table table-bordered mrg-B0">
        <thead>
            <tr>
                <th>Variant</th>
                <th>Kms</th>
                <th>Year</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($similar_cars['data'])){
            foreach($similar_cars['data'] as $similar_car):  ?>
            <tr>
                <td><?=$similar_car['version']?></td>
                <td><?= ($similar_car['km_driven']) ?></td>
                <td><?=$similar_car['make_year']?></td>
                <td>&#8377; <?= ($similar_car['car_price']) ?></td>
            </tr>
            <?php endforeach;}
            else{ ?>
            <tr><td colspan="4">No Cars Found with Similar Features!</td></tr> 
           <?php }?>
           
        </tbody>
    </table>
</div>
<script>
    $('.close-mp').click(function(){
        $('.marcketPriceSec').toggle();
    });
</script>