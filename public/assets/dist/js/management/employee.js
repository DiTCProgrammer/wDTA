
$.fn.employee = function () {
    var APP_URL = window.location.host;


    var paytype = $('input[name=paytype]:checked').val();
    var privilege = $('#privilege').val();
    if(privilege == 2){
           $('.show-dept').show();
    }else{
           $('.show-dept').hide();
    }
 
    if (paytype == 1) {
        $('input[name=extrawage]').prop('disabled', true);
        $('.show_extrawage_status').hide();
    }
    $('input[name=paytype]').change(function () {
        var val = $(this).val();
        if (val == 1) {
            $('input[name=extrawage]').prop('disabled', true);
            $('.show_extrawage_status').hide();
        } else {
            $('input[name=extrawage]').prop('disabled', false);
            $('.show_extrawage_status').show();

        }
    });

    $('#privilege').change(function () {
        var id = $(this).val();
        if (id == 2) {
            $('.show-dept').show();
        } else {
            $('.show-dept').hide();
        }
    });

    $('#date_birth').datepicker({format: 'yyyy-mm-dd'});//ปฏิทิน Date of Birth
    $('#date_working').datepicker({format: 'yyyy-mm-dd'});

    $('#img_onload').change(function () { //ส่วนของการโชว์รูป ใน employee
        var inputdata = this;
        var val = jQuery(this).val(); // ชื่อ พาท
        if (inputdata.files && inputdata.files[0]) {
            var filesize = ((inputdata.files[0].size) / 1024) / 1024;
            var type = jQuery(this).val().split('.').pop().toLowerCase();
            if (filesize <= 4096) {
//                if (jQuery.inArray(type, ['jpg', 'jpeg']) != -1) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    console.log();
                    $('.show_img').html('');
                    $('.show_img').html(' <img src="' + e.target.result + '">');
                };
                reader.readAsDataURL(inputdata.files[0]);
//                }
            }
        }
    });




    $('#empcode').change(function () {//ตรวจสอบ ค่า empcode ว่ามีค่าหรือไม่
        var data = $(this).val();
        if (data != '') {
            $('.show_status_emptycode').html('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '//' + APP_URL + '/employee/checkemp',
                type: 'POST',
                data: {'data': JSON.stringify(data)},
                success: function (msg) {
                    if (msg == 'TRUE') {
                        $('#empcode').val('');
                        $('#empcode').focus();
                        $('.show_status_emptycode').html('<p class="text-not">It can not work : ' + data + '</p>');
                    } else {
                        $('.show_status_emptycode').html('<p class="text-available">currently available</p>');
                    }
                }
            });
        }
    });

};
function delCheck(id) {
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
                    url: '//' + APP_URL + '/employee/' + id + '/destroy',
                    type: 'GET',
                    success: function (msg) {
                        swal({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            type: "success",
                            closeOnConfirm: false}, function () {
                            window.location.reload();
                        });
                    }
                });

            });
}
