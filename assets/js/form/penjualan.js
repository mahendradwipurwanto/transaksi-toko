//var base_url_tag = global_url+'Pengeluaran/';
var base_url = global_url + 'penjualan/';

$(document).on('click', '.btn-del', function () {

    var elm = $(this).parent().parent();
    elm.remove();

});
$(document).ready(function () {
    $('#detail-data').on('show.bs.modal', function (event) {
        var rowid = $(event.relatedTarget).data('id');
        //            alert(rowid);
        var url = base_url + "getDataview/";
        $.ajax({
            url: url,
            type: "POST",
            data: 'rowid=' + rowid,
            success: function (data) {
                $('.fetched_preview-data').html(data);
            }
        })
    });
});
$(function () {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }
    $(".select2").select2();
    $(".select3").select2();
    $('#formworkorder').on('keypress', function (e) {
        return e.which !== 13;
    });
    $('#date1').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    });
    $("#menu_transaksi").addClass("active");
    $("#menu_penjualan").addClass("active");
    var dataGrid = $('#datatable').dataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        searching: true,
        ajax: {
            url: base_url + 'ajax_list/',
            type: 'post',
            data: function (d) {
                d.IDprovinsi = $('#IDprovinsi').val();
            }
        },

        columnDefs: [
            {
                targets: [-1], //last column
                orderable: false, //set not orderable
            },
        ],


    });

    $('#btnFilter').click(function () {
        dataGrid.api().ajax.reload();
    });


    $(document).on('keydown', 'body', function (e) {
        var charCode = (e.which) ? e.which : event.keyCode;

        if (charCode == 118) //F7
        {
            addBarang();
            return false;
        }
        if (charCode == 119) //F8
        {
            $('.pilih_barang').focus();
            return false;
        }
        if (charCode == 120) //F9
        {
            $('#Simpann').focus();
            return false;
        }

    });
    $(document).on('click', '#Simpann', function () {
        $('.modal-dialog').removeClass('modal-lg');
        $('.modal-dialog').addClass('modal-sm');
        $('#ModalHeader').html('Konfirmasi');
        alert("Apakah anda yakin ingin menyimpan transaksi ini ?");
        $('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
        $('#ModalGue').modal('show');

        setTimeout(function () {
            $('button#SimpanTransaksi').focus();
        }, 500);
    });
    $(document).ready(function () {
        $('#search-data').on('show.bs.modal', function (event) {
            //            var rowid = $(event.relatedTarget).data('id');
            var url = base_url + "searching/";
            $.ajax({
                url: url,
                type: "POST",
                data: {nosep: $("#kode_barang").val()}, // data yang akan dikirim ke file proses
                success: function (data) {
                    $("#ids").val(data);
                    //                    $('.fetched_preview-data').html(data);
                }
            })
        });
    });
});

function getSisa() {
    var totTagihan = parseFloat($("#total_tagihan").cleanVal());
    //    var ongkir = parseFloat($("#ongkir").cleanVal());
    var bayar = parseFloat($("#jumlah_terbayar").cleanVal());
    var sisa = totTagihan - bayar;
    $("#sisa_pembayaran").val(toCurrency(sisa));
}

function addBarang() {
    $(".select2").select2();
    var idRow = $('#tabel_barang tr:last').attr('data-id');
    if (idRow == undefined) {
        idRow = 0;
    } else {
        idRow = parseInt(idRow) + 1;
        var lastRow = parseInt($('#index_row').val());
    }
    var lastRow = parseInt($('#index_row').val());
    if (lastRow != idRow) {
        lastRow = idRow;
        var nextRow = lastRow;
    } else {
        lastRow = parseInt(lastRow);
        var nextRow = lastRow + 1;
    }

    var htmlRow = $("#barang_0").html();
    htmlRow = htmlRow.replace('style="display: none;"', '');
    htmlRow = htmlRow.split("kode_barang_0").join("kode_barang_" + idRow);
    htmlRow = htmlRow.split("nama_barang_0").join("nama_barang_" + idRow);
    htmlRow = htmlRow.split("jumlah_0").join("jumlah_" + idRow);
    htmlRow = htmlRow.split("diskon_0").join("diskon_" + idRow);
    htmlRow = htmlRow.split("satuan_0").join("satuan_" + idRow);
    htmlRow = htmlRow.split("stok_0").join("stok_" + idRow);
    htmlRow = htmlRow.split("harga_0").join("harga_" + idRow);
    htmlRow = htmlRow.split("total_0").join("total_" + idRow);
    htmlRow = htmlRow.split("sub_total_0").join("sub_total_" + idRow);
    htmlRow = htmlRow.split("delete_0").join("delete_" + idRow);
    htmlRow = htmlRow.split("barang_0").join("barang_" + idRow);
    htmlRow = '<tr id="barang_' + idRow + '" data-id="' + idRow + '">' + htmlRow + '</tr>';
    $("#tabel_barang tbody").append(htmlRow);
    $('#index_row').val(nextRow);
}

function removeBarang(id) {
    var dly = 50;
    $("#" + id).remove();
    setTimeout(function () {
        //        getTotalHarga();
    }, dly);
}

//function resetBarang(){
//    var lastRow = parseInt($('#index_row').val());
//    for(var i=2; i <= lastRow; i++){
//        if($("#barang_"+i).length > 0){
//            $("#barang_"+i).remove();
//        }
//    }
//    $("#id_barang_1").val("0");
//    $("#id_warna_1").val("0");
//    $("#jumlah_1").val("0");
//    $("#ukuran_0").val("0");
//    $("#stok_0").val("0");
//    $("#satuan_1").val("0");
//    $("#harga_1").val("0");
//    $("#total_1").val("0");
//    $("#total_tagihan").val("0");
//    $('#index_row').val("1");
//}
function editData(id) {
    $('#edit-data').on('show.bs.modal', function (event) {
        var url = base_url + "edit/" + id;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href", url);
    })
}

function getHarga(row) {

    var dly = 50;
    var id_barang = $("#" + row).val();
    var indexRow = row.replace('kode_barang_', '');

    var dup = checkDuplicate();
    //    alert(dup);
    if (dup == false) {
        setTimeout(function () {
            $.ajax({
                url: base_url + 'getharga/' + id_barang
            })
                .done(function (msg) {
                    if (msg != null) {
                        $("#harga_" + indexRow).val(toCurrency(msg.harga));
                        $("#nama_barang_" + indexRow).val(msg.nama_barang);
                        $("#satuan_" + indexRow).val(toCurrency(msg.harga_tonasi));
                        $("#harga_" + indexRow).val(msg.harga);
                        $("#total_" + indexRow).val(toCurrency(msg.harga_tonasi * msg.harga));
                        $("#sub_total_" + indexRow).val(toCurrency(msg.harga_tonasi * msg.harga));
                    } else {
                        //                else{
                        //                    $("#harga_"+indexRow).val("0");
                        //                }
                        $("#nama_barang_" + indexRow).val("0");
                        $("#jumlah_" + indexRow).val("0");
                        $("#diskon_" + indexRow).val("0");
                        $("#total_" + indexRow).val("0");
                        $("#sub_total_" + indexRow).val("0");
                    }
                    getTotalHarga();
                });
            return false;
        }, dly);
    } else {
        $("#" + row).val("");
        alert("Duplikat Kode Barang, Barang yang anda pilih sudah terdaftar");
    }


}

function getTotalHargaItem(row) {
    $(".maks").mask("#.##0", {reverse: true});
    var dly = 50;
    var indexRow = row.replace('kode_barang_', '');

    setTimeout(function () {
        var jumlah = ($("#jumlah_" + indexRow).val() == "") ? 0 : parseFloat($("#jumlah_" + indexRow).val());
        var harga = parseFloat($("#harga_" + indexRow).val());
        var tonasi = parseFloat($("#satuan_" + indexRow).val());

        // var stok = ($("#stok_" + indexRow).val());

        // if (jumlah > stok) {
        //     alert("jumlah barang yang anda masukan melebihi dari stok. stok yang tersedia adalah = " + stok);
        // } else if (stok < 1) {
        //     alert("mohon maaf stok barang 0, anda tidak bisa melakukan penjualan");
        // } else {
        if (jumlah <= 0) {
            alert("Jumlah Barang tidak boleh kurang dari 1");
            $("#jumlah_" + indexRow).val(1);

            var totalNoDis = 1 * (harga * tonasi);
            $("#total_" + indexRow).val(toCurrency(totalNoDis));
            $("#sub_total_" + indexRow).val(toCurrency(totalNoDis));
        } else {

            // var diskon = ($("#diskon_" + indexRow).val() == "") ? 0 : parseFloat($("#diskon_" + indexRow).cleanVal());
            var diskon = 0
            var totalNoDis = jumlah * (harga * tonasi);
            var dis = (diskon == 0) ? 0 : diskon;
            var totwithDis = totalNoDis - dis;
            $("#total_" + indexRow).val(toCurrency((harga * tonasi)));
            $("#sub_total_" + indexRow).val(toCurrency(totwithDis));
            setTimeout(function () {
                getTotalHarga();
            }, dly);
        }
        // }
        return false;
    }, dly);

}

function getTotalHarga() {
    var idRow = $('#tabel_barang tr:last').attr('data-id');
    // var lastRows = parseInt($('#jumlah_terbayar').val());
    var total = 0;
    for (var i = 1; i <= idRow; i++) {
        if ($("#barang_" + i).length > 0) {
            harga = parseFloat($("#total_" + i).val());
            total = total + harga;
        }
    }

    $("#total_tagihan").val(toCurrency(total));
    // $("#tipe_pembayaran").val("tunai");
    // if (lastRows != null) {
    //     $("#jumlah_terbayar").val(toCurrency(lastRows));
    //     $("#sisa_pembayaran").val(toCurrency(total - lastRows));
    // } else {
    //     $("#jumlah_terbayar").val("0");
    //     $("#sisa_pembayaran").val(toCurrency(total));
    // }
}

function deleteData(id) {
    $('#delete-data').on('show.bs.modal', function (event) {
        var url = base_url + "delete/" + id;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href", url);
    })
}

function konfirmasiData(id) {
    $('#update-data').on('show.bs.modal', function (event) {
        var url = base_url + "konfirmasi/" + id;
        var modal = $(this)
        modal.find('#update-true-data').attr("href", url);
    })
}

function nonAktifData(id) {
    $('#nonaktif-data').on('show.bs.modal', function (event) {
        var url = base_url + "konfirmasi/" + id;
        var modal = $(this)
        modal.find('#nonakktif-true-data').attr("href", url);
    })
}

function checkDuplicate() {
    var key = [];
    var results = [];
    var ret = false;
    $(".pilih_barang").each(function () {
        key.push(this.value);
    });
    var sorted_arr = key.slice().sort();
    for (var x = 0; x < key.length - 1; x++) {
        if (sorted_arr[x + 1] == sorted_arr[x] && sorted_arr[x + 1] != 0) {
            results.push(sorted_arr[x]);
        }
    }

    if (results.length > 0) {
        ret = true;
    }

    return ret;
}