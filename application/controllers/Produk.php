<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends MY_Controller {

    var $meta_title = "INVENTORY | Data Produk";
    var $meta_desc = "INVENTORY";
    var $main_title = "Data Produk";
    var $base_url = "";
    var $base_url_redirect = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
         $this->base_url = $this->base_url_site . "produk/";
        $this->load->model("Produk_model");
        $this->load->library('zend','database'); 
        $this->load->helper('url','form');   
    }

    public function index() {
        $user_data =  $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        if(empty($id_session)){
             redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_home(),
            "custom_js" => array(
                 ASSETS_URL . "plugins/select2/select2.min.js",
                ASSETS_JS_URL . "form/produk.js",
            ),
            "custom_css" => array(
                ASSETS_URL . "plugins/autocomplete/css/jquery.autocomplete.css",
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/select2/select2.min.css",
            ),
        );
        print_r($this->config->item('menu_initial'));
        $this->_render("default", $dt);
    }
    
    
    public function save() {
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $alert = $this->_saveData($id);
        $this->session->set_flashdata("alert_pengguna", $alert);
        redirect($this->base_url);
    }

   public function delete($id) {
//       echoPre(date('Y-m-d h:i:s'));exit;
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        $delete = array(
                    "deletion" => 1,
                    "deletiondate" => date('Y-m-d H:i:s'),
                    "deletionby" => $id_session,
                );
        $del_author = $this->Produk_model->delete($delete, $id);
        $del_author['status'];
        if ($del_author['status']) {
            $alert = array(
                "status" => "success",
                "message" => "Success to delete Data Jenis Aturan."
            );
        } else {
            $alert = array(
                "status" => "failed",
                "message" => "Failed to delete Data Jenis Aturan."
            );
        }

        $this->session->set_flashdata("alert_pelanggaran", $alert);
        redirect($this->base_url);
    }
    public function getDataview() {
            $id = $_POST['rowid'];
            $dt['kode_barang'] = $this->Produk_model->cekkodebarang();
            $data = $this->Produk_model->getDetail($id);
            $dt['data'] = $data;
            $ret = $this->load->view("product/detail", $dt);
        }
    private function _home() {
        $page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
        $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
        $start = ($page - 1) * $this->limit;

        $data = $this->Produk_model->getDataIndex($start, $this->limit, $search);
        $countTotal = $this->Produk_model->getCountDataIndex($search);
        $arrBreadcrumbs = array(
            "Manage" => base_url(),
            "Data Product" => $this->base_url,
            "List" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt['kode_barang'] = $this->Produk_model->cekkodebarang();
        $dt["data"] = $data;        
        $dt["pagination"] = $this->_build_pagination($this->base_url, $countTotal, $this->limit, true, "&search=" . $search);
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("product/content_produk", $dt, true);
        return $ret;
    }

    private function _saveData($id = '') {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        $kode = isset($_POST["kode_produk"]) ? trim($_POST["kode_produk"]) : '';
        $nama_barang= isset($_POST["nama_produk"]) ? $_POST["nama_produk"] : '';
        $total_stok = isset($_POST["total_stok"]) ? $_POST["total_stok"] : '';
        $nominal = isset($_POST["harga"]) ? $_POST["harga"] : '';
        $harga_tonasi = isset($_POST["harga_tonasi"]) ? $_POST["harga_tonasi"] : '';
        $index = isset($_POST["indexs"]) ? $_POST["indexs"] : '';
        $produksi = isset($_POST["produksi"]) ? $_POST["produksi"] : '';
        $keterangan = isset($_POST["keterangan"]) ? $_POST["keterangan"] : '';
        $harga_to = str_replace(".", "", $harga_tonasi);
        $harga = str_replace(".", "", $nominal);
        $this->zend->load('Zend/Barcode'); 
        $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$kode), array())->draw();
        $imageName = $kode.'.jpg';
        $imagePath = 'assets/img/barcode/'; // penyimpanan file barcode
        imagejpeg($imageResource, $imagePath.$imageName); 
        $pathBarcode = $imagePath.$imageName; //Menyimpan path image bardcode kedatabase
//         update 
        if (!empty($nama_barang)) {
            if (!empty($id)) {
                $editAturan = array(
                    "kode_barang" => $kode,
                    "nama_barang" => $nama_barang,
                    "satuan" => $total_stok,
                    "keterangan" => $keterangan,
                    "harga" => $harga,
                    "indexs" => $index,
                    "produksi" => $produksi,
                    "harga_tonasi" => $harga_to,
                    "updateddate" => date('Y-m-d h:i:s'),
                    "updatedby" => $id_session,
                    "images" => $pathBarcode,
                );
                $res = $this->Produk_model->updateDetail($editAturan, $id);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to update Produk $nama_barang."
                    );
                }
            }
            // insert 
            else {
                $inAturan = array(
                            "kode_barang" => $kode,
                            "nama_barang" => $nama_barang,
                            "satuan" => $total_stok,
                            "keterangan" => $keterangan,
                            "harga" => $harga,
                            "indexs" => $index,
                            "produksi" => $produksi,
                            "harga_tonasi" => $harga_to,
                            "createddate" => date('Y-m-d h:i:s'),
                            "createdby" => $id_session,
                            "images" => $pathBarcode,
                        );
                $res = $this->Produk_model->saveData($inAturan);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to save Data Produk $nama_barang."
                    );
                }
            }
        }
        return $return;
    }
    public function ajax_list() {
        $post = $this->input->post();
        $nama = $post['IDprovinsi'];         
        $list = $this->Produk_model->get_datatables($nama);
        $data = array();
        foreach ($list as $dt) {
            $rupiah = number_format($dt->harga_tonasi,2,',','.');
            $hasil_rupiah = $dt->harga;
            $row = array();
            $row[] = $dt->kode_barang;
            $row[] = ucfirst($dt->nama_barang);
            $row[] = ucfirst($dt->indexs);
            $row[] = ucfirst($dt->produksi);
            $row[] = ucfirst($dt->satuan);
            $row[] = $rupiah;
            $row[] = $hasil_rupiah;
            $row[] = $dt->keterangan;
            $row[] = '<a href=""  data-id="' . $dt->id . '" data-toggle="modal" data-target="#qrcode-data" title="Preview QRcode"><img src="'.BASE_URL.''.$dt->images.'" alt="User Image"></a>';
             $row[] = '<a href=""  class="btn btn-flat btn-warning btn-sm del " data-id="'.$dt->id .'" data-toggle="modal" data-target="#edit-data" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>'
                    . '<a href="javascript:void(0)" onclick="deleteData('."'".$dt->id."'".')" class="btn btn-flat btn-danger btn-sm del"'
                    . ' title="Delete" data-toggle="modal" data-target="#delete-data"><span class="glyphicon glyphicon-trash">'
                    . '</span></a>';
            $data[] = $row;
        }
        $output = array(
            "recordsTotal" => $this->Produk_model->count_all(),
            "recordsFiltered" => $this->Produk_model->count_filtered($nama),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function getDataview2() {
        $id = $_POST['rowid'];
        $data = $this->Produk_model->getDetail($id);
//        echoPre($data);exit;
        $dt['data'] = $data;
        $ret = $this->load->view("product/qrcode", $dt);
    }
}
