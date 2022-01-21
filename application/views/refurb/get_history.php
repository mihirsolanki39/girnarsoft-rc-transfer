<?php foreach($historyList as $key => $value){ ?>
<?php
  $details    = $value['refurb_details'];
  $newArray   = [];
  for($i=1;$i<100;$i++){
     $new = explode($i.'. ',$details);
     if(isset($new[1]) && trim($new[1]) != ''){
      $j = $i+1;
      $temp = explode($j.'. ',trim($new[1]));
      $newArray[] = trim($temp[0]);
     }
  }
?>
<li class="side_nav">
  <div class="col-md-12 border-B">
    <div class="row">
      <div class="col-sm-3">
        <a href="#" class="sidenav-a">
            <span class="img-type"> </span><?php echo date('d-m-Y',strtotime($value['sent_to_refurb'])); ?><small>Sent On</small>
            <span></span><?php echo date('d-m-Y',strtotime($value['estimated_date'])); ?><small>Retun On</small>
        </a>
      </div>
         <div class="col-sm-3">
            <?php echo $value['sent_km']; ?><small> KM(before Refurb)</small>
            <span></span>&nbsp;&nbsp;&nbsp;&nbsp;<br/>
            <?php echo $value['return_km']; ?><small> KM(after Refurb)</small>
        </div>

      <div class="col-sm-6 side_text">
        <a class="adownl" style="cursor: pointer;" onclick="downloadFile('<?php echo $value['file_name']; ?>')" data-toggle="tooltip" data-placement="left" title="Download Workorder"><img src="<?php echo base_url() ?>assets/images/download.svg" /></a>
        <span class="active_text">Workshop : <?php echo $value['name']; ?></span>
        <?php foreach($newArray as $index => $r_detail) { ?>
        <span class="Detail_text"><?php $no = intval($index) + 1; echo $no.'. '.$r_detail; ?></span>
        <?php } ?>
        
      </div>
       
        
        
        
    </div>
      
      <div>        
          <span><b>Actual Amount </b>: </span><i class="fa fa-rupee"></i> <?php echo !empty($value['actual_amt'])?money_formated($value['actual_amt']):0; ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <span><b>Estimated amount </b>: </span> <i class="fa fa-rupee"></i> <?php echo !empty($value['estimated_amt'])? money_formated($value['estimated_amt']):0; ?>        
        </div>
      
  </div>
</li>
<?php }

function money_formated($number){    
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);
        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }
        $result = strrev($delimiter);
        return $result;
    }
?>

