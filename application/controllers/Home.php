<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    var $meta_title = "INVENTORY | Home";
    var $meta_desc = "INVENTORY";
    var $main_title = "Home";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "home/";
        $this->load->model("Home_model");
    }

    public function index() {
         $user_data =  $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        if(empty($id_session)){
             redirect();
        }        
        $dt = array(
            "title" => $this->meta_title,
            "cms_title" => $this->meta_desc,
            "description" => $this->meta_desc,
            "container" => $this->_home(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/home.js",
            ),
        );
        
        $this->_render("default", $dt);
    }
    
    private function _home() {        
        $arrBreadcrumbs = array(
            "Home" => base_url(),
            "Dashboard" => $this->base_url,
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt['barang'] = $this->Home_model->getBarang();
        $dt['penjualan'] = $this->Home_model->getPenjualan();
        $dt['pengguna'] = $this->Home_model->getPengguna();
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("home/content", $dt, True);
        return $ret;
       
    }

}
