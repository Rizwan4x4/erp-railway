<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

Route::get('/CompanyWise_EmpAge', 'App\Http\Controllers\HRMS\HrController@CompanyWise_EmpAge');
Route::get('/dept_att', 'App\Http\Controllers\HRMS\HrController@all_attendence');  //Get all dept att
Route::get('/this_user_attendence', 'App\Http\Controllers\HRMS\AttendenceDetails\OverallAttendenceController@this_user_attendence');  //get this user attendence
Route::get('this_user_attendence/{id}', 'App\Http\Controllers\HRMS\AttendenceDetails\OverallAttendenceController@this_user_attendence');  //get this user attendence
Route::get('/m_att_dtl_ct', 'App\Http\Controllers\HRMS\HrController@m_att_dtl_ct');  //Count current month attendence details
Route::get('/Attendance_count/{dateFrom}/{dateTo}', 'App\Http\Controllers\HRMS\HrController@Attendance_count');  //Count current date range attendence details
Route::post('leave_request_rt','App\Http\Controllers\HRMS\HrController@leave_request_fn'); //Add leave Request
// Route::post('leave_request_rt', 'App\Http\Controllers\HRMS\HrController@leave_request_fn'); //Add leave Request
Route::get('/view_profile', 'App\Http\Controllers\HRMS\HrController@view_profile');  //View logged-in employee detail
Route::get('/view_profile_qual', 'App\Http\Controllers\HRMS\HrController@view_profile_qual');  //View logged-in employee qualification
Route::get('m_lv_dtl_rt/{type}', 'App\Http\Controllers\HRMS\HrController@m_lv_dtl');  //Get leaves details
Route::get('ind_team_att', 'App\Http\Controllers\HRMS\HrController@all_ind_team');  //Get all team of logged in employee
Route::post('mark_team_att', 'App\Http\Controllers\HRMS\HrController@mark_team_att'); //Add Candidate
Route::get('ind_att_detail2/{id}', 'App\Http\Controllers\HRMS\HrController@ind_att_detail');  //Individule attendence
Route::get('fetch_att/{id}/{date}', 'App\Http\Controllers\HRMS\HrController@fetch_att');  //fetch candidate to update
Route::post('update_attandence', 'App\Http\Controllers\HRMS\HrController@update_attandence');  //update attandence
Route::get('team_all_leaves', 'App\Http\Controllers\HRMS\HrController@team_all_leaves');  //team leaves of logged in employee
Route::get('/all_team', 'App\Http\Controllers\HRMS\HrController@all_ind_team');  //team members to apply leave
Route::get('/all_ind_team', 'App\Http\Controllers\HRMS\HrController@all_ind_team');  //team members to apply leave
Route::post('time_adjustment', 'App\Http\Controllers\HRMS\HrController@Time_Adjustment'); //Time Adjustment
Route::get('fetch_emp_id', 'App\Http\Controllers\HRMS\HrController@fetch_emp_id');  //fetch Employee detail
Route::get('/delete_arrears/{id}', 'App\Http\Controllers\HRMS\HrController@delete_arrears');
Route::get('/delete_EmpFuelAllowance/{id}', 'App\Http\Controllers\HRMS\HrController@delete_EmpFuelAllowance');
Route::get('getproemploy/{department}/{location}/{designation}/{emp_id}/{start_date}/{end_date}', 'App\Http\Controllers\HRMS\HrController@getproemploy');
Route::get('getproemploycount/{department}/{location}/{designation}/{emp_id}/{start_date}/{end_date}', 'App\Http\Controllers\HRMS\HrController@getproemploycount');
Route::get('fetch_set_upSts/{id}', 'App\Http\Controllers\HRMS\HrController@fetch_rel_settlement');  //Fetch rel settlement
Route::post('update_sett_sts', 'App\Http\Controllers\HRMS\HrController@update_set_sts');  //update settlement status
Route::post('pay_settlement', 'App\Http\Controllers\HRMS\HrController@pay_settlement');  //pay settlement
Route::get('/emp_set_detail/{id}', 'App\Http\Controllers\HRMS\HrController@emp_set_detail');
Route::get('set_rep/{id}', 'App\Http\Controllers\HRMS\HrController@set_reporting');
Route::get('settlement_by_filter/{from_date}/{to_date}/{dept}/{designation}/{name}', 'App\Http\Controllers\HRMS\HrController@settlement_by_filter'); //Search settlement
Route::get('hr/getEmployeedetail', 'App\Http\Controllers\HRMS\HrController@getEmployeedetail');
Route::get('cash_distribution_totalamount/{date}', 'App\Http\Controllers\HRMS\HrController@cash_distribution_totalamount');
Route::get('/getLoan_C_Session', 'App\Http\Controllers\HRMS\HrController@getLoan_C_Session')->middleware('permission:Payroll Dashboard overall-view');  //GetLoan_C_Session
Route::get('/Salary_DistributionReport', 'App\Http\Controllers\HRMS\HrController@Salary_DistributionReport')->middleware('permission:Payroll Dashboard overall-view'); //Salary_DistributionReport
Route::get('/AllowancesReport', 'App\Http\Controllers\HRMS\HrController@AllowancesReport')->middleware('permission:Payroll Dashboard overall-view');
Route::get('/DepartmentWise_EmpStatus', 'App\Http\Controllers\HRMS\HrController@DepartmentWise_EmpStatus')->middleware('permission:Human Resource Dashboard overall-view');
Route::get('/Companywise_Salary', 'App\Http\Controllers\HRMS\HrController@Companywise_Salary')->middleware('permission:Payroll Dashboard overall-view');



Route::get('cash_distributionlist_detail1/{date}', 'App\Http\Controllers\HRMS\HrController@cash_distributionlist_detail1');
Route::get('cash_distributionlist_detail_date', 'App\Http\Controllers\HRMS\HrController@cash_distributionlist_detail_date');
Route::get('/delete_loan/{id}', 'App\Http\Controllers\HRMS\HrController@delete_loan');
Route::get('/overall_employees', 'App\Http\Controllers\HRMS\HrController@overall_employees');
Route::get('/currency_detail', 'App\Http\Controllers\HRMS\HrController@currency_detail');


Route::get('/department_detail', 'App\Http\Controllers\HRMS\EmployeDetails\EmployeDetailsController@department_detail');
Route::get('/department_detail2', 'App\Http\Controllers\HRMS\HrController@department_detail');


Route::get('/resigned_emp/{id}/{date}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@resigned_emp');
Route::get('/registered/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@registered');

Route::get('search_payroll_distributiondept', 'App\Http\Controllers\HRMS\HrController@search_payroll_distributiondept');
Route::get('search_payroll_distribution', 'App\Http\Controllers\HRMS\HrController@search_payroll_distribution');
Route::get('employee_loan/{id}', 'App\Http\Controllers\HRMS\HrController@employee_loan');
Route::get('employee_loan1/{id}', 'App\Http\Controllers\HRMS\HrController@employee_loan1');
// Route::get('/geteducation_detail/{id}','App\Http\Controllers\HRMS\HrController@geteducation_detail');


Route::get('/Leaves_detailByEmp_Id/{id}/{leave}/{dept}/{loc}/{des}', 'App\Http\Controllers\HRMS\HrController@Leaves_detailByEmp_Id');
//Route::get('/search_emp/','App\Http\Controllers\HRMS\HrController@search_emp');
Route::post('filter_activity', 'App\Http\Controllers\clientAdminController@filter_activity');
Route::get('/get_com_employee/', 'App\Http\Controllers\HRMS\HrController@get_com_employee');
Route::get('/org_employees/{id}', 'App\Http\Controllers\HRMS\HrController@org_employees');
Route::get('cv_builder/{id}/{emp_code}/{reg_id}', 'App\Http\Controllers\HRMS\HrController@cv_builder');
Route::post('get_emp_detail', 'App\Http\Controllers\HRMS\HrController@get_emp_detail');
Route::get('warning_reasons', 'App\Http\Controllers\HRMS\HrController@warning_reasons')->middleware('permission:HR Controller overall-view');
Route::get('get_warningreason_byId/{id}', 'App\Http\Controllers\HRMS\HrController@warning_reasonsbyId');

// ->middleware('permission:create tasks');
Route::get('/getindemployee_detail/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@getindemployee_detail');
Route::get('/getemployee_education/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@getemployee_education');
Route::get('cash_distributionlist_detail', 'App\Http\Controllers\HRMS\HrController@cash_distributionlist_detail');

Route::post('update_warningdetail', 'App\Http\Controllers\HRMS\HrController@update_warning');
Route::get('/roster_detail1', 'App\Http\Controllers\HRMS\HrController@roster_detail1');
Route::get('getattendance_report9/{department}/{location}/{designation}/{opening}/{closing}', 'App\Http\Controllers\HRMS\HrController@getattendance_report9');
Route::post('update_loan', 'App\Http\Controllers\HRMS\HrController@update_loan');  //update loan
Route::post('submit_session', 'App\Http\Controllers\HRMS\HrController@submit_session');
Route::get('/session_detail', 'App\Http\Controllers\HRMS\HrController@session_detail');
// Route::get('/delete_session/{id}', 'App\Http\Controllers\HRMS\HrController@delete_session');
Route::get('/delete_session/{id}', 'App\Http\Controllers\HRMS\HrController@delete_session')->middleware('permission:HR Controller Session Detail delete action');
Route::get('/find_emp_id', 'App\Http\Controllers\HRMS\LeavesDetails\LeavesApplicationController@find_emp_id');
Route::get('fetch_loan_slip/{id}', 'App\Http\Controllers\HRMS\HrController@fetch_loan_slip');  //Fetch rel loan for slip
Route::get('overall_leaves', 'App\Http\Controllers\HRMS\LeavesDetails\LeavesDashboardController@overall_leaves');

Route::post('submit_holidays', 'App\Http\Controllers\HRMS\HrController@submit_holidays')->middleware('permission:HR Controller inchlude holiday');
Route::get('holiday_detail/', 'App\Http\Controllers\HRMS\HrController@holiday_detail')->middleware('permission:HR Controller overall-view');
Route::post('submit_l', 'App\Http\Controllers\HRMS\HrController@submit_l')->middleware('permission:HR Controller Add leave type');
Route::post('submit_fine', 'App\Http\Controllers\HRMS\HrController@submit_fine')->middleware('permission:HR Controller add new fine');
Route::get('view_fine_detail/', 'App\Http\Controllers\HRMS\HrController@view_fine_detail')->middleware('permission:HR Controller overall-view');
Route::get('/delete_fine/{id}', 'App\Http\Controllers\HRMS\HrController@delete_fine');
Route::get('/delete_leave_type/{id}', 'App\Http\Controllers\HRMS\HrController@delete_leave_type')->middleware('permission:HR Controller delete leave type');
Route::get('/delete_holiday/{id}', 'App\Http\Controllers\HRMS\HrController@delete_holiday')->middleware('permission:HR Controller delete holiday');
Route::post('update_ind_att', 'App\Http\Controllers\HRMS\AttendenceDetails\OverallAttendenceController@update_ind_att');
//Route::get('/search_att/','App\Http\Controllers\HRMS\HrController@search_att');
Route::get('/get_count_leave/', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@get_count_leave');
Route::get('/get_count_dailyatt/', 'App\Http\Controllers\HRMS\HrController@get_count_dailyatt')->middleware('permission:Human Resource Dashboard overall-view');
Route::get('/count_hiring_d/', 'App\Http\Controllers\HRMS\HrController@count_hiring_d')->middleware('permission:Human Resource Dashboard overall-view');
Route::get('/view_hr_configuration/', 'App\Http\Controllers\HRMS\HrController@view_hr_configuration');
Route::post('submit_config', 'App\Http\Controllers\HRMS\HrController@submit_config')->middleware('permission:HR Controller hr configuration update');


Route::get('connectToAttendanceMachine', 'App\Http\Controllers\HRMS\HrController@connectToAttendanceMachine');
Route::get('connect_machine/{id}', 'App\Http\Controllers\HRMS\HrController@connect_machine');
Route::get('get_machine_users/{dept}/{desig}/{id}/{name}', 'App\Http\Controllers\HRMS\HrController@get_machine_users'); //Pull  attendance1
Route::get('fetch_leave_upSts/{id}', 'App\Http\Controllers\HRMS\LeavesDetails\LeavesApplicationController@fetch_leave_upSts');  //Fetch rel leave
Route::post('update_leave_sts', 'App\Http\Controllers\HRMS\LeavesDetails\LeavesApplicationController@update_leave_sts');  //update leave status
//Route::get('all_leaves','App\Http\Controllers\HRMS\HrController@all_leaves');
Route::get('ind_name/{id}', 'App\Http\Controllers\HRMS\HrController@ind_name');  //Individule name for attendence
Route::post('search_member', 'App\Http\Controllers\HRMS\HrController@search_member');  //search team member
Route::get('filter_team_leaves/{leave}/{dept}/{loc}/{des}', 'App\Http\Controllers\HRMS\HrController@filter_team_leaves');
Route::get('/leaves_dtl', 'App\Http\Controllers\HRMS\HrController@leaves_dtl');  //Count leaves detail
Route::get('selected_emp_leaves/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@selected_emp_leaves');  //Fetch rel leave
Route::get('selected_emp_timeTable/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@selected_emp_timeTable');  //Fetch rel timeTable
Route::get('/selected_emp_attendance/{id}', 'App\Http\Controllers\HRMS\HrController@getindatt_report'); //Fetch rel session attandence
Route::get('reporting_employees/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@reporting_employees');

Route::get('/session_att/', 'App\Http\Controllers\HRMS\HrController@session_att')->middleware('permission:Human Resource Dashboard overall-view');
Route::get('/hrdb_employee_count/', 'App\Http\Controllers\HRMS\HrController@hrdb_employee_count')->middleware('permission:Human Resource Dashboard overall-view');
Route::get('/job_exp_employee/', 'App\Http\Controllers\HRMS\HrController@job_exp_employee')->middleware('permission:Human Resource Dashboard overall-view');
Route::get('/cnic_exp_employee/', 'App\Http\Controllers\HRMS\HrController@cnic_exp_employee')->middleware('permission:Human Resource Dashboard overall-view');
Route::get('get_gracePeriods/{designation}/{location}/{department}', 'App\Http\Controllers\HRMS\HrController@get_gracePeriods');
Route::get('warning_reason/', 'App\Http\Controllers\HRMS\HrController@warning_reason')->middleware('permission:HR Controller overall-view');
Route::get('warning_Detail/{id}', 'App\Http\Controllers\HRMS\HrController@warning_Detail1');
Route::get('emp_leaves/', 'App\Http\Controllers\HRMS\HrController@emp_leaves');
Route::post('submit_warn_reas', 'App\Http\Controllers\HRMS\HrController@submit_warn_reas')->middleware('permission:HR Controller warning reason add new');
Route::get('/delete_warn_reas/{id}', 'App\Http\Controllers\HRMS\HrController@delete_warn_reas');
Route::get('overall_child_companies_emp', 'App\Http\Controllers\HRMS\HrController@overall_child_companies_emp')->middleware('permission:Department overall-view');
Route::get('att_time/{id}', 'App\Http\Controllers\HRMS\HrController@att_time');  //Fetch rel leave balance
Route::post('mark_attendance', 'App\Http\Controllers\HRMS\HrController@mark_attendance'); //Add
Route::get('find_sess_date/{id}', 'App\Http\Controllers\HRMS\HrController@find_sess_date');
Route::get('pull_attendance', 'App\Http\Controllers\HRMS\HrController@pull_attendance'); //Pull  attendance
Route::get('pull_attendance1', 'App\Http\Controllers\HRMS\HrController@pull_attendance1'); //Pull  attendance1


Route::get('/terminate_emp/{id}/{date}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@terminate_emp');
Route::get('getemployment_att_detail/{id}', 'App\Http\Controllers\HRMS\HrController@getemployment_att_detail');
Route::get('/att_ind_team', 'App\Http\Controllers\HRMS\HrController@att_ind_team');  //team members for attendance



Route::get('/search_depart_access/', 'App\Http\Controllers\Accounts\AccountsController@search_depart_access')->middleware('permission:Accounts Configurations  department access');
Route::get('employee_dtl_bycode/{code}', 'App\Http\Controllers\HRMS\HrController@employee_dtl_bycode');  //fetch Employee detail
Route::get('/avg_attendance_times/{id}', 'App\Http\Controllers\HRMS\HrController@avg_attendance_times');
Route::get('/department_byName/', 'App\Http\Controllers\HRMS\HrController@department_byName')->middleware('permission:Department overall-view');
Route::get('/disable_department/{id}', 'App\Http\Controllers\HRMS\HrController@disable_department');
Route::get('/active_department/{id}', 'App\Http\Controllers\HRMS\HrController@active_department');
Route::post('submit_hr_department', 'App\Http\Controllers\HRMS\HrController@submit_hr_department')->middleware('permission:Add new department');
Route::get('delete_hr_department/{id}', 'App\Http\Controllers\HRMS\HrController@delete_hr_department');
Route::get('fetch_hr_department/{id}', 'App\Http\Controllers\HRMS\HrController@fetch_hr_department');  //fetch departmrnt to update
Route::post('update_hr_department', 'App\Http\Controllers\HRMS\HrController@update_hr_department');  //update department
Route::get('id_by_code/{code}', 'App\Http\Controllers\HRMS\HrController@id_by_code');


Route::get('test_pull', 'App\Http\Controllers\HRMS\HrController@test_pull');
//Route::get('warning_detail','App\Http\Controllers\HRMS\HrController@warning_detail');





Route::get('/count_firing_d/', 'App\Http\Controllers\HRMS\HrController@count_firing_d')->middleware('permission:Human Resource Dashboard overall-view');
Route::post('create_employee', 'App\Http\Controllers\HRMS\HrController@create_employee')->middleware('permission:HRMS employees_detail create_employee');
Route::post('submit_roster', 'App\Http\Controllers\HRMS\HrController@submit_roster')->middleware('permission:HRMS Attendance Shifts add new');
Route::post('submit_update_roster', 'App\Http\Controllers\HRMS\HrController@submit_update_roster')->middleware('permission:HRMS Attendance Shifts Edit');
Route::get('/organization_chart', 'App\Http\Controllers\HRMS\HrController@organization_chart')->middleware('permission:HRMS Organization_Cart  view');  //update time Adjstment  status//organization_chart
Route::post('update_TM_sts', 'App\Http\Controllers\HRMS\HrController@update_TM_sts')->middleware('permission:HRMS Attendance Time-Adjustment update-HR-status');  //update time Adjstment  status





Route::middleware(['permission:HRMS employees_detail update_employee_profile'])->group(function () {
    Route::post('update_employee', 'App\Http\Controllers\HRMS\HrController@update_employee');
    Route::get('/getemployee_detail/{id}', 'App\Http\Controllers\HRMS\HrController@getemployee_detail');
});
Route::middleware(['permission:HRMS employees_detail update employee_employeement'])->group(function () {
    Route::post('update_employment', 'App\Http\Controllers\HRMS\HrController@update_employment');
    Route::get('/getemployment_detail/{id}', 'App\Http\Controllers\HRMS\HrController@getemployment_detail');
});
Route::middleware(['permission:HRMS employees_detail update employee_education'])->group(function () {
    Route::get('/getemployee_update_education/{id}', 'App\Http\Controllers\HRMS\HrController@getemployee_update_education');
    Route::post('/skip_education', 'App\Http\Controllers\HRMS\HrController@skip_education');
    Route::post('insert_education', 'App\Http\Controllers\HRMS\HrController@insert_education');
});
Route::middleware(['permission:HRMS employees_detail update employee_experience'])->group(function () {
    Route::get('/getemployee_update_experience/{id}', 'App\Http\Controllers\HRMS\HrController@getemployee_update_experience');
    Route::post('insert_experience', 'App\Http\Controllers\HRMS\HrController@insert_experience');
    Route::post('/skip_experience', 'App\Http\Controllers\HRMS\HrController@skip_experience');
});
Route::middleware(['permission:HRMS employees_detail overall-view,Human Resource Dashboard overall-view'])->group(function () {
    Route::get('/count_employees', 'App\Http\Controllers\HRMS\EmployeDetails\EmployeDetailsController@count_employees');
    Route::get('searchemployee/{dep}/{loc}/{des}/{gen}/{sts}/{min}/{max}/{cnic}/{id}/{ests}', 'App\Http\Controllers\HRMS\HrController@searchemployee');
    Route::get('search_Employee_bynamecnic', 'App\Http\Controllers\HRMS\EmployeDetails\EmployeDetailsController@search_Employee_bynamecnic');
});
//this permmission is also used in different routes
Route::get('/getemployee_exp/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@getemployee_exp');

Route::middleware(['permission:HRMS employees_detail update-Employee-status,GRN Detail Create,Human Resource Dashboard overall-view'])->group(function () {
    Route::get('/success_array/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@success_array');
    Route::get('/suspend_emp/{id}/{date}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@suspend_emp');
});
Route::middleware(['permission:HRMS employees_detail  add_documents'])->group(function () {
    Route::post('update_emp_docs', 'App\Http\Controllers\HRMS\HrController@update_emp_docs');
    Route::get('/getemployee_documents/{id}', 'App\Http\Controllers\HRMS\HrController@getemployee_documents');
});
Route::middleware(['permission:HRMS warning_detail create_warning'])->group(function () {
    Route::post('submit_warning', 'App\Http\Controllers\HRMS\HrController@submit_warning');
    Route::get('/getwarnig_emp/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@getwarnig_emp');
    Route::get('/getwarnig_emp/{id}', 'App\Http\Controllers\HRMS\WarningDetails\CreateWarningController@getwarnig_emp');
});
Route::middleware(['permission:HRMS warning_detail overall-view'])->group(function () {
    Route::get('/count_warnings', 'App\Http\Controllers\HRMS\WarningDetails\WarningDetailsController@count_warnings');
    Route::get('/search_warnings/', 'App\Http\Controllers\HRMS\WarningDetails\WarningDetailsController@search_warnings');
    Route::get('filter_warnings/{loc}/{des}/{dept}', 'App\Http\Controllers\HRMS\WarningDetails\WarningDetailsController@filter_warnings');
    Route::get('/getwarnig_d/{id}', 'App\Http\Controllers\HRMS\HrController@getwarnig_d');
});
Route::middleware(['permission:HRMS Attendance Grace-periods overall-view'])->group(function () {
    Route::get('overall_grace_period', 'App\Http\Controllers\HRMS\HrController@overall_grace_period');
});
Route::middleware(['permission:HRMS Attendance Grace-periods update-Overall grace-periods'])->group(function () {

    Route::get('/search_by_grace_period/{id}', 'App\Http\Controllers\HRMS\HrController@search_by_grace_period');
    Route::post('update_ind_grace', 'App\Http\Controllers\HRMS\HrController@update_ind_grace');
    Route::post('update_overall_grace', 'App\Http\Controllers\HRMS\HrController@update_overall_grace');
});
Route::middleware(['permission:HRMS Attendance Live-Attendance overall-view'])->group(function () {
    Route::get('/attendance_detail', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@attendance_detail');
    Route::get('/count_today_attendance', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@count_today_attendance');
});
Route::middleware(['permission:HRMS Attendance Live-Attendance Sync. Attendance'])->group(function () {
    Route::get('get_machines', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@get_machines');
    Route::get('pull_m_attendance1/{id}', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@pull_m_attendance'); //Pull  attendance1
    Route::get('pull_m_attendance2/{id}', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@pull_m_attendance'); //Pull  attendance1
    Route::get('pull_m_attendance3/{id}', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@pull_m_attendance'); //Pull  attendance1
    Route::get('pull_m_attendance4/{id}', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@pull_m_attendance'); //Pull  attendance1
    Route::get('pull_m_attendance5/{id}', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@pull_m_attendance'); //Pull  attendance1
    Route::get('pull_m_attendance6/{id}', 'App\Http\Controllers\HRMS\AttendenceDetails\LiveAttendenceController@pull_m_attendance'); //Pull  attendance1

});
Route::middleware(['permission:HRMS Attendance Overall-Attendance overall-view'])->group(function () {

    Route::get('getattendance/{department}/{location}/{designation}/{opening}/{closing}/{code}', 'App\Http\Controllers\HRMS\AttendenceDetails\OverallAttendenceController@getattendance');
});
Route::middleware(['permission:HRMS Attendance Shifts view'])->group(function () {
    Route::get('/roster_detail', 'App\Http\Controllers\HRMS\HrController@roster_detail');
    Route::get('fetch_roster_detail/{id}', 'App\Http\Controllers\HRMS\HrController@fetch_roster_detail');
});
Route::middleware(['permission:HRMS HR-Reports  Employee-Overview-Reports'])->group(function () {
    Route::get('getemploydetail/{emp_department}/{emp_location}/{emp_designation}/{emp_emp_id}/{emp_type}/{emp_status}', 'App\Http\Controllers\HRMS\HrReports\EmployeeOverviewController@getemploydetail');
    Route::get('gethireemploy/{hire_department}/{hire_location}/{hire_designation}/{hire_emp_id}/{hire_start_date}/{hire_end_date}', 'App\Http\Controllers\HRMS\HrReports\EmployeeOverviewController@gethireemploy');
    Route::get('gethireemploycount/{hire_department}/{hire_location}/{hire_designation}/{hire_emp_id}/{hire_start_date}/{hire_end_date}', 'App\Http\Controllers\HRMS\HrReports\EmployeeOverviewController@gethireemploycount');
});
Route::middleware(['permission:HRMS HR-Reports  Employee-Attendance-Reports'])->group(function () {
    Route::get('getattendance_report/{department}/{location}/{designation}/{emp_id}/{opening}/{closing}', 'App\Http\Controllers\HRMS\HrReports\EmployeeAttendenceController@getattendance_report');
    Route::get('/getindatt_count/{id}', 'App\Http\Controllers\HRMS\HrReports\EmployeeAttendenceController@getindatt_count');
    Route::get('/getindatt_report/{id}', 'App\Http\Controllers\HRMS\HrReports\EmployeeAttendenceController@getindatt_report');
    Route::get('getattendance_summary', 'App\Http\Controllers\HRMS\HrReports\EmployeeAttendenceController@getattendance_summary');
    Route::get('/get_payroll_att_detail/', 'App\Http\Controllers\HRMS\HrReports\EmployeeAttendenceController@get_payroll_att_detail');
});
Route::middleware(['permission:HRMS HR-Reports  Employee-Leave-Reports'])->group(function () {
    Route::get('get_absent_detail/{opening}/{closing}/{location}/{dept}/{desig}/{emp_id}', 'App\Http\Controllers\HRMS\HrReports\EmployeeLeaveReportsController@get_absent_detail');
    Route::get('getleaveemploy/{dept}/{loc}/{des}/{emp_id}/{date_from}/{date_end}/{leave_type}', 'App\Http\Controllers\HRMS\HrReports\EmployeeLeaveReportsController@getleaveemploy');
    Route::get('filter_leaves1/{dept}/{loc}/{des}/{emp_id}/{leave}/', 'App\Http\Controllers\HRMS\HrReports\EmployeeLeaveReportsController@filter_leaves1');
});
Route::middleware(['permission:HRMS HR-Reports  Employee-Payroll-Reports'])->group(function () {
    Route::get('loan_advance_report/{start_date}/{end_date}/{dept}/{type}/{status}', 'App\Http\Controllers\HRMS\HrReports\EmployeePayrollReportsController@loan_advance_report');
    Route::get('arrears_report/{start_date}/{end_date}/{dept}', 'App\Http\Controllers\HRMS\HrReports\EmployeePayrollReportsController@arrears_report');
});
Route::middleware(['permission:HRMS leaves_detail overall-view'])->group(function () {
    Route::get('view_leave_type/', 'App\Http\Controllers\HRMS\HrController@view_leave_type');
    Route::get('/filter_leaves_byId/', 'App\Http\Controllers\HRMS\HrController@filter_leaves_byId');

    Route::get('filter_leaves/{leave}/{dept}/{loc}/{des}', 'App\Http\Controllers\HRMS\LeavesDetails\LeavesDashboardController@filter_leaves');
});
Route::middleware(['permission:HRMS leaves_detail apply-leave'])->group(function () {
    Route::get('selected_emp_leaves_blnc/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@selected_emp_leaves_blnc');  //Fetch rel leave balance
    Route::post('submit_leave', 'App\Http\Controllers\HRMS\LeavesDetails\SubmitLeavesController@submit_leave');
});
Route::middleware(['permission:HRMS leaves_detail overall-view-request'])->group(function () {
    Route::get('filter_leaves_requisitions/{leave}/{dept}/{loc}/{des}/{status}/{Mstatus}/{HRstatus}', 'App\Http\Controllers\HRMS\LeavesDetails\LeavesApplicationController@filter_leaves_requisitions');
    Route::get('search_Employee_leave/{keyword1}', 'App\Http\Controllers\HRMS\LeavesDetails\LeavesApplicationController@search_Employee_leave');
});
Route::middleware(['permission:HRMS leaves_detail assign-leaves'])->group(function () {
    Route::post('submit_emp_leaves', 'App\Http\Controllers\HRMS\LeavesDetails\SubmitLeavesController@submit_emp_leaves');
});
Route::middleware(['permission:HRMS Attendance Time-Adjustment overall-view'])->group(function () {
    Route::get('/TimeAdjustment_detail', 'App\Http\Controllers\HRMS\HrController@TimeAdjustment_detail'); //view Time Adjustment details
});
Route::middleware(['permission:HRMS Attendance Employees-Overtime overall-view'])->group(function () {
    Route::get('/get_column_name', 'App\Http\Controllers\HRMS\HrController@get_column_name');
    Route::get('users_overtime/{dep}', 'App\Http\Controllers\HRMS\HrController@users_overtime');
});
Route::middleware(['permission:HRMS Attendance Employees-Overtime Approve overtime'])->group(function () {
    Route::post('submit_Att_Approval', 'App\Http\Controllers\HRMS\HrController@submit_Att_Approval');
});

//Route::get('/attendance','App\Http\Controllers\HRMS\HRMS\HrController@roster_detail1');
Route::get('/sendEmail','App\Http\Controllers\HRMS\HrController@sendEmail');
//Route::get('/flushSession','App\Http\Controllers\HRMS\HRMS\HrController@flushSession');
