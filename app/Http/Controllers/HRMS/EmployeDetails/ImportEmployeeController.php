<?php

namespace App\Http\Controllers\HRMS\EmployeDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;



class ImportEmployeeController extends Controller
{
    public function import(Request $request)
    {
        // Validate the request to ensure a file is uploaded
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        // Import the file using the EmployeeImport class
        Excel::import(new EmployeeImport, $request->file('file'));

        // Redirect back with a success message
        return response()->json(['message' => 'Employees imported successfully.']);
    }
}
