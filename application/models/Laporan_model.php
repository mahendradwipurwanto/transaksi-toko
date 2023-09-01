<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    var $table = "tr_transaksi";
    var $primary_key = "id";
    var $jointTable = "tr_transaksi_detail";

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataIndex($offset = 0, $limit = 10, $status_pembayaran = "", $tanggal = array())
    {

        if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
            $this->db->where($this->table . '.tanggal BETWEEN "' . $tanggal['start'] . '" AND "' . $tanggal['end'] . '"');
        }
        $this->db->from($this->table);
        if ($limit != 'all') {
            $this->db->limit($limit);
        }
        $this->db->offset($offset);
        $this->db->order_by($this->table . ".tanggal ASC");
        $data = $this->db->get();
        return $data->result();
    }

    public function getDataIndexexport($tanggal = array(), $shift = 0)
    {

        if ($tanggal != "" && !empty($tanggal)) {
            $this->db->where("tr_transaksi.tanggal BETWEEN '" . $tanggal['start'] . "' AND '" . $tanggal['end'] . "'");
        }

        if ($shift != "" && !empty($shift)) {
            $this->db->where("tr_transaksi.shift = " . $shift);
        }

        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->order_by($this->table . ".tanggal DESC");
        $data = $this->db->get();
        return $data;
    }
    public function getCountDataIndexexport($status_pembayaran = "", $tanggal = array(), $id_agen = "")
    {

        if (!empty($id_agen)) {
            $this->db->where('id_agen', $id_agen);
        } else {
            if ($status_pembayaran != "") {
                $this->db->where('status_pembayaran', $status_pembayaran);
            }
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                $this->db->where('tanggal_transaksi BETWEEN "' . $tanggal['start'] . '" AND "' . $tanggal['end'] . '"');
            }
        }
        $this->db->select($this->table . '.*, master_agen.nama_agen ');
        //        $this->db->join('master_agen','master_agen.id_agen = '.$this->table.'.id_agen');
        $this->db->from($this->table);
        $data = $this->db->count_all_results();
        return $data;
    }
    public function getBarangDetail($id)
    {

        $this->db->select($this->jointTable . ' .*, mst_produk.*');
        $this->db->from($this->jointTable);
        $this->db->join('mst_produk', 'mst_produk.id = ' . $this->jointTable . '.id_produk');
        if (is_array($id)) {
            $this->db->where_in($this->jointTable . ".id_trans_barang", $id);
            $this->db->order_by($this->jointTable . ".id_trans_barang", "asc");
        } else {
            $this->db->where($this->jointTable . ".id_trans_barang", $id);
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


    public function getDataTrans($tanggal = "", $shift = 0)
    {

        $this->db->select("tr_transaksi.*,mst_users.nama");


        $this->db->join("mst_users", "mst_users.id = tr_transaksi.createdby", 'left');
        if ($tanggal != "" && !empty($tanggal)) {
            $this->db->where("tr_transaksi.tanggal BETWEEN '" . $tanggal['start'] . "' AND '" . $tanggal['end'] . "'");
        }

        if ($shift != "" && !empty($shift)) {
            $this->db->where("tr_transaksi.shift = " . $shift);
        }
        $this->db->order_by("tr_transaksi.tanggal ASC");
        return $this->db->get_compiled_select('tr_transaksi');
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
    public function getBarangDetailpenjualan($id)
    {

        $this->db->select('mst_produk.nama_barang as produk,mst_produk.kode_barang,mst_produk.satuan,mst_produk.stok,'
            . 'tr_transaksi_detail.jumlah,tr_transaksi_detail.total,tr_transaksi_detail.total as harga,tr_transaksi_detail.kode_produk');
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
}
