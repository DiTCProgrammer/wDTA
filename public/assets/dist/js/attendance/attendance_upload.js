jQuery.fn.attendance_upload = function () {

    var main = jQuery(this); //div.attendance--upload form
    var form = main.find('div.box_upload_file form');
    var form_file = form.find('#input_file');
    var form_file_name = form.find('input#name_file');
    var form_date_length = form.find('input[name="date_length"]');
    var form_btn_browser = form.find('button.btn_browser');
    var form_btn_remove = form.find('button.btn_remove');
    var form_btn_upload = form.find('button.btn_upload');
    var file = '';
    var show_text = main.find('.show_text');
    var main_popup = jQuery('.attendance_popup');
    var popup_detail = main_popup.find('.popup_detail');
    var Empid = [];//Employee id 
    var condition = new Array();
    var conditionlate = new Array();
    var user = null;


    var system_message = jQuery('.system_message');
    var tab_content = system_message.find('.tab-content');
    var error_time = tab_content.find('#error_time table tbody');
    var error_time_num = system_message.find('ul li a[href="#error_time"] span.badge');

    var ready_time = tab_content.find('#ready table tbody');
    var ready_time_num = system_message.find('ul li a[href="#ready"] span.badge');

    var no_employee_time = tab_content.find('#no_employee table tbody');
    var no_employee_time_num = system_message.find('ul li a[href="#no_employee"] span.badge');

    var error_upload_time = tab_content.find('#error_upload table tbody');
    var error_upload_time_num = system_message.find('ul li a[href="#error_upload"] span.badge');


    process_view();

    //clear
    form_file.val('');
    form_file_name.val('');
    form_btn_browser.click(function () {
        form_file.click();
    });
    form_file.change(function () {
        var inputdata = this;
        file = inputdata;
        var namefile = jQuery(this).val();
        if (inputdata.files && inputdata.files[0]) {
            var filetype = jQuery(this).val().split('.').pop().toLowerCase();
            if (jQuery.inArray(filetype, ['txt']) != -1) {
                form_file_name.val(namefile);
                form_btn_browser.hide();
                form_btn_remove.show();
                form_btn_upload.show();
            } else {
                alert('กรุณาใช้ไฟล์นามสกุล .txt เท่านั้น');
                form_file_name.val('');
                form_file.val('');
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
        form_file.val('');
        form_btn_browser.show();
        form_btn_remove.hide();
        form_btn_upload.hide();
        file = '';
    });
    // Upload FIle
    form_btn_upload.click(function () {
        var inputdata = file;
        var data = '';
        show_text.find('table').html('');
        if (inputdata.files && inputdata.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                data = e.target.result; //.replace(/(\r\n|\n\r|\r|\n)/g, "<br>")
                //   main_popup.fadeIn(500);
                uploadtext(data);
//                setInterval(function () {
//                    uploadtext(data);
//                }, 1000);
            };
            reader.readAsText(inputdata.files[0]);
        }
    });
    function uploadtext(data) {
        var line = data.split('\n');
        var time = 500;
        // show_text
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var data = {};
        var key = '';
        var total_emp = 0;

        jQuery.each(line, function (k, v) {
            if (k > 0) {
                key = v.replace(/\s+\s+\s+/g, '__').split('__')[0];
                if (key) {
                    if (!data[key]) {
                        total_emp++;
                        data[key] = new Array();
                        data[key][0] = v;
                    } else {
                        data[key][data[key].length] = v;
                    }
                }
            }
        });

        var error_time_n = 0;

        var ready_time_n = 0;

        var no_employee_time_n = 0;

        var error_upload_time_n = 0;

        main_popup.show();
        popup_detail.find('table').html('');
        popup_detail.find('h2.title').text('Upload Process');

        jQuery.each(data, function (k, v) {

            jQuery.ajax({
                url: 'upload/insert1',
                type: "post",
                async: false,
                data: {'data': JSON.stringify(v), 'date_length': form_date_length.val()},
                success: function (r) {


                    var html = '';
                    var obj = jQuery.parseJSON(r);


                    if (obj.error_type == 1) {
                        Empid.push(obj.id);
                        jQuery.each(obj.detail, function (k, v) {
                            html += '<tr>';
                            html += '<td>' + obj.id + '</td>';
                            html += '<td>' + v['time'][0].split(" ")[0] + '</td>';
                            html += '<td>';
                            //  html +=  v['id']+'->';
                            jQuery.each(v['time'], function (k2, v2) {
                                var time = null;
                                time = v2.split(" ")[1];
                                var time2 = null;
                                time2 = time.split(":");
                                html += '<div class="box_check" item-id="' + v['id'] + '" item-use="true" item-data="' + v2 + '">';
                                html += time2[0] + ':' + time2[1];
                                html += '<i class="fa fa-check" aria-hidden="true"></i>';
                                html += '<i class="fa fa-times" aria-hidden="true"></i>';
                                html += '</div>';
                            });
                            error_time_n += 1;
                            html += '<div class="button" group-id="' + v['id'] + '">Update</div>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        error_time_num.text(error_time_n);
                        error_time.append(html);
                        popup_detail.find('table').append('<tr class="error_time"><td>Employee Code------' + obj.id + '------Status------<span>Error Time</span></td></tr>');

                    } else if (obj.error_type == 2) {
                        Empid.push(obj.id);
                        html += '<tr>';
                        html += '<td>' + obj.id + '</td>';
                        html += '<td>Success</td>';
                        html += '</tr>';
                        ready_time_n += 1;
                        ready_time.append(html);
                        ready_time_num.text(ready_time_n);
                        popup_detail.find('table').append('<tr class="ready"><td>Employee Code------' + obj.id + '------Status------<span>Ready</span></td></tr>');
                    } else if (obj.error_type == 3) {
                        html += '<tr>';
                        html += '<td>' + obj.id + '</td>';
                        html += '<td>Error</td>';
                        html += '</tr>';
                        no_employee_time_n += 1;
                        no_employee_time.append(html);
                        no_employee_time_num.text(no_employee_time_n);
                        popup_detail.find('table').append('<tr class="no_employee"><td>Employee Code------' + obj.id + '------Status------<span>No Employee</span></td></tr>');
                    } else if (obj.error_type == 4) {
                        html += '<tr>';
                        html += '<td>' + obj.id + '</td>';
                        html += '<td>Error</td>';
                        html += '</tr>';
                        error_upload_time_n += 1;
                        error_upload_time.append(html);
                        error_upload_time_num.text(error_upload_time_n);
                        popup_detail.find('table').append('<tr class="error_upload"><td>Employee Code------' + obj.id + '------Status------<span>Error Upload</span></td></tr>');
                    }

                }

            });


        });

        if (line && total_emp && form_date_length.val()) {
            jQuery.ajax({
                url: 'upload/log',
                type: "post",
                data: {'total_row': line.length, 'total_emp': total_emp, 'date_length': form_date_length.val()},
                success: function (r) {
                    main_popup.delay(2000).fadeOut();
                }

            });
        }



        form_file_name.val('');
        form_file.val('');
        form_btn_browser.show();
        form_btn_remove.hide();
        form_btn_upload.hide();
        file = '';

        remove_time();

    }

    function process_view() {

        var process_view = jQuery('div.process_view');
        var button_process = process_view.find('button');

        button_process.click(function () {

            main_popup.show();
            popup_detail.find('table').html('');
            popup_detail.find('h2.title').text('Calculate Process');

            getCondition();

        });
    }

    function getraw() {
        jQuery.each(Empid, function (k, v) {
            jQuery.ajax({
                url: 'upload/getraw',
                type: "post",
                async: false,
                data: {empcode: v},
                success: function (resault) {
                    if (resault) {
                        var obj = jQuery.parseJSON(resault);

                        try {

                            process_data(obj);
                        } catch (e) {

                            console.log('error getRaw');
                        }

                    }

                }
            });

        });
        main_popup.delay(2000).fadeOut();
        error_time_num.text(0);
        error_time.html('');
        ready_time_num.text(0);
        ready_time.html('');
        no_employee_time_num.text(0);
        no_employee_time.html('');
        error_upload_time_num.text(0);
        error_upload_time.html('');

    }

    function process_data(obj) {

        var txtot = null;
        var txt = null;
        // console.log(obj[0]);
        var data = {};
        var k1 = 0;



        jQuery.each(obj, function (k, v) {

            data[k1] = {};
            data[k1]['uid'] = v.uid;
            data[k1]['empcode'] = v.empcode;
            data[k1]['prefix'] = v.prefix;
            data[k1]['firstname'] = v.firstname;
            data[k1]['lastname'] = v.lastname;
            data[k1]['Sex'] = v.Sex;
            data[k1]['dept_id'] = v.dept_id;
            data[k1]['dept_code'] = v.dept_code;
            data[k1]['dept_name'] = v.dept_name;
            data[k1]['position'] = v.position;
            data[k1]['id_card'] = v.id_card;
            data[k1]['paytype'] = v.paytype;
            data[k1]['payrate'] = v.payrate;
            data[k1]['wage'] = v.wage;
            data[k1]['extrawage'] = v.extrawage;
            data[k1]['extrawage_status'] = v.extrawage_status;
            data[k1]['technicialwage'] = v.technicialwage;
            data[k1]['technicialwage_status'] = v.technicialwage_status;
            data[k1]['weekendotorday'] = v.weekendotorday;
            data[k1]['date_working'] = v.date_working;
            data[k1]['picture'] = v.picture;
            data[k1]['abs_id'] = v.abs_id;
            data[k1]['abs_detail'] = v.abs_detail;
            data[k1]['group_condition'] = v.group_condition;
            data[k1]['state'] = 1;
            data[k1]['ddate'] = v.ddate;
            data[k1]['name_date'] = v.name_date;


            data[k1]['holidayoff_id'] = v.holidayoff_id;
            data[k1]['holidayoff_detail'] = v.holidayoff_detail;
            data[k1]['holidaybus_id'] = v.holidaybus_id;
            data[k1]['holidaybus_detail'] = v.holidaybus_detail;
            data[k1]['weekendcompany'] = v.weekendcompany;
            data[k1]['weekenddept'] = v.weekenddept;

            if (v.state == 0 && Number(v.count_time) % 2 == 0 && Number(v.count_time) <= 6) { //&& Number(v.count_time) > 0

                txtot = null;
                var txtotarr = null;
                var tarr = v.dtime.split(',');
                
                
                if (Number(v.count_time) > 0 && tarr[1] != 1) {
                    txtot = processtad_ai(v.count_time, v.dtime, v.group_condition, v.ddate); //name**bot**ot**late**total**worktime**lateot**rate_ot_1**rate_ot_2**rate_ot_3**rate_ot_4**common_montly**common_daily**weekend_montly_intime**weekend_montly_ot**weekend_daily_intime**weekend_daily_ot
                    txtotarr = txtot;
                




                    data[k1]['condition'] = txtotarr['condition_name'];
                    data[k1]['status_error'] = 0;
                    data[k1]['bot'] = txtotarr['bot'];
                    data[k1]['ot'] = txtotarr['ottt'];
                    data[k1]['late'] = txtotarr['late'];
                    data[k1]['late_ot'] = txtotarr['lateot'];
                    data[k1]['total'] = txtotarr['total'];

                    data[k1]['common_montly_technicial'] = txtotarr['condition_common_montly_technicial'];
                    data[k1]['common_daily_technicial'] = txtotarr['condition_common_daily_technicial'];
                    data[k1]['weekend_montly_technicial'] = txtotarr['condition_holiday_montly_ot'];
                    data[k1]['weekend_daily_technicial'] = txtotarr['condition_weekend_montly_technicial'];
                    data[k1]['holiday_montly_intime'] = txtotarr['condition_holiday_montly_intime'];
                    data[k1]['holiday_montly_ot'] = txtotarr['condition_holiday_montly_ot'];
                    data[k1]['holiday_montly_technicial'] = txtotarr['condition_holiday_montly_technicial'];
                    data[k1]['holiday_daily_intime'] = txtotarr['condition_holiday_daily_intime'];
                    data[k1]['holiday_daily_ot'] = txtotarr['condition_holiday_daily_ot'];
                    data[k1]['holiday_daily_technicial'] = txtotarr['condition_holiday_daily_technicial'];
                    data[k1]['stthalfday'] = txtotarr['condition_stthalfday'];
                    data[k1]['OT_1_rate'] = txtotarr['condition_rate_ot_1'];
                    data[k1]['OT_2_rate'] = txtotarr['condition_rate_ot_2'];
                    data[k1]['OT_3_rate'] = txtotarr['condition_rate_ot_3'];
                    data[k1]['OT_4_rate'] = txtotarr['condition_rate_ot_4'];
                    data[k1]['worktime'] = txtotarr['condition_worktime'];

                    


                    if (tarr[1] != 1) {
                        data[k1]['timein1'] = tarr[0] ? tarr[0] : '00:00:30';
                        data[k1]['timeout1'] = tarr[1] ? tarr[1] : '00:00:30';
                        data[k1]['timein2'] = tarr[2] ? tarr[2] : '00:00:30';
                        data[k1]['timeout2'] = tarr[3] ? tarr[3] : '00:00:30';
                        data[k1]['timein3'] = tarr[4] ? tarr[4] : '00:00:30';
                        data[k1]['timeout3'] = tarr[5] ? tarr[5] : '00:00:30';
                    }
                    

                    var otja = ((Number(txtotarr['bot']) + Number(txtotarr['ottt'])) - Number(txtotarr['late']));

                    otja = otja > 0 ? otja : '';

                  

                    if (v.holidayoff_id == 0 && v.holidaybus_id == 0 && v.weekendcompany == 0 && v.weekenddept == 0) {

                        if (Number(v.paytype) == 1) {

                            

                            data[k1]['OT_1'] = txtotarr['condition_common_montly_ot'] == 1 ? otja : '';
                            data[k1]['OT_2'] = txtotarr['condition_common_montly_ot'] == 2 ? otja : '';
                            data[k1]['OT_3'] = txtotarr['condition_common_montly_ot'] == 3 ? otja : '';
                            data[k1]['OT_4'] = txtotarr['condition_common_montly_ot'] == 4 ? otja : '';

                            data[k1]['commond_montly_technicial_rate'] = txtotarr['condition_common_montly_technicial'] ? txtotarr['condition_rate_ot_' + txtotarr['condition_common_montly_technicial']] : '';


                        } else {



                            data[k1]['OT_1'] = txtotarr['condition_common_daily_ot'] == 1 ? otja : '';
                            data[k1]['OT_2'] = txtotarr['condition_common_daily_ot'] == 2 ? otja : '';
                            data[k1]['OT_3'] = txtotarr['condition_common_daily_ot'] == 3 ? otja : '';
                            data[k1]['OT_4'] = txtotarr['condition_common_daily_ot'] == 4 ? otja : '';

                            data[k1]['commond_daily_technicial_rate'] = txtotarr['condition_common_daily_technicial'] ? txtotarr['condition_rate_ot_' + txtotarr['condition_common_daily_technicial']] : '';


                        }
                    } else {

                        if (Number(v.paytype) == 1) {

//                        }

                            if (txtotarr['condition_weekend_montly_intime'] == 1) {
                                data[k1]['OT_1'] = Number(txtotarr['condition_worktime']) * 60;

                            } else {
                                //data[k1]['OT_1'] = txtotarr['condition_weekend_montly_ot'] == 1 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_1'] = txtotarr['condition_weekend_montly_ot'] == 1 ? otja : '';
                            }

                            if (txtotarr['condition_weekend_montly_intime'] == 2) {
                                data[k1]['OT_2'] = Number(txtotarr['condition_worktime']) * 60;
                            } else {
                                // data[k1]['OT_2'] = txtotarr['condition_weekend_montly_ot'] == 2 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_2'] = txtotarr['condition_weekend_montly_ot'] == 2 ? otja : '';
                            }

                            if (txtotarr['condition_weekend_montly_intime'] == 3) {
                                data[k1]['OT_3'] = Number(txtotarr['condition_worktime']) * 60;
                            } else {
                                //data[k1]['OT_3'] = txtotarr['condition_weekend_montly_ot'] == 3 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_3'] = txtotarr['condition_weekend_montly_ot'] == 3 ? otja : '';
                            }

                            if (txtotarr['condition_weekend_montly_intime'] == 4) {
                                data[k1]['OT_4'] = Number(txtotarr['condition_worktime']) * 60;
                            } else {
                                //data[k1]['OT_4'] = txtotarr['condition_weekend_montly_ot'] == 4 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_4'] = txtotarr['condition_weekend_montly_ot'] == 4 ? otja : '';
                            }

                            data[k1]['weekend_montly_technicial_rate'] = txtotarr['condition_weekend_montly_technicial'] ? txtotarr['condition_rate_ot_' + txtotarr['condition_weekend_montly_technicial']] : '';
                            data[k1]['holiday_montly_technicial_rate'] = txtotarr['condition_holiday_montly_technicial'] ? txtotarr['condition_rate_ot_' + txtotarr['condition_holiday_montly_technicial']] : '';

                        } else {



                            if (txtotarr['condition_weekend_daily_intime'] == 1) {
                                data[k1]['OT_1'] = Number(txtotarr['condition_worktime']) * 60;
                            } else {
                                // data[k1]['OT_1'] = txtotarr['condition_weekend_daily_ot'] == 1 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_1'] = txtotarr['condition_weekend_daily_ot'] == 1 ? otja : '';
                            }

                            if (txtotarr['condition_weekend_daily_intime'] == 2) {
                                data[k1]['OT_2'] = Number(txtotarr['condition_worktime']) * 60;
                            } else {
                                // data[k1]['OT_2'] = txtotarr['condition_weekend_daily_ot'] == 2 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_2'] = txtotarr['condition_weekend_daily_ot'] == 2 ? otja : '';

                            }

                            if (txtotarr['condition_weekend_daily_intime'] == 3) {
                                data[k1]['OT_3'] = Number(txtotarr['condition_worktime']) * 60;
                            } else {
                                // data[k1]['OT_3'] = txtotarr['condition_weekend_daily_ot'] == 3 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_3'] = txtotarr['condition_weekend_daily_ot'] == 3 ? otja : '';
                            }

                            if (txtotarr['condition_weekend_daily_intime'] == 4) {
                                data[k1]['OT_4'] = Number(txtotarr['condition_worktime']) * 60;
                            } else {
                                //data[k1]['OT_4'] = txtotarr['condition_weekend_daily_ot'] == 4 ? Math.floor(Number(otja) / 60) + '.' + zeroPad(Number(otja) % 60, 2) : '';
                                data[k1]['OT_4'] = txtotarr['condition_weekend_daily_ot'] == 4 ? otja : '';
                            }


                            data[k1]['weekend_daily_technicial_rate'] = txtotarr['condition_weekend_daily_technicial'] ? txtotarr['condition_rate_ot_' + txtotarr['condition_weekend_daily_technicial']] : '';
                            data[k1]['holiday_daily_technicial_rate'] = txtotarr['condition_holiday_daily_technicial'] ? txtotarr['condition_rate_ot_' + txtotarr['condition_holiday_daily_technicial']] : '';
                        }

                    }
                   
                    
                } else {
                   
                    if (v.holidayoff_id == 0 && v.holidaybus_id == 0 && v.weekendcompany == 0 && v.weekenddept == 0) {
                        data[k1]['status_error'] = 0;
                    } else {
                        data[k1]['status_error'] = 0;
                        //  data[k1]['condition'] = txtotarr['condition_name'];
                    }
                }

            } else {

                data[k1]['txt_error'] = v.dtime;
                data[k1]['status_error'] = 1;

            }

            k1++;
        });


        insert_view(data);




    }

    function insert_view(data_view) {
        if (data_view) {
            //  console.log(JSON.stringify(data_view));
            jQuery.ajax({
                url: 'upload/insert_view',
                type: "post",
                async: false,
                data: {'data': JSON.stringify(data_view)},
                success: function (r) {
                    popup_detail.find('table').append(r);
                }
            });
        }
    }

    //step get process AI #7
    function processtad_ai(ct, ttime, gcond, ddate) {
        var rs = [];
        var i = 0;
        var rs2 = '';

        var ctcond = Number(condition[gcond][ct].length) - 1;
        while (i <= ctcond) {
            rs[i] = selectcondition(gcond, ct, i, ttime, ddate); // Fine Condition All Group

            ++i;
        }
        
        
        var j = 0;
        if (i === 1) {
            rs2 = rs[j];
        } else {
            while (j <= Number(ctcond) - 1) {
                if (rs2 === '') {
                    rs2 = rs[j];
                }
                rs2 = conditionusing(rs2, rs[j + 1]);  // Select Condition Once
                
                ++j;
            }
        }
        
      
      
        //var rs2arr = rs2.split('**');
        var rs2arr = rs2;

        //var bot = rs2arr[1];
        var bot = rs2arr['bot'];

        if (Number(rs2arr['condition_bot']) === -1) {
            bot = rs2arr['bot'];
        } else if (Number(rs2arr['condition_bot']) > 0) { // function check Before OT
            if (Number(rs2arr['condition_bot']) <= Number(rs2arr[return_data])) {
                bot = rs2arr['condition_bot'];
            }
        } else if (Number(rs2arr['condition_bot']) === 0) {
            bot = 0;
        }

        var ottt = 0.0;
        var ev2 = 0.0;

        
        
        if (Number(rs2arr['condition_ot']) === -1) {
            ottt = rs2arr['ot'];
        } else if (Number(rs2arr['condition_ot']) > 0) { // function check OT
            if (Number(rs2arr['condition_ot']) <= rs2arr['ot']) {
                ottt = Number(rs2arr['condition_ot']);
            } else {
                ottt = rs2arr['ot'];
            }
        } else if (Number(rs2arr['condition_ot']) === 0) {
            ottt = 0;
        }
        
      

        if (Number(rs2arr['condition_fixot']) === 0) {
           
            ottt = 0;
            ev2 = rs2arr['ot'];
            rs2arr['lateot'] = 0;
        } else {
            rs2arr['late'] = Number(rs2arr['late']) + Number(rs2arr['lateot']);
        }

        // fixot error

        var total = ((Number(rs2arr['condition_worktime']) * 60) + Number(bot) + Number(ottt) + Number(ev2)) - Number(rs2arr['late']);
        total = Math.floor(Number(total) / 60) + '.' + zeroPad(Number(total) % 60, 2);

         
         
        var return_data = [];
        return_data['condition_name'] = rs2arr['condition_name'];
        return_data['bot'] = bot;
        return_data['ottt'] = (ottt > 0?ottt:ev2);
        return_data['late'] = rs2arr['late'];
        return_data['total'] = total;
        return_data['condition_worktime'] = rs2arr['condition_worktime'];
        return_data['lateot'] = rs2arr['lateot'];
        return_data['condition_rate_ot_1'] = rs2arr['condition_rate_ot_1'];
        return_data['condition_rate_ot_2'] = rs2arr['condition_rate_ot_2'];
        return_data['condition_rate_ot_3'] = rs2arr['condition_rate_ot_3'];
        return_data['condition_rate_ot_4'] = rs2arr['condition_rate_ot_4'];
        return_data['condition_common_montly_ot'] = rs2arr['condition_common_montly_ot'];
        return_data['condition_common_daily_ot'] = rs2arr['condition_common_daily_ot'];
        return_data['condition_weekend_montly_intime'] = rs2arr['condition_weekend_montly_intime'];
        return_data['condition_weekend_montly_ot'] = rs2arr['condition_weekend_montly_ot'];
        return_data['condition_weekend_daily_intime'] = rs2arr['condition_weekend_daily_intime'];
        return_data['condition_weekend_daily_ot'] = rs2arr['condition_weekend_daily_ot'];
        return_data['condition_common_montly_technicial'] = rs2arr['condition_common_montly_technicial'];
        return_data['condition_common_daily_technicial'] = rs2arr['condition_common_daily_technicial'];
        return_data['condition_weekend_montly_technicial'] = rs2arr['condition_weekend_montly_technicial'];
        return_data['condition_weekend_daily_technicial'] = rs2arr['condition_weekend_daily_technicial'];
        return_data['condition_holiday_montly_intime'] = rs2arr['condition_holiday_montly_intime'];
        return_data['condition_holiday_montly_ot'] = rs2arr['condition_holiday_montly_ot'];
        return_data['condition_holiday_montly_technicial'] = rs2arr['condition_holiday_montly_technicial'];
        return_data['condition_holiday_daily_intime'] = rs2arr['condition_holiday_daily_intime'];
        return_data['condition_holiday_daily_ot'] = rs2arr['condition_holiday_daily_ot'];
        return_data['condition_holiday_daily_technicial'] = rs2arr['condition_holiday_daily_technicial'];
        return_data['condition_stthalfday'] = rs2arr['condition_stthalfday'];
          
        return return_data;


    }

    //step get process AI  #8
    function selectcondition(gcond, ct, i, ttime, ddate) {

        var timeStart;
        var timeEnd;
        var timeEnd2;
        var timeaot;
        var late = 0;
        var lateot = 0;
        var bot = 0;
        var ot = 0;
        var sttkidlate = 0;
        var chkcondok = 0;
        var chklate = '';
        var tarr = ttime.split(',');
        var j = 0; // loop qty condition
        var jdate = null;
        // var jdate = tarr[j].substring(0, 4) + '/' + tarr[j].substring(5, 7) + '/' + tarr[j].substring(8, 10);

        var math_time = /-/g;

        while (j <= Number(ct) - 1) {
            jdate = tarr[j].substring(0, 4) + '/' + tarr[j].substring(5, 7) + '/' + tarr[j].substring(8, 10);

            timeStart = new Date(tarr[j].replace(math_time, '/')).getTime(); // time employee
            //console.log(tarr[j].replace(math_time,'/'));
            timeStart = (Number(timeStart) / 1000) / 60;


            timeEnd = new Date(jdate + ' ' + condition[gcond][ct][i][j]).getTime(); // condition time normal
            timeEnd = (Number(timeEnd) / 1000) / 60;

            if (conditionlate[gcond][ct][i][j] !== '') {

                timeEnd2 = new Date(jdate + ' ' + conditionlate[gcond][ct][i][j]).getTime(); // condition time flexibility 
                timeEnd2 = (Number(timeEnd2) / 1000) / 60;
            } else {

                timeEnd2 = conditionlate[gcond][ct][i][j];
                //  console.log(gcond+'_'+ct+'_'+i+'_'+j+'_'+conditionlate[4][4][0][0]);
            }

            timeaot = new Date(jdate + ' ' + condition[gcond][ct][i]['aot']).getTime(); // condition time Start OT 
            timeaot = (Number(timeaot) / 1000) / 60;

            sttkidlate = condition[gcond][ct][i]['sttkidlate'];

            if (Number(timeStart) < Number(timeEnd)) {

                if (j % 2 === 0) {
                    if (j === 0) {
                        bot = Number(timeEnd) - Number(timeStart); //bofore First Time OT
                        chkcondok = Number(chkcondok) + (Number(timeEnd) - Number(timeStart)); // Time Check Condition Selected

                    } else {
                        if (Number(timeaot) <= Number(timeEnd)) { //Fucntion Start OT
                            ot = Number(ot) + (Number(timeEnd) - Number(timeStart));
                            chkcondok = Number(chkcondok) + (Number(timeEnd) - Number(timeStart)); // Time Check Condition Selected
                        } else {
                            chkcondok = Number(chkcondok) + (Number(timeEnd) - Number(timeStart)); // Time Check Condition Selected
                        }
                    }
                } else {
                    if (sttkidlate === 0 || timeEnd2 === '' || Number(timeEnd) === Number(timeEnd2)) {
                        if (Number(timeaot) <= Number(timeEnd)) {
                            lateot = Number(lateot) + (Number(timeEnd) - Number(timeStart)); //Late Time OT No Flexibility 
                            ot = Number(ot) + (Number(timeStart) - Number(timeaot));
                        } else {
                            late = Number(late) + (Number(timeEnd) - Number(timeStart)); //Late Time No Flexibility 
                        }
                        chkcondok = Number(chkcondok) + (Number(timeEnd) - Number(timeStart)); // Time Check Condition Selected
                    } else {
                        chklate = checkconditionlate(timeEnd2, timeStart);  //Function Check Flexibility 
                        if (chklate === 'L') {
                            late = Number(late) + (Number(timeEnd) - Number(timeStart)); //Late Time Flexibility
                            chkcondok = Number(chkcondok) + (Number(timeEnd) - Number(timeStart)); // Time Check Condition Selected
                        }
                    }
                }

            } else if (Number(timeStart) >= Number(timeEnd)) {

                if (j % 2 === 0) {

                    if (sttkidlate === 0 || timeEnd2 === '' || Number(timeEnd) === Number(timeEnd2)) {
                        if (Number(timeaot) <= Number(timeEnd)) {
                            lateot = Number(lateot) + (Number(timeStart) - Number(timeEnd)); //Late Time OT No Flexibility 
                            ot = Number(ot) + (Number(timeStart) - Number(timeaot));
                        } else {
                            late = Number(late) + (Number(timeStart) - Number(timeEnd)); //Late Time No Flexibility 
                        }
                        chkcondok = Number(chkcondok) + (Number(timeStart) - Number(timeEnd)); // Time Check Condition Selected
                    } else {
                        chklate = checkconditionlate(timeStart, timeEnd2);  //Function Check Flexibility 
                        if (chklate === 'L') {
                            late = Number(late) + (Number(timeStart) - Number(timeEnd)); //Late Time Flexibility 
                            chkcondok = Number(chkcondok) + (Number(timeStart) - Number(timeEnd)); // Time Check Condition Selected
                        }
                    }

                } else {
                    if (Number(timeaot) <= Number(timeEnd)) { //Fucntion Start OT
                        //ot = Number(ot) + ((Number(timeEnd) - Number(timeaot)) + (Number(timeStart) - Number(timeEnd)));
                        ot = Number(ot) + (Number(timeStart) - Number(timeaot));
                        chkcondok = Number(chkcondok) + (Number(timeStart) - Number(timeEnd)); // Time Check Condition Selected
                    } else {
                        chkcondok = Number(chkcondok) + (Number(timeStart) - Number(timeEnd)); // Time Check Condition Selected
                    }
                }

            }

            ++j;

        }
        

        var return_data = [];
        return_data['condition_name'] = condition[gcond][ct][i]['name'];
        return_data['bot'] = bot;
        return_data['ot'] = ot;
        return_data['late'] = late;
        return_data['chkcondok'] = chkcondok;
        return_data['condition_bot'] = Number(condition[gcond][ct][i]['bot']);
        return_data['condition_ot'] = condition[gcond][ct][i]['ot'];
        return_data['condition_worktime'] = condition[gcond][ct][i]['worktime'];
        return_data['lateot'] = lateot;
        return_data['condition_fixot'] = condition[gcond][ct][i]['fixot'];
        return_data['condition_rate_ot_1'] = condition[gcond][ct][i]['rate_ot_1'];
        return_data['condition_rate_ot_2'] = condition[gcond][ct][i]['rate_ot_2'];
        return_data['condition_rate_ot_3'] = condition[gcond][ct][i]['rate_ot_3'];
        return_data['condition_rate_ot_4'] = condition[gcond][ct][i]['rate_ot_4'];
        return_data['condition_common_montly_ot'] = condition[gcond][ct][i]['common_montly_ot'];
        return_data['condition_common_daily_ot'] = condition[gcond][ct][i]['common_daily_ot'];
        return_data['condition_weekend_montly_intime'] = condition[gcond][ct][i]['weekend_montly_intime'];
        return_data['condition_weekend_montly_ot'] = condition[gcond][ct][i]['weekend_montly_ot'];
        return_data['condition_weekend_daily_intime'] = condition[gcond][ct][i]['weekend_daily_intime'];
        return_data['condition_weekend_daily_ot'] = condition[gcond][ct][i]['weekend_daily_ot'];
        return_data['condition_common_montly_technicial'] = condition[gcond][ct][i]['common_montly_technicial'];
        return_data['condition_common_daily_technicial'] = condition[gcond][ct][i]['common_daily_technicial'];
        return_data['condition_weekend_montly_technicial'] = condition[gcond][ct][i]['weekend_montly_technicial'];
        return_data['condition_weekend_daily_technicial'] = condition[gcond][ct][i]['weekend_daily_technicial'];
        return_data['condition_holiday_montly_intime'] = condition[gcond][ct][i]['holiday_montly_intime'];
        return_data['condition_holiday_montly_ot'] = condition[gcond][ct][i]['holiday_montly_ot'];
        return_data['condition_holiday_montly_technicial'] = condition[gcond][ct][i]['holiday_montly_technicial'];
        return_data['condition_holiday_daily_intime'] = condition[gcond][ct][i]['holiday_daily_intime'];
        return_data['condition_holiday_daily_ot'] = condition[gcond][ct][i]['holiday_daily_ot'];
        return_data['condition_holiday_daily_technicial'] = condition[gcond][ct][i]['holiday_daily_technicial'];
        return_data['condition_stthalfday'] = condition[gcond][ct][i]['stthalfday'];
        
      

        return return_data;


    }


    //step process AI Check Flexibility Time #9
    function checkconditionlate(timeStart, timeEnd) {

        var txt = '';

        if (Number(timeStart) < Number(timeEnd)) {
            txt = 'L';
        }

        return txt;

    }

    //step processtad AI Condition Using ver.1 #10
    function conditionusing(rs1, rs2) {
        var rs1arr = rs1;
        var rs2arr = rs2;
//        var rs1arr = rs1.split('**');
//        var rs2arr = rs2.split('**');
        //if (Number(rs1arr[4]) < Number(rs2arr[4])) {
        if (Number(rs1arr['chkcondok']) < Number(rs2arr['chkcondok'])) {
            return rs1;
        } else {
            return rs2;
        }

    }

    function zeroPad(num, places) {
        var zero = places - num.toString().length + 1;
        return Array(+(zero > 0 && zero)).join("0") + num;
    }




    function getCondition() {
        var c = 0;
        var gn = 0;
        var ct = 0;
        jQuery.ajax({
            url: 'upload/getcondition',
            type: "get",
            success: function (resault) {
                if (resault) {

                    var obj = jQuery.parseJSON(resault);

                    jQuery.each(obj, function (k, v) {

                        if (gn !== v.group) {
                            condition[v.group] = new Array();
                            conditionlate[v.group] = new Array();
                            ct = 0;
                        }

                        if (ct !== v.counttime) {
                            condition[v.group][v.counttime] = new Array();
                            conditionlate[v.group][v.counttime] = new Array();
                            c = 0;
                        } else {
                            c++;
                        }

                        condition[v.group][v.counttime][c] = new Array();
                        conditionlate[v.group][v.counttime][c] = new Array();
                        condition[v.group][v.counttime][c]['name'] = new Array();
                        condition[v.group][v.counttime][c]['name'] = v.name;
                        condition[v.group][v.counttime][c]['ot'] = new Array();
                        condition[v.group][v.counttime][c]['ot'] = v.ot;
                        condition[v.group][v.counttime][c]['bot'] = new Array();
                        condition[v.group][v.counttime][c]['bot'] = v.bot;
                        condition[v.group][v.counttime][c]['wt'] = new Array();
                        condition[v.group][v.counttime][c]['wt'] = v.worktime;
                        condition[v.group][v.counttime][c]['aot'] = new Array();
                        condition[v.group][v.counttime][c]['aot'] = v.aot;
                        condition[v.group][v.counttime][c]['sttkidlate'] = new Array();
                        condition[v.group][v.counttime][c]['sttkidlate'] = v.sttkidlate;
                        condition[v.group][v.counttime][c]['fixot'] = new Array();
                        condition[v.group][v.counttime][c]['fixot'] = v.fixot;
                        condition[v.group][v.counttime][c]['rate_ot_1'] = new Array();
                        condition[v.group][v.counttime][c]['rate_ot_1'] = v.rate_ot_1;
                        condition[v.group][v.counttime][c]['rate_ot_2'] = new Array();
                        condition[v.group][v.counttime][c]['rate_ot_2'] = v.rate_ot_2;
                        condition[v.group][v.counttime][c]['rate_ot_3'] = new Array();
                        condition[v.group][v.counttime][c]['rate_ot_3'] = v.rate_ot_3;
                        condition[v.group][v.counttime][c]['rate_ot_4'] = new Array();
                        condition[v.group][v.counttime][c]['rate_ot_4'] = v.rate_ot_4;
                        condition[v.group][v.counttime][c]['common_montly_ot'] = new Array();
                        condition[v.group][v.counttime][c]['common_montly_ot'] = v.common_montly_ot;
                        condition[v.group][v.counttime][c]['common_montly_technicial'] = new Array();
                        condition[v.group][v.counttime][c]['common_montly_technicial'] = v.common_montly_technicial;
                        condition[v.group][v.counttime][c]['common_daily_ot'] = new Array();
                        condition[v.group][v.counttime][c]['common_daily_ot'] = v.common_daily_ot;
                        condition[v.group][v.counttime][c]['common_daily_technicial'] = new Array();
                        condition[v.group][v.counttime][c]['common_daily_technicial'] = v.common_daily_technicial;
                        condition[v.group][v.counttime][c]['weekend_montly_intime'] = new Array();
                        condition[v.group][v.counttime][c]['weekend_montly_intime'] = v.weekend_montly_intime;
                        condition[v.group][v.counttime][c]['weekend_montly_ot'] = new Array();
                        condition[v.group][v.counttime][c]['weekend_montly_ot'] = v.weekend_montly_ot;
                        condition[v.group][v.counttime][c]['weekend_montly_technicial'] = new Array();
                        condition[v.group][v.counttime][c]['weekend_montly_technicial'] = v.weekend_montly_technicial;
                        condition[v.group][v.counttime][c]['weekend_daily_intime'] = new Array();
                        condition[v.group][v.counttime][c]['weekend_daily_intime'] = v.weekend_daily_intime;
                        condition[v.group][v.counttime][c]['weekend_daily_ot'] = new Array();
                        condition[v.group][v.counttime][c]['weekend_daily_ot'] = v.weekend_daily_ot;
                        condition[v.group][v.counttime][c]['weekend_daily_technicial'] = new Array();
                        condition[v.group][v.counttime][c]['weekend_daily_technicial'] = v.weekend_daily_technicial;
                        condition[v.group][v.counttime][c]['holiday_montly_ot'] = new Array();
                        condition[v.group][v.counttime][c]['holiday_montly_ot'] = v.holiday_montly_ot;
                        condition[v.group][v.counttime][c]['holiday_montly_intime'] = new Array();
                        condition[v.group][v.counttime][c]['holiday_montly_intime'] = v.holiday_montly_intime;
                        condition[v.group][v.counttime][c]['holiday_montly_technicial'] = new Array();
                        condition[v.group][v.counttime][c]['holiday_montly_technicial'] = v.holiday_montly_technicial;
                        condition[v.group][v.counttime][c]['holiday_daily_ot'] = new Array();
                        condition[v.group][v.counttime][c]['holiday_daily_ot'] = v.holiday_daily_ot;
                        condition[v.group][v.counttime][c]['holiday_daily_intime'] = new Array();
                        condition[v.group][v.counttime][c]['holiday_daily_intime'] = v.holiday_daily_intime;
                        condition[v.group][v.counttime][c]['holiday_daily_technicial'] = new Array();
                        condition[v.group][v.counttime][c]['holiday_daily_technicial'] = v.holiday_daily_technicial;
                        condition[v.group][v.counttime][c]['stthalfday'] = new Array();
                        condition[v.group][v.counttime][c]['stthalfday'] = v.stthalfday;

                        condition[v.group][v.counttime][c]['worktime'] = new Array();
                        condition[v.group][v.counttime][c]['worktime'] = v.worktime;
                        var obj2 = jQuery.parseJSON(v.timeinout);
                        var kd = 0;
                        jQuery.each(obj2, function (k2, v2) {
                            condition[v.group][v.counttime][c][kd] = new Array();
                            condition[v.group][v.counttime][c][kd] = v2;

                            kd++;
                        });
                        var obj3 = jQuery.parseJSON(v.timespare);
                        var kd3 = 0;
                        jQuery.each(obj3, function (k3, v3) {
                            conditionlate[v.group][v.counttime][c][kd3] = new Array();
                            conditionlate[v.group][v.counttime][c][kd3] = v3;
                            kd3++;
                        });
                        gn = v.group;
                        ct = v.counttime;

                        if (k == obj.length - 1) {

                            getraw();
                        }
                    });

                    //console.log(conditionlate);

                    //html += '<input id="hida" value="condition">';

                }
            }
        });



    }




    function remove_time() {

        var system_message = jQuery('.system_message');
        var box_check = system_message.find('div.box_check');
        var button = system_message.find('div.button');
        box_check.click(function () {

            if (jQuery(this).attr('item-use') == "true") {
                jQuery(this).attr('item-use', false);
            } else {
                jQuery(this).attr('item-use', true);
            }
        });
        button.click(function () {
            var data_time = [];
            var data_time_error = [];
            var group_id = jQuery(this).attr('group-id');
            var item = system_message.find('div.box_check[item-id="' + group_id + '"]');
            jQuery.each(item, function (k, v) {
                if (item.eq(k).attr('item-use') == 'true') {
                    data_time.push(item.eq(k).attr('item-data'));
                } else {
                    data_time_error.push(k);
                }
            });
            if (data_time.length > 0 && data_time_error.length > 0) {

                jQuery.ajax({
                    url: 'upload/removetime',
                    type: "post",
                    data: {'id': group_id, 'time': data_time.join(",")},
                    success: function (r) {
                        if (r == 1) {
                            jQuery.each(data_time_error, function (k, v) {
                                item.eq(v).hide();
                            });
                        }
                    }
                });
            }

        });
    }
};
jQuery.fn.set_table = function () {
    var main = jQuery(this);
    var detail = main.find('.detail');
    var table = main.find('table tbody,table thead');
    //table.width(detail.width());
};
//jQuery.fn.attendance_popup = function(){
//  var main = jQuery(this);
//  
//};