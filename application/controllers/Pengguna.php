<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends MY_Controller {

    var $meta_title = "appMEC | Pengguna";
    var $meta_desc = "appMEC";
    var $main_title = "Data Pengguna";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "pengguna/";
        $this->load->model("pengguna_model");
        $this->load->model("level_model");
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
                ASSETS_JS_URL . "form/pengguna.js",
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
         $edPengguna = array(
                    "status" => 0,
                );

        $del_agen = $this->pengguna_model->updateDetail($edPengguna, $id);
        $del_agen['status'];
        if ($del_agen['status']) {
            $alert = array(
                "status" => "success",
                "message" => "Success to delete Pengguna."
            );
        } else {
            $alert = array(
                "status" => "failed",
                "message" => "Failed to delete Pengguna. Please try again."
            );
        }

        $this->session->set_flashdata("alert_pengguna", $alert);
        redirect($this->base_url);
    }

    public function edit($term_id) {
        header('Content-Type: application/json');
        $data = $this->pengguna_model->getDetail($term_id);
        $resData = $data[0];
        echo json_encode($resData);
    }

    private function _home() {
        $page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
        $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
        $start = ($page - 1) * $this->limit;

        $data = $this->pengguna_model->getDataIndex($start, $this->limit, $search);
        $countTotal = $this->pengguna_model->getCountDataIndex($search);
        $arrBreadcrumbs = array(
            "Pengguna" => base_url(),
            "Data Pengguna" => $this->base_url,
            "List" => "#",
        );
        $dt["level"] = $this->level_model->getDataIndex(0, 'all', '');
        
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt["data"] = $data;
        $dt["pagination"] = $this->_build_pagination($this->base_url, $countTotal, $this->limit, true, "&search=" . $search);
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("pengguna/content", $dt, true);
        return $ret;
    }

    private function _saveData($id = '') {

        $fullname = isset($_POST["nama"]) ? trim($_POST["nama"]) : '';
        $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
        $password = isset($_POST["password"]) ? $_POST["password"] : '';
        $id_level = isset($_POST["id_level"]) ? $_POST["id_level"] : '';

//        $passwordEn = passwordEncrypt($password);
        $passwordEn = sha1($password);
        
        $return = array(
            "status" => "failed",
            "message" => "Failed to save Pengguna. Please try again."
        );
        
//        echoPre($_POST);exit;
        // update 
        if (!empty($fullname) && !empty($username)  ) {
            
            if (!empty($id)) {
                $edPengguna = array(
                    "nama" => $fullname,
                    "username" => $username,
                    "id_level" => $id_level
                );
                 
                if($password != ""){
                    $edPengguna['password'] = $passwordEn;
                }
                
                $res = $this->pengguna_model->updateDetail($edPengguna, $id);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to update Pengguna $fullname."
                    );
                }
            }
            // insert 
            else {
                $inPengguna = array(
                    "nama" => $fullname,
                    "username" => $username,
                    "password" => $passwordEn,
                    "id_level" => $id_level,
                    "status" => 1
                );
                $res = $this->pengguna_model->saveData($inPengguna);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to save Pengguna $fullname."
                    );
                }
            }
        }
        return $return;
    }

}
