<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends MY_Controller {

    var $meta_title = "INVENTORY | Data Produk";
    var $meta_desc = "INVENTORY";
    var $main_title = "Data Produk";
    var $base_url = "";
    var $base_url_redirect = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "20";

    public function __construct() {
        parent::__construct();
         $this->base_url = $this->base_url_site . "produk/";
        $this->load->model("Produk_model");
           $this->load->library('Zend');
    }

    public function index($code) {
        echoPre($code);
        $this->load->library('Zend');
        //meload di folder Zend
        $this->zend->load('Zend/Barcode');
        //melakukan generate barcode
        Zend_Barcode::render('code39', 'image', array('text'=>$code, 'barHeight' => 25, 'factor'=>1.98), array());
    }
    
    
}
