<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function getBarang(){

        $ret = $this->db->select('count(id) as barang')
                ->from('mst_produk')
                ->get()->row();
        return $ret;
    }
    public function getPenjualan(){

        $ret = $this->db->select('count(id) as penjualan')
                ->from('tr_transaksi')
                ->get()->row();
        return $ret;
    }
   public function getPengguna(){

        $ret = $this->db->select('count(id) as user')
                ->from('mst_users')
                ->get()->row();
        return $ret;
   }
//    public function getPengeluaran(){
//
//        $ret = $this->db->select('count(tr_pengeluaran.id) as pengeluaran')
//                ->from('tr_pengeluaran')
//                ->get()->row();
//        return $ret;
//    }
}
