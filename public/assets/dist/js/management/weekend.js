
$(function () {
    var APP_URL = window.location.host;
    $('#year').change(function () {
        var year = $('#year').val();
        var month = $('#month').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '//' + APP_URL + '/weekend/depertment/checkDateTime',
            type: 'POST',
            data: {'y': year, 'm': month},
            success: function (msg) {
                var html_1 = '';
                var html_2 = '';
                var html_3 = '';
                var html_4 = '';
                $('.week-checkbook').html('');
                html_1 = '<div class="col-sm-12">' +
                        '<div class="col-sm-4"></div> <div class="col-sm-8 "><span>M</span>' +
                        '<span>T</span>' +
                        '<span>W</span>' +
                        '<span>Th</span>' +
                        '<span>F</span>' +
                        '<span>Sa</span>' +
                       '<span>Su</span>' +
                        '</div>' +
                        '</div>';
                for (var i = 1; i <= 6; i++) {

                    html_2 = html_2 + "<div class=\"col-sm-12 dataretuenQ\"> <div class=\"col-sm-4\">\n\
                            <div class=\"\" ><h4>" + i + " week </h4></div></div>\n\
                    <div class=\"col-sm-8\"><div class=\"week-checkbook-row\" >";
                    for (var ii = 1; ii <= 7; ii++) {
                        if (msg[i][ii] == '') {
                            html_2 = html_2 + "<span><input class=\"\" id=\"weekend[]\" disabled=\"disabled\" name=\"weekend[]\" type=\"checkbox\"></span>";
                        } else {
                            html_2 = html_2 + "<span><input class=\"\" id=\"weekend[]\" name=\"weekend[]\" type=\"checkbox\" value=\"" + msg[i][ii] + "\"></span>";
                        }
                    }
                    html_2 = html_2 + "</div>\n\
                    </div></div>";


                }
                $('.week-checkbook').append(html_1 + html_2);
            }
        });
    });
    $('#month').change(function () {
        var year = $('#year').val();
        var month = $('#month').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '//' + APP_URL + '/weekend/depertment/checkDateTime',
            type: 'POST',
            data: {'y': year, 'm': month},
            success: function (msg) {
                var html_1 = '';
                var html_2 = '';
                var html_3 = '';
                var html_4 = '';
                $('.week-checkbook').html('');
                html_1 = '<div class="col-sm-12">' +
                        '<div class="col-sm-4"></div> <div class="col-sm-8 "><span>M</span>' +
                        '<span>T</span>' +
                        '<span>W</span>' +
                        '<span>Th</span>' +
                        '<span>F</span>' +
                        '<span>Sa</span>' +
                       '<span>Su</span>' +
                        '</div>' +
                        '</div>';
                for (var i = 1; i <= 6; i++) {

                    html_2 = html_2 + "<div class=\"col-sm-12 dataretuenQ\"> <div class=\"col-sm-4\">\n\
                            <div class=\"\" ><h4>" + i + " week </h4></div></div>\n\
                    <div class=\"col-sm-8\"><div class=\"week-checkbook-row\" >";
                    for (var ii = 1; ii <= 7; ii++) {
                        if (msg[i][ii] == '') {
                            html_2 = html_2 + "<span><input class=\"\" id=\"weekend[]\" disabled=\"disabled\" name=\"weekend[]\" type=\"checkbox\"></span>";
                        } else {
                            html_2 = html_2 + "<span><input class=\"\" id=\"weekend[]\" name=\"weekend[]\" type=\"checkbox\" value=\"" + msg[i][ii] + "\"></span>";
                        }
                    }
                    html_2 = html_2 + "</div>\n\
                    </div></div>";


                }
                $('.week-checkbook').append(html_1 + html_2);
            }
        });

    });
});
function delWeekendCompany(id) {
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
                    url: '//' + APP_URL + '/weekend/company/' + id + '/destroy',
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

function delWeekendDepertment(id) {
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
                    url: '//' + APP_URL + '/weekend/depertment/' + id + '/destroy',
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