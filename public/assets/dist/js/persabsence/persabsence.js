$(function () {
    $('input[name="date_length"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
      
    });
    
    function dateChanged(ev) {
        alert(ev);
    }

    $('.calendar_icon').click(function () {
        $('input[name="date_length"]').click();
    });





    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var empcode = button.data('empcode');
        var name = button.data('name');
        var date = button.data('date');
        var absence = button.data('absence');
        var detial = button.data('detial');
        var img = button.data('img');
        var modal = $(this);
        modal.find('.modal-empcode').text('Empcode : ' + empcode);
        modal.find('.modal-name').text('Name : ' + name);
        modal.find('.modal-date').text('Date : ' + date);
        modal.find('.modal-detial').text('Detial : ' + detial);
        if (img) {
            modal.find('.modal-img').html('<img src="' + img + '"     width="100%">');
        }
        modal.find('.modal-absence').text('Name Absence : ' + absence);


    });

    $('.file').find('#attfile').change(function () {
        if ($(this).val()) {
            jQuery(this).next('div').html($(this).val());
        } else {
            jQuery(this).next('div').html(jQuery(this).next('div').attr('data-default'));
        }
    });

    $('.calendar').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('.calendar_icon').click(function () {
        jQuery('.calendar').click();
    });
    $('.calendar').on('apply.daterangepicker', function (ev, picker) {
        this.form.submit();
    });

    $('input[name="date_length"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
    var APP_URL = window.location.host;
    $('#search').change(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '//' + APP_URL + '/persabsence/search',
            type: 'POST',
            data: {'data': $(this).val()},
            success: function (msg) {
                $('.showSearch').html('');
                for (var i = 0; i < msg.length; i++) {
                    var html = '<button type="button" class="btn btn-default btn-block btn-flat" onclick="dataEmpcode(' + msg[i]['id'] + ',' + msg[i]['empcode'] + ')" >' + msg[i]['firstname'] + ' ' + msg[i]['lastname'] + '</button>';
                    $('.showSearch').append(html);
                }
            }
        });
    });
    search_employees();
    $('.search').search_employees();

});

function search_employees() {
    $.fn.search_employees = function () {

        var main = $(this);
        var employee_search_text = main.find('input[type="text"]#employee_search_text');
        var search_btn = main.find('a.btn_search');
        var employee_id = jQuery('.management--persabsence').find('#empcode');
        var uid = jQuery('.management--persabsence').find('#id_empcode');
        var dept_id = jQuery('.management--persabsence').find('#dept_id');
        var show_search = $('div.show_search');
        $.ajaxSetup({
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
                $.ajax({
                    url: 'search_employee',
                    type: "post",
                    data: {'text': text},
                    success: function (r) {
                        console.log(r);
                        if (r) {
                            show_search.find('ul').html('');
                            show_search.fadeIn();
                            var obj = $.parseJSON(r);
                            var html = '';
                            $.each(obj, function (k, v) {
                                html += '<li data-uid="' + v.uid + '" data-empcode="' + v.empcode + '" dept-id="' + v.dept_id + '">' + v.prefix + v.firstname + ' ' + v.lastname + '</li>';
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
                employee_id.val($(this).attr('data-empcode'));
                uid.val($(this).attr('data-uid'));
                dept_id.val($(this).attr('dept-id'));
                employee_search_text.val($(this).text());
                show_search.fadeOut();
            });
        }



    };
}



function dataEmpcode(id, emp) {
    $('.showSearch').html('');
    $('#empcode').val(emp);
    $('#id_empcode').val(id);

}

function delPersabsence(id) {
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
                    url: '//' + APP_URL + '/persabsence/' + id + '/destroy',
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