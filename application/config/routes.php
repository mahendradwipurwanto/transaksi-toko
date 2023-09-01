<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// APPS START HERE //

$route['transaksi'] = 'penjualan/edit';
$route['transaksi/save'] = 'penjualan/save';
$route['penjualan/edit/(:num)'] ='penjualan/edit/$1';

$route['produk'] = 'produk/index';
$route['produk/add'] = 'produk/edit';
$route['produk/edit/(:num)'] ='produk/edit/$1';

$route['laporan/penjualan'] = 'laporan';

// Pengguna Routes
$route['/pengguna'] = 'pengguna/index';
$route['/pengguna/add'] = 'pengguna/add';
$route['/pengguna/save'] = 'pengguna/save';
$route['/pengguna/edit/(:num)'] = function($param , $id){
    return 'pengguna/edit/'.$id;
};
//home
$route['/home/'] ='home/index/';
//profile
$route['/pengguna/delete/(:num)'] = function($param , $id){
      return 'pengguna/delete/'.$id;
};
$route['/profile/save_profile'] = 'profile/save_profile';
$route['/profile/edit/(:num)'] = function($param , $id){
    return 'profile/edit/'.$id;
};

// Level Routers
$route['/level'] = 'level/index';
$route['/level/add'] = 'level/add';
$route['/level/save'] = 'level/save';
$route['/level/edit/(:num)'] = function($param , $id){
    return 'level/edit/'.$id;
};

$route['/level/delete/(:num)'] = function($param , $id){
      return 'pengguna/delete/'.$id;
};

$route['login'] = 'login/index';
$route['logout'] = 'login/logout';

$route['default_controller'] = 'login/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

