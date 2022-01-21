<?php
foreach($result as $sell_customer){
?>
<div class="media text-left">
          <div class="media-body" style="width:580px;word-break:break-all;">
            <h4 class="media-heading"><?=date('d M Y H:i',strtotime($sell_customer['added']))?></h4>
            <?php 
            if('agent'==strtolower($sell_customer['source'])){
                if($comment_source=='DC'){
                  echo '<strong>Agent: </strong>'.stripslashes($sell_customer['comment']);
                }
            }
            else{                
                echo stripslashes($sell_customer['comment']);
            }
            //stripslashes($sell_customer['comment'])
            ?>
          </div>
    	</div>
        <hr class="mrg-T10 mrg-B0">
<?php } ?>    

