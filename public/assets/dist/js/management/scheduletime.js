$(function () {
    
      $('#myModalScheduletime').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var datagroup = button.data('datagroup'); 
        ; 
        var modal = $(this);
        modal.find('.modal-datagroup').val(datagroup);
       
       
        
    });
    
    var sttkidlate = $('#sttkidlate:checked').val();
    var ot = $('input[name=ot]:checked').val();
    var bot = $('input[name=bot]:checked').val();

    if (ot == -1) {
        $('#ot_text').prop('disabled', true);
    }
    if (bot == -1) {
        $('#bot_text').prop('disabled', true);
    }
    if (sttkidlate != 1) {
        flexibility_box(true);
    }

    $('input[name=timecheck_1]').change(function () {
        if (this.checked == false) {
            $('input[name=timecheck_2]').prop("checked", false);
            $('input[name=timecheck_3]').prop("checked", false);
        }
    });
    $('input[name=timecheck_2]').change(function () {
        if (this.checked == true) {

            $('input[name=timecheck_1]').prop("checked", true);
            $('input[name=timecheck_3]').prop("checked", false);
        } else {
            $('input[name=timecheck_1]').prop("checked", true);
            $('input[name=timecheck_3]').prop("checked", false);
        }
    });
    $('input[name=timecheck_3]').change(function () {

        if (this.checked == true) {

            $('input[name=timecheck_1]').prop("checked", true);
            $('input[name=timecheck_2]').prop("checked", true);
        }
    });
    $('#sttkidlate').change(function () {
        if (this.checked == true) {
            flexibility_box(false);
        } else {
            flexibility_box(true);
        }
    });
    $('input[name=ot]').change(function () {
        if ($(this).val() == 1) {
            $('#ot_text').prop('disabled', false);
            $('#ot_text').val('0');
            $('#ot_text').focus();
        } else {
            $('#ot_text').prop('disabled', true);
            $('#ot_text').val('');
        }
    });
    $('input[name=bot]').change(function () {
        if ($(this).val() == 1) {
            $('#bot_text').prop('disabled', false);
            $('#bot_text').val('60');
            $('#bot_text').focus();
        } else {
            $('#bot_text').prop('disabled', true);
            $('#bot_text').val('');
        }
    });


});

function flexibility_box(dataval) {
    $('#flexibility_1_m1').prop('disabled', dataval);
    $('#flexibility_1_m2').prop('disabled', dataval);
    $('#flexibility_2_m3').prop('disabled', dataval);
    $('#flexibility_2_m4').prop('disabled', dataval);
    $('#flexibility_3_m5').prop('disabled', dataval);
    $('#flexibility_3_m6').prop('disabled', dataval);
}

function delScheduletimeCheck(id) {
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
                    url: '//' + APP_URL + '/scheduletime/' + id + '/destroy',
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
function delGroupScheduletime(id) {
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
                    url: '//' + APP_URL + '/scheduletime/' + id + '/destroydep',
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