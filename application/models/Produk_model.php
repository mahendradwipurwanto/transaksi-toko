<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {

    var $table = "mst_produk";
    var $primary_key = "id";
    var $column_order = array('kode_barang', 'kode_barang', null);
    public function __construct() {
        parent::__construct();
    }

    public function getDataIndex($offset = 0, $limit = 10, $search = "") {

         if (!empty($search)) {
            $this->db->like('kode_barang', $search);
        }
        $this->db->from($this->table);
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->order_by($this->table . ".kode_barang ASC");
        $data = $this->db->get();
        return $data->result();
    }
     public function cekkodebarang()
    {
        $this->db->select('RIGHT(mst_produk.kode_barang,2) as kode_barang', FALSE);
		  $this->db->order_by('kode_barang','DESC');    
		  $this->db->limit(1);    
		  $query = $this->db->get('mst_produk');  //cek dulu apakah ada sudah ada kode di tabel.    
		  if($query->num_rows() <> 0){      
			   //cek kode jika telah tersedia    
			   $data = $query->row();      
			   $kode = intval($data->kode_barang) + 1; 
		  }
		  else{      
			   $kode = 1;  //cek jika kode belum terdapat pada table
		  }
			  $tgl=date('dmY'); 
			  $batas = str_pad($kode, 3, "0", STR_PAD_LEFT);    
			  $kodetampil = "BR".$tgl.$batas;  //format kode
			  return $kodetampil;  
    }
    public function getDetail($id) {
        $this->db->like('kode_barang', $id);
        $query = $this->db->get($this->table, 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->row_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }
    
    public function getByLevel($id) {
        $this->db->where('id_level', $id);
        $query = $this->db->get($this->table, 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->result_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getCountDataIndex($search = "") {
        if (!empty($search)) {
            $this->db->like('kode_barang', $search);
        }
        $this->db->select($this->table . '.* ');
        $this->db->from($this->table);
        $data = $this->db->count_all_results();
        return $data;
    }
     function count_filtered($nama = "") {
        $this->_get_datatables_query();
        if (!empty($nama)) {
            $this->db->like("kode_barang", $nama);
        };
        $query = $this->db->get();
        return $query->num_rows();
    }
     public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function saveData($arrData = array(), $debug = false) {

        $this->db->set($arrData);
        if ($debug) {
            $retVal = $this->db->get_compiled_insert($this->table);
        } else {
            $res = $this->db->insert($this->table);
            if (!$res) {
                $retVal['error_stat'] = "Failed To Insert";
                $retVal['status'] = false;
            } else {
                $retVal['error_stat'] = "Success To Insert";
                $retVal['status'] = true;
                $retVal['id'] = $this->db->insert_id();
            }
        }
        return $retVal;
    }

    public function updateDetail($array, $id) {

        $this->db->where($this->primary_key, $id);
        $query = $this->db->update($this->table, $array);
        if (!$query) {

            $retVal['error_stat'] = "Failed To Insert";
            $retVal['status'] = false;
        } else {
            $retVal['error_stat'] = "Success To Update";
            $retVal['status'] = true;
            $retVal['id'] = $id;
        }

        return $retVal;
    }

    public function delete($array, $id) {
        $this->db->where($this->primary_key, $id);
        $q = $this->db->update($this->table, $array);

        if (!$q) {
            $retVal['error_stat'] = "Failed To Delete";
            $retVal['status'] = false;
        } else {
            $retVal['error_stat'] = "Success To Delete";
            $retVal['status'] = true;
        }

        return $retVal;
    }
     private function _get_datatables_query() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('deletion !=',1);
        $i = 0;
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables($nama = "") {
        $this->_get_datatables_query();
        $this->db->order_by('mst_produk.kode_barang ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function getDetailHarga($id) {
        $this->db->select('mst_produk.harga,mst_produk.satuan');
        
        $this->db->where('mst_produk.id',$id);
        $query = $this->db->get('mst_produk', 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->row_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }
}
