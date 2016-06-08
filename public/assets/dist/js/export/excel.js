jQuery(function () {

    jQuery('.search').export_excel();
    jQuery('div.box_export_data').export_contro();

    jQuery('input#date_length').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    jQuery('.calendar_icon').click(function () {
        jQuery('input#date_length').click();
    });



});

function confirmexport() {
    var APP_URL = window.location.host;

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Export it!",
        closeOnConfirm: false},
            function () {
                jQuery('form#export').submit();

            });
}