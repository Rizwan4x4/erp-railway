<?php

namespace App\Repositories\HRMS\WarningDetails;

use App\Contracts\Repository\HRMS\WarningDetails\CreateWarningRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;
class CreateWarningRepository implements CreateWarningRepositoryInterface
{


    public function warning_reasons(){
        try{

            return DB::connection('sqlsrv2')->table('Warning_Reason')->where('CompanyID','=',company_id())->get();

            } catch (QueryException $e) {
                // Throw a custom exception with the original message
                throw new ErrorException("Error getting warning reasons: " . $e->getMessage());
            }

            }
            public function getEmployeeDetail( $emp_id)
            { try{
                return DB::connection('sqlsrv2')
                    ->table('Emp_Profile')
                    ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                    ->select('Emp_Profile.*', 'Emp_Register.*')
                    ->where('Emp_Register.EmployeeCode', '=', $emp_id)
                    ->where('Emp_Profile.CompanyID', '=', company_id())
                    ->get();

             } catch (QueryException $e) {
                        // Throw a custom exception with the original message
                        throw new ErrorException("Error getting employe detail: " . $e->getMessage());
                    }
            }
            public function getEmployeeID($emp_code)
            { try {
                return DB::connection('sqlsrv2')
                    ->table('Emp_Register')
                    ->select('EmployeeID')
                    ->where('EmployeeCode', '=', $emp_code)
                    ->where('CompanyID', '=', company_id())
                    ->first();
                } catch (QueryException $e) {
                    // Throw a custom exception with the original message
                    throw new ErrorException("Error getting available value: " . $e->getMessage());
                }
            }
            public function checkIfWarningLetterExists( $emp_id)
{ try {
    return DB::connection('sqlsrv2')
        ->table('Warning_Letter')
        ->where('CompanyID', '=', company_id())
        ->where('EmployeeID', '=', $emp_id)
        ->exists();
    } catch (QueryException $e) {
        // Throw a custom exception with the original message
        throw new ErrorException("Error getting available value: " . $e->getMessage());
    }
}
public function getWarningLetter( $emp_id)
{ try {
    return DB::connection('sqlsrv2')
        ->table('Warning_Letter')
        ->where('CompanyID', '=', company_id())
        ->where('EmployeeID', '=', $emp_id)
        ->orderBy('WarningType', 'desc')
        ->first();
    } catch (QueryException $e) {
        // Throw a custom exception with the original message
        throw new ErrorException("Error getting available value: " . $e->getMessage());
    }
}


            public function insertWarningLetter($data)
            {
                try{
               return DB::connection('sqlsrv2')->insert(
                    'INSERT INTO Warning_Letter(CompanyID, DateIssued, EmployeeID, EmployeeName, Department, Designation, Location, WarningType, ReasonSubject, CreatedBy, CreatedOn, WarningContent) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',
                    $data
                );
               }   catch (QueryException $e) {
                    // Throw a custom exception with the original message
                    throw new ErrorException("Error getting warning Letter: " . $e->getMessage());
                }
            }

            public function updateEmployeeStatus($emp_id, $warning_type)
            {
                try{
               return DB::connection('sqlsrv2')->update(
                    'UPDATE Emp_Register SET Status = ? WHERE EmployeeID = ? AND CompanyID = ?',
                    [$warning_type, $emp_id,  company_id()]
                );
            }catch (QueryException $e) {
                    // Throw a custom exception with the original message
                    throw new ErrorException("Error getting Employe Status: " . $e->getMessage());
                }
            }

            public function insertActivityLog($data)
            {
                DB::insert(
                    "INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) VALUES (?,?,?,?,?,?)",
                    $data
                );
            }
            public function getwarnig_emp($id){
                if ($id == 0 || $id == null || $id == '') {
                    $id = Session::get('employee_id');
                } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                    return;
                }
               return DB::connection('sqlsrv2')->table('Warning_Letter')->where('EmployeeID','=',$id)->get();

            }

}
