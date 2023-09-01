var base_url_tag = global_url+'pengguna/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    $("#menu_pengguna").addClass("active");
    $("#menu_add_edit_pengguna").addClass("active");
    
    $("#formPengguna").submit(function(){
        var id = $("#id").val();
        var pass = $("#password").val();
        var cpass = $("#confirm_password").val();
        if(id == ""){
           if(pass == "" && cpass == ""){
               alert("Password todak boleh kosong!");
               return false;
           }
           if(pass != cpass ){
               alert("Password yang anda masukan pada confirm password tidak sama!");
               return false;
           }
           return true;
        }
        else{
            if(pass != cpass ){
               alert("Password yang anda masukan tidak sama!");
               return false;
           }
           return true;
        }
        
    });
});

function loadData(url) {
    $.ajax({
        url: url
    })
    .done(function( msg ) {
        $("#form-head").html("Edit Pengguna");
        $("#id").val(msg.id);
        $("#nama").val(msg.nama);
        $("#username").val(msg.username);
        $("#id_level").val(msg.id_level);
        $("#pass_label").html("Ubah Password");
        $(".pass_notif").html("Kosongkan jika tidak ingin mengubah");
    });
    return false;
}

function deleteData(id) {
    locationDel = base_url_tag+"delete/"+id;
    msg = "Apakah Anda Akan menghapus Pengguna Ini ? ";
    
    var r = confirm(msg);
    if (r==true) {
           window.location = locationDel;
    }
}