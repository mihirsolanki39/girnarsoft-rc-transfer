<?php

/**
 * model : Make_model
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Make_model extends CI_Model {

    public function __construct() {
        
    }

    public function getCarMakeList($car_type = 'new', $orderBy = 'priority', $orderFlag = 'desc') {
        if ($car_type == 'new'){
            $where = " WHERE dis_cont=0";
        }    
        if ($car_type == 'used') {
            $where = " WHERE dis_cont not in(2)";
        }    
        if ($car_type == 'upcoming') {
            $where = " WHERE dis_cont in(0,2)";
        }
        if ($orderBy != '') {
            $orderBy = " ORDER BY " . $orderBy . " " . $orderFlag . ",make asc";
        }    
        else {
            $orderBy = " ORDER BY make asc";
        }
        $sql = "SELECT id,make from car_make" . $where . $orderBy;
        $result    = $this->db->query($sql, [])->result_array();
        return $result;
    }
    
    function getCarModelList($make='',$car_type='new',$fields='*',$orderby='model',$where='where 1=1',$flag='asc', $offset=0,$limit=0)
	{
		if($limit>0)
		{
			$limitStr = " LIMIT $offset,$limit";	
		}
		$where.=" and make='$make'";
		if($car_type=='new'){
			$sql = "select  $fields from make_model $where AND dis_cont=0 order by $orderby $flag";
                }
                elseif($car_type=='used'){
			 $sql = "select  $fields from make_model $where AND parent_model_id=0 AND dis_cont in (0,1) order by $orderby $flag";
                }
                elseif($car_type=='make-seller-enquiry') {
			$sql = "select  $fields from make_model $where  AND dis_cont in (0,1) order by $orderby $flag";
                }
                elseif($car_type=='upcoming'){
			 $sql = "select  $fields from make_model $where AND dis_cont = 2 order by $orderby $flag $limitStr";
                }
                elseif($car_type=='new_upcoming'){
			$sql = "select  $fields from make_model $where AND dis_cont in (0,2) order by $orderby $flag";	
                }
                elseif($car_type=='all'){
            $sql = "select  $fields from make_model $where AND dis_cont in (0,1,2) order by $orderby $flag";  
                }
                else{
			$sql = "select  $fields from make_model $where order by dis_cont,$orderby $flag";	
                }
                //echo $sql;die;
		$result    = $this->db->query($sql, [])->result_array();
              return $result;
		
	}
    public function getMake() {
        
        $sql = "Select id, make from car_make order by priority DESC";
        $dataMake = $this->db->query($sql, [])->result_object();
        
        return $dataMake;
    }
    
    public function getMakeNameById($id) {
        $where ='';
        if($id!=''){
            $where = 'Where id="'.$id.'"';
        }
        $sql = "Select id, make from car_make $where order by priority DESC";
        $dataMake = $this->db->query($sql, [])->result_array();
        return $dataMake;
    }
    
    public function getMakeNameBymakeId($id) {
        $where ='';
        $dataMake=[];
        if($id!=''){
            $where = 'Where id="'.$id.'"'; 
            $sql = "Select id, make from car_make $where order by priority DESC";
            $dataMake = $this->db->query($sql, [])->result_array();
        }
        return $dataMake;
    }

    public function getModels(){
        
        $sql = "Select id, make, model from make_model";
        $sql .= " where parent_model_id = '0' ";               
        $sql .= " order by model ASC";
        $modelData = $this->db->query($sql, [])->result_object();
        return $modelData;
    }
     public function getChildModel($modelId){
      
        if(isset($modelId) && !empty($modelId)){ 
            $sql = "Select id from make_model where id IN (".$modelId.") OR parent_model_id IN (".$modelId.")";
            $dataModel = $this->db->query($sql, [])->result_object();
        }
        $modelIds = '';
        if(isset($dataModel) && !empty($dataModel)){ 
            foreach($dataModel as $key => $val){
                $modelIds .= $val->id.",";
            }
        }
        if(!empty($modelIds)) {
            $modelIds = substr($modelIds,0,-1);
        }
        return $modelIds;
    }

 public function getAllModelListAll($modelname = null)
        {
            $sql    = "SELECT id,model,parent_model_id FROM make_model WHERE model = '" . trim($modelname) . "'";
            $result    = $this->db->query($sql, [])->result_array();
            $d = $this->getAllModelListAllGetName($result[0]['id']);
            $keys = $this->getKeys($d);
            array_push($keys, $modelname);
            array_unique($keys);
            return $keys;
        }
        
        public function getAllModelListAllGetName($modelid = '')
        {
            $sql      = "SELECT id,model,parent_model_id FROM make_model WHERE parent_model_id= '" . $modelid . "'";
            $result    = $this->db->query($sql, [])->result_array();
            $children = array();

            if (count($result) > 0)
            {

                foreach ($result as $k => $row)
                {
                    //echo $row[model];exit;
                    $children[$row['model']] = $this->getAllModelListAllGetName($row['id']);
                }
            }
            return $children;
        }
        
        public function getKeys($array)
        {
            $keys = array();

            foreach ($array as $key => $value)
            {
                $keys[] = $key;

                if (is_array($value))
                {
                    $keys = array_merge($keys, $this->getKeys($value));
                }
            }

            return $keys;
        }

    public function getMakeModelVersionByCarId($version_id) {
        $sql = "SELECT mv.db_version_id, mv.db_version, mv.uc_fuel_type,mv.uc_body_type,mv.uc_transmission,mm.id as model_id, mm.model, mm.make_id, mm.make FROM ".MODEL_VERSION." as mv INNER JOIN ".MAKE_MODEL." As mm ON mv.model_id = mm.id WHERE mv.db_version_id = ".$version_id;
        return $this->db->query($sql,array())->result_array();
    }

    function getMakeName($makeIds) {
        $makeStr = '';
        if (!empty($makeIds)) {
            $sql = "Select id, make from car_make";
            $sql .= " where id IN (" . $makeIds . ") ";
            $makeData = $this->db->query($sql, [])->result_object();
            if (isset($makeData) && !empty($makeData)) {
                foreach ($makeData as $makeKey => $makeVal) {
                    $makeStr .= $makeVal->make . ',';
                }
            }
        }
        if (!empty($makeStr)) {
            $makeStr = substr($makeStr, 0, -1);
        }
        return $makeStr;
    }
    
    function getMakeModelName($modelIds) {
        $makeModelStr = '';
        if(!empty($modelIds)) {
            $sql = "Select id, make, model from make_model";
            $sql .= " where id IN (".$modelIds.") ";               
            $sql .= " order by model ASC";
            $modelData = $this->db->query($sql, [])->result_object();
            if(isset($modelData) && !empty($modelData)){ 
                foreach($modelData as $modelKey => $modelVal){
                    $makeModelStr .= $modelVal->make." ".$modelVal->model.',';
                }
            }
        }
        if(!empty($makeModelStr)) {
            $makeModelStr = substr($makeModelStr, 0, -1);
        }
        return $makeModelStr;
    }
public function getModelByMakeId($makeId) {
        $getMakeNameById = $this->Make_model->getMakeNameById($makeId);
        if(!empty($getMakeNameById)){
            $result = $this->Make_model->getCarModelList($getMakeNameById[0]['make'],'all');
        }
        return !empty($result)?$result:[];
    }
    public function getinsuranceModelByMakeId($makeId) {
        if($makeId){
        $getMakeNameById = $this->Make_model->getMakeNameById($makeId);
        $result = $this->Make_model->getCarModelList($getMakeNameById[0]['make'],'all');
        }
        return !empty($result)?$result:[];
    }
    public function getVersionById($make, $model) {
        $this->load->model('UserDashboard');
        $fields    = "db_version_id,db_version,uc_fuel_type,Displacement";
        $sqlJoin   = " ";
        $where     = $sqlJoin . " WHERE model_version.mk_id = '" . $make . "' AND model_version.model_id = '" . $model . "' ";
        $orderBy   = "uc_fuel_type";
        $versionListArr = array();
        $versionListArr = $this->UserDashboard->getCarVersionList($make, 'all', $fields, $orderBy, $where);
     return !empty($versionListArr)?$versionListArr:[];
        
    }
function getVariantListByModel($modelId){
        $sql ="select db_version_id,db_version from model_version where db_version_model='".$modelId."' and dis_cont in('0','1') ";
	$variantlist = $this->db->query($sql, [])->result_object();
        return $variantlist;
    }


    public function getParentModel($modelId,$flag='')
    {      
        if(isset($modelId) && !empty($modelId))
        { 
            $sql = "Select model from make_model where id IN (".$modelId.") and parent_model_id='0'";
            $dataModel = $this->db->query($sql, [])->result_array();
            $modelIds = !empty($dataModel[0]['model'])?$dataModel[0]['model']:'';
            if(empty($dataModel))
            {
               $sql = "Select parent_model_id from make_model where id IN (".$modelId.")" ;
               $dataModel = $this->db->query($sql, [])->result_array();
                $psql = "Select model from make_model where id = ".$dataModel[0]['parent_model_id'];
               $pdataModel = $this->db->query($psql, [])->result_array();
               $modelIds = $pdataModel[0]['model'];
            }
        }
        if((!empty($flag)) && (isset($modelId) && !empty($modelId)))
        {
            if(!empty($modelId))
            {
                 $mod = '';
                 $this->db->select('id'); 
                 $this->db->from('make_model');
                 $this->db->where_in('parent_model_id',$modelId);
                 $this->db->or_where('id',$modelId);
                 $query = $this->db->get();
                 $pdataModel = $query->result_array();
                 foreach($pdataModel as $key => $v)
                 {
                    $mod .=$v['id'].',';
                 }
                 $str = rtrim($mod, ',');
                 //echo $mod; exit;
                 $modelIds = $str;
            }
        }
        return $modelIds;
    }


    public function getMakeModelDuoName($myear='')
    {
        $this->db->select('mm.make,mm.model,mm.id as model_id,mm.make_id,cm.priority');
        $this->db->from('make_model as mm');
        $this->db->join('car_make AS cm', 'cm.id=mm.make_id','left');
        $this->db->where('mm.parent_model_id','0');
        //$this->db->order_by('mm.make','asc');
        $this->db->order_by('cm.priority','desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return  $result;   
    }
    
    public function truncate_table($table_name){
        $this->db->truncate($table_name); 
        return true;
    }
    
    public function inset_data($table_name,$data){
        $this->db->insert_batch($table_name, $data);
        return true;
    }
    
    public function  getDealersTableData($table_name,$limit_from='',$limit=''){
        $this->dealers = $this->load->database('dealers', TRUE);
        $this->dealers->from($table_name);
        if(!empty($limit))
        $this->dealers->limit($limit, $limit_from);
        $query  = $this->dealers->get();
        return $query->result();
    }
    
    

}


