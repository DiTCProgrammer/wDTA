<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', 'HomeController@index');
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

Route::auth();
//Route::post('/employee', 'Management\EmployeeController@index');

Route::group(array('prefix' => '/absence'), function() {
    Route::resource('/', 'Absence\AbsenceController');

    Route::resource('/{id}/update', 'Absence\AbsenceController@update');
    Route::resource('/{id}/destroy', 'Absence\AbsenceController@destroy');
    Route::resource('/{id}/edit', 'Absence\AbsenceController@edit');

});


Route::group(array('prefix' => '/scheduletime'), function() {
    Route::resource('/', 'Scheduletime\ScheduletimeController');
    Route::resource('/view', 'Scheduletime\ScheduletimeController@view');
    Route::resource('/create', 'Scheduletime\ScheduletimeController@create');
    Route::resource('/update', 'Scheduletime\ScheduletimeController@update');
    Route::resource('/{id}/update', 'Scheduletime\ScheduletimeController@update');
    Route::resource('/{id}/destroy', 'Scheduletime\ScheduletimeController@destroy');
    Route::resource('/{id}/destroydep', 'Scheduletime\ScheduletimeController@destroydep');
    Route::resource('/{id}/edit', 'Scheduletime\ScheduletimeController@edit');
    Route::resource('/updatedep', 'Scheduletime\ScheduletimeController@updatedep');
});



Route::group(array('prefix' => '/persabsence'), function() {
    Route::resource('/', 'Persabsence\PersabsenceController');
    Route::resource('/view', 'Persabsence\PersabsenceController@view');
    Route::resource('/create', 'Persabsence\PersabsenceController@create');
    Route::resource('/update', 'Persabsence\PersabsenceController@update');
    Route::resource('/{id}/destroy', 'Persabsence\PersabsenceController@destroy');
    Route::resource('/search', 'Persabsence\PersabsenceController@search');
    Route::resource('/search_employee', 'Persabsence\PersabsenceController@search_employee');
    Route::resource('/myabsence', 'Persabsence\PersabsenceController@myabsence');
    Route::resource('/myabsenceview', 'Persabsence\PersabsenceController@myview');
    Route::resource('/export', 'Persabsence\ExportController');
    Route::resource('/import', 'Persabsence\PersabsenceController@import');
    Route::resource('/import_data', 'Persabsence\PersabsenceController@import_data');
});


Route::group(array('prefix' => '/holiday'), function() {
    Route::resource('/', 'Holiday\HolidayController');
    Route::resource('/official/add', 'Holiday\HolidayController@createOfficial');
    Route::resource('/official/update', 'Holiday\HolidayController@updateOfficial');
    Route::resource('/official/{id}/destroy', 'Holiday\HolidayController@destroyOfficial');
    Route::resource('/official', 'Holiday\HolidayController@Official');


    Route::resource('/business/add', 'Holiday\HolidayController@createBusiness');
    Route::resource('/business/update', 'Holiday\HolidayController@updateBusiness');
    Route::resource('/business/{id}/destroy', 'Holiday\HolidayController@destroyBusiness');
    Route::resource('/business', 'Holiday\HolidayController@Business');
});


Route::group(array('prefix' => '/weekend'), function() {
    Route::resource('/', 'Weekend\WeekendController');
    Route::resource('/company/add', 'Weekend\WeekendController@createCompany');
    Route::resource('/company/update', 'Weekend\WeekendController@updateCompany');
    Route::resource('/company/{id}/update', 'Weekend\WeekendController@updateCompany');
    Route::resource('/company/{id}/edit', 'Weekend\WeekendController@editCompany');
    Route::resource('/company/{id}/destroy', 'Weekend\WeekendController@destroyCompany');
    Route::resource('/company', 'Weekend\WeekendController@company');


    Route::resource('/depertment/add', 'Weekend\WeekendController@createDepertment');
    Route::resource('/depertment/update', 'Weekend\WeekendController@updateDepertment');
//    Route::resource('/depertment/{id}/update', 'Weekend\WeekendController@updateDepertment');
//    Route::resource('/depertment/{id}/edit', 'Weekend\WeekendController@editDepertment');
    Route::resource('/depertment/{id}/destroy', 'Weekend\WeekendController@destroyDepertment');
    Route::resource('/depertment/checkDateTime', 'Weekend\WeekendController@checkDateTime');
    Route::resource('/depertment', 'Weekend\WeekendController@depertment');
});


//Route::resource('/employee', 'Management\EmployeeController');
Route::group(array('prefix' => '/upload'), function() {
    Route::resource('/', 'Attendance\UploadController@index');
    Route::post('insert1', 'Attendance\UploadController@insert1');
    Route::resource('test', 'Attendance\UploadController@test');
    Route::resource('removetime', 'Attendance\UploadController@remove_time');
    Route::resource('getcondition', 'Attendance\UploadController@getcondition');
    Route::resource('getraw', 'Attendance\UploadController@getraw');
    Route::resource('insert_view', 'Attendance\UploadController@insert_view');
    Route::resource('log', 'Attendance\UploadController@log');
});

Route::group(array('prefix' => '/delete'), function() {
    Route::resource('/', 'Attendance\DeleteController@index');
    Route::resource('/search_employee', 'Attendance\DeleteController@search_employee');
    Route::resource('/test', 'Attendance\DeleteController@test');
    Route::resource('/destroy', 'Attendance\DeleteController@destroy');
});



Route::group(array('prefix' => '/home'), function() {
    Route::resource('/', 'HomeController@index');
});
//Route::get('/home', 'HomeController@index');

Route::group(array('prefix' => '/employee'), function() {
    Route::resource('/', 'Management\EmployeeController');
    Route::resource('create', 'Management\EmployeeController@create');
    Route::resource('createuser', 'Management\EmployeeController@createuser');
    Route::resource('{id}/{id_emp}/edit', 'Management\EmployeeController@edit');
    Route::resource('update', 'Management\EmployeeController@update');
    Route::resource('updateuser', 'Management\EmployeeController@updateuser');
    Route::resource('{id}/update', 'Management\EmployeeController@update');
    Route::resource('{id}/destroy', 'Management\EmployeeController@destroy');
    Route::resource('checkemp', 'Management\EmployeeController@checkemp');
});

Route::group(array('prefix' => '/department'), function() {
    Route::resource('/', 'Department\DepartmentController@view');
    Route::resource('create', 'Department\DepartmentController@create');
    Route::resource('update', 'Department\DepartmentController@update');
    Route::resource('{id}/edit', 'Department\DepartmentController@edit');
    Route::resource('{id}/update', 'Department\DepartmentController@update');
    Route::resource('checkemp', 'Department\DepartmentController@checkemp');
    Route::resource('{id}/destroy', 'Department\DepartmentController@destroy');
});

Route::group(array('prefix' => '/company'), function() {
    Route::resource('/', 'Company\CompanyController');
    Route::resource('{id}/update', 'Company\CompanyController@update');
});

Route::get('importexport', 'MaatwebsiteController@index');
Route::get('downloadExcel/{type}', 'MaatwebsiteDemoController@downloadExcel');
Route::post('importExcel', 'MaatwebsiteDemoController@importExcel');

Route::group(array('prefix' => '/export'), function() {
    Route::resource('/', 'Export\ExcelController');
    Route::resource('/excel', 'Export\ExcelController@exportexcel');
});


Route::group(array('prefix' => '/dataoverview'), function() {
    Route::resource('/', 'Dataoverview\PersonalsdataController@getdept');
    Route::resource('{id}/users', 'Dataoverview\PersonalsdataController@getusers');
    Route::resource('/users/search', 'Dataoverview\PersonalsdataController@users_search');
    Route::resource('{empcode}/{dept_id}/{date}/user', 'Dataoverview\PersonalsdataController@getuser');
    Route::resource('myinformation', 'Dataoverview\PersonalsdataController@myinformation');
    Route::resource('myinformation2', 'Dataoverview\PersonalsdataController@myinformation2');
});

//Route::get('export', 'Export\ExcelController@index');