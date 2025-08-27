<?php

namespace App\Imports;

use App\Models\Emp_Profile;
use App\Models\Emp_Register;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class EmployeeImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $lastEmployee = DB::connection('sqlsrv2')->table("Emp_Profile")
                ->where('CompanyID', '=', $row['companyid'])
                ->orderBy('EmployeeID', 'desc')
                ->first();

            if ($lastEmployee && isset($lastEmployee->Employee_Code)) {
                $lastEmpCodeParts = explode("-", $lastEmployee->Employee_Code);
                $lastNumber = isset($lastEmpCodeParts[1]) ? intval($lastEmpCodeParts[1]) : 0;
                $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                $employeeCode = company_prefix()->company_prefix . '-' . $newNumber;
            } else {
                $employeeCode = company_prefix()->company_prefix . '-00001';
            }

            $empProfile = new Emp_Profile([
                'Name'           => $row['name'],
                'FatherHusband'  => $row['fatherhusband'],
                'Gender'         => $row['gender'],
                'Religion'       => $row['religion'],
                'Email'          => $row['email'],
                'Mobile'         => $row['mobile'],
                'Phone'          => $row['phone'],
                'CNIC'           => $row['cnic'],
                'CnicExpiry'     => $row['cnicexpiry'],
                'MaritalStatus'  => $row['maritalstatus'],
                'DOB'            => $row['dob'],
                'BloodGroup'     => $row['bloodgroup'],
                'City'           => $row['city'],
                'Address'        => $row['address'],
                'CreatedBy'      => $row['createdby'],
                'CreatedOn'      => $row['createdon'],
                'DeletedBy'      => $row['deletedby'],
                'DeletedOn'      => $row['deletedon'],
                'UpdatedBy'      => $row['updatedby'],
                'UpdatedOn'      => $row['updatedon'],
                'CompanyID'      => $row['companyid'],
                'Relation'       => $row['relation'],
                'Employee_Code'  => $employeeCode,
                'CompanyName'    => $row['companyname'],
                'Country'        => $row['country'],
            ]);
            $empProfile->setConnection('sqlsrv2');
            $empProfile->save();
            $employeeID = $empProfile->EmployeeID;
            // dd($employeeID);

            $empRegister = new Emp_Register([
                'EmployeeID'               => $employeeID,  // FK
                'EmployeeCode'             => $employeeCode,
                'CompanyID'                => $row['companyid'],
                'Department'               => $row['department'],
                'Designation'              => $row['designation'],
                'PostingCity'              => $row['postingcity'] ?? null,
                'CompanyEmail'             => $row['companyemail'] ?? null,
                'JoiningDate'              => $row['joiningdate'],
                'Status'                   => $row['status'] ?? 'Active',
                'ReportingTo'              => $row['reportingto'] ?? null,
                'CreatedBy'                => Auth::user()->name ?? 'System',
                'CreatedOn'                => now(),
                'DeletedBy'                => null,
                'DeletedOn'                => null,
                'ReportingTo2'             => $row['reportingto2'] ?? null,
                'JobShift'                 => $row['jobshift'] ?? null,
                'Salary'                   => $row['salary'] ?? 0,
                'Stipend'                  => $row['stipend'] ?? 0,
                'JobStatus'                => $row['jobstatus'] ?? null,
                'ProbationEnd'             => $row['probationend'] ?? null,
                'JobDescription'           => $row['jobdescription'] ?? null,
                'ChildCompany'             => $row['childcompany'] ?? null,
                'SendNotification'         => $row['sendnotification'] ?? 0,
                'AllowEmployeesAttendance' => $row['allowemployeesattendance'] ?? 1,
                'EportalAccess'            => $row['eportalaccess'] ?? 1,
                'ExpStatus'                => $row['expstatus'] ?? 0,
                'EduStatus'                => $row['edustatus'] ?? 0,
                'DocStatus'                => $row['docstatus'] ?? 0,
                'RegDate'                  => $row['regdate'] ?? null,
                'MethodType'               => $row['methodtype'] ?? null,
                'BankAccount'              => $row['bankaccount'] ?? null,
                'bank_name'                => $row['bank_name'] ?? null,
                'account_name'             => $row['account_name'] ?? null,
                'remarks'                  => $row['remarks'] ?? null,
                'CompanyName'              => $row['companyname'] ?? null,
                'SuspensionEnd'            => $row['suspensionend'] ?? null,
                'AllowAttendance'          => $row['allowattendance'] ?? 1,
                'ResignDate'               => $row['resigndate'] ?? null,
                'TerminateDate'            => $row['terminatedate'] ?? null,
                'Salary_Currency'          => $row['salary_currency'] ?? 'PKR',
                'AttendanceMachine'        => $row['attendancemachine'] ?? null,
            ]);
            $empRegister->setConnection('sqlsrv2');
            $empRegister->save();
        }
    }
}
