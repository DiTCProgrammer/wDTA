jQuery(function () {

    jQuery('.search').attendance_delete();
    jQuery('div.box_delete_data').delete_contro();

    jQuery('input#date_length').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    jQuery('.calendar_icon').click(function () {
        jQuery('input#date_length').click();
    });



});

function delWeekendDepertment() {
    var APP_URL = window.location.host;

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false},
            function () {
                jQuery('form#delete').submit();

            });
}