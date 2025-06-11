<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class hrms_permission_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Permission::query()->delete();

      //AR
    //   DB::table('permissions')->delete();;
    //   DB::table('roles')->delete();


    Permission::create(['name' => 'Recruitment', 'type' => 'Recruitment']);
    Permission::create(['name' => 'Recruitment job opening view']);
    Permission::create(['name' => 'Recruitment Post job']);
    Permission::create(['name' => 'Recruitment Candidates view']);
    Permission::create(['name' => 'Add new Candidates']);
    Permission::create(['name' => 'Actions on added candidates']);
    Permission::create(['name' => 'Recruitment Interview view']);
    Permission::create(['name' => 'Actions on interview candidates']);
    Permission::create(['name' => 'status updation of interview']);

    //   // Define permissions
    Permission::create(['name' => 'HRMS', 'type' => 'HRMS']);

Permission::create(['name' => 'HRMS employees_detail overall-view']);
Permission::create(['name' => 'HRMS employees_detail create_employee']);
Permission::create(['name' => 'HRMS employees_detail update_employee_profile']);
Permission::create(['name' => 'HRMS employees_detail update employee_employeement']);
Permission::create(['name' => 'HRMS employees_detail update employee_education']);
Permission::create(['name' => 'HRMS employees_detail update employee_experience']);
Permission::create(['name' => 'HRMS employees_detail  add_documents']);
Permission::create(['name' => 'HRMS employees_detail view employee profile']);
Permission::create(['name' => 'HRMS employees_detail update-Employee-status']);

Permission::create(['name' => 'HRMS warning_detail overall-view']);
Permission::create(['name' => 'HRMS warning_detail create_warning']);
Permission::create(['name' => 'HRMS warning_detail actions']);
Permission::create(['name' => 'HRMS leaves_detail overall-view']);
Permission::create(['name' => 'HRMS leaves_detail overall-view-request']);
Permission::create(['name' => 'HRMS leaves_detail apply-leave']);
Permission::create(['name' => 'HRMS leaves_detail assign-leaves']);




Permission::create(['name' => 'HRMS Attendance overall-view']);
Permission::create(['name' => 'HRMS Attendance Live-Attendance overall-view']);
Permission::create(['name' => 'HRMS Attendance Live-Attendance Sync. Attendance']);

Permission::create(['name' => 'HRMS Attendance Overall-Attendance overall-view']);
Permission::create(['name' => 'HRMS Attendance Employees-Overtime overall-view']);
Permission::create(['name' => 'HRMS Attendance Employees-Overtime Approve overtime']);
Permission::create(['name' => 'HRMS Attendance Time-Adjustment overall-view']);
Permission::create(['name' => 'HRMS Attendance Time-Adjustment update-manager-status']);
Permission::create(['name' => 'HRMS Attendance Time-Adjustment update-HR-status']);

Permission::create(['name' => 'HRMS Attendance Grace-periods overall-view']);
// Permission::create(['name' => 'HRMS Attendance Grace-periods Department-view']);
// Permission::create(['name' => 'HRMS Attendance Grace-periods Team-view']);
Permission::create(['name' => 'HRMS Attendance Grace-periods update-Overall grace-periods']);
// Permission::create(['name' => 'HRMS Attendance Grace-periods update-employee grace-periods']);
Permission::create(['name' => 'HRMS Attendance Shifts view']);
Permission::create(['name' => 'HRMS Attendance Shifts Edit']);
Permission::create(['name' => 'HRMS Attendance Shifts add new']);





Permission::create(['name' => 'HRMS HR-Reports  view']);
Permission::create(['name' => 'HRMS HR-Reports  Employee-Overview-Reports']);
Permission::create(['name' => 'HRMS HR-Reports  Employee-Attendance-Reports']);
Permission::create(['name' => 'HRMS HR-Reports  Employee-Leave-Reports']);
Permission::create(['name' => 'HRMS HR-Reports  Employee-Payroll-Reports']);
Permission::create(['name' => 'HRMS HR-Reports  Salary-&-Stipend-Reports']);


Permission::create(['name' => 'HRMS Organization_Cart  view']);



$backendSource = 'backend';
$type = 'Recruitment';

// $Recruiment = Role::create(['name' => 'Recruiment', 'source' => $backendSource, 'type' => $type]);
$Jobopening = Role::create(['name' => 'Job opening', 'source' => $backendSource, 'type' => $type]);
$Candidates = Role::create(['name' => 'Candidates', 'source' => $backendSource, 'type' => $type]);

$Interview = Role::create(['name' => 'Interview', 'source' => $backendSource, 'type' => $type]);

// $recruitment = [
//     'Recruitment overall-view',
//    'Recruitment job opening view',
//   'Recruitment Post job',
//    'Recruitment Candidates view',
//    'Add new Candidates',
//  'Actions on added candidates',
//     'Recruitment Interview view',
//   'Actions on interview candidates',
//  'status updation of interview',
// ];
// $Recruiment->syncPermissions($recruitment);
$jobopening = [

   'Recruitment job opening view',
  'Recruitment Post job',

];
$Jobopening->syncPermissions($jobopening);
$candidates = [

   'Recruitment Candidates view',
   'Add new Candidates',
 'Actions on added candidates',

];
$Candidates->syncPermissions($candidates);
$interview = [

    'Recruitment Interview view',
  'Actions on interview candidates',
 'status updation of interview',
];
$Interview->syncPermissions($interview);
//


$backendSource = 'backend';
$type = 'HRMS';
    // // Define roles
    $adminRole1 = Role::create(['name' => 'employees_detail', 'source' => $backendSource, 'type' => $type]);
    $adminRole2 = Role::create(['name' => 'warning_detail', 'source' => $backendSource, 'type' => $type]);
    $adminRole3 = Role::create(['name' => 'leaves_detail', 'source' => $backendSource, 'type' => $type]);
    $adminRole4 = Role::create(['name' => 'Attendance_detail', 'source' => $backendSource, 'type' => $type]);
    $adminRole5 = Role::create(['name' => 'HR-Reports', 'source' => $backendSource, 'type' => $type]);
    $adminRole6 = Role::create(['name' => 'Organization chart', 'source' => $backendSource, 'type' => $type]);

      $Role1 = Role::findByName('employees_detail');
      $Role2 = Role::findByName('warning_detail');
      $Role3 = Role::findByName('leaves_detail');
      $Role4 = Role::findByName('Attendance_detail');
      $Role5 = Role::findByName('HR-Reports');
      $Role6 = Role::findByName('Organization chart');

    // // Assign permissions to roles
    $Role1->givePermissionTo([

    'HRMS employees_detail overall-view',
    'HRMS employees_detail create_employee',
    'HRMS employees_detail update_employee_profile',
    'HRMS employees_detail update employee_employeement',
    'HRMS employees_detail update employee_education',
    'HRMS employees_detail update employee_experience',
    'HRMS employees_detail  add_documents',
    'HRMS employees_detail update-Employee-status',
    'HRMS employees_detail view employee profile',
 ]);



    $Role2->givePermissionTo([
        'HRMS warning_detail overall-view',
        'HRMS warning_detail create_warning',
        'HRMS warning_detail actions'
     ]);

    $Role3->givePermissionTo([
        'HRMS leaves_detail overall-view',
        'HRMS leaves_detail overall-view-request',
        'HRMS leaves_detail apply-leave',
        'HRMS leaves_detail assign-leaves'
    ]);

    $Role4->givePermissionTo([
        'HRMS Attendance overall-view',
        'HRMS Attendance Live-Attendance overall-view',
        'HRMS Attendance Live-Attendance Sync. Attendance',
        'HRMS Attendance Overall-Attendance overall-view',
        'HRMS Attendance Employees-Overtime overall-view',
        'HRMS Attendance Time-Adjustment overall-view',
        'HRMS Attendance Employees-Overtime Approve overtime',
        'HRMS Attendance Time-Adjustment update-manager-status',
        'HRMS Attendance Time-Adjustment update-HR-status',
        'HRMS Attendance Grace-periods overall-view',
        'HRMS Attendance Grace-periods update-Overall grace-periods',
        'HRMS Attendance Shifts view',
        'HRMS Attendance Shifts Edit',
        'HRMS Attendance Shifts add new'
     ]);



    $Role5->givePermissionTo(
        [
    'HRMS HR-Reports  view',
    'HRMS HR-Reports  Employee-Overview-Reports',
    'HRMS HR-Reports  Employee-Attendance-Reports',
    'HRMS HR-Reports  Employee-Leave-Reports',
    'HRMS HR-Reports  Employee-Payroll-Reports',
    'HRMS HR-Reports  Salary-&-Stipend-Reports'

]);

$Role6->givePermissionTo(
    [
        'HRMS Organization_Cart  view'

]);




$userEmail = env('USER_EMAIL');
$user = User::where('email', $userEmail)->first();
$recruitmentpermission = Permission::findByName('Recruitment');
$hrmspermission = Permission::findByName('HRMS');

if ($user) {
    $user->givePermissionTo($recruitmentpermission);
    $user->assignRole('Job opening');
    $user->assignRole('Candidates');
    $user->assignRole('Interview');

    // $user->assignRole('HR Configuration');
    $user->givePermissionTo($hrmspermission);

    $user->assignRole('employees_detail');
    $user->assignRole('warning_detail');
    $user->assignRole('leaves_detail');
    $user->assignRole('Attendance_detail');
    $user->assignRole('HR-Reports');
    $user->assignRole('Organization chart');



} else {
    // Handle the case when the user with the specified email is not found
    $this->command->info("User with email $userEmail not found.");
}




    }
}
