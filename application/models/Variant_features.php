<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Variant_features extends CI_Model {

    public function __construct() {
        
    }
    
    function getcarfeature($versionid)
    {
        $feild="vf.*,ts.AntiLockBrakingSystem,ts.GearShiftIndicators,ts.AdjustableSteering,ts.RearWashWiper,ts.FrontFogLights,ts.SteeringMountedAudioControls,ts.AlloyWheels,ts.AirCondition,ts.TubelessTyres,ts.FrontSpeakers,ts.RearSpeakers";
        
        //$sqlfeatures="SELECT ".$feild." FROM ".VARIANT_FEATURES." as vf left join ".TECHNICAL_SPECIFICATIONS." as ts on ts.id=vf.variant_id where ts.version_id='".$versionid."'";
        $sqlfeatures="SELECT ".$feild." FROM variant_features as vf left join technical_specifications as ts on ts.id=vf.variant_id where ts.version_id='".$versionid."'";
        $resultfeatures = $this->db->query($sqlfeatures, [])->result_object();
         //echo "<pre>";
         //print_r($resultfeatures);
        if($resultfeatures){
         $resultfeatures[0]->CupHolders='No';
          $resultfeatures[0]->RearFogLights='No';
        $featureArray = array('child_safety_lock' => 'yes','immobilizer' => 'yes','central_locking' => 'yes','airbags' => 'yes','AntiLockBrakingSystem' => 'yes','reversing_camera' => 'yes','keyless_entry' => 'yes','sunroof' => 'yes','rain_sensing_wipers' => 'yes','moon_roof' => 'yes','cruise_control' => 'yes','GearShiftIndicators' => 'yes','AdjustableSteering' => 'yes','RearWashWiper'=> 'yes','RearFogLights' => 'yes','deffoger' => 'yes','power_windows' => 'yes','power_steering' => 'yes','driver_seat_height_adjust' =>'yes','rear_ac_vents' => 'yes','bluetooth_connectivity' => 'yes','FrontFogLights' => 'yes','SteeringMountedAudioControls' =>'yes','AlloyWheels' => 'yes','audio_system' => 'yes', 'AirCondition' => 'yes','TubelessTyres' =>'yes','FrontSpeakers' => 'yes','RearSpeakers' => 'yes','CupHolders' => 'yes');
         $returnarr=array();
         $count=0;
         $i=0;
         foreach($featureArray as $key=>$val){
             
             if ( $resultfeatures[0]->$key && strtolower($resultfeatures[0]->$key) == 'yes') {
                 $key = ($key == 'AirCondition') ? 'air_conditioner' : $key;
                 $key = ($key == 'AntiLockBrakingSystem') ? 'Anti-Lock_Braking_System' : $key;
                 $key = ($key == 'GearShiftIndicators') ? 'Gear_Shift_Indicators' : $key;
                 $key = ($key == 'AdjustableSteering') ? 'Adjustable_Steering' : $key;
                 $key = ($key == 'RearWashWiper') ? 'Rear_Wash_Wiper' : $key;
                 $key = ($key == 'FrontFogLights') ? 'Front_Fog_Lights' : $key;
                 $key = ($key == 'SteeringMountedAudioControls') ? 'Steering_Mounted_Audio_Controls' : $key;
                 $key = ($key == 'AlloyWheels') ? 'Alloy_Wheels' : $key;
                 $key = ($key == 'TubelessTyres') ? 'Tubeless_Tyres' : $key;
                 $key = ($key == 'FrontSpeakers') ? 'Front_Speakers' : $key;
                 $key = ($key == 'RearSpeakers') ? 'Rear_Speakers' : $key;
                 
                // $returnarr[]['value']=ucwords(implode(" ", explode("_", $key)));
                 //$returnarr[]['key']=$count;
                 $returnarr[]=array('value'=>ucwords(implode(" ", explode("_", $key))),'key'=>$count);
                 //$returnarr[]=$count;
                 
                if($i==5){
                 break;
                    } 
                    $i++;
                 
             }
             
             $count++; 
             
         }
        }
    
}
public function getCarOnRoadPrice($city_id,$version_id) {
        $arr = array();
        $newCarPrice=0;
        if(isset($city_id) && !empty($version_id)) {
             $sql = "Select opa.ex_showroom, opa.registration, opa.insurance, opa.logistic from technical_specifications ts INNER JOIN orp_price_actual opa ON ts.id = opa.technical_specification_id and opa.city ='".$city_id."'  where ts.version_id = '".$version_id."' ";
            
            $carData = $this->db->query($sql, [])->result_object();
          //echo "<pre>"; print_r($carData);
            if(!empty($carData)) {
                $newCarPrice = (intval($carData[0]->ex_showroom) + intval($carData[0]->registration) + intval($carData[0]->insurance) + intval($carData[0]->logistic));
                
            }
            

           }
           return $newCarPrice;
    }

}