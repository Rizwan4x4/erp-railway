<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ExtendedPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class HRMS_SalalryPermissionSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        // Define permissions
        Permission::create(['name' => 'Payroll', 'type' => 'Payroll']);
        Permission::create(['name' => 'Payroll Salary Management']);
        //Salary Management permissions
        Permission::create(['name' => 'Payroll Salary Processsing']);
        //Salary Processing permissions
        Permission::create(['name' => 'Payroll Generated Salaries']);
        //Generated Salaries
        Permission::create(['name' => 'Payroll Proceed to HR approval']);
        Permission::create(['name' => 'Payroll Add deduction and overtime']);


        Permission::create(['name' => 'Payroll HR Approval']);
        //HR Approval component permission
        Permission::create(['name' => 'Payroll Proceed to Finance Approval']);
        // Permission::create(['name' => 'Payroll Proceed to Finance Approval']);

        Permission::create(['name' => 'Payroll Finance Approval']);
        //Finance Approval
        Permission::create(['name' => 'Payroll Proceed for distribution']);
        Permission::create(['name' => 'Payroll Apply Inst and Fines']);
        Permission::create(['name' => 'Payroll Apply Arrears and Allow']);
        Permission::create(['name' => 'Payroll Update Employee Salary']);

        Permission::create(['name' => 'Payroll Salary Distribution']);
        //Salary Distribution
        Permission::create(['name' => 'Payroll Generate Salary Slip']);
       // Generate Salary Slip
       Permission::create(['name' => 'Payroll View Salary Slip']);
       Permission::create(['name' => 'Payroll Update Status by Paying Salary']);

       Permission::create(['name' => 'Payroll Bank Distribution List']);
      //Bank Distribution List
      Permission::create(['name' => 'Payroll Download Excel file']);
    //   Permission::create(['name' => 'Payroll View Salary Slip']);//repeated in other component also
      Permission::create(['name' => 'Payroll Download Salary Slip']);

      Permission::create(['name' => 'Payroll Cash Distribution List']);
      //Cash Distribution List
      Permission::create(['name' => 'Payroll Download Excel according to date']);

      Permission::create(['name' => 'Payroll Pending Salaries']);
    //   //Pending Salaries

    //   Permission::create(['name' => 'Payroll View Salary Slip']);
      Permission::create(['name' => 'Payroll Change Status/Pay Salary']);


      Permission::create(['name' => 'Payroll employee Salary Details']);
      //Employe salary details view

      Permission::create(['name' => 'Payroll Indvisual employee Salary Details']);
      Permission::create(['name' => 'Payroll Update Indvisual employee Salary']);


 Permission::create(['name' => 'Payroll employee Stipend Details']);
  //Employe stipend details view
  Permission::create(['name' => 'Payroll apply Stipend']);
  Permission::create(['name' => 'Payroll active or disabel Stipend status']);
  Permission::create(['name' => 'Payroll update Stipend']);



      Permission::create(['name' => 'Payroll Loan and Advance']);

      //Loan and Advance
      Permission::create(['name' => 'Payroll Apply for loan']);
      Permission::create(['name' => 'Payroll Actions for loan']);
      Permission::create(['name' => 'Payroll Actions for installment']);


      Permission::create(['name' => 'Payroll Dues Details']);
      //Dues Details
      Permission::create(['name' => 'Payroll Apply Dues']);
      Permission::create(['name' => 'Payroll Actions on Dues']);

      Permission::create(['name' => 'Payroll Taxes Details']);
//Taxes Details

Permission::create(['name' => 'Payroll Appply Tax']);
Permission::create(['name' => 'Payroll download excel file of Tax']);
Permission::create(['name' => 'Payroll update tax of employee']);


Permission::create(['name' => 'Payroll Incentives']);
//Incentives
Permission::create(['name' => 'Payroll Arrears']);
//Arrears
Permission::create(['name' => 'Payroll Appply Arrears']);
Permission::create(['name' => 'Payroll Arrears Action']);

Permission::create(['name' => 'Payroll Bonuses']);
//Bonuses
Permission::create(['name' => 'Payroll Appply Bonuses']);
Permission::create(['name' => 'Payroll Bonuses Action']);

Permission::create(['name' => 'Payroll Allowances']);
//Allowances
Permission::create(['name' => 'Payroll Other Allowances']);
//Other Allowances
Permission::create(['name' => 'Payroll Appply Allowance']);
Permission::create(['name' => 'Payroll update Allowance of employee']);

Permission::create(['name' => 'Payroll Welfare Allowances']);
// Welfare Allowances
Permission::create(['name' => 'Payroll Apply Welfare Allowance']);
Permission::create(['name' => 'Payroll Allowance slip action']);


Permission::create(['name' => 'Payroll Fuel Allowances']);
//Fuel Allowances
Permission::create(['name' => 'Payroll Update Fuel Rates']);
Permission::create(['name' => 'Payroll Add Fuel Allowance']);
Permission::create(['name' => 'Payroll Fuel Allowance Action']);

Permission::create(['name' => 'Payroll Final Settlement']);
//Final Settlement

Permission::create(['name' => 'Payroll Final Settlement Action']);

$backendSource = 'backend';
$type = 'Payroll';

$salaryManagement = Role::create(['name' => 'Salary Management', 'source' => $backendSource, 'type' => $type]);
$salaryProcessing = Role::create(['name' => 'Salary Processing', 'source' => $backendSource, 'type' => $type]);
$employeeSalaries = Role::create(['name' => 'Employee Salaries', 'source' => $backendSource, 'type' => $type]);
$employeeStipend = Role::create(['name' => 'Employee Stipend', 'source' => $backendSource, 'type' => $type]);
$loanAndAdvance = Role::create(['name' => 'Loan and Advance', 'source' => $backendSource, 'type' => $type]);
$duesAndTax = Role::create(['name' => 'Dues and Tax', 'source' => $backendSource, 'type' => $type]);
$incentive = Role::create(['name' => 'Incentive', 'source' => $backendSource, 'type' => $type]);
$arrears = Role::create(['name' => 'Arrears', 'source' => $backendSource, 'type' => $type]);
$bonus = Role::create(['name' => 'Bonus', 'source' => $backendSource, 'type' => $type]);
$allowances = Role::create(['name' => 'Allowances', 'source' => $backendSource, 'type' => $type]);
$finalStatementRole = Role::create(['name' => 'Final Statement', 'source' => $backendSource, 'type' => $type]);





$permissions = [
   
    'Payroll Salary Management',
    'Payroll Salary Processsing',
    'Payroll Generated Salaries',
    'Payroll Proceed to HR approval',
    'Payroll Add deduction and overtime',
    'Payroll HR Approval',
    'Payroll Proceed to Finance Approval',
    'Payroll Finance Approval',
    'Payroll Proceed for distribution',
    'Payroll Apply Inst and Fines',
    'Payroll Apply Arrears and Allow',
    'Payroll Update Employee Salary',
    'Payroll Salary Distribution',
    'Payroll Generate Salary Slip',
    'Payroll View Salary Slip',
    'Payroll Update Status by Paying Salary',
    'Payroll Bank Distribution List',
    'Payroll Download Excel file',
    'Payroll Download Salary Slip',
    'Payroll Cash Distribution List',
    'Payroll Download Excel according to date',
    'Payroll Pending Salaries',
    'Payroll Change Status/Pay Salary',
    'Payroll Pending Salaries',
    'Payroll Change Status/Pay Salary',
    'Payroll employee Salary Details',
    'Payroll Indvisual employee Salary Details',
    'Payroll Update Indvisual employee Salary',
    'Payroll employee Stipend Details',
    'Payroll apply Stipend',
    'Payroll active or disabel Stipend status',
    'Payroll update Stipend',
];

// Attach permissions to the 'Salary Management' role
foreach ($permissions as $permissionName) {
    $permission = Permission::where('name', $permissionName)->first();
    
    if ($permission) {
        $salaryManagement->givePermissionTo($permission);
    }
}

$SalaryProcessingpermissions = [
    'Payroll Salary Processsing',
    'Payroll Generated Salaries',
    'Payroll Proceed to HR approval',
    'Payroll Add deduction and overtime',
    'Payroll HR Approval',
    'Payroll Proceed to Finance Approval',
    'Payroll Finance Approval',
    'Payroll Proceed for distribution',
    'Payroll Apply Inst and Fines',
    'Payroll Apply Arrears and Allow',
    'Payroll Update Employee Salary',
    'Payroll Salary Distribution',
    'Payroll Generate Salary Slip',
    'Payroll View Salary Slip',
    'Payroll Update Status by Paying Salary',
    'Payroll Bank Distribution List',
    'Payroll Download Excel file',
    'Payroll Download Salary Slip',
    'Payroll Cash Distribution List',
    'Payroll Download Excel according to date',
    'Payroll Pending Salaries',
    'Payroll Change Status/Pay Salary',
];

foreach ($SalaryProcessingpermissions as $permissionName) {
    $permission = Permission::where('name', $permissionName)->first();
    if ($permission) {
        $salaryProcessing->givePermissionTo($permission);
    }
}

$EmployeeSalaries = [
    'Payroll employee Salary Details',
    'Payroll Indvisual employee Salary Details',
    'Payroll Update Indvisual employee Salary',
];
$employeeSalaries->syncPermissions($EmployeeSalaries);
$EmployeeStipend = [
    'Payroll employee Stipend Details',
    'Payroll apply Stipend',
    'Payroll active or disabel Stipend status',
    'Payroll update Stipend',
];
$employeeStipend->syncPermissions($EmployeeStipend);


$loanAdvance = [
    'Payroll Loan and Advance',
    'Payroll Apply for loan',
    'Payroll Actions for loan',
    'Payroll Actions for installment',

];
$loanAndAdvance->syncPermissions($loanAdvance);

$dueTax = [
    'Payroll Dues Details',
    'Payroll Apply Dues',
    'Payroll Actions on Dues',
    'Payroll Taxes Details',
    'Payroll Appply Tax',
    'Payroll download excel file of Tax',
    'Payroll update tax of employee',
];
$duesAndTax->syncPermissions($dueTax);

$Incentive= [
    'Payroll Incentives',
    'Payroll Arrears',
    'Payroll Appply Arrears',
    'Payroll Arrears Action',
    'Payroll Bonuses',
    'Payroll Appply Bonuses',
    'Payroll Bonuses Action',
    'Payroll Allowances',
    'Payroll Other Allowances',
    'Payroll Appply Allowance',
    'Payroll update Allowance of employee',
    'Payroll Welfare Allowances',
    'Payroll Apply Welfare Allowance',
    'Payroll Allowance slip action',
    'Payroll Fuel Allowances',
    'Payroll Update Fuel Rates',
    'Payroll Add Fuel Allowance',
    'Payroll Fuel Allowance Action',
];
$incentive->syncPermissions($Incentive);
$Arrears = [
    'Payroll Arrears',
    'Payroll Appply Arrears',
    'Payroll Arrears Action',
];
$arrears->syncPermissions($Arrears);
$Bonus = [
    'Payroll Bonuses',
    'Payroll Appply Bonuses',
    'Payroll Bonuses Action',
];

$bonus->syncPermissions($Bonus);
$Allowances = [
    'Payroll Allowances',
    'Payroll Other Allowances',
    'Payroll Appply Allowance',
    'Payroll update Allowance of employee',
    'Payroll Welfare Allowances',
    'Payroll Apply Welfare Allowance',
    'Payroll Allowance slip action',
    'Payroll Fuel Allowances',
    'Payroll Update Fuel Rates',
    'Payroll Add Fuel Allowance',
    'Payroll Fuel Allowance Action',
];
$allowances->syncPermissions($Allowances);
$Finalstatement= [
    'Payroll Final Settlement',
    'Payroll Final Settlement Action',
];
$finalStatementRole->syncPermissions($Finalstatement);


// $permissions = Permission::all();


// $salaryManagement->syncPermissions($permissions);


$userEmail = env('USER_EMAIL');
$user = User::where('email', $userEmail)->first();
$payrollpermission = Permission::findByName('Payroll');
if ($user) {
    $user->givePermissionTo($payrollpermission);
    $user->assignRole('Salary Management');
    $user->assignRole('Salary Processing');
    $user->assignRole('Employee Salaries');
    $user->assignRole('Employee Stipend');
    $user->assignRole('Loan and Advance');
    $user->assignRole('Dues and Tax');
    $user->assignRole('Incentive');
    $user->assignRole('Arrears');
    $user->assignRole('Bonus');
    $user->assignRole('Allowances');
    $user->assignRole('Final Statement');

  
} else {
    // Handle the case when the user with the specified email is not found
    $this->command->info("User with email $userEmail not found.");
}



$user = User::where('email', 'Taimoor@sasystems.solutions')->first();
$user->assignRole('Salary Management');
$user->assignRole('Salary Processing');
$user->assignRole('Employee Salaries');
$user->assignRole('Employee Stipend');
$user->assignRole('Loan and Advance');
$user->assignRole('Dues and Tax');
$user->assignRole('Incentive');
$user->assignRole('Arrears');
$user->assignRole('Bonus');
$user->assignRole('Allowances');
$user->assignRole('Final Statement');



    }
}
