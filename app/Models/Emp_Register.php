<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emp_Register extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'Emp_Register';

    public $timestamps = false;

    protected $primaryKey = 'EmployeeID';

    protected $fillable = [
        'EmployeeID',
        'EmployeeCode',
        'CompanyID',
        'Department',
        'Designation',
        'PostingCity',
        'CompanyEmail',
        'JoiningDate',
        'Status',
        'ReportingTo',
        'CreatedBy',
        'CreatedOn',
        'DeletedBy',
        'DeletedOn',
        'ReportingTo2',
        'JobShift',
        'Salary',
        'Stipend',
        'JobStatus',
        'ProbationEnd',
        'JobDescription',
        'ChildCompany',
        'SendNotification',
        'AllowEmployeesAttendance',
        'EportalAccess',
        'ExpStatus',
        'EduStatus',
        'DocStatus',
        'RegDate',
        'MethodType',
        'BankAccount',
        'bank_name',
        'account_name',
        'remarks',
        'CompanyName',
        'SuspensionEnd',
        'AllowAttendance',
        'ResignDate',
        'TerminateDate',
        'Salary_Currency',
        'AttendanceMachine',
    ];
}
