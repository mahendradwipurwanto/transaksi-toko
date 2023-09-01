var base_url_tag = global_url+'persediaan/';
var base_url = global_url+'persediaan/';
$(document).on('click', '#add_barang', function(){
    var idBrg = $('#id_barang').val();
    var nmBrg = $('#id_barang option:selected').text();
//    var biaya = $('#biaya').val();
    var StckReady = $('#jumlah').val();
    var StckPros = $('#harga').val();
    var Stcktot = $('#satuan').val();
    $("#nama_barang").val("");
    $("#id_barang").val("");
    $("#jumlah").val("");
    $("#harga").val("");
    $("#satuan").val("");
      if(StckReady == false){
        alert("Jumlah tidak boleh kosong");
    } else {
    var elm = '<tr id="barang_'+idBrg+'" >'+
                '<td>'+nmBrg+
                       '<input type="hidden" value="'+idBrg+'" name="jenis_barang[]"/>'+
                '</td>'+
                '<td>'+StckReady+
                        '<input type="hidden" value="'+StckReady+'" name="jumlah[]"/>'+

                '</td>'+
                '<td>'+StckPros +
                       '<input type="hidden" value="'+StckPros+'" name="harga[]">'+
                '</td>'+
                 '<td>'+Stcktot +
                       '<input type="hidden" value="'+Stcktot+'" name="satuan[]">'+
                '</td>'+
                '<td>'+
                       '<a  class="btn btn-danger btn-del" ><span class="glyphicon glyphicon-trash"></span></a></td>'+
                '</td>'+
                '</tr>';

    var tabel = $('#tabel_barang').append(elm);
    //return false;
    }
});

$(document).on('click', '.btn-del', function(){

    var elm = $(this).parent().parent();
    elm.remove();

});


$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }
    $(".select2").select2();
   $('#formworkorder').on('keypress', function(e){
        return e.which !== 13;
    });
    $('#date1').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
    });
     $("#menu_transaksi").addClass("active");
    $("#menu_persediaan").addClass("active");
     $( "#date1" ).change(function() {
         var date1 = $( "#date1" ).val();
         if(date1 != false){
            $("#add_barang").css("display","inline");
            resetBarang();
         }
         else{
            $("#add_barang").css("display","none");
            resetBarang();
         }

      });
       $( "#id_supplier" ).change(function() {
         var id_supplier = $( "#id_supplier" ).val();
         if(id_supplier != 0){
            loadDataAgen(id_supplier);
            $("#add_barang").css("display","inline");
            $("#simpan").css("display","inline");
         }
         else{
            $("#id_supplier").val("");
            $("#nama").val("");
            $("#alamat").val("");
            $("#add_barang").css("display","none");
            $("#simpan").css("display","none");
         }

      });
       $( "#id_barang" ).change(function() {
         var id_barang = $( "#id_barang" ).val();
         if(id_barang != 0){
            getHarga(id_barang);
         }
         else{
            $("#id_barang").val("");
            $("#harga").val("");
            $("#satuan").val("");
         }

      });

       $(document).ready(function() {
        $('#edit-data').on('show.bs.modal', function (event) {

            var rowid = $(event.relatedTarget).data('id');
//            alert(rowid);
            var url = base_url+"getDataview/";
                $.ajax({
                    url: url,
                    type: "POST",
                    data :  'rowid='+ rowid,
                    success : function(data){
                    $('.fetched-data').html(data);
                    }

                })
        });
    });
    var dataGrid = $('#datatable').dataTable({
           processing: true,
        responsive: true,
        serverSide: false,
        searching: true,
        ajax : {
            url : base_url + 'ajax_list/',
            type : 'post',
            data:  function(d){
                d.IDprovinsi = $('#IDprovinsi').val();
            }
        },

    columnDefs: [
        {
            targets : [ -1 ], //last column
            orderable: false, //set not orderable
        },
        ],


    });

    $('#btnFilter').click(function() {
        dataGrid.api().ajax.reload();
    });
});

function loadDataAgen(id) {
    setTimeout(function (){
    $.ajax({
        url: base_url_tag+'getAgen/'+id
    })
    .done(function( msg ) {
        $("#alamat").val(msg.alamat);
        $("#telp").val(msg.telp);
//        $("#supplier_id").val( msg.id);
    });
    return false;
});
}
function removeBarang(id){
    var dly = 50;
    $("#"+id).remove();
    setTimeout(function (){
        getTotalHarga();
    },dly);
}
function resetBarang(){
    var lastRow = parseInt($('#index_row').val());
    for(var i=2; i <= lastRow; i++){
        if($("#barang_"+i).length > 0){
            $("#barang_"+i).remove();
        }
    }
    $("#id_barang_1").val("0");
    $("#id_warna_1").val("0");
    $("#id_satuan_1").val("0");
    $("#jumlah_1").val("0");
    $("#harga_1").val("0");
    $("#total_1").val("0");
    $("#total_tagihan").val("0");
    $('#index_row').val("1");
}
function getHarga(id_barang){
   var dup = checkDuplicate();
    if(dup == false){
        setTimeout(function (){
            $.ajax({
                url: base_url+'getharga/'+id_barang
            })
            .done(function( msg ) {
                if(msg != null){
                    $("#harga").val(toCurrency(msg.harga));
                    $("#satuan").val(msg.satuan);
                }else{
                    $("#harga").val("0");
//                    $("#biaya").val("0");
                }
                $("#jumlah").val("0");
                $("#total").val("0");
                getTotalHarga();
            });
            return false;
        });
    }
    else{
//        $("#"+row).val(0);
        alert("Duplikat barang, Barang yang anda pilih sudah terdaftar");
    }

}
function getTotalHargaItem(row){
 $(".maks").mask("#.##0",{reverse:true});
    var dly = 50;
    var indexRow = row.replace('id_barang_','');
    setTimeout(function (){
       var jumlah = ($("#jumlah").val() == "") ? 0 : parseFloat($("#jumlah").val());
       if(jumlah < 0){
           alert("Jumlah Barang tidak boleh kurang dari 0");
           $("#jumlah").val(0);
       }
       else{
            var harga = parseFloat($("#harga").cleanVal());

            var totalNoDis = jumlah * harga;
//            alert(totalNoDis);
            var totwithDis = totalNoDis;
            $("#total").val(toCurrency(totwithDis));
             setTimeout(function (){
                 getTotalHarga();
             },dly);
       }
        return false;
    },dly);

}
function getTotalHarga(){
   var idRow = $('#tabel_barang tr:last').attr('data-id');
    var total = 0;
    for(var i=1; i <= idRow; i++){
        if($("#barang_"+i).length > 0){
            harga = parseFloat($("#total_"+i).cleanVal());
            total = total + harga;
        }
    }

    $("#total_tagihan").val(toCurrency(total));
}
function deleteData(id) {
     $('#delete-data').on('show.bs.modal', function (event) {
        var url = base_url+"delete/"+id;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href",url);
        })
    }
function konfirmasiData(id) {
     $('#update-data').on('show.bs.modal', function (event) {
        var url = base_url+"konfirmasi/"+id;
        var modal = $(this)
        modal.find('#update-true-data').attr("href",url);
        })
    }
function nonAktifData(id) {
     $('#nonaktif-data').on('show.bs.modal', function (event) {
        var url = base_url+"konfirmasi/"+id;
        var modal = $(this)
        modal.find('#nonakktif-true-data').attr("href",url);
        })
    }
function checkDuplicate(){
    var key = [];
    var results = [];
    var ret = false;
    $("#add_barang").each(function(){
        key.push(this.value);
    });
    var sorted_arr = key.slice().sort();

    for (var x = 0; x < key.length - 1; x++) {
        if (sorted_arr[x + 1] == sorted_arr[x] && sorted_arr[x + 1] != 0) {
            results.push(sorted_arr[x]);
        }
    }

    if(results.length > 0){
        ret = true;
    }

    return ret;
}