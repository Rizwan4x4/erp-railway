<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use App\Models\ExtendedPermission;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\companyController;
Route::get('/',[companyController::class, 'home']);


Route::post('test_image/submit',function(Request $request){
     if($request->hasFile('image_file')){
        $file = $request->file('image_file');
        $name_image = time().$file->getClientOriginalName();
        $file->move(public_path().'/images/', $name_image);
     return request()->json(200,$name_image);
    }
});

Route::get('/test/getUser','App\Http\Controllers\UserController@index');
Route::get('/test/getUserbyid/{id}','App\Http\Controllers\UserController@show');
Route::get('account_stock_available',[StockDetailController::class, 'count_available']);


Route::get('/check-table', function () {
    $user = new User;
    return $user->checkTable(); // This will return the table name (e.g., "tb_users")
});



Route::get('/create_role', function () {
    ExtendedPermission::create(['name' => 'Payroll ', 'type' => 'hrms']);
});
Route::delete('/delete-role/{role}', function (Role $role) {
    // Check if the role exists
    if ($role) {
        // Delete the role
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }

    return response()->json(['message' => 'Role not found'], 404);
});

Route::get('/all-roles-and-permissions', function () {
    // Get all roles
    $roles =  \Spatie\Permission\Models\Role::where('source', 'backend')
    ->with('permissions')
    ->get();

    foreach ($roles as $role) {
        $permissions = $role->permissions->pluck('name', 'id')->toArray();
        $formattedPermissions = [];

        foreach ($permissions as $id => $name) {
            $formattedPermissions[] = ["id" => $id, "name" => $name];
        }

        $permissionsData[$role->name] = $formattedPermissions;
    }

    return ['data' => $permissionsData];

});
Route::post('/addrole', function (Request $request) {
    $validatedData = $request->validate([
    'role_name' => 'required|string|max:255',
        'selected_permissions' => 'array', // Assuming it's an array of selected permission IDs
    ]);

    // Create the new role
    $role = Role::create([
        'name' => $validatedData['role_name'],
        'source' => 'frontend',
    ]);

    // Attach selected permissions to the role (assuming you have a pivot table)
    if (isset($validatedData['selected_permissions'])) {
        $role->permissions()->sync($validatedData['selected_permissions']);
    }

    return response()->json(['message' => 'Role created successfully'], 201);
});
Route::put('/update-role/{role}', function (Request $request, Role $role) {
    $validatedData = $request->validate([
        'role_name' => 'required|string|max:255',
        'selected_permissions' => 'array', // Assuming it's an array of selected permission IDs
    ]);

    // Update the role's name
    $role->name = $validatedData['role_name'];
    $role->save();

    // Sync selected permissions to the role (assuming you have a pivot table)
    if (isset($validatedData['selected_permissions'])) {
        $permissions = $validatedData['selected_permissions'];

        // Convert the array of permission IDs to an array of integers
        $permissions = array_map('intval', $permissions);

        $role->permissions()->sync($permissions);
    } else {
        // If no permissions are selected, detach all existing permissions
        $role->permissions()->detach();
    }

    return response()->json(['message' => 'Role updated successfully']);
});

// Route::put('/update-role/{role}', function (Request $request, Role $role) {
//     $validatedData = $request->validate([
//         'role_name' => 'required|string|max:255',
//         'selected_permissions' => 'array', // Assuming it's an array of selected permission IDs
//     ]);

//     // Update the role's name
//     $role->name = $validatedData['role_name'];
//     $role->save();

//     // Sync selected permissions to the role (assuming you have a pivot table)
//     if (isset($validatedData['selected_permissions'])) {
//         $role->permissions()->sync($validatedData['selected_permissions']);
//     } else {
//         // If no permissions are selected, detach all existing permissions
//         $role->permissions()->detach();
//     }

//     return response()->json(['message' => 'Role updated successfully']);
// });

Route::get('/showeuserrole', function () {
    // Get all roles with their assigned users
    $roles = Role::where('source', 'frontend')
    ->with('users', 'permissions')
    ->get();

    // Return the roles and users as JSON
    return response()->json(['roles' => $roles]);
});
Route::get('/showroles', function (Illuminate\Http\Request $request) {
    $empCode = $request->query('emp_code');

    // Retrieve the user based on emp_code
    $user = User::where('emp_code', $empCode)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Get the user's roles
    $roles = $user->roles;

    // Create an array to store role-permission pairs
    $rolePermissions = [];

    // Iterate through each role and get its permissions
    foreach ($roles as $role) {
        $rolePermissions[$role->name] = $role->permissions;
    }

    return response()->json(['user' => $user, 'rolePermissions' => $rolePermissions]);
});

Route::get('/assign-Permission_to_role', function () {
    $PayrollSalaryProcessing = ExtendedPermission::where('name', 'Payroll Salary Processsing')->first();
    $PayrollGeneratedSalaries = ExtendedPermission::where('name', 'Payroll Generated Salaries')->first();

    // Repeat this for any other existing permissions you want to assign
    $salaryProcessing = Role::firstOrCreate(['name' => 'Salary Processing']);
    $genetrateSalary = Role::firstOrCreate(['name' => 'Generated Salaries']);


// Assign existing permissions to roles
$salaryProcessing->givePermissionTo([$PayrollSalaryProcessing, $PayrollGeneratedSalaries]);

$genetrateSalary->givePermissionTo([$PayrollGeneratedSalaries]);


});



Route::get('/get_roles_permission', function (Request $request) {

    $demandReqRole = Role::where('name', 'Demand Requisition')->first();

// Get all permissions assigned to the role
    $permissions = $demandReqRole->permissions()->get(['id', 'name']);
    $roleWithPermissions = [
        'role' => $demandReqRole->name,
        'permissions' => $permissions->toArray()
    ];

// Get all roles along with their permissions
    $rolesWithPermissions = Role::with('permissions:id,name')->get();

// Initialize an array to store role-permission associations
    $rolePermissionsArray = [];

// Loop through each role
    foreach ($rolesWithPermissions as $role) {
        // Store role name and permissions in the array
        $rolePermissionsArray[$role->name] = $role->permissions->toArray();
    }

    dd($rolePermissionsArray);

// Alternatively, you can use where() method
//    $editArticlesPermission = Permission::where('name', 'edit articles')->first();
return response()->json($permissions);

});


Route::get('assign/to/user', function (){
    $user = User::where('email', 'fahad@sagroup.ltd')->first();
//    dd($user);
    return $user->assignRole('warning_detail');
});


Route::get('remove/to/user', function (){
    $user = User::where('email', 'Taimoor@sasystems.solutions')->first();
//    dd($user);
    dd($user->permissions); // Dump the user's current permissions

    $user->revokePermissionTo([]); // Revoke the "view profile" permission

    // Save the changes to the database
    $user->save();

    dd($user->permissions); // Dump the user's permissions after revoking


});


Route::get('del/all/permmission', function (){
    Permission::where([])->delete();

});

Route::get('del/all/role', function (){
    Role::where([])->delete();
});

Route::get('del/one/per', function (){
    $user = User::where('email', 'Taimoor@sasystems.solutions')->first();

    // Find the "admin" role
    $adminRole = Role::findByName('admin');

// Revoke the "create tasks" permission from the "admin" role
    $adminRole->revokePermissionTo('create tasks');
});

Route::get('assign/one/per', function (){
    $user = User::where('email', 'Taimoor@sasystems.solutions')->first();

    // Find the "admin" role
    $adminRole = Role::findByName('admin');

// Revoke the "create tasks" permission from the "admin" role
    $adminRole->givePermissionTo('create tasks');
});

Route::get('assign/one/role_to_user', function (Request $request){

    $user = User::where('email', 'umairahmad@sasystems.solutions')->first();
    $role = Role::where('name', $request->role)->first();

        // Assign the role to the user
        $user->assignRole($role);

        // Optionally, you can also revoke other roles if needed
        // $user->removeRole('previous_role_name');

        // Additional logic, such as displaying a success message or redirecting
    return response()->json($user->getRoleNames());

});






