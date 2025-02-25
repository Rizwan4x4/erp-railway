<?php

namespace App\Repositories\HRMS\EmployeDetails;

use App\Contracts\Repository\HRMS\EmployeeDetails\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function searchEmployeeByNameCnic($keyword)
    {
        // Implement the logic for searching employees by name and CNIC
        try {
            $mainQuery = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Profile.EmployeeID', 'desc')
                ->select('Emp_Profile.*', 'Emp_Register.*')
                ->where('Emp_Profile.CompanyID', '=', company_id())
                ->where(function ($query) use ($keyword) {
                    $query->where('Emp_Profile.CNIC', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('Emp_Profile.Employee_Code', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('Emp_Profile.Phone', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('Emp_Profile.Mobile', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('Emp_Profile.Name', 'LIKE', '%' . $keyword . '%');
                });
            if (Session::get('hr_write') == 'true') {
                return $mainQuery->paginate(15);
            } else {
                $employeeIDs = array_column(reporting_team(), 'EmployeeID');
                return $mainQuery->whereIn('Emp_Register.EmployeeID', $employeeIDs)->paginate(15);
            }
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function searchEmployeeByFilter($department, $location, $designation, $gender, $status, $min_price, $max_price, $cnic, $emp_id, $emp_sts)
    {
        try {
            $mainQuery = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Profile.EmployeeID', 'desc')
                ->select('Emp_Profile.*', 'Emp_Register.*')
                ->where('Emp_Register.Department', 'LIKE', '%' . $department . '%')
                ->where('Emp_Register.PostingCity', 'LIKE', '%' . $location . '%')
                ->where('Emp_Register.Designation', 'LIKE', '%' . $designation . '%')
                ->where('Emp_Profile.Gender', 'LIKE', $gender . '%')
                ->where('Emp_Register.JobStatus', 'LIKE', '%' . $status . '%')
                ->where('Emp_Register.Salary', '>=', $min_price)
                ->where('Emp_Register.Salary', '<=', $max_price)
                ->where('Emp_Profile.CNIC', 'LIKE', '%' . $cnic . '%')
                ->where('Emp_Register.EmployeeCode', 'LIKE', '%' . $emp_id . '%')
                ->where('Emp_Register.Status', 'LIKE', '%' . $emp_sts . '%')
                ->where('Emp_Profile.CompanyID', '=', company_id());

            if (Session::get('hr_write') == 'true') {
                return $mainQuery->paginate(15);
            } else {
                $employeeIDs = array_column(reporting_team(), 'EmployeeID');
                return $mainQuery->whereIn('Emp_Register.EmployeeID', $employeeIDs)->paginate(15);
            }
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }


    }

    public function department_detail()
    {
        try {

            return DB::connection('sqlsrv2')->table('Employee_Dep_Comp')->where('companyID', '=', company_id())->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function overall_designation()
    {
        try {

            return DB::table('tb_designation')->select('designation_name', 'id')->where('company_id', '=', company_id())->orderBy('designation_name', 'asc')->get();


        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function overall_location()
    {
        try {

            return DB::table('tb_company_locations')->select('location_name')->where('company_id', '=', company_id())->orderBy('location_name', 'asc')->get();


        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function count_employees()
    {
        try {
            $allEmployees = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id());
            if (Session::get('hr_write') != 'true') {
                $allEmployees->whereIn('Emp_Register.EmployeeID', array_column(reporting_team(), 'EmployeeID'));
            }
            $result = $allEmployees->selectRaw('COUNT(*) as all_users')
                ->selectRaw('SUM(CASE WHEN Status = \'Registered\' THEN 1 ELSE 0 END) as active_users')
                ->selectRaw('SUM(CASE WHEN Status = \'Resigned\' THEN 1 ELSE 0 END) as inactive_users')
                ->selectRaw('SUM(CASE WHEN Status = \'Suspended\' THEN 1 ELSE 0 END) as suspended_users')
                ->selectRaw('SUM(CASE WHEN Status = \'Terminated\' THEN 1 ELSE 0 END) as terminated_users')
                ->selectRaw('SUM(CASE WHEN Status = \'\' THEN 1 ELSE 0 END) as incomplete_users')
                ->selectRaw('SUM(CASE WHEN JobStatus = \'Contract\' THEN 1 ELSE 0 END) as contractual_users')
                ->first();

            return [
                'all_users' => $result->all_users,
                'active_users' => $result->active_users,
                'inactive_users' => $result->inactive_users,
                'suspended_users' => $result->suspended_users,
                'terminated_users' => $result->terminated_users,
                'incomplete_users' => $result->incomplete_users,
                'contractual_users' => $result->contractual_users,
            ];

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function StipendDetail($id)
    {
        try {
            return DB::connection('sqlsrv2')->table('StipendDetail')->where('StipendDetail.EmpID', '=', $id)->where('StipendDetail.CompanyID', '=', company_id())->exists();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting stipendDetails: " . $e->getMessage());
        }
    }

    public function emp_detail($id)
    {
        try {
            return DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->join('StipendDetail', 'Emp_Profile.EmployeeID', 'StipendDetail.EmpID')->select('StipendDetail.StipendAmount', 'Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Emp details: " . $e->getMessage());
        }
    }

    public function Else_emp_detail($id)
    {
        try {
            return DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Emp details: " . $e->getMessage());
        }
    }

    public function getemployee_education($id)
    {

        try {

            return DB::connection('sqlsrv2')->table('Employee_Qualification')->where('EmployeeID', '=', $id)->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting education: " . $e->getMessage());
        }
    }

    public function getLoanSessionName($company_id)
    {
        try {

            return DB::connection('sqlsrv2')->table('HrSessions')
                ->select('SessionName')
                ->where('CompanyID', '=', company_id())
                ->where('CurrentSession', '=', '1')
                ->get('SessionName')
                ->map(function ($session) {
                    return $session->SessionName;
                })
                ->first();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getEmployeeTax($company_id, $emp_id)
    {
        try {

            return DB::connection('sqlsrv2')->table('PayrollTax')
                ->where('CompanyID', '=', company_id())
                ->where('EmployeeID', '=', $emp_id)
                ->sum('TaxAmount');

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getEmployeeInstallment($company_id, $emp_id, $loanSession)
    {
        try {

            return DB::connection('sqlsrv2')->table('LoanDetail')
                ->where('CompanyID', '=', company_id())
                ->where('EmployeeID', '=', $emp_id)
                ->where('InstallmentSession', '=', $loanSession)
                ->where('InstallmentStatus', '=', 'Unpaid')
                ->sum('InstallmentAmount');

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getEmployeeStipend($company_id, $emp_id, $update_date)
    {
        try {
            return DB::connection('sqlsrv2')->table('StipendDetail')
                ->where('CompanyID', '=', company_id())
                ->where('EmpID', '=', $emp_id)
                ->where('SessionEndDate', '<=', $update_date)
                ->where('Status', '=', 'Active')
                ->sum('StipendAmount');

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getEmployeeAllowance($company_id, $emp_id, $update_date)
    {
        try {

            return DB::connection('sqlsrv2')->table('PayrollAllowance')
                ->where('CompanyID', '=', company_id())
                ->where('EmployeeID', '=', $emp_id)
                ->where('SessionEndDate', '<=', $update_date)
                ->where('Status', '=', 'Approved')
                ->sum('AllowanceAmount');

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getEmployeeFuel($company_id, $emp_id)
    {
        try {

            return DB::connection('sqlsrv2')->table('FuelAllowance')
                ->where('CompanyID', '=', company_id())
                ->where('EmployeeID', '=', $emp_id)
                ->where('Status', '=', 'Approved')
                ->sum('FuelQuantity');

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getEmployeeJoiningDate($company_id, $emp_id)
    {
        try {

            return DB::connection('sqlsrv2')->table('Emp_Register')
                ->where('CompanyID', '=', company_id())
                ->where('EmployeeID', '=', $emp_id)
                ->value('JoiningDate');

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getwarnig_emp($id)
    {
        try {
            if ($id == 0) {
                $id = employee_id();
            }
            return DB::connection('sqlsrv2')->table('Warning_Letter')->where('EmployeeID', '=', $id)->get();


        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }


    }

    public function getemployee_exp($id)
    {

        try {
            return DB::connection('sqlsrv2')->table('Emp_Work_Experience')->where('EmployeeID', '=', $id)->get();


        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function getReportingEmployee($id)
    {
        try {
            $rep1 = $rep1code = $rep2 = $rep2code = "Not Assigned";
            $repid = DB::connection('sqlsrv2')->table('Emp_Register')->select('ReportingTo', 'ReportingTo2')
                ->where('CompanyID', '=', company_id())
                ->where('EmployeeID', '=', $id)
                ->first();
            $query = DB::connection('sqlsrv2')->table('Emp_Register')
                ->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode');
            $query1 = clone $query;
            if ($repid->ReportingTo != null) {
                $rep1Arr = $query1->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode')
                    ->where('Emp_Register.EmployeeID', '=', $repid->ReportingTo)->first();
                $rep1 = $rep1Arr->Name;
                $rep1code = $rep1Arr->EmployeeCode;
            }
            if ($repid->ReportingTo2 != null) {
                $rep2Arr = $query->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode')
                    ->where('Emp_Register.EmployeeID', '=', $repid->ReportingTo2)
                    ->first();
                $rep2 = $rep2Arr->Name;
                $rep2code = $rep2Arr->EmployeeCode;
            }
            return [
                'rep1' => $rep1,
                'rep1code' => $rep1code,
                'rep2' => $rep2,
                'rep2code' => $rep2code,
            ];
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function getEmployeeSuccessDetail($id)
    {

    //     try {
    //         if ($id == 0) {
    //             $id = employee_id();
    //         }
    //         return DB::connection('sqlsrv2')
    //             ->select(DB::raw("
    //     SELECT
    //         (
    //             SUM(CASE WHEN Address IS NOT NULL and Address != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN CNIC IS NOT NULL and CNIC != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN City IS NOT NULL and City != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN CompanyEmail IS NOT NULL and CompanyEmail != '' THEN 0 ELSE 0 END) +
    //             SUM(CASE WHEN DOB IS NOT NULL and DOB != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN Department IS NOT NULL and Department != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN Designation IS NOT NULL and Designation != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN EduStatus IS NOT NULL and EduStatus != '' THEN 17 ELSE 0 END) +
    //             SUM(CASE WHEN ExpStatus IS NOT NULL and ExpStatus != '' THEN 17 ELSE 0 END) +
    //             SUM(CASE WHEN Email IS NOT NULL and Email != '' THEN 0 ELSE 0 END) +
    //             SUM(CASE WHEN EmployeeCode IS NOT NULL and EmployeeCode != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN FatherHusband IS NOT NULL and FatherHusband != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN Gender IS NOT NULL and Gender != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN JobDescription IS NOT NULL and JobDescription !='' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN MaritalStatus IS NOT NULL and MaritalStatus != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN Mobile IS NOT NULL and Mobile != '' THEN 4 ELSE 0 END) +
    //             SUM(CASE WHEN Photo IS NOT NULL and Photo != '' and Photo != 'pro.png' THEN 6 ELSE 0 END) +
    //             SUM(CASE WHEN ReportingTo IS NOT NULL and ReportingTo != '' THEN 4 ELSE 0 END)
    //         ) as profile_completion
    //     FROM Emp_Profile
    //     JOIN Emp_Register ON Emp_Profile.EmployeeID = Emp_Register.EmployeeID
    //     WHERE Emp_Profile.EmployeeID = $id
    // "));

        try {
            if ($id == 0) {
                $id = employee_id();
            }
            return DB::connection('sqlsrv2')
                ->select(DB::raw("
                SELECT
                    (
                        SUM(CASE WHEN Address IS NOT NULL AND CAST(Address AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN CNIC IS NOT NULL AND CAST(CNIC AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN City IS NOT NULL AND CAST(City AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN CompanyEmail IS NOT NULL AND CAST(CompanyEmail AS VARCHAR(MAX)) != '' THEN 0 ELSE 0 END) +
                        SUM(CASE WHEN DOB IS NOT NULL AND CAST(DOB AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN Department IS NOT NULL AND CAST(Department AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN Designation IS NOT NULL AND CAST(Designation AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN EduStatus IS NOT NULL AND CAST(EduStatus AS VARCHAR(MAX)) != '' THEN 17 ELSE 0 END) +
                        SUM(CASE WHEN ExpStatus IS NOT NULL AND CAST(ExpStatus AS VARCHAR(MAX)) != '' THEN 17 ELSE 0 END) +
                        SUM(CASE WHEN Email IS NOT NULL AND CAST(Email AS VARCHAR(MAX)) != '' THEN 0 ELSE 0 END) +
                        SUM(CASE WHEN EmployeeCode IS NOT NULL AND CAST(EmployeeCode AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN FatherHusband IS NOT NULL AND CAST(FatherHusband AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN Gender IS NOT NULL AND CAST(Gender AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN JobDescription IS NOT NULL AND CAST(JobDescription AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN MaritalStatus IS NOT NULL AND CAST(MaritalStatus AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN Mobile IS NOT NULL AND CAST(Mobile AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END) +
                        SUM(CASE WHEN Photo IS NOT NULL AND CAST(Photo AS VARCHAR(MAX)) != '' AND Photo != 'pro.png' THEN 6 ELSE 0 END) +
                        SUM(CASE WHEN ReportingTo IS NOT NULL AND CAST(ReportingTo AS VARCHAR(MAX)) != '' THEN 4 ELSE 0 END)
                    ) as profile_completion
                FROM Emp_Profile
                JOIN Emp_Register ON Emp_Profile.EmployeeID = Emp_Register.EmployeeID
                WHERE Emp_Profile.EmployeeID = $id
            "));
        }
        catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }


    public function updateEmployeeResignedStatus($id, $resignDate)
    {
        try {
            $result = DB::connection('sqlsrv2')->update('update Emp_Register set Status=?, ResignDate=? where EmployeeID =?', ["Resigned", $resignDate, $id]);

            return $result;
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function createFinalSettlement($id, $resignDate)
    {
        try {
            $updateDate = long_date();

            $findSessionClosed = DB::connection('sqlsrv2')->table('HrSessions')
                ->where('CompanyID', '=', company_id())
                ->where('CurrentSession', '=', 1)
                ->get();

            $sessionName = null;
            foreach ($findSessionClosed as $findSession) {
                $sessionName = $findSession->SessionName;
            }

            DB::connection('sqlsrv2')->insert("INSERT INTO FinalSettlement(CompanyID, EmployeeID, SessionName, ResignOn, DStatus, MStatus, HrStatus, Status, FStatus, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $id, $sessionName, $resignDate, 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', username(), $updateDate]);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function getEmployeeDetails($id)
    {
        try {
            $employeeDetail = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')
                ->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)
                ->first();

            return $employeeDetail;
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }


    public function registered($id)
    {
        try {
            $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set Status=?,RegDate=? where EmployeeID =?', ["Registered", '', $id]);

            if ($result5) {
                DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('EmployeeID', $id)->where('Status', '!=', 'Approved')->delete();
                return DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                    ->where('Emp_Profile.EmployeeID', '=', $id)->get();

            }
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function selected_emp_leaves($id)
    {
        try {
            $company_id = company_id();
            if ($id == 0) {
                $id = employee_id();
            }
            return DB::connection('sqlsrv2')->table('leave_Requisition')->orderBy('StartDate', 'desc')->select('leave_Requisition.*')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function selected_emp_leaves_blnc($id)
    {
        try {
            $company_id = company_id();
            $this_year = date("Y");
            if ($id == 0) {
                $id = employee_id();
            }
            return DB::connection('sqlsrv2')->table('EmpLeave')->orderBy('LeaveType', 'asc')->select('EmpLeave.*')->where('CompanyID', '=', company_id())->where('CreatedOn', 'like', '%' . $this_year . '%')->where('EmployeeID', '=', $id)->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function selected_emp_timeTable($id)
    {
        try {
            $company_id = company_id();
            if ($id == 0) {
                $id = employee_id();
            }
            return DB::connection('sqlsrv2')->table('Emp_Register')
                ->join('Roasters', 'Emp_Register.JobShift', '=', 'Roasters.RosterID')
                ->orderBy('Roasters.RosterID', 'asc')
                ->select('Roasters.*')
                ->where('Roasters.CompanyID', '=', company_id())->where('Emp_Register.EmployeeID', '=', $id)->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function findSession($company_id)
    {
        try {
            return DB::connection('sqlsrv2')->table('HrSessions')
                ->where('CompanyID', '=', $company_id)
                ->where('CurrentSession', '=', 1)
                ->first();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function fetch_emp_arrears($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return DB::connection('sqlsrv2')->table('PayrollArrears')->where('EmployeeID', '=', $id)->where('CompanyID', '=', company_id())->orderBy('ArrearsID', 'desc')->get();

        } catch (QueryException $e) {

            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function fetch_emp_bonuses($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return DB::connection('sqlsrv2')->table('PayrollBonuses')->where('EmployeeID', '=', $id)->where('CompanyID', '=', company_id())->orderBy('BonusID', 'desc')->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function checkEmpAllowanceExistence($company_id, $emp_id)
    {
        try {
            return DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $emp_id)->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function fetchEmpAllowances($company_id, $emp_id)
    {
        try {
            return DB::connection('sqlsrv2')->table('PayrollAllowance')
                ->where('CompanyID', '=', $company_id)
                ->where('EmployeeID', '=', $emp_id)
                ->orderBy('AllowanceID', 'desc')
                ->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function salaries_history($emp_id)
    {
        try {
            return DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $emp_id)->orderBy('DistributionID', 'desc')->paginate(5);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function fetch_employee_loans($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return DB::connection('sqlsrv2')->table('LoanRequisition')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->orderBy('LoanId', 'desc')->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function fetch_emp_fine($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return DB::connection('sqlsrv2')->table('FineDetail')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->orderBy('FineId', 'desc')->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function fetch_emp_dues($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return DB::connection('sqlsrv2')->table('PayrollDues')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->orderBy('DuesID', 'desc')->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }


    public function updateEmployeeStatus($id, $status, $terminateDate)
    {
        try {
            return DB::connection('sqlsrv2')->update('update Emp_Register set Status=?, TerminateDate=? where EmployeeID =?', [$status, $terminateDate, $id]);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function insertFinalSettlement($company_id, $id, $session_name, $date, $username, $update_date)
    {
        try {
            return DB::connection('sqlsrv2')->insert("INSERT INTO FinalSettlement(CompanyID, EmployeeID, SessionName, ResignOn, DStatus, MStatus, HrStatus, Status, FStatus, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?)", [$company_id, $id, $session_name, $date, 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', $username, $update_date]);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function insertActivityLog($company_id, $username, $userFullName, $employeeName, $eventStatus, $description, $activityTime)
    {
        try {
            return DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [$company_id, $username, $userFullName, $eventStatus, $description, $activityTime]);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function fetchEmployeeDetails($company_id, $id)
    {
        try {
            return DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')
                ->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)
                ->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function updateEmployeeStatusAndDate($id, $suspensionEnd, $status, $regDate)
    {
        try {
            return DB::connection('sqlsrv2')->update('update Emp_Register set SuspensionEnd=?, Status=?, RegDate=? where EmployeeID =?', [$suspensionEnd, $status, $regDate, $id]);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }

    }

    public function fetchFullName($id)
    {
        try {
            return DB::connection('sqlsrv2')->table('Emp_Profile')
                ->select('Name')
                ->where('EmployeeID', '=', $id)
                ->first();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

}
