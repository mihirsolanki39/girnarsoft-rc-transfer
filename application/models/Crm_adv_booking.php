<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Crm_adv_booking extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTable() {
        return 'crm_adv_booking';
    }




    public function getAllBookingInfo($searchbyval='',$searchbyvaldealer='',$searchby='',$showroom='',$sale_emp='',$searchdate='',$daterange_to='',$daterange_from='',$pages='',$dashboard='',$role_name='',$user_id='')
    {
        $rpp=10;
        $perPageRecord = $rpp == 0 ? 10 : $rpp;
        $pageNo = (isset($pages) && $pages != '') ? $pages : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        $this->db->select('ad.*,d.organization as showroom,de.organization as dealership_name,o.outlet_address,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,u.name,c.name as colors');
        $this->db->from('crm_adv_booking as ad');
        $this->db->join('crm_user as u', 'ad.emp_id=u.id','left');
        $this->db->join('crm_dealers as d', 'ad.showroom_id=d.id','left');
        $this->db->join('crm_outlet as o', 'o.dealer_id = ad.showroom_id','left');
        $this->db->join('crm_dealers as de', 'ad.dealer_id=de.id','left');
        $this->db->join('colors as c', 'c.id=ad.color','left');
        $this->db->join('model_version as mv', 'ad.version_id=mv.db_version_id','left');
        $this->db->join('make_model as mm', 'mv.model_id = mm.id','left');

        if((!empty($searchbyval)) && (!empty($searchby)))
        {
            if($searchby=='searchmobile')
            {
                $this->db->where('ad.customer_mobile',$searchbyval);
            }
            if($searchby=='searchslip')
            {
                //$searchByInd ='ad.booking_slip_no';
                 $this->db->where('ad.booking_slip_no',$searchbyval);
            }
              
            if($searchby=='searchbooking')
            {
               // $searchByInd ='ad.showroom_booking_no';  
                $this->db->where('ad.showroom_booking_no',$searchbyval);
            }
            if($searchby=='searchcustname')
            { 

               $this->db->where('ad.customer_name like', "%".trim($searchbyval)."%");         
            }

            //$this->db->where($searchByInd,$searchbyval);      
       }
       if(!empty($showroom))
       {
            $this->db->where('ad.showroom_id',$showroom);
       }
      
       if(!empty($sale_emp))
       {
           $this->db->where('ad.emp_id',$sale_emp);
       }
      
       if(!empty($daterange_to))
       {
            $searchedDate = 'ad.booking_date';
            if(!empty($daterange_to))
            {
                $to = date('Y-m-d', strtotime($daterange_to)); 
                $where = "DATE(".$searchedDate.")";
                $this->db->where($where.'>=',$to);
            }
            if(!empty($daterange_from))
            {
                $from = date('Y-m-d', strtotime($daterange_from));
                $where = "DATE(".$searchedDate.")";
               // $this->db->where($where.'<=',$from);
                $this->db->where($searchedDate.'<=',$from);
            }
          
        }      
        //$this->db->order_by('ad.updated_by','desc');
        $this->db->order_by('ad.id','desc');
        if (isset($pages))
        {
           $this->db->offset((int) ($startLimit));
        }
        if (!empty($perPageRecord))
        {
            $this->db->limit((int) $perPageRecord);
        }
        $query = $this->db->get();
        $result = $query->result_array();
      // echo $this->db->last_query(); exit;
        return  $result;     
    }

     public function getAllBookingInfoCount($searchbyval='',$searchbyvaldealer='',$searchby='',$showroom='',$sale_emp='',$searchdate='',$daterange_to='',$daterange_from='',$pages='',$dashboard='',$role_name='',$user_id='')
    {
        $this->db->select('ad.*,d.organization as showroom,de.organization as dealership_name,o.outlet_address,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,u.name,c.name as colors');
        $this->db->from('crm_adv_booking as ad');
        $this->db->join('crm_user as u', 'ad.emp_id=u.id','left');
        $this->db->join('crm_dealers as d', 'ad.showroom_id=d.id','left');
        $this->db->join('crm_outlet as o', 'o.dealer_id = ad.showroom_id','left');
        $this->db->join('crm_dealers as de', 'ad.dealer_id=de.id','left');
        $this->db->join('colors as c', 'c.id=ad.color','left');
        $this->db->join('model_version as mv', 'ad.version_id=mv.db_version_id','left');
        $this->db->join('make_model as mm', 'mv.model_id = mm.id','left');

        if((!empty($searchbyval)) && (!empty($searchby)))
        {
            if($searchby=='searchmobile')
            {
                $searchByInd ='ad.customer_mobile';
            }
            if($searchby=='searchslip')
            {
                $searchByInd ='ad.booking_slip_no';
            }
              
            if($searchby=='searchbooking')
            {
                $searchByInd ='ad.showroom_booking_no';  
            }
            if($searchby=='searchcustname')
            {
                $searchByInd ='ad.customer_name';  
                //$this->db->like('lci.name', $searchbyval, 'both');           
            }
            $this->db->where($searchByInd,$searchbyval);      
       }
       if(!empty($showroom))
       {
            $this->db->where('ad.showroom_id',$showroom);
       }
      
       if(!empty($sale_emp))
       {
           $this->db->where('ad.emp_id',$sale_emp);
       }
      
       if(!empty($daterange_to))
       {
            $searchedDate = 'ad.booking_date';
            if(!empty($daterange_to))
            {
                $to = date('Y-m-d', strtotime($daterange_to)); 
                $where = "DATE(".$searchedDate.")";
                $this->db->where($where.'>=',$to);
            }
            if(!empty($daterange_from))
            {
                $from = date('Y-m-d', strtotime($daterange_from));
                $where = "DATE(".$searchedDate.")";
               // $this->db->where($where.'<=',$from);
                $this->db->where($searchedDate.'<=',$from);
            }
          
        }      
        $this->db->order_by('ad.updated_by','desc');
        $query = $this->db->get();
        $result = $query->result_array();
      // echo $this->db->last_query(); exit;
        return  $result;     
    }

    public function addAdvBooking($data,$id="")
    {
        if(empty($id)) 
        {
            $this->db->trans_start();
            $this->db->insert('crm_adv_booking', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } 
        else 
        {
            $this->db->where('id', $id);
            $this->db->update('crm_adv_booking', $data);
            $result = $id;
        }
        return $result;
    }

      public function addRefurbWorkshop($data,$id="")
    {
        if(empty($id)) 
        {
            $this->db->trans_start();
            $this->db->insert('crm_refurb_workshop', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } 
        else 
        {

            $this->db->where('id', $id);
            $this->db->update('crm_refurb_workshop', $data);
            $result = $id;
        }
        return $result;
    }

    public function getAdvBooking($id)
    {
        $this->db->select('ad.*,ad.id as booking_id,mv.db_version as version,mm.make as make,mm.model as model');
        $this->db->from('crm_adv_booking as ad');
        $this->db->join('model_version as mv', 'ad.version_id=mv.db_version_id','left');
        $this->db->join('make_model as mm', 'mv.model_id = mm.id','left');
        $this->db->where('ad.id',$id);
        $query = $this->db->get();
        $result = $query->result_array();
        // echo $this->db->last_query(); exit;
        return  $result; 
    }

    public function getRefurbWorkshop($id='')
    {
        $this->db->select('*');
        $this->db->from('crm_refurb_workshop');
        if(!empty($id))
        {
            $this->db->where('id',$id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        // echo $this->db->last_query(); exit;
        return  $result; 
    }


     public function getRefurbWorkshopAll($searchbyval='',$searchbyvaldealer='',$searchby='',$pages='')
    {
        $rpp=5;
        $perPageRecord = $rpp == 0 ? 5 : $rpp;
        $pageNo = (isset($pages) && $pages != '') ? $pages : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        $this->db->select('*');
        $this->db->from('crm_refurb_workshop');

        if((!empty($searchbyval)) && (!empty($searchby)))
        {
            if($searchby=='searchmobile')
            {
                $searchByInd ='owner_mobile';
            }
            if($searchby=='searchslip')
            {
                $searchByInd ='name';
            }
              
            if($searchby=='searchbooking')
            {
                $searchByInd ='mobile';  
            }
            if($searchby=='searchcustname')
            {
                $searchByInd ='owner_name';  
                //$this->db->like('lci.name', $searchbyval, 'both');           
            }
            $this->db->where($searchByInd,$searchbyval);      
       }
               $this->db->order_by('updated_at','desc');
      // $this->db->order_by('lmt.priority','desc');
        if (isset($pages))
        {
           $this->db->offset((int) ($startLimit));
        }
        if (!empty($perPageRecord))
        {
            $this->db->limit((int) $perPageRecord);
        }
        $query = $this->db->get();
        $result = $query->result_array();
      // echo $this->db->last_query(); exit;
        return  $result;     
    }

      public function getRefurbWorkshopAllCount($searchbyval='',$searchbyvaldealer='',$searchby='',$pages='')
    {
        $this->db->select('*');
        $this->db->from('crm_refurb_workshop');

        if((!empty($searchbyval)) && (!empty($searchby)))
        {
            if($searchby=='searchmobile')
            {
                $searchByInd ='owner_mobile';
            }
            if($searchby=='searchslip')
            {
                $searchByInd ='name';
            }
              
            if($searchby=='searchbooking')
            {
                $searchByInd ='mobile';  
            }
            if($searchby=='searchcustname')
            {
                $searchByInd ='owner_name';  
                //$this->db->like('lci.name', $searchbyval, 'both');           
            }
            $this->db->where($searchByInd,$searchbyval);      
       }
               $this->db->order_by('updated_at','desc');
      // $this->db->order_by('lmt.priority','desc');
       
        $query = $this->db->get();
        $result = $query->result_array();
      // echo $this->db->last_query(); exit;
        return  count($result);     
    }
}
