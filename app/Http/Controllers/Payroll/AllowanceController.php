<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class AllowanceController extends Controller
{
    public function delete_allowance($id)
    {
        $isDeleted= DB::connection('sqlsrv2')->update('update PayrollWelfareAllowance set IsDeleted=?, DeletedBy=?, DeletedOn=? where CompanyID=? and AllowanceID=?', [1, username(), long_date(), company_id(), $id]);

        if ($isDeleted) {
            $data = 'allowance deleted';
            return request()->json(200, $data);
        }
    }
}
