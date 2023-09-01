<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends MY_Controller
{

    var $meta_title = "INVENTORY | Manage Transaksi";
    var $meta_desc = "INVENTORY";
    var $main_title = "Data Transaksi";
    var $base_url = "";
    var $base_url_redirect = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct()
    {
        parent::__construct();
        $this->base_url = $this->base_url_site . "penjualan/";
        $this->load->model("penjualan_model");
        //        $this->load->model("customer_model");
        $this->load->model("Produk_model");
        $this->load->library('user_agent');
    }

    public function index()
    {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        if (empty($id_session)) {
            redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_home(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/penjualan.js",
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",
                ASSETS_URL . "plugins/daterangepicker/moment.min.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
                ASSETS_URL . "plugins/select2/select2.min.js",
            ),
            "custom_css" => array(

                ASSETS_URL . "plugins/select2/select2.min.css",
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.css",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.css",
            ),
        );
        $this->_render("default", $dt);
    }

    private function _home()
    {
        $page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
        $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
        $start = ($page - 1) * $this->limit;
        $provinsi = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";
        $data = $this->penjualan_model->getDataIndex($start, $this->limit, $search);
        $countTotal = $this->penjualan_model->getCountDataIndex($search);
        $arrBreadcrumbs = array(
            "Manage" => base_url(),
            "Transaksi" => $this->base_url,
            "List" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;

        $dt['produk'] = $this->penjualan_model->getProduk();
        $dt["data"] = $data;
        $dt["shift_txt"] = getCurrentShift();
        $dt["pagination"] = $this->_build_pagination($this->base_url, $countTotal, $this->limit, true, "&search=" . $search);
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("penjualan/content", $dt, true);
        return $ret;
    }

    public function ajax_list()
    {
        $list = $this->penjualan_model->get_datatables();
        $data = array();
        $no = 0;
        foreach ($list as $key => $dt) {
            $no++;
            $hasil_rupiah = "Rp " . number_format($dt->bayar, 0, '', '.');
            $row[0] = $no;
            $row[1] = date('d M Y', strtotime($dt->tanggal));
            $row[2] = '<a href=""  data-id="' . $dt->id . '" data-toggle="modal" data-target="#detail-data" title="Preview"><strong>' . $dt->invoice . '</strong></a>';
            $row[3] = $hasil_rupiah;
            $row[4] = $dt->nama;
            $row[5] = '<a href="javascript:void(0)" onclick="deleteData(' . "'" . $dt->id . "'" . ')" '
                . 'class="btn btn-danger btn-sm del btn-flat" title="Delete" data-toggle="modal" data-target="#delete-data">'
                . '<span class="glyphicon glyphicon-trash"></span></a>'
                . '<a href=""  data-id="' . $dt->id . '" class="btn btn-flat btn-success btn-sm" data-toggle="modal" data-target="#detail-data" title="Preview"><span class="glyphicon glyphicon-search"></span></a>';
            $data[$dt->id] = array_values($row);
        }
        $output = array(
            "recordsTotal" => $this->penjualan_model->count_all(),
            "recordsFiltered" => $this->penjualan_model->count_filtered(),
            "data" => array_values($data),
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id = "")
    {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        if (empty($id_session)) {
            redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_homeEdit($id),
            "custom_js" => array(
                ASSETS_JS_URL . "form/penjualan.js",
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",
                ASSETS_URL . "plugins/daterangepicker/moment.min.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
                ASSETS_URL . "plugins/select2/select2.min.js",
                ASSETS_URL . "plugins/autocomplete/js/jquery.autocomplete.js",
            ),
            "custom_css" => array(
                ASSETS_URL . "plugins/autocomplete/css/jquery.autocomplete.css",
                ASSETS_URL . "plugins/select2/select2.min.css",
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.css",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.css",
            ),
        );
        $this->_render("default", $dt);
    }

    private function _homeEdit($id = "")
    {
        $bread = $id ? 'Edit' : 'Add';
        $data = $this->penjualan_model->getDetail($id);
        $arrBreadcrumbs = array(
            "Data" => base_url(),
            "Transaksi" => $this->base_url,
            $bread => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt['produk'] = $this->penjualan_model->getProduk();
        $dt['data'] = $data;
        $dt['base_url'] = $this->base_url;
        $dt["shift_txt"] = getCurrentShift();
        if (is_numeric($id)) {
            $data = $this->penjualan_model->getDetail($id);
            $dataBarang = $this->penjualan_model->getBarangDetail($id);

            $dt['count'] = $this->penjualan_model->getBarangCount($id);
            $resData = $data[0];
            $resData["barang"] = $dataBarang;
            $dt['transaksi'] = $resData;
            //            echoPre($resData['barang']);exit;
            $ret = $this->load->view("penjualan/form_edit", $dt, true);
        } else {
            $ret = $this->load->view("penjualan/form", $dt, true);
        }
        return $ret;
    }

    public function save()
    {
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $alert = $this->_saveData($id);
        $this->session->set_flashdata("alert_transaksi", $alert);
//        redirect($this->base_url);
        redirect($this->agent->referrer());
    }

    public function getcek($id_barang)
    {
        header('Content-Type: application/json');
        $data = $this->penjualan_model->getCekStok($id_barang);

        $resData = $data;
        echo json_encode($resData);
    }

    public function getDataview()
    {
        $id = $_POST['rowid'];
        $data_penjualan = $this->penjualan_model->getDetail($id);
        $dt['data_p'] = $data_penjualan[0];
        $dt['data'] = $this->penjualan_model->getBarangDetail($id);
        $ret = $this->load->view("penjualan/preview", $dt);
    }

    public function cetak($id)
    {
        $data_penjualan = $this->penjualan_model->getDetail($id);
        $dt['createdby'] = $this->penjualan_model->getCreatedby($data_penjualan[0]['createdby']);
        $dt['data_p'] = $data_penjualan[0];
        $dt['data'] = $this->penjualan_model->getBarangDetail($id);
        $ret = $this->load->view("penjualan/preview_cetak", $dt);
    }

    public function getHarga($id_barang)
    {
        header('Content-Type: application/json');
        $data = $this->Produk_model->getDetail($id_barang);
        //        echoPre($this->db->last_query());exit;
        $resData = $data;
        echo json_encode($resData);
    }

    private function _saveData($id = '')
    {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        //         echoPre($_POST);exit;
        $kode_barang = isset($_POST["kode_barang"]) ? $_POST["kode_barang"] : '';
        $total = isset($_POST["total"]) ? $_POST["total"] : '';

        $invoice = $this->penjualan_model->cekbarang();
        $return = array(
            "status" => "failed",
            "message" => "Failed to save Penjualan. Please try again."
        );

        // update category
        if ($id != "") {

            $index_row = isset($_POST["index_row"]) ? trim($_POST["index_row"]) : '';
            $total_bayar = 0;

            for ($i = 1; $i <= $index_row; $i++) {
                $total = isset($_POST["total_" . $i]) ? trim($_POST["total_" . $i]) : '';
                $jumlah = isset($_POST["jumlah_" . $i]) ? trim($_POST["jumlah_" . $i]) : '';
                $total_bayar = $total_bayar + ($jumlah * filterHarga($total));
            }

            $edit = array(
                "invoice" => $invoice,
                "bayar" => $total_bayar,
                "status" => 0,
                "shift" => getCurrentShift() == "Pagi" ? 0 : 1,
                "updatedby" => $id_session,
            );
            $res = $this->penjualan_model->updateDetail($edit, $id);
            $del_author = $this->penjualan_model->deleteDetail($id);
            $del_author['status'];
            if ($del_author['status'] == true) {
                // save detail 
                for ($i = 1; $i <= $index_row; $i++) {
                    $kode_barang = isset($_POST["kode_barang_" . $i]) ? trim($_POST["kode_barang_" . $i]) : '';
                    $total = isset($_POST["total_" . $i]) ? trim($_POST["total_" . $i]) : '';
                    $sub_total = isset($_POST["sub_total_" . $i]) ? trim($_POST["sub_total_" . $i]) : '';
                    $jumlah = isset($_POST["jumlah_" . $i]) ? trim($_POST["jumlah_" . $i]) : '';

                    $inDetail = array(
                        "id_transaksi" => $res['id'],
                        "kode_produk" => $kode_barang,
                        "harga_perpalet" => filterHarga($total),
                        "jumlah" => $jumlah,
                        "total" => $jumlah * filterHarga($total),
                    );
                    $resDet = $this->penjualan_model->saveDataDetail($inDetail);
                }
            }
            if ($res['status'] == true) {
                $return = array(
                    "status" => "success",
                    "message" => "Success to update Penjualan."
                );
            }
        } // insert category
        else {

            $index_row = isset($_POST["index_row"]) ? trim($_POST["index_row"]) : '';
            $total_bayar = 0;

            for ($i = 1; $i <= $index_row; $i++) {
                $total = isset($_POST["total_" . $i]) ? trim($_POST["total_" . $i]) : '';
                $jumlah = isset($_POST["jumlah_" . $i]) ? trim($_POST["jumlah_" . $i]) : '';
                $total_bayar = $total_bayar + ($jumlah * filterHarga($total));
            }

            $insert = array(
                "invoice" => $invoice,
                "tanggal" => date("Y-m-d h:i:s"),
                "bayar" => $total_bayar,
                "status" => 0,
                "shift" => getCurrentShift() == "Pagi" ? 0 : 1,
                "createdby" => $id_session,
            );
            $res = $this->penjualan_model->saveData($insert);
            if ($res['status'] == 1) {

                for ($i = 1; $i <= $index_row; $i++) {
                    $kode_barang = isset($_POST["kode_barang_" . $i]) ? trim($_POST["kode_barang_" . $i]) : '';
                    $total = isset($_POST["total_" . $i]) ? trim($_POST["total_" . $i]) : '';
                    $sub_total = isset($_POST["sub_total_" . $i]) ? trim($_POST["sub_total_" . $i]) : '';
                    $jumlah = isset($_POST["jumlah_" . $i]) ? trim($_POST["jumlah_" . $i]) : '';

                    $inDetail = array(
                        "id_transaksi" => $res['id'],
                        "kode_produk" => $kode_barang,
                        "harga_perpalet" => filterHarga($total),
                        "jumlah" => $jumlah,
                        "total" => $jumlah * filterHarga($total),
                    );
                    $resDet = $this->penjualan_model->saveDataDetail($inDetail);
                }
                $return = array(
                    "status" => "success",
                    "message" => "Success to save Penjualan"
                );
            }
        }
        return $return;
    }

    public function delete($id)
    {
        $del_author = $this->penjualan_model->delete($id);
        $this->penjualan_model->deleteDetail($id);
        $del_author['status'];
        if ($del_author['status']) {
            $alert = array(
                "status" => "success",
                "message" => "Success to delete Manage Pemesanan."
            );
        } else {
            $alert = array(
                "status" => "failed",
                "message" => "Failed to delete Manage Penjualan."
            );
        }

        $this->session->set_flashdata("alert_pelanggaran", $alert);
        redirect($this->base_url);
    }

    public function konfirmasi($id)
    {

        $alert = array(
            "status" => "failed",
            "message" => "Failed to Konfirmasi Data Penjualan. Please try again."
        );
        $cek = $this->db->from('tr_penjualan')->where('id', $id)->get()->row_array();

        if ($cek['status'] == 0) {
            $up = array(
                "status" => 1,
            );
        } else {
            $up = array(
                "status" => 0,
            );
        }
        $res = $this->penjualan_model->updated($up, $id);
        if ($res['status'] == true) {
            $alert = array(
                "status" => "success",
                "message" => "Success to Konfirmasi Data Penjualan."
            );
        }
        $this->session->set_flashdata("alert_diagnostik", $alert);
        redirect($this->base_url);
    }

    public function searching()
    {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        if (empty($id_session)) {
            redirect();
        }
        $nik = isset($_REQUEST["nama"]) ? $_REQUEST["nama"] : "";
        $cek = $this->penjualan_model->getCekIdcard($nik);
    }
}
