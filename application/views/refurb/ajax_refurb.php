<?php 
intval($renewtabCount['tot']) . "--". intval($renewtabCount['totassigned']) . "--" . intval($renewtabCount['totnotassigned']) ;
//echo '15--05--10';
echo "####@@@@@";
if(!empty($query['leads'])){
    $i=0;
 foreach($query['leads'] as $k=>$val){?>   
?>
<tr>
<td>
  <div class="mrg-B5"><b><?php echo $val['make'].' '.$val['model'].' '.$val['version'];?></b> </div>

  <div class="text-gray-customer">
   <span class="font-14"><?php !empty($val['regno']) ? $val['regno'] :'';?></span>
 </div>
</td>
<td>
  <?php echo (!empty($val['is_refurb_done']) &&  $val['is_refurb_done']=='0') ? 'In Refurb' : '';?>
 </td>
<td>Services</td>
<td>
  <?php $sent_to_refurb=($val['sent_to_refurb']!='0000-00-00') ? date("d M, Y",strtotime($val['sent_to_refurb'])) : '';?>  
  <div>Sent On <?php echo $sent_to_refurb;?></div>
  <?php $estimated_date=($val['estimated_date']!='0000-00-00') ? date("d M, Y",strtotime($val['estimated_date'])) : '';?>  
  <div>Return On <?php echo $estimated_date;?></div>
</td>
<td><?php echo (!empty($val['estimated_amt'])) ? $val['estimated_amt'] :''?> </td>
<td>
 <button class="btn btn-default"> Download Workorder</button></td>
</tr>
<?php }} else{

echo "1";exit;

 } ?>
