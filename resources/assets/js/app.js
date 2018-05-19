$(document).ready(function() {
    var products = $('.datatables').DataTable({
        "columns": [
            { "visible": false },
            null,
            null,
            null,
            null,
            null,
        ],
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/product",
        "ordering": false,
        "info": false,
        "searching": false,
        "lengthChange": false,
        "paging": false,
    });
});
