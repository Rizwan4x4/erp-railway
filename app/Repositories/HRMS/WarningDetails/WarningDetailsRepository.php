<?php

namespace App\Repositories\HRMS\WarningDetails;

use App\Contracts\Repository\HRMS\WarningDetails\WarningDetailsRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
class WarningDetailsRepository implements WarningDetailsRepositoryInterface
{
    public function count_warnings(){
        try{
          
                $total=DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID','=',company_id())->count();
                $first=DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID','=',company_id())->where('WarningType','=','First')->count();
                $second=DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID','=',company_id())->where('WarningType','=','Second')->count();
                $terminate=DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID','=',company_id())->where('WarningType','=','Terminate')->count();
                // return directly
                    return array(
                      'total' => $total,
                      'first' => $first,
                      'second' => $second,
                       'terminate' => $terminate,
                      );
              
                    } catch (QueryException $e) {
                        // Throw a custom exception with the original message
                        throw new ErrorException("Error getting available value: " . $e->getMessage());
                    }
      
            }
            public function searchWarnings($keyword, $Page)
            {
                try{
          
                    return DB::connection('sqlsrv2')
                    ->table('Warning_Letter')
                    ->join('Emp_Profile', 'Warning_Letter.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                    ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                    ->where('Warning_Letter.CompanyID', '=', company_id())
                    ->select('Warning_Letter.*', 'Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.PostingCity')
                    ->where('Emp_Profile.Name', 'LIKE', '%' . $keyword . '%')
                    ->paginate(20, ['*'], 'page', $Page);
                  
                } catch (QueryException $e) {
                    // Throw a custom exception with the original message
                    throw new ErrorException("Error getting available value: " . $e->getMessage());
                }
            
            }
            public function filterWarnings( $designation, $department, $location)
            {
                try{
               
                $query = DB::connection('sqlsrv2')
                    ->table('Warning_Letter')
                    ->join('Emp_Profile', 'Warning_Letter.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                    ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                    ->where('Warning_Letter.CompanyID', '=', company_id())
                    ->select('Warning_Letter.*', 'Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.PostingCity')
                    ->where('Warning_Letter.Designation', 'LIKE', '%' . $designation . '%')
                    ->where('Warning_Letter.Department', 'LIKE', '%' . $department . '%')
                    ->where('Emp_Register.PostingCity', 'LIKE', '%' . $location . '%');
        
                return $query->paginate(20);
                // remove pagination 
            }catch (QueryException $e) {
                    // Throw a custom exception with the original message
                    throw new ErrorException("Error getting Search Warning: " . $e->getMessage());
                }
            }
}
