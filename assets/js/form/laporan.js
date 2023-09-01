var base_url_tag = global_url + 'laporan/';

$(function () {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }

    $('.money-input').mask("#.##0", { reverse: true });
    $(".select2").select2();

    $('#date1').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    });
    $('#date2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    });
    $('#formTransaksi').on('keypress', function (e) {
        return e.which !== 13;
    });

    $("#menu_laporan").addClass("active");
    $("#menu_add_laporan").addClass("active");

    var dataGrid = $('#datatable').dataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: base_url_tag + 'getData/',
            type: 'post',
            data: function (d) {
                d.date1 = $('#date1').val();
                d.date2 = $('#date2').val();
                d.shift = $('#shift').val();
            }
        },
        columns: [
            { data: 'shift' },
            { data: 'tanggal' },
            { data: 'invoice' },
            { data: 'total' },
            { data: 'createdby' },
        ]
    });

    $(document).on('click', '#export-xls', function () {
        $('[name="date1"]').val($('#date1').val());
        $('[name="date2"]').val($('#date2').val());
        $('[name="status"]').val($('#status_pembayaran').val());

    });
    $(document).on('click', '#excel', function () {
        $('[name="date1"]').val($('#date1').val());
        $('[name="date2"]').val($('#date2').val());
    });
    $('#btnFilter').click(function () {
        dataGrid.api().ajax.reload();

        $("#pdf").css("display", "inline");
        $("#excel").css("display", "inline");
    });

    $(document).ready(function () {
        $('#detail-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            //            alert(rowid);
            var url = base_url_tag + "getDataview/";
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
});