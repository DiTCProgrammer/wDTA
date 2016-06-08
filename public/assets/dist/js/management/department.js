$(function () {
    var APP_URL = window.location.host;
//    if ($('#example1').length) {
//        $("#example1").DataTable();
//    }

    var status_night = $('input[name=status_night]:checked').val();
    if (status_night == 0) {
        $('.time_val').hide();
    }

    $('.night').change(function () {
        var val = jQuery(this).val();
        if (val == 1) {
            $('.time_val').show();
        } else {
            $('.time_val').hide();
        }
    });

    $('#code').blur(function () {//ตรวจสอบ ค่า empcode ว่ามีค่าหรือไม่
        var data = $(this).val();
        if (data != '') {
            $('.show_status_emptycode').html('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '//' + APP_URL + '/department/checkemp',
                type: 'POST',
                data: {'data': data},
                success: function (msg) {
                    if (msg == 'TRUE') {
                        $('#code').val('');
                        $('#code').focus();
                        $('.show_status_code').html('<p class="text-not">It can not work : ' + data + '</p>');
                    } else {
                        $('.show_status_code').html('<p class="text-available">currently available</p>');
                    }
                }
            });
        }
    });

});

function delDepartment(id) {
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
                    url: '//' + APP_URL + '/department/'+id+'/destroy',
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

