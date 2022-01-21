<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_upload_docs_list extends CI_Model {

	/*public function getDocList($parent_id='',$doc_stage='',$not_in_id=[],$rc='')
	{
		$this->db->select('id,name,parent_id,status,order_v3,order_no,is_required,doc_stage');
		$this->db->from('crm_upload_docs_list');
		$this->db->where('order_v3>"0"');
		
		$this->db->where('is_ats','1');
		$this->db->where('parent_id',$parent_id);
		if(!empty($doc_stage)){
			$this->db->where('doc_stage',$doc_stage);
		}
		if(!empty($not_in_id))
		{
			$this->db->where_not_in('id', $not_in_id);
		}
		if(!empty($rc))
		{
			$this->db->where('rc_doc_stage',$rc);
			$this->db->where('origin','RCM');
			$this->db->where('rc_doc','1');
		}
		else if(empty($rc))
		{
			$this->db->where('origin','ATS');
		}
		$this->db->order_by('order_no','asc');
		$query = $this->db->get();
	//	echo $this->db->last_query(); exit;
		return $result = $query->result_array();
	}*/

	public function saveCheckLists($data,$case_id)
	{
		if((!empty($data[0])) && (empty($data[1]))){
			$data=$data[0];
		}
		if(!empty($data[1])){
		foreach ($data as $key => $value) 
		{
			$des = [];
			$resu = $this->getChecklist($value['tag_id'],$case_id,$value['doc_type']);
			$des['tag_id'] = $value['tag_id'];
			$des['case_id'] = $value['case_id'];
			$des['doc_type'] = $value['doc_type'];
			$des['status'] = $value['status'];
			if(empty($resu))
			{
                $this->db->trans_start();
	        $this->db->insert('crm_document_checklist', $des);
	        $insert_id = $this->db->insert_id();
	        $this->db->trans_complete();
	      // echo $this->db->last_query(); exit;
	        $result = $insert_id;
	        
			}
			else
			{
				$this->db->where('id', $resu['id']);
		        $this->db->update('crm_document_checklist', $des);
		       // echo $this->db->last_query(); exit;
		       $result = $resu['id'];
			}
		}
	}
	else
	{
			$des = [];
			$resu = $this->getChecklist($data['tag_id'],$case_id,$data['doc_type']);
			$des['tag_id'] = $data['tag_id'];
			$des['case_id'] = $data['case_id'];
			$des['doc_type'] = $data['doc_type'];
			$des['status'] = $data['status'];
			if(empty($resu))
			{
                $this->db->trans_start();
	        $this->db->insert('crm_document_checklist', $des);
	        $insert_id = $this->db->insert_id();
	        $this->db->trans_complete();
	      // echo $this->db->last_query(); exit;
	        $result = $insert_id;
	        
			}
			else
			{
				$this->db->where('id', $resu['id']);
		        $this->db->update('crm_document_checklist', $des);
		      //  echo $this->db->last_query(); exit;
		       $result = $resu['id'];
			}
	}
		//echo $this->db->last_query(); exit;
		return $result;
	}
	public function getChecklist($tag_id='',$case_id,$doc_type,$flag='')
	{
		$this->db->select('*');
		$this->db->from('crm_document_checklist as cudl');
		if(!empty($tag_id))
		{
			$this->db->where('tag_id',$tag_id);
		}
		$this->db->where('case_id',$case_id);
		$this->db->where('doc_type',$doc_type);
		$query = $this->db->get();
		$result = $query->result_array();
              //  echo $this->db->last_query(); exit;
		if(empty($flag))
		{
			return $result[0];
		}
		else
		{
			return $result;
		}
	    

	}
	public function getInsImageList($customer_id="",$image_id="",$tag_id="",$bank_id="",$doc_type="1",$case_id='',$flag='',$tagIds='',$img_ids=[],$subcat_id='')
	{
		$this->db->select('cudl.*,lci.customer_name as buyer_name,lci.buyer_type,lci.customer_company_name,cudt.tag_id,cudt.parent_tag_id,cudt.image_id,cudt.id as imgID,cudt.bank_id as bank_id,cudt.mark_incorrect as err,lm.parent_name,scm.name,dm.parent_id,dm.sub_category_id as sub_id,scm.is_required,dm.id as tagid');
		$this->db->from('crm_upload_docs_loan as cudl');
		$this->db->join('crm_upload_doc_tag_mapping as cudt','cudl.id=cudt.image_id and cudt.status="1"','left');
		$this->db->join('crm_upload_doc_list_mapping as dm','dm.id=cudt.parent_tag_id','left');
		$this->db->join('crm_insurance_customer_details as lci','lci.id=cudl.case_id','left');
		$this->db->join('upload_doc_category_list as lm','lm.id=dm.parent_id','left');
		$this->db->join('upload_doc_sub_category_list as scm','scm.id=cudt.tag_id','left');
		if($customer_id>0){
		$this->db->where('cudl.customer_id',$customer_id);
		}
		if($case_id>0){
		$this->db->where('cudl.case_id',$case_id);
		}
		if($image_id>0)
		{
			$this->db->where('cudt.image_id',$image_id);
		}
		if(!empty($img_ids))
		{
			$this->db->where_in('cudl.id',$img_ids);
		}
		if(!empty($tag_id))
		{
			$this->db->where('cudt.tag_id',$tag_id);
		}
		if(!empty($tagIds))
		{
			//echo $tagIds; exit;
			$tgid = explode(',', $tagIds);
			$this->db->where_in('cudt.tag_id',$tgid);
		}
		if($bank_id>0)
		{
			$this->db->where('cudt.bank_id',$bank_id);
		}
		if($doc_type>0){
			$this->db->where('cudl.doc_type',"$doc_type");
		}
		if(!empty($subcat_id))
		{
			$this->db->where('dm.sub_category_id',"$subcat_id");
		}
		$this->db->where('cudl.status','1');
		if(!empty($subcat_id))
		{
			$this->db->group_by('dm.sub_category_id');	
		}
		//$this->db->order_by('cudt.tag_id','desc');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		 return $result;
	}

	//public function getDocList($parent_id='',$doc_stage='',$not_in_id=[],$rc='',$ins_flag='',$groupby='',$ids_in=[])
        public function getDocCheckList($case_id='',$doc_stage='')
        {
            $this->db->select('*');
		$this->db->from('crm_document_checklist ');
                $this->db->where('doc_type',$doc_stage);
                $this->db->where('case_id',$case_id);
                $query = $this->db->get();
	//echo $this->db->last_query(); exit;
		 $result = $query->result_array();
		 return  $result;
        }

	public function getDocList($parent_id='',$doc_stage='',$not_in_id=[],$rc='',$ins_flag='',$groupby='',$tag_ids=[])
	{
            	$this->db->select('dm.*,cl.parent_name,cl.is_required as catreq,scl.name,scl.is_required as is_require,dm.is_required as listreq,dm.status as liststatus');
		$this->db->from('crm_upload_doc_list_mapping as dm');
		$this->db->join('upload_doc_category_list as cl ',' dm.parent_id=cl.id','inner');
		$this->db->join('upload_doc_sub_category_list as scl ',' dm.sub_category_id=scl.id','inner');
		//$this->db->join('crm_document_checklist as cdl ',' cdl.tag_id=dm.id','left');
		if(!empty($doc_stage))
		{
			$this->db->where('cl.doc_type',$doc_stage);
		}
		if(!empty($not_in_id))
		{
			$this->db->where_not_in('dm.id', $not_in_id);
		}
		if(!empty($parent_id))
		{
			$this->db->where('dm.parent_id',$parent_id);
		}
		if(!empty($ins_flag))
		{
			$this->db->where('dm.ins_flag',$ins_flag);
		}
		if(!empty($tag_ids))
		{
			$this->db->where_in('dm.sub_category_id',$tag_ids);
		}
		if((!empty($groupby)) && ($groupby=='1'))
		{
			$this->db->group_by('dm.parent_id');	
		}
		if((!empty($groupby)) && ($groupby=='2'))
		{
			$this->db->group_by('dm.sub_category_id');	
		}
		$this->db->order_by('cl.order_no','asc');
		$this->db->order_by('dm.sub_category_id','asc');
		$query = $this->db->get();
		 $result = $query->result_array();
              //  echo $this->db->last_query();//die;
                //echo "<pre>";print_r($result);
		 return  $result;
	}

	public function insertLoginDocs($data,$id='')
	{
		if(empty($id))
		{
            $this->db->trans_start();
	        $this->db->insert('crm_upload_docs_loan', $data);
	        $insert_id = $this->db->insert_id();
	        $this->db->trans_complete();
	        $result = $insert_id;
	        
		}
		else
		{
			$this->db->where('id', $id);
	        $this->db->update('crm_upload_docs_loan', $data);
	        $result = $id;
		}
		//echo $this->db->last_query(); exit;
		return $result;
	}

	/*public function getImageList($customer_id="",$image_id="",$tag_id="",$bank_id="",$doc_type="1",$case_id='',$flag='',$tagIds='',$img_ids=[])
	{
	        $this->db->select('cudl.*,cudt.tag_id,cudt.image_id,cudt.id as imgID,cudt.bank_id as bank_id,cud.name,cud.parent_id,cud.is_required,cudt.mark_incorrect as err');
		$this->db->from('crm_upload_docs_loan as cudl');
		$this->db->join('crm_upload_doc_tag_mapping as cudt','cudl.id=cudt.image_id and cudt.status="1"','left');
		$this->db->join('crm_upload_docs_list as cud','cud.id=cudt.tag_id','left');
		if($customer_id>0){
		$this->db->where('cudl.customer_id',$customer_id);
		}
		if($case_id>0){
		$this->db->where('cudl.case_id',$case_id);
		}
		if($image_id>0)
		{
			$this->db->where('cudt.image_id',$image_id);
		}
		if(!empty($img_ids))
		{
			$this->db->where_in('cudl.id',$img_ids);
		}
		if($tag_id>0)
		{
			$this->db->where('cudt.tag_id',$tag_id);
		}
		if($tagIds>0)
		{
			$tgid = explode(',', $tagIds);
			$this->db->where_in('cudt.tag_id',$tgid);
		}
		if($bank_id>0)
		{
			$this->db->where('cudt.bank_id',$bank_id);
		}
		if($doc_type>0){
			$this->db->where('cudl.doc_type',"$doc_type");
		}
		$this->db->where('cudl.status','1');
		$this->db->order_by('cudt.tag_id','desc');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		 return $result;
	}*/
public function getImageuploadList($customer_id="",$image_id="",$tag_id="",$bank_id="",$doc_type="1",$case_id='',$flag='',$tagIds='',$img_ids=[],$subcat_id='',$ptag_id='')
	{
		$this->db->select('cudl.*,lci.seller_name as buyer_name,cudt.tag_id,cudt.parent_tag_id,cudt.image_id,cudt.id as imgID,cudt.bank_id as bank_id,cudt.mark_incorrect as err,lm.parent_name,scm.name,dm.parent_id,dm.sub_category_id as sub_id,scm.is_required,dm.id as tagid');
		$this->db->from('crm_upload_docs_loan as cudl');
		$this->db->join('crm_upload_doc_tag_mapping as cudt','cudl.id=cudt.image_id and cudt.status="1"','left');
		$this->db->join('crm_upload_doc_list_mapping as dm','dm.id=cudt.parent_tag_id','left');
		$this->db->join('crm_used_car_other_fields as lci','lci.case_id=cudl.case_id','left');
		$this->db->join('upload_doc_category_list as lm','lm.id=dm.parent_id','left');
		$this->db->join('upload_doc_sub_category_list as scm','scm.id=cudt.tag_id','left');
		if($customer_id>0){
		$this->db->where('cudl.customer_id',$customer_id);
		}
		if($case_id>0){
		$this->db->where('cudl.case_id',$case_id);
		}
		if($image_id>0)
		{
			$this->db->where('cudt.image_id',$image_id);
		}
		if(!empty($img_ids))
		{
			$this->db->where_in('cudl.id',$img_ids);
		}
		if($tag_id>0)
		{
			$this->db->where('cudt.tag_id',$tag_id);
		}
		if($tagIds>0)
		{
			$tgid = explode(',', $tagIds);
			$this->db->where_in('cudt.tag_id',$tgid);
		}
		if($ptag_id>0)
		{
			$this->db->where('cudt.parent_tag_id',$ptag_id);
		}
		if($bank_id>0)
		{
			$this->db->where('cudt.bank_id',$bank_id);
		}
		if($doc_type>0){
			$this->db->where('cudl.doc_type',$doc_type);
		}
		if(!empty($subcat_id))
		{
			$this->db->where('dm.sub_category_id',$subcat_id);
		}
		$this->db->where('cudl.status','1');
		if(!empty($subcat_id))
		{
			$this->db->group_by('dm.sub_category_id');	
		}
		//$this->db->order_by('cudt.tag_id','desc');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		 return $result;
	}
	public function getImageList($customer_id="",$image_id="",$tag_id="",$bank_id="",$doc_type="1",$case_id='',$flag='',$tagIds='',$img_ids=[],$subcat_id='',$ptag_id='')
	{
		$this->db->select('cudl.*,lci.name as buyer_name,cudt.tag_id,cudt.parent_tag_id,cudt.image_id,cudt.id as imgID,cudt.bank_id as bank_id,cudt.mark_incorrect as err,lm.parent_name,scm.name,dm.parent_id,dm.sub_category_id as sub_id,scm.is_required,dm.id as tagid');
		$this->db->from('crm_upload_docs_loan as cudl');
		$this->db->join('crm_upload_doc_tag_mapping as cudt','cudl.id=cudt.image_id and cudt.status="1"','left');
		$this->db->join('crm_upload_doc_list_mapping as dm','dm.id=cudt.parent_tag_id','left');
		$this->db->join('loan_customer_info as lci','lci.id=cudl.case_id','left');
		$this->db->join('upload_doc_category_list as lm','lm.id=dm.parent_id','left');
		$this->db->join('upload_doc_sub_category_list as scm','scm.id=cudt.tag_id','left');
		if($customer_id>0){
		$this->db->where('cudl.customer_id',$customer_id);
		}
		if($case_id>0){
		$this->db->where('cudl.case_id',$case_id);
		}
		if($image_id>0)
		{
			$this->db->where('cudt.image_id',$image_id);
		}
		if(!empty($img_ids))
		{
			$this->db->where_in('cudl.id',$img_ids);
		}
		if($tag_id>0)
		{
			$this->db->where('cudt.tag_id',$tag_id);
		}
		if($ptag_id>0)
		{
			$this->db->where('cudt.parent_tag_id',$ptag_id);
		}
		if($tagIds>0)
		{
			$tgid = explode(',', $tagIds);
			$this->db->where_in('cudt.tag_id',$tgid);
		}
		if($bank_id>0)
		{
			$this->db->where('cudt.bank_id',$bank_id);
		}
		if($doc_type>0){
			$this->db->where('cudl.doc_type',"$doc_type");
		}
		if(!empty($subcat_id))
		{
			$this->db->where('dm.sub_category_id',$subcat_id);
		}
		$this->db->where('cudl.status','1');
		if(!empty($subcat_id))
		{
			$this->db->group_by('dm.sub_category_id');	
		}
		//$this->db->order_by('cudt.tag_id','desc');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		 return $result;
	}

	public function insertTagMapping($data,$id='')
	{

		if(empty($id))
		{
                $data['created_on'] = date('Y-m-d h:i:s');
                $this->db->trans_start();
	        $this->db->insert('crm_upload_doc_tag_mapping', $data);
	        $insert_id = $this->db->insert_id();
	        $this->db->trans_complete();
	        $result = $insert_id;
                }
		else
		{
		$this->db->where('id', $id);
	        $this->db->update('crm_upload_doc_tag_mapping', $data);
	        $result = $id;
		}
		//echo $this->db->last_query(); exit;
		return $result;
	}

public function getChecklistDoc($case_id,$doc_type,$tag_id='')
{
	$this->db->select('dm.*,cl.parent_name,scl.name,scl.is_required as is_require');
	$this->db->from('crm_upload_doc_list_mapping as dm');
	$this->db->join('upload_doc_category_list as cl ',' dm.parent_id=cl.id','inner');
	$this->db->join('upload_doc_sub_category_list as scl ',' dm.sub_category_id=scl.id','inner');
	$this->db->join('crm_upload_doc_tag_mapping as cdtm ',' cdtm.parent_tag_id=dm.id','left');
	$this->db->join('crm_upload_docs_loan as cdl ',' cdtm.image_id=cdl.id','left');
	$this->db->where('cdl.case_id',$case_id);
	$this->db->where('cdl.doc_type',$doc_type);
	$this->db->where('cdl.status','1');
	$this->db->where('cdtm.status','1');
	$query = $this->db->get();
	//echo $this->db->last_query(); exit;
	return $result = $query->result_array();
}

public function getInsDocList($parent_id='',$doc_stage='',$not_in_id=[],$catId)
	{
		$this->db->select('id,name,parent_id,status,order_v3,order_no,is_required,doc_stage');
		$this->db->from('crm_upload_docs_list');
		//$this->db->where('order_v3>"0"');
		$this->db->where('origin','INS');
		$this->db->where('is_ats','2');
		$this->db->where('parent_id',$parent_id);
		$this->db->where('doc_stage',$doc_stage);
                $this->db->where('ins_category',$catId);
                if(!empty($not_in_id))
		{
		$this->db->where_not_in('id', $not_in_id);
		}
		$this->db->order_by('order_no','asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result = $query->result_array();
	}



	public function insertPendencyMapping($data,$id='')
	{

		if(empty($id))
		{
                $this->db->trans_start();
	        $this->db->insert('loan_doc_pendency_mapping', $data);
	        $insert_id = $this->db->insert_id();
	        $this->db->trans_complete();
	        $result = $insert_id;
	        
		}
		else
		{
			$this->db->where('id', $id);
	        $this->db->update('loan_doc_pendency_mapping', $data);
	        $result = $id;
		}
		//echo $this->db->last_query(); exit;
		return $result;
	}

	/*public function getPendencyDetail($case_id,$doc_type='',$pendency_id='')
	{
		$this->db->select('dpm.*,udt.name as doc_name,udt.id as doc_id,udt.parent_id as doc_parent_id');
		$this->db->where(array('dpm.case_id'=>$case_id,'dpm.status'=>'1'));
		if($pendency_id>0){
			$this->db->where('dpm.pendency_doc_id',$pendency_id);
		}
		if($doc_type>0)
		{
			$this->db->where('dpm.doc_type',$doc_type);
		}
		$this->db->from('loan_doc_pendency_mapping as dpm');
		$this->db->join('crm_upload_docs_list as udt','dpm.pendency_doc_id=udt.id','inner');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return $result;

	} */

	public function getPendencyDetail($case_id,$doc_type='',$pendency_id='')
	{
		$this->db->select('dpm.*,ust.name as doc_name,udt.sub_category_id as doc_id,udt.parent_id as doc_parent_id');
		$this->db->where(array('dpm.case_id'=>$case_id,'dpm.status'=>'1'));
		if($pendency_id>0){
			$this->db->where('dpm.pendency_doc_id',$pendency_id);
		}
		if($doc_type>0)
		{
			$this->db->where('dpm.doc_type',$doc_type);
		}
		$this->db->from('loan_doc_pendency_mapping as dpm');
		$this->db->join('crm_upload_doc_list_mapping as udt','dpm.pendency_doc_id=udt.sub_category_id','inner');
		$this->db->join('upload_doc_sub_category_list as ust','ust.id=udt.sub_category_id','inner');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return $result;

	}

	public function getTagNameById($tagId)
	{
		$this->db->select('id,name');
		$this->db->from('crm_upload_docs_list');
		$this->db->where('id',$tagId);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result = $query->result_array();

	}
	public function getPendencyImageList($customer_id="",$image_id="",$tag_id="",$bank_id="",$doc_type="1",$case_id='')
	{
	        $this->db->select('cudl.*,cudt.tag_id,cudt.image_id,cudt.id as imgID,cudt.bank_id as bank_id,cud.name,cud.parent_id,cudt.mark_incorrect as err');
		$this->db->from('crm_upload_docs_loan as cudl');
		$this->db->join('crm_upload_doc_tag_mapping as cudt','cudl.id=cudt.image_id and cudt.status="1"','left');
		$this->db->join('crm_upload_docs_list as cud','cud.id=cudt.tag_id','left');
		$this->db->join('loan_doc_pendency_mapping as pend','pend.pendency_doc_id=cudt.tag_id','left');
		if($customer_id>0){
		$this->db->where('cudl.customer_id',$customer_id);
		}
		if($case_id>0){
		$this->db->where('cudl.case_id',$case_id);
		}
		if($image_id>0)
		{
			$this->db->where('cudt.image_id',$image_id);
		}
		if($tag_id>0)
		{
			$this->db->where('cudt.tag_id',$tag_id);
		}
		if($bank_id>0)
		{
			$this->db->where('cudt.bank_id',$bank_id);
		}
		$this->db->where('cudl.doc_type',"$doc_type");
		$this->db->where('cudl.status','1');
		$this->db->where('pend.status','1');
		//$this->db->order_by('cudt.tag_id','desc');
		
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		 return $result;
	}
        
        public function getInsPendencyImageList($customer_id="",$image_id="",$tag_id="",$bank_id="",$doc_type="1",$case_id='')
	{
	        $this->db->select('cudl.*,cudt.tag_id,cudt.image_id,cudt.id as imgID,cudt.bank_id as bank_id,cud.name,cud.parent_id,cudt.mark_incorrect as err');
		$this->db->from('crm_upload_docs_loan as cudl');
		$this->db->join('crm_upload_doc_tag_mapping as cudt','cudl.id=cudt.image_id and cudt.status="1"','left');
		$this->db->join('crm_upload_docs_list as cud','cud.id=cudt.tag_id','left');
		//$this->db->join('loan_doc_pendency_mapping as pend','pend.pendency_doc_id=cudt.tag_id','left');
		if($customer_id>0){
		$this->db->where('cudl.customer_id',$customer_id);
		}
		if($case_id>0){
		$this->db->where('cudl.case_id',$case_id);
		}
		if($image_id>0)
		{
			$this->db->where('cudt.image_id',$image_id);
		}
		if($tag_id>0)
		{
			$this->db->where('cudt.tag_id',$tag_id);
		}
		if($bank_id>0)
		{
			$this->db->where('cudt.bank_id',$bank_id);
		}
		$this->db->where('cudl.doc_type',"$doc_type");
		$this->db->where('cudl.status','1');
		//$this->db->where('pend.status','1');
		//$this->db->order_by('cudt.tag_id','desc');
		
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		 return $result;
	}

	public function insertPersonnelDocs($data,$id='')
	{
		if(empty($id))
		{
            $this->db->trans_start();
	        $this->db->insert('customer_personnel_docs', $data);
	        $insert_id = $this->db->insert_id();
	        $this->db->trans_complete();
	        $result = $insert_id;
	        
		}
		else
		{
			$this->db->where('id', $id);
	        $this->db->update('customer_personnel_docs', $data);
	        $result = $id;
		}
		//echo $this->db->last_query(); exit;
		return $result;
	}

	public function getPersonnelDocs($customer_id='',$tag_id='',$id='',$image_id='')
	{
		$this->db->select('c.*,cudl.doc_name,cudl.doc_url,cudl.sent_to_aws,cud.name as tag_name,cud.parent_id');
		$this->db->from('customer_personnel_docs as c');
		$this->db->join('crm_upload_docs_list as cud','cud.id=c.tag_id','left');
		$this->db->join('crm_upload_docs_loan as cudl','cudl.id=c.image_id','left');
		if(!empty($customer_id))
		{
			$this->db->where('c.customer_id',$customer_id);
		}
		if(!empty($id))
		{
			$this->db->where('c.id',$id);
		}
		if(!empty($image_id))
		{
			$this->db->where('c.image_id',$image_id);
		}
		if($tag_id>0)
		{
			$this->db->where('c.tag_id',$tag_id);
		}
		$this->db->where('cudl.status','1');
		$this->db->where('c.status','1');
		$query = $this->db->get();
		$result = array();
		if($query !== FALSE && $query->num_rows() > 0){
		    $result = $query->result_array();
		}
		//$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		 return $result;
	}

	public function getCategoryList($id=[],$doc='1')
	{
		$this->db->select('*');
		$this->db->from('upload_doc_category_list ');
		$this->db->where('status','1');
		if(!empty($id))
		{
			$this->db->where_not_in('id',$id);
		}
		if(!empty($doc))
		{
			$this->db->where('doc_type',$doc);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return $result;
	}

	public function getSubCategoryList($cat_id,$ids=[])
	{
		$this->db->select('um.*,sb.name,sb.is_required as is_require');
		$this->db->from('crm_upload_doc_list_mapping as um');
		$this->db->join('upload_doc_sub_category_list as sb','sb.id=um.sub_category_id','inner');
		$this->db->where('um.status','1');
		if(!empty($ids))
		{
			$this->db->where_not_in('sb.id',$ids);
		}
		if(!empty($cat_id))
		{
			$this->db->where('um.parent_id',$cat_id);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return $result;
	}
        
        public function updateUploadDocListMapping($parentId,$id = "",$status = "",$is_required = ""){
            $data['status'] = $status;
            $data['is_required'] = $is_required;
            if(!empty($id)){
                $this->db->where('id',$id);
                $this->db->update('crm_upload_doc_list_mapping',$data);
            }else{
                $this->db->where('parent_id',$parentId);
                $this->db->update('crm_upload_doc_list_mapping',array('status' => '0','is_required' => '0'));
            }
            
            return true;
        }

        public function getawsurl()
        {
        	$this->db->select('*');
			$this->db->from('crm_upload_docs_loan');
			$this->db->where('sent_to_aws','0');
			$query = $this->db->get();
			$result = $query->result_array();
			//echo $this->db->last_query(); exit;
			return $result;
        }
        public function setawsurl($url,$id,$flag='')
        {
        	if(!empty($id)){
        		if(empty($flag))
        		$data['doc_url_new'] = $url;

        		$data['sent_to_aws'] = '1';
                $this->db->where('id',$id);
                $this->db->update('crm_upload_docs_loan',$data);
            }
        }
        public function setusedcarawsurl($url,$id)
        {
        	if(!empty($id)){
        		$data['image_url'] = $url;
        		$data['sent_to_aws'] = '1';
                $this->db->where('id',$id);
                $this->db->update('crm_used_car_image_mapper',$data);
            }
        }

}

?>
