jQuery(function () {
    jQuery('input[name="date_length"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    jQuery('.calendar_icon').click(function () {
        jQuery('input[name="date_length"]').click();
    });
});

function clickgo() {
    
    jQuery.fn.clickgoto = function () {

        var main = jQuery(this);
        var employee_search_text = main.find('input[type="text"]#employee_search_text');
        var search_btn = main.find('a.btn_search');
        var employee_id = main.find('#employee_id');
        var show_search = jQuery(
                'div.show_search');

    };
    
}