$(document).ready(function () {
    $('#myBaTable').dataTable({
        "aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
        "iDisplayLength": 10,
        "order": [[0, "asc"]],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Here..."
        }
    });
});