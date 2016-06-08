$(window).load(function() {
    if (typeof(to_be_called)!='undefined')
        for (var i=0; i<to_be_called.length; i++)
            to_be_called[i].call();
    $('#attacks-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
});