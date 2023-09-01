var base_url = global_url+'produk/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    $(".select").select2();
   $('#formworkorder').on('keypress', function(e){
        return e.which !== 13;
    });
     $('.money-input').mask("#.##0", {reverse: true});    
     $("#menu_data").addClass("active");
    $("#menu_data_produk").addClass("active"); 
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
     $(document).ready(function () {
        $('#qrcode-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            var url = base_url + "getDataview2/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched_qr-data').html(data);
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

function deleteData(id) {
     $('#delete-data').on('show.bs.modal', function (event) {
        var url = base_url +"delete/"+id;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href",url);
        })
    }