jQuery(function () {
    jQuery('input[name="date_length"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    jQuery('.calendar_icon').click(function () {
        jQuery('input[name="date_length"]').click();
    });


    jQuery('.system_message').set_table();
    jQuery('.attendance--upload_form').attendance_upload();

});
