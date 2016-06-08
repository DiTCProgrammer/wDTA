$(function () {
    $('input[name="date_length"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });


});

function delHolidatOfficial(id) {
    var APP_URL = window.location.host;

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false},
            function () {
                $.ajax({
                    url: '//' + APP_URL + '/holiday/official/' + id + '/destroy',
                    type: 'GET',
                    success: function (msg) {
                        swal({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            type: "success",
                          
                            closeOnConfirm: false}, function () {window.location.reload();});

                    }
                });

            });
}
function delHolidatBusiness(id) {
    var APP_URL = window.location.host;

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false},
            function () {
                $.ajax({
                    url: '//' + APP_URL + '/holiday/business/' + id + '/destroy',
                    type: 'GET',
                    success: function (msg) {
                        swal({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            type: "success",
                          
                            closeOnConfirm: false}, function () {window.location.reload();});

                    }
                });

            });
}