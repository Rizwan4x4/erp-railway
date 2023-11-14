<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

Route::get('session_detail_dist', 'App\Http\Controllers\HRMS\HrController@session_detail_dist');
Route::get('session_wise_cashdistribution/{session}/{location}', 'App\Http\Controllers\HRMS\HrController@session_wise_cashdistribution');
Route::get('session_wise_cashdistribution_count/{session}/{location}', 'App\Http\Controllers\HRMS\HrController@session_wise_cashdistribution_count');
Route::get('session_wise_bankdistribution_count/{session}/{location}', 'App\Http\Controllers\HRMS\HrController@session_wise_bankdistribution_count');
Route::post('update_ind_allowance', 'App\Http\Controllers\HRMS\HrController@update_ind_allowance');
//Payroll loans
Route::get('loan_report/{id}','App\Http\Controllers\HRMS\HrController@loan_report');
Route::get('fetch_employee_dtl/{id}', 'App\Http\Controllers\HRMS\HrController@fetch_employee_dtl');  //fetch Employee detail for loan and advance
Route::post('loan','App\Http\Controllers\HRMS\HrController@add_loan_req')->middleware('permission:Payroll Apply for loan');  //Add loan
Route::get('/fetch_all_loans', 'App\Http\Controllers\HRMS\HrController@fetch_all_loans');  //View loans
Route::get('/fetch_filtered_loans/{id}','App\Http\Controllers\HRMS\HrController@fetch_filtered_loans')->middleware('permission:Payroll Loan and Advance');
Route::get('fetch_emp_upSts/{id}', 'App\Http\Controllers\HRMS\HrController@fetch_rel_loan')->middleware('permission:Payroll Actions for loan'); //Fetch rel loan
Route::get('/fetch_all_installments', 'App\Http\Controllers\HRMS\HrController@fetch_all_installments')->middleware('permission:Payroll Loan and Advance');  //View installments
Route::post('update_loan_m_sts', 'App\Http\Controllers\HRMS\HrController@update_loan_m_sts');  //update loan manager status
Route::post('pay_loan', 'App\Http\Controllers\HRMS\HrController@pay_loan'); //Pay loan
Route::get('/overall_employees_pr','App\Http\Controllers\HRMS\HrController@overall_employees_payroll')->middleware('permission:Payroll Final Settlement');
Route::get('filter_loans/{from}/{to}/{dept}/{desig}/{name}','App\Http\Controllers\HRMS\HrController@filter_loan_requisitions');
Route::get('/search_arrears','App\Http\Controllers\HRMS\HrController@search_arrears')->middleware('permission:Payroll Arrears');

Route::get('settlement_slip/{id}','App\Http\Controllers\ReportsController@settlement_slip');
Route::get('fetch_pending_loan/{id}', 'App\Http\Controllers\HRMS\HrController@fetch_pending_loan');  //fetch Employee loan and advance
Route::post('return_loan', 'App\Http\Controllers\HRMS\HrController@return_loan');  //Return loan
//Route::post('update_loan_m_sts', 'App\Http\Controllers\HRMS\HrController@update_loan_m_sts');  //update loan manager status

Route::get('fetch_fuel_limit/{id}','App\Http\Controllers\HRMS\HrController@fetch_fuel_limit')->middleware('permission:Fuel setting update actions');
Route::get('/session_not_in_dist/', 'App\Http\Controllers\HRMS\HrController@session_not_in_dist');
    // ->middleware('permission:Payroll Arrears')
    // ->middleware('permission:Payroll Bonuses')
    // ->middleware('permission:Payroll Allowances')
    // ->middleware('permission:Payroll Fuel Allowances');
Route::post('update_fuel_limit', 'App\Http\Controllers\HRMS\HrController@update_fuel_limit')->middleware('permission:Fuel setting update actions');
Route::post('update_emp_dist_salary','App\Http\Controllers\HRMS\HrController@update_emp_dist_salary')->middleware('permission:Payroll Update Status by Paying Salary');
Route::get('/overall_cities','App\Http\Controllers\HRMS\HrController@overall_cities');
Route::get('/overall_payroll_employees','App\Http\Controllers\HRMS\HrController@overall_payroll_employees');
Route::get('/fetch_emp_detail/{id}','App\Http\Controllers\HRMS\HrController@fetch_emp_detail')->middleware('permission:Payroll Indvisual employee Salary Details');
Route::post('submit_payroll_detail','App\Http\Controllers\HRMS\HrController@submit_payroll_detail')->middleware('permission:Payroll Update Indvisual employee Salary');
Route::get('filter_employees/{emp_id}/{dept}/{loc}/{des}','App\Http\Controllers\HRMS\HrController@filter_employees')->middleware('permission:Payroll employee Salary Details');
Route::get('update_payroll_status/{id}','App\Http\Controllers\HRMS\HrController@update_payroll_status')->middleware('permission:HR Controller Session Detail Status');
Route::get('fetch_payroll_generation','App\Http\Controllers\HRMS\HrController@fetch_payroll_generation');
Route::get('getpayroll_gen_report/{emp_id}/{department}/{designation}/{status}','App\Http\Controllers\HRMS\HrController@getpayroll_gen_report');
Route::get('/search_payroll/','App\Http\Controllers\HRMS\HrController@search_payroll')->middleware('permission:Payroll Generated Salaries');

Route::get('/find_session/','App\Http\Controllers\HRMS\HrController@find_session');
Route::get('/session_pre_dis/','App\Http\Controllers\HRMS\HrController@session_pre_dis')->middleware('permission:Payroll Generated Salaries');
Route::get('/search_payroll_bonus/','App\Http\Controllers\HRMS\HrController@search_payroll_bonus');
Route::get('/search_EmpFuelAllowance/','App\Http\Controllers\HRMS\HrController@search_EmpFuelAllowance');
Route::get('/find_payroll_emp/{id}','App\Http\Controllers\HRMS\HrController@find_payroll_emp')->middleware('permission:Payroll Add deduction and overtime');
Route::post('update_payroll_ind_status','App\Http\Controllers\HRMS\HrController@update_payroll_ind_status')->middleware('permission:Payroll Add deduction and overtime');
Route::get('/proceedhrapproval','App\Http\Controllers\HRMS\HrController@proceedhrapproval')->middleware('permission:Payroll Proceed to HR approval');

Route::get('/proceedfinanceapproval','App\Http\Controllers\HRMS\HrController@proceedfinanceapproval')->middleware('permission:Payroll Proceed to Finance Approval');
Route::get('/search_hr_approval/','App\Http\Controllers\HRMS\HrController@search_hr_approval')->middleware('permission:Payroll HR Approval');
Route::get('get_dept_bycompany/{company}','App\Http\Controllers\HRMS\HrController@get_dept_bycompany');
Route::get('/find_payroll_emp_hrapproval/{id}','App\Http\Controllers\HRMS\HrController@find_payroll_emp_hrapproval');
Route::post('update_payroll_ind_status_hrapproval','App\Http\Controllers\HRMS\HrController@update_payroll_ind_status_hrapproval');
Route::get('fetch_payroll_finance_approval','App\Http\Controllers\HRMS\HrController@fetch_payroll_finance_approval');

Route::get('/find_payroll_emp_financeapproval/{id}','App\Http\Controllers\HRMS\HrController@find_payroll_emp_financeapproval');
Route::post('update_payroll_ind_status_financeapproval','App\Http\Controllers\HRMS\HrController@update_payroll_ind_status_financeapproval');
Route::get('/fetch_distribution_cash_payabale/{department_name}','App\Http\Controllers\HRMS\HrController@fetch_distribution_cash_payabale')->middleware('permission:Payroll Generate Salary Slip');
Route::get('/fetch_distribution_bank_payabale/','App\Http\Controllers\HRMS\HrController@fetch_distribution_bank_payabale')->middleware('permission:Payroll Salary Distribution');
Route::get('/proceeddistapproval','App\Http\Controllers\HRMS\HrController@proceeddistapproval')->middleware('permission:Payroll Proceed for distribution');
Route::get('/view_emp_salary_slip/{id}','App\Http\Controllers\HRMS\HrController@view_emp_salary_slip')->middleware('permission:Payroll View Salary Slip');
Route::get('/generate_slip/{emp_id}/{slip_id}/{emp_code}','App\Http\Controllers\HRMS\HrController@generate_slip');
Route::get('/generate_slip1/{emp_id}/{slip_id}/{emp_code}/{session}','App\Http\Controllers\HRMS\HrController@generate_slip1');
Route::get('hr/totalEmp_SalaryCount', 'App\Http\Controllers\HRMS\HrController@totalEmp_SalaryCount')->middleware('permission:Payroll Salary Distribution');
Route::get('getemploycashdetail/{emp_department}/{emp_username}/{session}/{status}','App\Http\Controllers\HRMS\HrReports\EmployeePayrollReportsController@getemploycashdetail');
Route::get('getemployeecashsum/{emp_department}/{emp_username}/{session}/{status}','App\Http\Controllers\HRMS\HrReports\EmployeePayrollReportsController@getemployeecashsum');

Route::get('getemployeebanksum/{emp_department}/{emp_username}/{session}/{status}','App\Http\Controllers\HRMS\HrReports\EmployeePayrollReportsController@getemployeebanksum');
Route::post('submit_arrears', 'App\Http\Controllers\HRMS\HrController@submit_arrears')->middleware('permission:Payroll Appply Arrears');
Route::post('submit_EmpFuelAllowance', 'App\Http\Controllers\HRMS\HrController@submit_EmpFuelAllowance')->middleware('permission:Payroll Add Fuel Allowance');
Route::get('/fetch_payroll_arrears','App\Http\Controllers\HRMS\HrController@fetch_payroll_arrears');
Route::get('/fetch_EmpFuelAllowance','App\Http\Controllers\HRMS\HrController@fetch_EmpFuelAllowance')->middleware('permission:Payroll Fuel Allowances');
Route::get('/fetch_FuelRate','App\Http\Controllers\HRMS\HrController@fetch_FuelRate')->middleware('permission:Payroll Fuel Allowances');
Route::get('approve_arrears/{id}', 'App\Http\Controllers\HRMS\HrController@approve_arrears');
Route::get('find_payroll_arrear/{id}', 'App\Http\Controllers\HRMS\HrController@find_payroll_arrear');
Route::post('update_ind_arrears', 'App\Http\Controllers\HRMS\HrController@update_ind_arrears')->middleware('permission:Payroll Arrears Action');
Route::post('submit_bonus', 'App\Http\Controllers\HRMS\HrController@submit_bonus')->middleware('permission:Payroll Appply Bonuses');
Route::get('/fetch_payroll_bonus','App\Http\Controllers\HRMS\HrController@fetch_payroll_bonus')->middleware('permission:Payroll Bonuses');
Route::get('approve_bonus/{id}', 'App\Http\Controllers\HRMS\HrController@approve_bonus');
Route::get('find_payroll_bonus/{id}', 'App\Http\Controllers\HRMS\HrController@find_payroll_bonus');
Route::get('find_EmpFuelAllowance/{id}', 'App\Http\Controllers\HRMS\HrController@find_EmpFuelAllowance');
Route::post('update_ind_bonus', 'App\Http\Controllers\HRMS\HrController@update_ind_bonus');
Route::post('update_EmpFuelAllowance', 'App\Http\Controllers\HRMS\HrController@update_EmpFuelAllowance');
Route::post('update_FuelRate', 'App\Http\Controllers\HRMS\HrController@update_FuelRate')->middleware('permission:Payroll Update Fuel Rates');
Route::post('submit_dues', 'App\Http\Controllers\HRMS\HrController@submit_dues')->middleware('permission:Payroll Apply Dues');
Route::get('/fetch_payroll_dues','App\Http\Controllers\HRMS\HrController@fetch_payroll_dues')->middleware('permission:Payroll Apply Dues');
Route::get('find_payroll_dues/{id}', 'App\Http\Controllers\HRMS\HrController@find_payroll_dues');
Route::post('update_ind_dues', 'App\Http\Controllers\HRMS\HrController@update_ind_dues');
Route::get('approve_dues/{id}', 'App\Http\Controllers\HRMS\HrController@approve_dues');
Route::get('/fetch_payroll_allowance','App\Http\Controllers\HRMS\HrController@fetch_payroll_allowance')->middleware('permission:Payroll Allowances');

Route::post('submit_allowance', 'App\Http\Controllers\HRMS\HrController@submit_allowance')->middleware('permission:Payroll Appply Allowance');
Route::get('approve_allowance/{id}', 'App\Http\Controllers\HRMS\HrController@approve_allowance');
Route::get('find_payroll_allowance/{id}', 'App\Http\Controllers\HRMS\HrController@find_payroll_allowance');
Route::get('allowance_arrears','App\Http\Controllers\HRMS\HrController@allowance_arrears')->middleware('permission:Payroll Apply Arrears and Allow|Payroll Proceed for distribution');
Route::get('/salaries_history/{emp_id}','App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@salaries_history'); //Fetch paid salary of single employee
Route::get('/fetch_employee_loans/{id}','App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@fetch_employee_loans'); //Fetch loans of single employee
Route::get('/fetch_emp_fine/{id}','App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@fetch_emp_fine'); //Fetch fine of single employee
Route::get('/fetch_emp_dues/{id}','App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@fetch_emp_dues'); //Fetch dues of single employee
Route::get('/fetch_emp_arrears/{id}','App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@fetch_emp_arrears'); //Fetch arrears of single employee
Route::get('/fetch_emp_bonuses/{id}','App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@fetch_emp_bonuses'); //Fetch bonuses of single employee
Route::get('/fetch_emp_allowances/{id}','App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@fetch_emp_allowances'); //Fetch allowances of single employee
Route::get('salary_report/{startdate}','App\Http\Controllers\HRMS\HrController@salary_report');
Route::get('/fetch_payroll_tax','App\Http\Controllers\HRMS\HrController@fetch_payroll_tax');
Route::post('submit_tax', 'App\Http\Controllers\HRMS\HrController@submit_tax');
Route::get('find_payroll_tax/{id}', 'App\Http\Controllers\HRMS\HrController@find_payroll_tax');
Route::post('update_ind_tax', 'App\Http\Controllers\HRMS\HrController@update_ind_tax');
Route::get('/search_payroll_tax/','App\Http\Controllers\HRMS\HrController@search_payroll_tax');
Route::get('salary_report/','App\Http\Controllers\HRMS\HrController@salary_report');
Route::get('/fetch_fuel_allowance','App\Http\Controllers\HRMS\HrController@fetch_fuel_allowance')->middleware('permission:Fuel Setting');
Route::post('submit_fuel_allowance', 'App\Http\Controllers\HRMS\HrController@submit_fuel_allowance')->middleware('permission:Fuel assign fuel allowance');
Route::post('insert_bills','App\Http\Controllers\HRMS\HrController@insert_fuelbill')->middleware('permission:Fuel new bill');

Route::get('/TotalFuelAmount','App\Http\Controllers\HRMS\HrController@TotalFuelAmount')->middleware('permission:Fuel Setting,Fuel bills');
Route::get('/employee_fuelDetail/{id}','App\Http\Controllers\HRMS\HrController@employee_fuelDetail')->middleware('permission:Fuel new bill');
Route::get('/accounts/bills_detail/','App\Http\Controllers\HRMS\HrController@fuel_bills_detail')->middleware('permission:Fuel Setting,Fuel bills');
Route::get('approve_fuel_allowance/{id}', 'App\Http\Controllers\HRMS\HrController@approve_fuel_allowance');
Route::post('submit_stipend', 'App\Http\Controllers\HRMS\HrController@submit_stipend')->middleware('permission:Payroll apply Stipend');
Route::get('/fetch_payroll_stipend','App\Http\Controllers\HRMS\HrController@fetch_payroll_stipend')->middleware('permission:Payroll employee Stipend Details');
Route::get('update_stipend_status/{id}/{sts}', 'App\Http\Controllers\HRMS\HrController@update_stipend_status')->middleware('permission:Payroll active or disabel Stipend status');
Route::post('update_stipend', 'App\Http\Controllers\HRMS\HrController@update_stipend')->middleware('permission:Payroll update Stipend');
Route::get('/search_stipend','App\Http\Controllers\HRMS\HrController@search_stipend');
Route::get('dist_byName','App\Http\Controllers\HRMS\HrController@dist_byName');
Route::get('pendingdist_byName','App\Http\Controllers\HRMS\HrController@pendingdist_byName')->middleware('permission:Payroll Pending Salaries');
Route::get('accounts/fetch_distpending_salaries','App\Http\Controllers\HRMS\HrController@fetch_distpending_salaries')->middleware('permission:Payroll Pending Salaries');
Route::get('accounts/fetch_distpending_salaries1/{session}','App\Http\Controllers\HRMS\HrController@fetch_distpending_salaries1');
Route::get('accounts/fetch_distpending_salaries2/{code}/{session}','App\Http\Controllers\HRMS\HrController@fetch_distpending_salaries2');


//Route::get('search_finance_approval','App\Http\Controllers\HRMS\HrController@pending_salariesdetail');
Route::get('installments_detail/{id}','App\Http\Controllers\HRMS\HrController@installments_detail')->middleware('permission:Payroll Actions for loan');
Route::post('skip_installment','App\Http\Controllers\HRMS\HrController@skip_installment');
Route::post('waiveoff_installment','App\Http\Controllers\HRMS\HrController@waiveoff_installment');

Route::get('/count_settlements','App\Http\Controllers\HRMS\HrController@count_settlements')->middleware('permission:Payroll Final Settlement');
Route::get('single_welfarepayroll/{id}','App\Http\Controllers\HRMS\HrController@single_welfarepayroll');
Route::post('pay_welfareallowance', 'App\Http\Controllers\HRMS\HrController@pay_welfareallowance');
Route::get('approve_welfareallowance/{id}', 'App\Http\Controllers\HRMS\HrController@approve_welfareallowance');
Route::post('submit_welfareallowance', 'App\Http\Controllers\HRMS\HrController@submit_welfareallowance')->middleware('permission:Payroll Apply Welfare Allowance');
Route::get('search_welfarepayroll','App\Http\Controllers\HRMS\HrController@search_welfarepayroll')->middleware('permission:Payroll Welfare Allowances');
//Route::get('fetch_payroll_welfareallowance','App\Http\Controllers\HRMS\HrController@fetch_payroll_welfareallowance');
Route::get('welfare_allowanceslip/{id}','App\Http\Controllers\HRMS\HrController@welfare_allowanceslip')->middleware('permission:Payroll Allowance slip action');

Route::get('/getemployee_Saldetails/{id}','App\Http\Controllers\HRMS\HrController@getemployee_Saldetails');
Route::get('/getemployee_Loandetails/{id}','App\Http\Controllers\HRMS\HrController@getemployee_Loandetails');
Route::get('fetch_employee_amount/{id}', 'App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController@fetch_employee_amount');

Route::get('salary_state', 'App\Http\Controllers\HRMS\HrController@salary_state')->middleware(['permission:Payroll Generated Salaries', 'permission:Payroll HR Approval']);

Route::middleware(['permission:Payroll Apply Inst and Fines'])->group(function () {

    Route::get('search_finance_approval','App\Http\Controllers\HRMS\HrController@search_finance_approval');
    Route::get('chech_installments','App\Http\Controllers\HRMS\HrController@chech_installments');
    Route::get('fetchall_finance_approval','App\Http\Controllers\HRMS\HrController@fetchall_finance_approval');
});
Route::middleware(['permission:Payroll Final Settlement Action'])->group(function () {
    Route::post('add_settlement', 'App\Http\Controllers\HRMS\HrController@add_settlement');
    Route::get('/delete_settlement/{id}', 'App\Http\Controllers\HRMS\HrController@delete_settlement');
});

Route::get('/delete_allowance/{id}', 'App\Http\Controllers\Payroll\AllowanceController@delete_allowance');
