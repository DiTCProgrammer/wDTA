jQuery.fn.attendance_delete = function () {

    var main = jQuery(this);
    var employee_search_text = main.find('input[type="text"]#employee_search_text');
    var search_btn = main.find('a.btn_search');
    var employee_id = main.find('#employee_id');
    var show_search = jQuery('div.show_search');
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    search_btn.click(function () {
        search_employee();
    });

    employee_search_text.keypress(function (event) {
        if (event.keyCode == 13) {
            search_employee();
        }
    });



    function search_employee() {
        var text = employee_search_text.val();
        if (text) {
            jQuery.ajax({
                url: 'delete/search_employee',
                type: "post",
                data: {'text': text},
                success: function (r) {
                    console.log(r);
                    if (r) {
                        show_search.find('ul').html('');
                        show_search.fadeIn();
                        var obj = jQuery.parseJSON(r);
                        var html = '';
                        jQuery.each(obj, function (k, v) {
                            html += '<li data-id="' + v.id + '">' + v.prefix + v.firstname + ' ' + v.lastname + '</li>';
                        });
                        show_search.find('ul').html('').append(html);
                        change_item();
                    }
                }
            });
        } else {
            show_search.find('ul').html('');
            show_search.fadeOut();
        }
    }

    function change_item() {
        show_search.find('ul li').click(function () {
            employee_id.val(jQuery(this).attr('data-id'));
            employee_search_text.val(jQuery(this).text());
            show_search.fadeOut();
        });
    }



};


jQuery.fn.delete_contro = function () {
    var main = jQuery(this);
    var radio = main.find('input[type="radio"][name="form[type_delete]"]');
    var select = main.find('div.select');
    var search = main.find('div.search');
    var show_search = main.find('div.show_search');
    var employee_id = jQuery('#employee_id');
    var employee_search_text = jQuery('#employee_search_text');
    
    radio.eq(0).prop('checked', true);
    employee_id.val('');
    employee_search_text.val('');
    radio.change(function () {
        show_type(jQuery(this).val());
    });

    function show_type(e) {
        if (e == 1) {
            select.slideUp();
            search.slideUp();
            show_search.hide();
            employee_id.val('');
            employee_search_text.val('');
        } else if (e == 2) {

            select.slideDown();
            search.slideUp();
            show_search.hide();
            employee_id.val('');
            employee_search_text.val('');
        } else {
            select.slideUp();
            search.slideDown();
        }
    }
};