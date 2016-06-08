<?php

namespace App\Http\Controllers\Export;

use App\Export;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use Auth;
use Session;
use DB;

class ExcelController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        \Debugbar::disable();
    }

    public function index() {
        $company_id = Auth::user()->company_id;
        $company = DB::connection('dta_' . $company_id)->select('SELECT * FROM config_company');
        Session::set('mycompany', $company[0]);
        $model = new Export();
        $rs = $model->getDept();
        return view('export/view', ['dept_data' => $rs]);
    }

    public function checkzero($pr) {
        if (strlen($pr) == 1) {
            $pr = '0' . $pr;
        }
        return $pr;
    }

    public function exportexcel(Export $fn, Request $request) {

        if (!Session::get('mycompany')) {
            return redirect('export');
        }

        $post = $request->input('form');
        $type = $post['type_export'];
        $department = $post['department'];
        $employee_id = $post['employee_id'];
        $date = explode('-', $post['date_length']);
        $dateStart = $date[0] . '-' . $date[1] . '-' . $date[2];
        $dateEnd = $date[3] . '-' . $date[4] . '-' . $date[5];
        if (isset($post['status_ot'])) {
            $ot['status_ot'] = $post['status_ot'];
            $ot['date_ot'] = explode('-', $post['date_ot']);
            $ot['dateStart_ot'] = $ot['date_ot'][0] . '-' . $ot['date_ot'][1] . '-' . $ot['date_ot'][2];
            $ot['dateEnd_ot'] = $ot['date_ot'][3] . '-' . $ot['date_ot'][4] . '-' . $ot['date_ot'][5];
        } else {
            $ot['status_ot'] = 0;
            $ot['date_ot'] = 0;
            $ot['dateStart_ot'] = 0;
            $ot['dateEnd_ot'] = 0;
        }
        
        $dayrealworking = (strtotime($dateEnd) - strtotime($dateStart))/  ( 60 * 60 * 24 );

        if ($type == 1) {

            $export = $fn->Employee($dateStart, $dateEnd);
        } else if ($type == 2) {

            if ($department) {

                $export = $fn->Employee($dateStart, $dateEnd, $department);
            } else {

                $export = $fn->Employee($dateStart, $dateEnd);
            }
        } else if ($type == 3) {

            if ($employee_id) {

                $export = $fn->Employee($dateStart, $dateEnd, '', $employee_id);
            } else {

                $export = $fn->Employee($dateStart, $dateEnd);
            }
        } else {
            $export = $fn->Employee($dateStart, $dateEnd);
        }

        $data = array(
            array('DiTC Time Attendance Report ( Summary )'),
            array('Period: ' . date('F', strtotime($dateStart)) . ' Select Date Report: ' . date('d-m-Y', strtotime($dateStart)) . ' to ' . date('d-m-Y', strtotime($dateEnd))),
            array('Year: ' . date('Y', strtotime($dateStart)) . ' Company: ' . Session::get('mycompany')->name),
            array('Exported on ' . date('d-m-Y') . ' Address: ' . Session::get('mycompany')->address . ' Tel: ' . Session::get('mycompany')->tel . ' Fax: ' . Session::get('mycompany')->fax),
            array('', '')
        );

        $headReport = array(
            array('DiTC Time Attendance Report ( Summary )'),
            array('Period: ' . date('F', strtotime($dateStart)) . ' Select Date Report: ' . date('d-m-Y', strtotime($dateStart)) . ' to ' . date('d-m-Y', strtotime($dateEnd))),
            array('Year: ' . date('Y', strtotime($dateStart)) . ' Company: ' . Session::get('mycompany')->name),
            array('Exported on ' . date('d-m-Y') . ' Address: ' . Session::get('mycompany')->address . ' Tel: ' . Session::get('mycompany')->tel . ' Fax: ' . Session::get('mycompany')->fax),
            array('', ''),
            array('ลำดับ', 'รหัส', 'ชื่อ', 'นามสกุล', 'ค่าแรง', 'ค่าเทคนิค', 'วันทำงานปกติ', 'วันหยุดสัปดาห์', 'วันหยุดนักขัต', 'OT1', 'OT1.5', 'OT2', 'OT3', 'รวมเงินเดือน', 'รวมค่าเทคนิค', 'OT1', 'OT1.5', 'OT2', 'OT3', 'สายนาที', 'สายยอดเงิน')
        );

        $headError = array(
            array('DiTC Time Attendance Report ( Summary )'),
            array('Period: ' . date('F', strtotime($dateStart)) . ' Select Date Report: ' . date('d-m-Y', strtotime($dateStart)) . ' to ' . date('d-m-Y', strtotime($dateEnd))),
            array('Year: ' . date('Y', strtotime($dateStart)) . ' Company: ' . Session::get('mycompany')->name),
            array('Exported on ' . date('d-m-Y') . ' Address: ' . Session::get('mycompany')->address . ' Tel: ' . Session::get('mycompany')->tel . ' Fax: ' . Session::get('mycompany')->fax),
            array('', ''),
            array('ลำดับ', 'รหัส', 'ชื่อ', 'นามสกุล', 'Error', 'รายละเอียด')
        );

        $headAbsence = array(
            array('DiTC Time Attendance Report ( Summary )'),
            array('Period: ' . date('F', strtotime($dateStart)) . ' Select Date Report: ' . date('d-m-Y', strtotime($dateStart)) . ' to ' . date('d-m-Y', strtotime($dateEnd))),
            array('Year: ' . date('Y', strtotime($dateStart)) . ' Company: ' . Session::get('mycompany')->name),
            array('Exported on ' . date('d-m-Y') . ' Address: ' . Session::get('mycompany')->address . ' Tel: ' . Session::get('mycompany')->tel . ' Fax: ' . Session::get('mycompany')->fax),
            array('', ''),
            array('ลำดับ', 'รหัส', 'ชื่อ', 'นามสกุล', 'ขาดงาน')
        );

        $headGroup = array(
            array('DiTC Time Attendance Report ( Summary )'),
            array('Period: ' . date('F', strtotime($dateStart)) . ' Select Date Report: ' . date('d-m-Y', strtotime($dateStart)) . ' to ' . date('d-m-Y', strtotime($dateEnd))),
            array('Year: ' . date('Y', strtotime($dateStart)) . ' Company: ' . Session::get('mycompany')->name),
            array('Exported on ' . date('d-m-Y') . ' Address: ' . Session::get('mycompany')->address . ' Tel: ' . Session::get('mycompany')->tel . ' Fax: ' . Session::get('mycompany')->fax),
            array('', ''),
            array('ลำดับ', 'หน่วยงาน', 'Rate 1', 'Rate 2', 'Rate 3', 'Rate 4')
        );

        $name = date('YmdHis');

        if ($export) {
            if ($export['data']) {
                $i = 1;
                foreach ($export['data'] as $key => $item) {

                    if ($item->paytype == 2) {
                        $ot1_money = ((($item->salary / 8) / 60) * $item->OT_1_rate) * $item->ot10;
                        $ot2_money = ((($item->salary / 8) / 60) * $item->OT_2_rate) * $item->ot15;
                        $ot3_money = ((($item->salary / 8) / 60) * $item->OT_3_rate) * $item->ot20;
                        $ot4_money = ((($item->salary / 8) / 60) * $item->OT_4_rate) * $item->ot30;
                        $totaltech = $item->tech * ((($item->workingdayreal + $item->weekend) * (float) $item->commond_daily_technicial_rate) + ($item->weekend * (float) $item->weekend_daily_technicial_rate) + ($item->holiday * (float) $item->holiday_daily_technicial_rate));

                        $late_money = (($item->salary / 8) / 60) * $item->late;
                    } else {
                        $ot1_money = (((($item->salary / 30) / 8) / 60) * $item->OT_1_rate) * $item->ot10;
                        $ot2_money = (((($item->salary / 30) / 8) / 60) * $item->OT_2_rate) * $item->ot15;
                        $ot3_money = (((($item->salary / 30) / 8) / 60) * $item->OT_3_rate) * $item->ot20;
                        $ot4_money = (((($item->salary / 30) / 8) / 60) * $item->OT_4_rate) * $item->ot30;
                        $totaltech = $item->tech * (($item->workingday * (float) $item->commond_montly_technicial_rate) + ($item->weekend * (float) $item->weekend_montly_technicial_rate) + ($item->holiday * (float) $item->holiday_montly_technicial_rate));

                        $late_money = ((($item->salary / 30) / 8) / 60) * $item->late;
                        
                        if($dayrealworking >= 1 && $dayrealworking <= 7){
                            $a = 4;
                        } else if($dayrealworking >= 8 && $dayrealworking <= 14){
                            $a = 3;
                        } else if($dayrealworking >= 15 && $dayrealworking <= 21){
                            $a = 2;
                        } else {
                            $a = 1;
                        }
                    }

                    $data2[$key][] = $i;
                    $data2[$key]['uid'] = $item->empcode;
                    $data2[$key]['firstname'] = $item->firstname;
                    $data2[$key]['lastname'] = $item->lastname;
                    $data2[$key]['salary'] = $item->salary;
                    $data2[$key]['tech'] = $item->tech;
                    $data2[$key]['workingday'] = $item->workingday;
                    $data2[$key]['weekend'] = $item->weekend;
                    $data2[$key]['holiday'] = $item->holiday;
                    $data2[$key]['ot10'] = (int) $item->ot10 != 0 ? $this->checkzero(floor((float) $item->ot10 / 60)) . ":" . $this->checkzero((int) $item->ot10 % 60) : '-';
                    $data2[$key]['ot15'] = (int) $item->ot15 != 0 ? $this->checkzero(floor((float) $item->ot15 / 60)) . ":" . $this->checkzero((int) $item->ot15 % 60) : '-';
                    $data2[$key]['ot20'] = (int) $item->ot20 != 0 ? $this->checkzero(floor((float) $item->ot20 / 60)) . ":" . $this->checkzero((int) $item->ot20 % 60) : '-';
                    $data2[$key]['ot30'] = (int) $item->ot30 != 0 ? $this->checkzero(floor((float) $item->ot30 / 60)) . ":" . $this->checkzero((int) $item->ot30 % 60) : '-';
                    $data2[$key]['totalsalary'] = $item->paytype == 2 ? $item->salary * ($item->workingday) : $item->salary / 2;
                    //$data2[$key]['totalsalary'] = $item->paytype == 2 ? $item->salary * ($item->workingday + $item->weekend + $item->holiday) : $item->salary / 2;

                    $data2[$key]['totaltech'] = $item->empcode==156?$item->tech:$totaltech;

                    $data2[$key]['ot1_money'] = $item->pay2_ot1 != 0 ? $item->pay2_ot1 : '-';
                    $data2[$key]['ot2_money'] = $item->pay2_ot2 != 0 ? $item->pay2_ot2 : '-';
                    $data2[$key]['ot3_money'] = $item->pay2_ot3 != 0 ? $item->pay2_ot3 : '-';
                    $data2[$key]['ot4_money'] = $item->pay2_ot4 != 0 ? $item->pay2_ot4 : '-';
                    $data2[$key]['late'] = $item->late != 0 ? $this->checkzero(floor((float) $item->late / 60)) . ":" . $this->checkzero((int) $item->late % 60) : '-';
                    $data2[$key]['late_money'] = $late_money != 0 ? $late_money : '-';
                    $i++;
                }
            } else {
                $data2 = '';
            }

            if ($export['error']) {
                $iError = 1;
                foreach ($export['error'] as $key_error => $item_error) {
                    $dataError[$key_error][] = $iError;
                    $dataError[$key_error]['uid'] = $item_error->empcode;
                    $dataError[$key_error]['firstname'] = $item_error->firstname;
                    $dataError[$key_error]['lastname'] = $item_error->lastname;
                    $dataError[$key_error]['date'] = $item_error->ddate;
                    $dataError[$key_error]['texterror'] = $item_error->txt_error;
                    $iError++;
                }
            } else {
                $dataError = '';
            }

            if ($export['absence']) {
                $iAbsence = 1;
                foreach ($export['absence'] as $key_absence => $item_absence) {
                    $dataAbsence[$key_absence][] = $iAbsence;
                    $dataAbsence[$key_absence]['uid'] = $item_absence->empcode;
                    $dataAbsence[$key_absence]['firstname'] = $item_absence->firstname;
                    $dataAbsence[$key_absence]['lastname'] = $item_absence->lastname;
                    $dataAbsence[$key_absence]['date'] = $item_absence->ddate;
                    $iAbsence++;
                }
            } else {
                $dataAbsence = '';
            }

            if ($export['otgroup']) {
                $iOtGroup = 1;
                foreach ($export['otgroup'] as $key_otgroup => $item_otgroup) {
                    $dataOtGroup[$key_otgroup][] = $iOtGroup;
//                    $dataOtGroup[$key_otgroup]['deptid'] = $item_otgroup->dept_id;
                    $dataOtGroup[$key_otgroup]['dept_name'] = $item_otgroup->dept_name;
                    $dataOtGroup[$key_otgroup]['OT_1_rate'] = $item_otgroup->OT_1_rate;
                    $dataOtGroup[$key_otgroup]['OT_2_rate'] = $item_otgroup->OT_2_rate;
                    $dataOtGroup[$key_otgroup]['OT_3_rate'] = $item_otgroup->OT_3_rate;
                    $dataOtGroup[$key_otgroup]['OT_4_rate'] = $item_otgroup->OT_4_rate;
                    $iOtGroup++;
                }
            } else {
                $dataOtGroup = '';
            }

            Excel::create($name, function($excel) use($data, $data2, $dataError, $dataAbsence, $dataOtGroup, $headReport, $headError, $headAbsence, $headGroup) {

                // Our first sheet
                $excel->sheet('Report', function($sheet) use($data, $data2, $headReport) {

                    $sheet->fromArray($headReport, null, 'A1', false, false);

                    $sheet->setFontFamily('Tahoma');
                    $sheet->setFontSize(11);

                    $sheet->setPageMargin(array(
                        0.46, 0.30, 0.30, 0.46
                    ));
                    $sheet->mergeCells('A0:U0')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A1:U1')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A2:U2')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A3:U3')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A4:U4')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A5:U5')->setAllBorders('none')->cell(function($cells) {
                        
                    });

//                    $sheet->setAllBorders('thin')->cells('A6:U6', function($cells) {
//                        $cells->setBackground('#3DBFC5');
//                        $cells->setAlignment('center');
//                        $cells->setValignment('center');
//                    });

                    $sheet->setAllBorders('thin')->cells('A6:U6', function($cells) {

                        $cells->setBackground('#0099CC');
                        $cells->setAlignment('center');
                    })->setrowsToRepeatAtTop(array(6, 6));

                    $sheet->setFreeze('A7');

                    $sheet->setFontBold(false);

                    $sheet->setColumnFormat(array(
                        'E' => '#,###',
                        'F' => '#,###',
                        'G' => '#',
                        'H' => '#',
                        'I' => '#',
                        'J' => '#,###',
                        'K' => '#,###',
                        'L' => '#,###',
                        'M' => '#,###',
                        'N' => '#,###',
                        'O' => '#,###',
                        'P' => '#,###.00',
                        'Q' => '#,###.00',
                        'R' => '#,###.00',
                        'S' => '#,###.00',
                        'T' => '#,###',
                        'U' => '#,##0.##',
                    ));
                    if ($data2) {
                        foreach ($data2 as $val) {
                            $sheet->appendRow($val);
                        }
                    }

                    $sheet->setAllBorders('thin');
                    $sheet->setOrientation('landscape');
                });

                // Error
                $excel->sheet('Error Report', function($sheet) use($data, $dataError, $headError) {

                    $sheet->fromArray($headError, null, 'A1', false, false);

                    $sheet->setFontFamily('Tahoma');
                    $sheet->setFontSize(11);

                    $sheet->setPageMargin(array(
                        0.46, 0.30, 0.30, 0.46
                    ));
                    $sheet->mergeCells('A0:U0')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A1:U1')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A2:U2')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A3:U3')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A4:U4')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A5:U5')->setAllBorders('none')->cell(function($cells) {
                        
                    });

                    $sheet->setAllBorders('thin')->cells('A6:F6', function($cells) {
                        $cells->setBackground('#0099CC');
                        $cells->setAlignment('center');
                    })->setrowsToRepeatAtTop(array(6, 6));

                    $sheet->setFreeze('A7');

                    $sheet->setFontBold(false);

                    if ($dataError) {
                        foreach ($dataError as $val) {
                            $sheet->appendRow($val);
                        }
                    }

                    $sheet->setAllBorders('thin');
                    $sheet->setOrientation('landscape');
                });

                // Absence
                $excel->sheet('Absence Report', function($sheet) use($data, $dataAbsence, $headAbsence) {

                    $sheet->fromArray($headAbsence, null, 'A1', false, false);

                    $sheet->setFontFamily('Tahoma');
                    $sheet->setFontSize(11);

                    $sheet->setPageMargin(array(
                        0.46, 0.30, 0.30, 0.46
                    ));
                    $sheet->mergeCells('A0:U0')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A1:U1')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A2:U2')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A3:U3')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A4:U4')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A5:U5')->setAllBorders('none')->cell(function($cells) {
                        
                    });

                    $sheet->setAllBorders('thin')->cells('A6:E6', function($cells) {
                        $cells->setBackground('#0099CC');
                        $cells->setAlignment('center');
                    })->setrowsToRepeatAtTop(array(6, 6));

                    $sheet->setFreeze('A7');

                    $sheet->setFontBold(false);

                    if ($dataAbsence) {
                        foreach ($dataAbsence as $val) {
                            $sheet->appendRow($val);
                        }
                    }

                    $sheet->setAllBorders('thin');
                    $sheet->setOrientation('landscape');
                });

                //Ot Group
                $excel->sheet('OT Group Report', function($sheet) use($data, $dataOtGroup, $headGroup) {

                    $sheet->fromArray($headGroup, null, 'A1', false, false);

                    $sheet->setFontFamily('Tahoma');
                    $sheet->setFontSize(11);

                    $sheet->setPageMargin(array(
                        0.46, 0.30, 0.30, 0.46
                    ));
                    $sheet->mergeCells('A0:U0')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A1:U1')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A2:U2')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A3:U3')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A4:U4')->setAllBorders('none')->cell(function($cells) {
                        
                    });
                    $sheet->mergeCells('A5:U5')->setAllBorders('none')->cell(function($cells) {
                        
                    });

                    $sheet->setAllBorders('thin')->cells('A6:F6', function($cells) {
                        $cells->setBackground('#0099CC');
                        $cells->setAlignment('center');
                    })->setrowsToRepeatAtTop(array(6, 6));

                    $sheet->setFreeze('A7');

                    $sheet->setFontBold(false);

                    if ($dataOtGroup) {
                        foreach ($dataOtGroup as $val) {
                            $sheet->appendRow($val);
                        }
                    }

                    $sheet->setAllBorders('thin');
                    $sheet->setOrientation('landscape');
                });
            })->export('xls');
        } else {
            return redirect('export');
        }
    }

}
