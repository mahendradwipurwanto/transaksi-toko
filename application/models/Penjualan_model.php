<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{

    var $table = "tr_transaksi";
    var $primary_key = "id";
    var $column_order = array('id', 'id', null);
    var $jointTable = "tr_transaksi_detail";
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function check()
    {

        $ret = $this->db->select('*')
            ->from($this->table)
            ->get()->result();
        return $ret;
    }

    public function get_datasearch($searching)
    {

        $ret = $this->db->select('*')
            ->from('mst_produk')
            ->like('kode_barang', $searching)
            ->get()->result();
        return $ret;
    }

    public function getDataIndex($offset = 0, $limit = 10, $search = "")
    {
        $this->db->select('tr_transaksi.id,tr_transaksi.status,tr_transaksi.tanggal,'
            . 'tr_transaksi_detail.jumlah,tr_transaksi_detail.total');
        $this->db->from($this->table);
        $this->db->join('tr_transaksi_detail', 'tr_transaksi.id = tr_transaksi_detail.id_transaksi', 'left');
        if ($limit != "all") {
            $this->db->limit($limit);
        }
        $this->db->offset($offset);
        $this->db->order_by($this->table . ".id ASC");
//        $this->db->group_by($this->table . ".id");
        $data = $this->db->get();
        return $data->result();
    }

    public function getProduk()
    {
        $this->db->select('*');
        $this->db->from('mst_produk');
        $query = $this->db->get();

        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->result_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getDetail($id)
    {
        $this->db->select('*');
        $this->db->where('tr_transaksi.id', $id);
        $query = $this->db->get($this->table, 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->result_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getCreatedby($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('mst_users', 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->row();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getcekpersediaan($id)
    {
        $this->db->select('*');
        $this->db->where('tr_persediaan.id_produk', $id);
        $query = $this->db->get('tr_persediaan', 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->row();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getcekstok($id)
    {
        $this->db->select('*');
        $this->db->where('mst_produk.id', $id);
        $query = $this->db->get('mst_produk', 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->row();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getBarangDetail($id)
    {

        $this->db->select('mst_produk.nama_barang as produk,mst_produk.kode_barang,mst_produk.satuan,mst_produk.stok,'
            . 'tr_transaksi_detail.jumlah,tr_transaksi_detail.total,tr_transaksi_detail.harga_perpalet as harga,tr_transaksi_detail.kode_produk');
        $this->db->from('tr_transaksi_detail');
        $this->db->join('mst_produk', 'mst_produk.kode_barang = tr_transaksi_detail.kode_produk', 'left');
//        $this->db->join('mst_warna', 'mst_warna.id = tr_transaksi_detail.id_warna');
        if (is_array($id)) {
            $this->db->where_in("tr_transaksi_detail.id_transaksi", $id);
            $this->db->order_by("tr_transaksi_detail.id_transaksi", "asc");
        } else {
            $this->db->where("tr_transaksi_detail.id_transaksi", $id);
        }

        $query = $this->db->get();
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->result_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getBarangCount($id)
    {

        $this->db->select('count(id) as count');
        $this->db->from('tr_transaksi_detail');

        if (is_array($id)) {
            $this->db->where_in("tr_transaksi_detail.id_transaksi", $id);
            $this->db->order_by("tr_transaksi_detail.id_transaksi", "asc");
        } else {
            $this->db->where("tr_transaksi_detail.id_transaksi", $id);
        }

        $query = $this->db->get();
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->row();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getCountDataIndex($search = "")
    {
        $this->db->select('tr_transaksi.id,tr_transaksi.status,tr_transaksi.tanggal,'
            . 'tr_transaksi_detail.jumlah,tr_transaksi_detail.total');
        $this->db->from($this->table);
        $this->db->join('tr_transaksi_detail', 'tr_transaksi.id = tr_transaksi_detail.id_transaksi', 'left');
        $data = $this->db->count_all_results();
        return $data;
    }

    public function cekbarang()
    {
        $this->db->select('RIGHT(tr_transaksi.invoice,2) as invoice', FALSE);
        $this->db->order_by('invoice', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tr_transaksi');  //cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() <> 0) {
            //cek kode jika telah tersedia
            $data = $query->row();
            $kode = intval($data->invoice) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $tgl = date('dmY');
        $batas = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $kodetampil = "" . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    public function saveData($arrData = array(), $debug = false)
    {

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

    public function updateDetail($array, $id)
    {

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

    public function updatestokbarang($array, $id)
    {

        $this->db->where('id', $id);
        $query = $this->db->update('mst_produk', $array);
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

    public function updatestokpersediaan($array, $id)
    {

        $this->db->where('id_produk', $id);
        $query = $this->db->update('tr_persediaan', $array);
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

    public function deleteDetail($id)
    {
        $this->db->where('id_transaksi', $id);
        $q = $this->db->delete('tr_transaksi_detail');
        if (!$q) {
            $retVal['error_stat'] = "Failed To Delete";
            $retVal['status'] = false;
        } else {
            $retVal['error_stat'] = "Success To Delete";
            $retVal['status'] = true;
        }
        return $retVal;
    }

    public function saveUpdateDataDetail($arrData = array(), $debug = false)
    {
        $this->db->set($arrData);
        if ($debug) {
            $retVal = $this->db->get_compiled_insert($this->table);
        } else {
            $res = $this->db->insert('tr_transaksi_detail');
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

    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        $q = $this->db->delete($this->table);
        if (!$q) {
            $retVal['error_stat'] = "Failed To Delete";
            $retVal['status'] = false;
        } else {
            $retVal['error_stat'] = "Success To Delete";
            $retVal['status'] = true;
        }
        return $retVal;
    }

    private function _get_datatables_query()
    {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        $this->db->select('tr_transaksi.*,mst_users.nama');
        $this->db->from($this->table);
        $this->db->join('mst_users', 'mst_users.id = ' . $this->table . '.createdby', 'left');
        $this->db->where('tr_transaksi.createdby', $id_session);
        $i = 0;
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($nama = "")
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->result();
    }

    public function saveDataDetail($arrData = array(), $debug = false)
    {

        $this->db->set($arrData);
        if ($debug) {
            $retVal = $this->db->get_compiled_insert($this->table);
        } else {
            $res = $this->db->insert($this->jointTable);
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

    function count_filtered($nama = "")
    {
        $this->_get_datatables_query();
//        if (!empty($nama)) {
//            $this->db->like("mst_customer.nama", $nama);
//        }
//        $this->db->where($this->table.".status =",0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
//        $this->db->where($this->table.".status =",0);
        return $this->db->count_all_results();
    }

    public function updated($array, $id)
    {


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

    public function getCekIdcard($id = "")
    {
        $ret = $this->db->select('*')
            ->from('mst_produk')
//                        ->join('tr_idcard b','b.card_id = a.id','left')
            ->where('kode_barang', $id)
            ->get()->row_array();
        return $ret;
    }
}
