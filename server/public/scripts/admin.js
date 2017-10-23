$(function () {
    $("#users-table").DataTable({
        "order": [[0, "asc"]],
        "columnDefs": [
            {
                "targets": [0]
            },
            {
                "targets": [1]
            },
            {
                "targets": [2]
            },
            {
                "targets": [3],
                "orderable": false
            },
            {
                "targets": [4],
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [5],
                "orderable": false,
                "searchable": false
            }
        ],
        "scrollY": '50vh',
        "scrollX": true,
        "paging": true,
        "info": true
    });

    var element = document.getElementById("menu-admin");
    element.setAttribute("class", "active");
});