<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    var $id_user = "1";
    var $user_level = array("1" => "Super Adminstrator", "2" => "Adminstrator",
        "3" => "Editor", "0" => "OFF");
    var $site_active = "default";
    var $menu_active = "";
    var $base_url_site = "";
    var $user_logged_level = "";
    var $cms_title = "Penjualan & Persediaan";
    var $cms_active_config = array();
    var $menu_initial = "";

    function __construct() {
        parent::__construct();
        $this->load->library("breadcrumbs");
        $this->load->library("upload");
        /// Set Site Uri
        $site = 'default';
        $this->site_active = $site;
        $this->menu_active = isset($this->uri->segments[1]) ? $this->uri->segments[1] : 'login';
        $this->base_url_site = base_url();
        $this->menu_initial = $this->config->item('menu_list');
        /// Set DB Config

        $arr_site = $this->config->item("site_cms");
        /// Set User Level
        $this->user_logged_level = $this->session->userdata("user_level");
        $config_cms = $this->config->item("site_property");
        $this->cms_active_config = isset($config_cms[$this->site_active]) ? $config_cms[$this->site_active] : array();
        
    }

    public function _render($template, $cnf = array()) {
        $template = (!empty($cnf['template'])) ? $cnf['template'] : 'template/default';
        
//        $this->checkValidateUser();
//echopre($template);exit;
        //loop for css custom file
        $css_script = '';
        if (isset($cnf['custom_css']) && is_array($cnf['custom_css'])) {
            foreach ($cnf['custom_css'] as $val) {
                $css_script .= "<link rel=\"stylesheet\" href=\"" . $val . "\" />\n\t";
            }
        } else {
            $css_script = isset($cnf['custom_css']) ? isset($cnf['custom_css']) : '';
        }
        //end loop
        //loop for js custom file
        $js_script = '';
        if (isset($cnf['custom_js']) && is_array($cnf['custom_js'])) {
            foreach ($cnf['custom_js'] as $val) {
                $js_script .= "<script type=\"text/javascript\" src=\"" . $val . "\"></script>\n\t\t";
            }
        } else {
            $js_script = isset($cnf['custom_js']) ? isset($cnf['custom_js']) : '';
        }
        //end loop

        $meta_refresh = '1800';
        if (isset($cnf['meta_refresh'])) {
            $meta_refresh = '<meta http-equiv="Refresh" content="' . $cnf['meta_refresh'] . '" />';
        }

        $subCat = (isset($cnf['sub_categori'])) ? $cnf['sub_categori'] : '';

        /// Get Template Setting
        // $setting_cms = $this->config->item("site_property");
        // $default_set = $setting_cms[$this->site_active];

        // $color_template = $default_set['theme_color'];
        // $site_name = $default_set['cms_name'];

        // $this->cms_title = $site_name;

        $theme_default = "skin-light";
        // set expire
        $my_time = time();
        $expired_header = gmdate('D, d M Y H:i:s', $my_time + 120) . " GMT";

        $company = 'Greensoul.com';
        $dt = array(
            'meta_title' => isset($cnf['title']) ? $cnf['title'] : "Penggajian",
            'description' => isset($cnf['description']) ? $cnf['description'] : '',
            'keywords' => isset($cnf['keywords']) ? $cnf['keywords'] : '',
            'url' => isset($cnf['url']) ? $cnf['url'] : '',
            'og_image' => isset($cnf['og_image']) ? $cnf['og_image'] : '',
            'meta_refresh' => $meta_refresh,
            'expires' => '',
            'header_title' => (isset($cnf['header'])) ? $cnf['header'] : '',
            'custom_css' => $css_script,
            'assets_css_url' => ASSETS_CSS_URL,
            'assets_js_url' => ASSETS_JS_URL,
            'assets_image_url' => ASSETS_IMAGE_URL,
            'theme' => $theme_default,
            'custom_js' => $js_script,
            'base_url_admin' => $this->base_url_site,
            'main_content' => (isset($cnf['container'])) ? $cnf['container'] : '',
            "head_navbar" => $this->_get_header_nav(),
            "side_navbar" => $this->_get_sidebar_nav(),
            "main_footer" => $this->_get_footer(),
        );
        $this->load->view($template, $dt);
    }

    private function _get_header_nav() {
        $user_data =  $this->session->userdata("user_id");
        if($user_data == 1){
        $menu["header_menu"] = array(
//            "supplier" =>
//            array("class" => "glyphicon glyphicon-duplicate",
//                "desc" => "Supplier",
//                "main_url" => $this->base_url_site . "supplier/",
//                "sub_menu" => "post_sub"
//            ),
            "produk" =>
            array("class" => "glyphicon glyphicon-briefcase",
                "desc" => "Produk",
                "main_url" => $this->base_url_site . "produk/",
                "sub_menu" => "post_sub"
            ),
            "penjualan" =>
            array("class" => "glyphicon glyphicon-shopping-cart ",
                "desc" => "Transaksi",
                "main_url" => $this->base_url_site . "penjualan/",
                "sub_menu" => ""
            ),
            "laporan" =>
            array("class" => "glyphicon glyphicon-file",
                "desc" => "Laporan",
                "main_url" => $this->base_url_site . "laporan/penjualan",
                "sub_menu" => ""
            ),
//            "persediaan" =>
//            array("class" => "glyphicon glyphicon-edit",
//                "desc" => "Persediaan",
//                "main_url" => $this->base_url_site . "persediaan/",
//                "sub_menu" => ""
//            ),
            "List User" =>
            array("class" => "glyphicon glyphicon-user",
                "desc" => "List User",
                "main_url" => $this->base_url_site . "pengguna/",
                "sub_menu" => ""
            ),
        );
        }else{
            $menu["header_menu"] = array(
          
//            "produk" =>
//            array("class" => "glyphicon glyphicon-briefcase",
//                "desc" => "Barang",
//                "main_url" => $this->base_url_site . "produk/",
//                "sub_menu" => "post_sub"
//            ),
            "penjualan" =>
            array("class" => "glyphicon glyphicon-shopping-cart ",
                "desc" => "Transaksi",
                "main_url" => $this->base_url_site . "transaksi/",
                "sub_menu" => ""
            ),
            
        );
        }
        $menu["username"] = $this->session->userdata("user_username");
        $menu["fullname"] = $this->session->userdata("user_name");        
        $menu["link_edit_profil"] = $this->base_url_site . "profile/edit/".$this->session->userdata("user_id");
        $menu["link_logout"] = base_url() . "logout/";
        $menu["cms_title"] = $this->cms_title;
        $ret = $this->load->view("template/navbar/header_nav", $menu, true);
        return $ret;
    }

    private function _get_sidebar_nav() {
         $user_data =  $this->session->userdata("user_level");
//         echoPre($user_data);exit;
         if($user_data == 5) { //gudang
             $menu["sidebar_nav"] = array(
            "dashboard" =>
            array("class" => "glyphicon glyphicon-list text-yellow",
                "desc" => "Dashboard",
                "main_url" => $this->base_url_site . "home/",
                "sub_menu" => "",
            ),
//            "data" =>
//            array("class" => "glyphicon glyphicon-th-large text-blue",
//                "desc" => "Master Data",
//                "main_url" => $this->base_url_site,
//                "sub_menu" => "data_sub"
//            ),
            "transaksi" =>
            array("class" => "glyphicon glyphicon-shopping-cart text-lime",
                "desc" => "Manage",
                "main_url" => $this->base_url_site,
                "sub_menu" => "manage_sub"
            ),
            "perhitungan" =>
                array("class" => "glyphicon glyphicon-time text-red",
                    "desc" => "Perhitungan",
                    "main_url" => $this->base_url_site,
                    "sub_menu" => "perhitungan_sub",
                ),
        );
         } else if ($user_data == 3){ //kasir
             $menu["sidebar_nav"] = array(
                    "dashboard" =>
                    array("class" => "glyphicon glyphicon-list text-yellow",
                        "desc" => "Dashboard",
                        "main_url" => $this->base_url_site . "home/",
                        "sub_menu" => "",
                    ),
                    "transaksi" =>
                    array("class" => "glyphicon glyphicon-shopping-cart text-lime",
                        "desc" => "Manage",
                        "main_url" => $this->base_url_site,
                        "sub_menu" => "manage_sub"
                    ),
                );
         }else {
        $menu["sidebar_nav"] = array(
            "dashboard" =>
            array("class" => "glyphicon glyphicon-list text-yellow",
                "desc" => "Dashboard",
                "main_url" => $this->base_url_site . "home/",
                "sub_menu" => "",
            ),
            "data" =>
            array("class" => "glyphicon glyphicon-th-large text-blue",
                "desc" => "Master Data",
                "main_url" => $this->base_url_site,
                "sub_menu" => "data_sub"
            ),
            "transaksi" =>
            array("class" => "glyphicon glyphicon-shopping-cart text-lime",
                "desc" => "Manage",
                "main_url" => $this->base_url_site,
                "sub_menu" => "manage_sub"
            ),
            "perhitungan" =>
                array("class" => "glyphicon glyphicon-time text-red",
                    "desc" => "Perhitungan",
                    "main_url" => $this->base_url_site,
                    "sub_menu" => "perhitungan_sub",
                ),
//            "laporan" =>
//            array("class" => "glyphicon glyphicon-signal text-blue",
//                "desc" => "Laporan",
//                "main_url" => $this->base_url_site . "",
//                "sub_menu" => "laporan_sub"
//            ),
             
             "pengguna" =>
            array("class" => "glyphicon glyphicon-user text-purple",
                "desc" => "Pengguna",
                "main_url" => $this->base_url_site . "",
                "sub_menu" => "pengguna_sub"
            ),
        );
         }
          if($user_data == 3){
              $menu["submenu_side"] = array(
            "manage_sub" => array(
                "penjualan" => array(
                    "class" => "glyphicon glyphicon-edit text-lime",
                    "url" => "penjualan",
                    "desc" => "Penjualan",
                ),
            ),
        );
         
          } else{
        $menu["submenu_side"] = array("data_sub" => array(
            
                "data_supplier" => array(
                    "class" => "glyphicon glyphicon-edit text-blue",
                    "url" => "supplier/",
                    "desc" => "Data Supplier",
                ),
                "data_produk" => array(
                    "class" => "glyphicon glyphicon-edit text-blue",
                    "url" => "produk/",
                    "desc" => "Data Produk",
                ),
                "data_satuan" => array(
                    "class" => "glyphicon glyphicon-edit text-blue",
                    "url" => "kriteria/",
                    "desc" => "Data Kriteria",
                ),
                 "data_himpunan" => array(
                    "class" => "glyphicon glyphicon-edit text-blue",
                    "url" => "himpunan/",
                    "desc" => "Data Jenis Himpunan",
                ),
                "data_jenis_aturan" => array(
                    "class" => "glyphicon glyphicon-edit text-blue",
                    "url" => "Jenis/Aturan/",
                    "desc" => "Data Jenis Aturan",
                ),
            ),
            "manage_sub" => array(
//                "pemesanan" => array(
//                    "class" => "glyphicon glyphicon-edit text-lime",
//                    "url" => "pemesanan",
//                    "desc" => "Pemesanan",
//                ),               
                "permintaan" => array(
                    "class" => "glyphicon glyphicon-edit text-lime",
                    "url" => "permintaan",
                    "desc" => "Permintaan",
                ),
                 "persediaan" => array(
                    "class" => "glyphicon glyphicon-edit text-lime",
                    "url" => "persediaan",
                    "desc" => "Persediaan",
                ),
                "penjualan" => array(
                    "class" => "glyphicon glyphicon-edit text-lime",
                    "url" => "penjualan",
                    "desc" => "Penjualan",
                ),
            ),
            "pengguna_sub" => array(
                "add_edit_pengguna" => array(
                    "class" => "glyphicon glyphicon-edit text-purple",
                    "url" => "pengguna/",
                    "desc" => "Data Pengguna",
                ),
            ),
            "perhitungan_sub" => array(
                "perhitungan_eoq" => array(
                    "class" => "glyphicon glyphicon-edit text-red",
                    "url" => "perhitungan/",
                    "desc" => "Tsukamoto",
                ),
            ),
//            "laporan_sub" => array(
//                "add_laporan" => array(
//                    "class" => "glyphicon glyphicon-edit text-blue",
//                    "url" => "laporan/",
//                    "desc" => "Laporan Data Bahan Baku",
//                ),
//                "add_laporan_penjualan" => array(
//                    "class" => "glyphicon glyphicon-edit text-blue",
//                    "url" => "laporan/penjualan",
//                    "desc" => "Laporan Data Penjualan",
//                ),
//                "add_laporan_permintaan" => array(
//                    "class" => "glyphicon glyphicon-edit text-blue",
//                    "url" => "laporan/permintaan",
//                    "desc" => "Laporan Data Permintaan",
//                ),               
//                "add_laporan_pengeluaran" => array(
//                    "class" => "glyphicon glyphicon-edit text-blue",
//                    "url" => "laporan/pengeluaran",
//                    "desc" => "Laporan Data Pengeluaran",
//                ),               
//                "add_laporan_pemesanan" => array(
//                    "class" => "glyphicon glyphicon-edit text-blue",
//                    "url" => "laporan/pemesanan",
//                    "desc" => "Laporan Data Pemesanan",
//                ),               
//                "add_laporan_pemasukan" => array(
//                    "class" => "glyphicon glyphicon-edit text-blue",
//                    "url" => "laporan/pemasukan",
//                    "desc" => "Laporan Data Pemasukan",
//                ),               
//            ),
        );
         
          }
        if ($this->user_logged_level == 'Editor') {
            unset($menu["sidebar_nav"]['user']);
        }
        $menu["site_active"] = $this->site_active;
        // $site_property = $this->config->item('site_property');
        // $arr_access = array();
        // $arr_site = array('default');//$this->session->userdata("user_site_access");
        // foreach ($arr_site as $index_site) {
        //     $arr_access[$index_site] = $site_property[$index_site];
        // }
        // $menu["site_sidebar"] = $arr_access;
        $ret = $this->load->view("template/navbar/side_nav", $menu, true);
        return $ret;
    }

    private function _get_footer() {
        $dt = array();
        $ret = $this->load->view("template/footer", $dt, true);
        return $ret;
    }

    public function _get_template_table() {
        $template = array(
            'table_open' => '<table class="table table-hover table-stripped">',
            'thead_open' => '<thead>',
            'thead_close' => '</thead>',
            'heading_row_start' => '<tr>',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'tbody_open' => '<tbody>',
            'tbody_close' => '</tbody>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );

        return $template;
    }

    public function _build_pagination($base_url = "", $total = 100, $per_page = 10, $query_string = TRUE, $url_string = "&search=") {

        $config_pagination['base_url'] = $base_url;
        $config_pagination['total_rows'] = $total;
        $config_pagination['per_page'] = $per_page;

        $config_pagination['page_query_string'] = $query_string;
        $config_pagination['query_string_segment'] = 'page';
        $config_pagination['suffix'] = $url_string;
        $config_pagination['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config_pagination['full_tag_close'] = '</ul>';

        $config_pagination['next_tag_open'] = '<li>';
        $config_pagination['next_tag_close'] = '</li>';


        $config_pagination['use_page_numbers'] = TRUE;
        //$config_pagination['prefix'] = 'search';

        $config_pagination['prev_tag_open'] = '<li>';
        $config_pagination['prev_tag_close'] = '</li>';

        $config_pagination['cur_tag_open'] = '<li class="active"><a href="#">';
        $config_pagination['cur_tag_close'] = '</li></a>';
        $config_pagination['num_tag_open'] = '<li>';
        $config_pagination['num_tag_close'] = '</li>';
        $config_pagination['first_tag_open'] = '';
        $config_pagination['first_link'] = '';
        $config_pagination['last_link'] = '';


        $this->pagination->initialize($config_pagination);
        $ret = $this->pagination->create_links();
        return $ret;
    }

    public function setBreadcrumbs($arrBreadcrumbs = array()) {
        $res = "";
        foreach ($arrBreadcrumbs as $label => $url) {
            $this->breadcrumbs->add($label, $url);
        }
        $res = $this->breadcrumbs->output();
        return $res;
    }

    public function checkValidateUser() {
        $arr_menu = $this->session->userdata("user_allowed_menu");
        $base_url = base_url();
        $login = base_url() . "login/";
        if (empty($_SESSION["user_validated"])) {
            redirect($login);
        }
        if (!in_array($this->menu_initial[$this->menu_active]['init'], $arr_menu)) {            
            $return = array(
                "status" => "failed",
                "message" => "You Don't Have Access To This Menu"
            );
            $this->session->set_flashdata("alert_home", $return);
             redirect(base_url() . "home/");
        }
    }

    public function isAjaxPost(){
        if(!$this->input->is_ajax_request()){
            echo "Ilegal";
            die;
        }
    }

}
