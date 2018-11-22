<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Excel_import_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function select()
    {
        $this->db->order_by('CustomerID', 'ASC');
        $query = $this->db->get('tbl_custumer');

        return $query-> result();
    }

    public function insert($data)
    {
        $this->db->insert_batch('tbl_custumer', $data);
    }

    public function verificar_customerid($customer_id)
    {
        $this->db->where('CustomerID', $customer_id);
        $this->db->get('tbl_custumer');
        if($this->db->affected_rows()>0)
            return false;
        else
            return true;
    }

    public function actualizar($customer_id, $data1)
    {
            $this->db->where('CustomerID', $customer_id);
            $this->db->update('tbl_custumer', $data1);
        if($this->db->affected_rows()>0)
            return false;
        else
            return true;
    }
}