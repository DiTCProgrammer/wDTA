jQuery.fn.upload_excel = function () {
    var main = jQuery(this);
    var button = main.find('button.btn_upload');
    var input_file = main.find('input[name="input_file"]');
    var form_file_name = main.find('input#name_file');
    var form_date_length = main.find('input[name="date_length"]');
    var form_btn_browser = main.find('button.btn_browser');
    var form_btn_remove = main.find('button.btn_remove');
    var form_btn_upload = main.find('button.btn_upload');
    var file = '';
    var main_popup = jQuery('.absence_popup');
    var popup_detail = main_popup.find('.popup_detail');

    //clear
    input_file.val('');
    form_file_name.val('');

    form_btn_browser.click(function () {
        input_file.click();
    });

    //ajax_setting
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    input_file.change(function () {
        var inputdata = this;
        file = inputdata;
        var namefile = jQuery(this).val();
        if (inputdata.files && inputdata.files[0]) {
            var filetype = jQuery(this).val().split('.').pop().toLowerCase();
            if (jQuery.inArray(filetype, ['xls']) != -1) {
                form_file_name.val(namefile);
                form_btn_browser.hide();
                form_btn_remove.show();
                form_btn_upload.show();
            } else {
                alert('กรุณาใช้ไฟล์นามสกุล .xls เท่านั้น');
                form_file_name.val('');
                input_file.val('');
                form_btn_browser.show();
                form_btn_remove.hide();
                form_btn_upload.hide();
                file = '';
            }
        }
    });

    // Remove File
    form_btn_remove.click(function () {
        form_file_name.val('');
        input_file.val('');
        form_btn_browser.show();
        form_btn_remove.hide();
        form_btn_upload.hide();
        file = '';
    });

    button.click(function () {

        upload_file();
    });

    function upload_file() {

        input_file.each(function () {
            var data = null;
            var file_val = jQuery(this).val();
            var file = this;
            if (file.files && file.files[0]) {
                var filetype = jQuery(this).val().split('.').pop().toLowerCase();
                if (jQuery.inArray(filetype, ['xls']) != -1) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var data = e.target.result;
                        read_excel_file(data);

                    };
                    reader.readAsBinaryString(file.files[0]);

                } else {
                    alert('กรุณาใช้ไฟล์นามสกุล .xls');
                }
            }

        });
    }


    function read_excel_file(data) {
        var arr = {};
        var cfb = XLS.CFB.read(data, {type: 'binary'});
        var wb = XLS.parse_xlscfb(cfb);
        var absence = {};

        wb.SheetNames.forEach(function (sheetName) {
            var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);
            var data = XLS.utils.sheet_to_json(wb.Sheets[sheetName], {header: 1});
            jQuery.each(data, function (indexR, valueR) {
                if (indexR > 0) {
                    if (!absence[valueR[1]]) {
                        absence[valueR[1]] = new Array();
                    }
                    absence[valueR[1]][absence[valueR[1]].length] = valueR;
                }
            });


        });
        if (absence) {
            main_popup.show();
            popup_detail.find('table').html('');
            popup_detail.find('h2.title').text('Upload Process');
            jQuery.each(absence, function (k, v) {
                jQuery.ajax({
                    url: 'import_data',
                    type: "post",
                    async: false,
                    data: {'data': JSON.stringify(v)},
                    success: function (r) {
                        if (r) {
                            var html = '';
                            var obj = jQuery.parseJSON(r);
                            if (obj.state == 1) {
                                html += '<tr class="success">';
                                html += '<td>Employee Code------' + obj.empcode + '------Status------<span>Ready</span></td>';
                                html += '</tr>';

                            } else if (obj.state == -1) {
                                html += '<tr class="nodata">';
                                html += '<td><span>Incorrect information on system Format</span></td>';
                                html += '</tr>';
                            } else {
                                html += '<tr class="Error">';
                                html += '<td>Employee Code------' + obj.empcode + '------Status------<span>Error</span></td>';
                                html += '</tr>';
                            }
                            popup_detail.find('table').append(html);

                        }
                    }

                });
            });

            main_popup.delay(2000).fadeOut();

            form_file_name.val('');
            input_file.val('');
            form_btn_browser.show();
            form_btn_remove.hide();
            form_btn_upload.hide();
            file = '';
        }
    }
};