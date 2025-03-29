$(document).ready(function() {
    $('#club').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
        "order": [[0, "DESC"]]
    });
    $('#uploads').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            { data: 'title', name: 'title' },
            { data: 'image', name: 'image', orderable: false, searchable: false},
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
        "order": [[0, "DESC"]]
    });
});
