<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{

    var $meta_title = "INVENTORY | Laporan";
    var $meta_desc = "INVENTORY";
    var $main_title = "Data Laporan";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct()
    {
        parent::__construct();
        $this->base_url = $this->base_url_site . "laporan";
        $this->load->model("laporan_model");
    }

    public function index()
    {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        //        $status_session = $user_data['user_status'];
        if (empty($id_session)) {
            redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_home(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/laporan.js",
                ASSETS_URL . "plugins/select2/select2.full.min.js",
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",
                ASSETS_URL . "plugins/daterangepicker/moment.min.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
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

        $dtStart =  isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
        $dtEnd =  isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";
        $shift =  isset($_REQUEST["shift"]) ? $_REQUEST["shift"] : 0;

        $url = $this->base_url_site . "laporan/";
        $arrBreadcrumbs = array(
            "Laporan" => base_url(),
            "Data Penjualan" => $url,
            "Tetes" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = "Laporan";
        $dt["base_url"] = $url;
        $dt['post_start'] = json_encode($dtStart);
        $dt['post_end'] = json_encode($dtEnd);
        $dt['post_shift'] = json_encode($shift);
        $ret = $this->load->view("laporan/content", $dt, true);
        return $ret;
    }
    public function getData()
    {
        $t = $this->isAjaxPost();
        $this->load->library('datatables');
        $post = $this->input->post();
        $dtStart = $post['date1'];
        $dtEnd = $post['date2'];
        $shift = $post['shift'];
        $tgl = array();
        if ((!empty($dtStart) && ($dtEnd)) && ($dtStart != "dd-mm-yyyy" && $dtStart != "dd-mm-yyyy")) {
            $tgl['start'] = $dtStart;
            $tgl['end'] = $dtEnd;
        }

        $dataTransaksi = $this->laporan_model->getDataTrans($tgl, $shift);

        if (!empty($dataTransaksi)) {
            $response = $this->datatables->collection($dataTransaksi)
                ->addColumn('shift', function ($row) {
                    $shift = $row->shift == 0 ? 'Shift Pagi' : 'Shift Sore';
                    return $shift;
                })
                ->addColumn('tanggal', function ($row) {
                    $tgl = date('d F Y', strtotime($row->tanggal));
                    return $tgl;
                })
                ->addColumn('invoice', function ($row) {
                    $invoice = '<a href=""  data-id="' . $row->id . '" data-toggle="modal" data-target="#detail-data" title="Preview"><strong>' . $row->invoice . '</strong></a>';
                    return $invoice;
                })
                ->addColumn('total', function ($row) {
                    $bayar = "Rp " . number_format($row->bayar, 0, '', '.');
                    return $bayar;
                })
                ->addColumn('createdby', function ($row) {
                    $createdby = $row->nama;
                    return $createdby;
                })
                ->render();
            echo json_encode($response);


            // $data = array();
            // $no = 0;
            // foreach ($dataTransaksi as $dt) {
            //     $no++;
            //     $hasil_rupiah = "Rp " . number_format($dt->bayar, 0, '', '.');
            //     $row[] = $no;
            //     $row[] = date('d M Y H:i:s', strtotime($dt->tanggal));
            //     $row[] = $dt->invoice;
            //     $row[] = $hasil_rupiah;
            //     $row[] = $dt->nama;
            //     $data[] = $row;
            // }
            // $output = array(
            //     "recordsTotal" => count($dataTransaksi),
            //     "recordsFiltered" => count($dataTransaksi),
            //     "data" => $data,
            // );
            // //output to json format
            // echo json_encode($output);
        }
    }
    public function getDataview()
    {
        $id = $_POST['rowid'];
        $data_penjualan = $this->laporan_model->getDetail($id);
        $dt['data_p'] = $data_penjualan[0];
        $dt['data'] = $this->laporan_model->getBarangDetailpenjualan($id);
        $ret = $this->load->view("laporan/preview", $dt);
    }
    public function export()
    {
        $dtStart =  isset($_POST["date1"]) ? $_POST["date1"] : "";
        $dtEnd =  isset($_POST["date2"]) ? $_POST["date2"] : "";
        $shift =  isset($_POST["shift"]) ? $_POST["shift"] : 0;
        $tgl = array();
        if ((!empty($dtStart) && ($dtEnd)) && ($dtStart != "dd-mm-yyyy" && $dtStart != "dd-mm-yyyy")) {
            $tgl['start'] = $dtStart;
            $tgl['end'] = $dtEnd;
        }
        //        echoPre($_POST);exit;
        $transaksi = $this->laporan_model->getDataIndexexport($tgl, $shift);
        $heading = array('TANGGAL', 'JAM REGISTRASI', 'NAMA ANGKUTAN', 'NAMA SOPIR', 'ANTRIAN', 'TANGGAL MASUK', 'JAM MASUK', 'TANGGAL KELUAR', 'JAM KELUAR');
        $this->load->library('Excel/Classes/PHPExcel');
        //Create a new Object
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->setTitle('LAPORAN PENERIMAAN TETES');
        //Loop Heading
        //        $status_pembayaran = $this->config->item('status');
        $rowNumberH = 1;
        $colH = 'A';
        foreach ($heading as $h) {
            $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
            $colH++;
        }
        $i = 1;
        foreach ($transaksi->result() as $n) {
            $i++;
            $createddate = date('d-m-Y', strtotime($n->createddate));
            $jam_registrasi = date('H:i:s', strtotime($n->createddate));
            $cekin = date('d-m-Y', strtotime($n->checkin_date));
            $cekdate = date('H:i:s', strtotime($n->checkin_date));
            $cekout = date('d-m-Y', strtotime($n->check_out));
            $cekdate1 = date('H:i:s', strtotime($n->check_out));
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $createddate);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $jam_registrasi);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $n->transportasi);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $n->nama);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $n->nomor);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $cekin);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $cekdate);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $cekout);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $cekdate1);
        }
        $objPHPExcel->getActiveSheet()->freezePane('A2');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Penerimaan Tetes PerTanggal-' . $dtStart . ' - ' . $dtEnd . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        exit();
    }
}
