$(function () {
    var APP_URL = window.location.host;
//    $('#img_onload').change(function () { //ส่วนของการโชว์รูป ใน employee
//        var inputdata = this;
//        var val = jQuery(this).val(); // ชื่อ พาท
//        if (inputdata.files && inputdata.files[0]) {
//            var filesize = ((inputdata.files[0].size) / 1024) / 1024;
//            var type = jQuery(this).val().split('.').pop().toLowerCase();
//            if (filesize <= 4096) {
//                var reader = new FileReader();
//                reader.onload = function (e) {
//                    console.log();
//                    $('.show_img').html('');
//                    $('.show_img').html(' <img src="' + e.target.result + '">');
//                };
//                reader.readAsDataURL(inputdata.files[0]);
//            }
//        }
//    });

    $('.file').find('#img_onload').change(function () {
        var inputdata = this;
        if ($(this).val()) {
            if (inputdata.files && inputdata.files[0]) {
                var filesize = ((inputdata.files[0].size) / 1024) / 1024;
                var type = jQuery(this).val().split('.').pop().toLowerCase();

                if (filesize <= 4096) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        console.log();
                        $('.show_img').html('');
                        $('.show_img').html(' <img src="' + e.target.result + '">');
                    };
                    reader.readAsDataURL(inputdata.files[0]);
                }

            }
            jQuery(this).next('div').html($(this).val());
        } else {
            jQuery(this).next('div').html(jQuery(this).next('div').attr('data-default'));
        }
    });
});
