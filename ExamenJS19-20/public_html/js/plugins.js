
$.extend(true, $.fn.dataTable.defaults, {
    "searching": false
});

$(document).ready(function () {
    $('#tabla').DataTable({
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    });
});



