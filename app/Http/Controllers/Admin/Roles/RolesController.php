<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Contracts\Repository\Admin\Roles\RolesRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Rules\UniqueRule;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesController extends Controller
{
    use CommonTrait;
    protected $RolesRepositoryInterface;
    protected  $RolesServiceInterface;

    public function __construct(RolesRepositoryInterface $RolesRepositoryInterface)
    {
        $this->RolesRepositoryInterface = $RolesRepositoryInterface;
  
    }



public function allRolesAndPermissions()
{
    try{
    // Get all unique role types
return $this->sendSuccess('roles and permission data fetched!', $this->RolesRepositoryInterface->getAllRolesAndPermissions());

   
} catch (\Exception $e) {


    Log::error('Unhandled Exception: ' . $e->getMessage());
    return $this->sendError($e->getMessage(), $e->getCode());
}
}
public function addRole(Request $request)
{
     try{

    $validator = Validator::make($request->all(), [
        'role_name' => 'required|string|max:255',
        'selected_permissions' => 'array', // Assuming it's an array of selected permission IDs
    ]);

    // Check if the validation fails
    if ($validator->fails()) {
        return $this->sendError(['errors' => $validator->errors()], 401);
    }

    // Validation passed, proceed to create the role
    $validatedData = $validator->validated();


    $roleName = $validatedData['role_name'];
    $selectedPermissions = $validatedData['selected_permissions'];



    return $this->sendSuccess('Role created successfully', $this->RolesRepositoryInterface->createRole($roleName, 'frontend', $selectedPermissions));
} catch (\Exception $e) {


    Log::error('Unhandled Exception: ' . $e->getMessage());
    return $this->sendError($e->getMessage(), $e->getCode());
}
}

public function deleteRole(Role $role)
{
    try{
    // Check if the role exists
    if ($role) {
        // Delete the role
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }

    return response()->json(['message' => 'Role not found'], 404);
} catch (\Exception $e) {


    Log::error('Unhandled Exception: ' . $e->getMessage());
    return $this->sendError($e->getMessage(), $e->getCode());
}
}



public function getSingleRolePermission($roleId)
{
    try {
      return $this->sendSuccess('roles and permission data fetched!',$this->RolesRepositoryInterface->getSingleRolePermission($roleId));

        
      
} catch (\Exception $e) {


    Log::error('Unhandled Exception: ' . $e->getMessage());
    return $this->sendError($e->getMessage(), $e->getCode());
}
}

public function updateRole(Request $request, Role $role)
{
    try{

    $validator = Validator::make($request->all(), [
      
        'role_name' => 'required|string|max:255',
        'selected_permissions' => 'array',
    ]);

    if ($validator->fails()) {
        return $this->sendError(['errors' => $validator->errors()], 401);
    }

    $validatedData = $validator->validated();


    return $this->sendSuccess('Role updated successfully',  $this->RolesRepositoryInterface->updateRoleNameAndPermissions($role, $validatedData['role_name'], $validatedData['selected_permissions']));
  
} catch (\Exception $e) {


    Log::error('Unhandled Exception: ' . $e->getMessage());
    return $this->sendError($e->getMessage(), $e->getCode());
}
 
}

public function showUserRole()
{ try{
    // Get all roles with their assigned users
    $roles = Role::where('source', 'frontend')
        ->with('users', 'permissions')
        ->get();

    // Return the roles and users as JSON
    return response()->json(['roles' => $roles]);
} catch (\Exception $e) {


    Log::error('Unhandled Exception: ' . $e->getMessage());
    return $this->sendError($e->getMessage(), $e->getCode());
}
}

public function assignRole(Request $request)
{
    try{
    // Validate the incoming request data (e.g., emp_code, roleName)
    $request->validate([
        'emp_code' => 'required|string',
        'roleName' => 'required|array', // Ensure roleName is an array
    ]);

    // Find the user by emp_code
    $user = User::where('emp_code', $request->input('emp_code'))->first();

    if (!$user) {
        return response()->json(['error' => 'User not found']);
    }

    // Get an array of role names from the request
    $roleNames = $request->input('roleName');

    
    $result = $this->RolesRepositoryInterface->assignRole($user, $roleNames);
 
    if (isset($result['error'])) {
        return $this->sendError(['error' => $result['error']], $result['code']);
    } else {
        return  $this->sendSuccess(['message' => $result['message']], $result['code']);
    }
} catch (\Exception $e) {


    Log::error('Unhandled Exception: ' . $e->getMessage());
    return $this->sendError($e->getMessage(), $e->getCode());
}


}




public function getUserRoles($id)
{
    try {
        $result =  $this->RolesRepositoryInterface->getUserRoles($id);
        

    if (isset($result['error'])) {
        return $this->sendError($result['error'], $result['code']);
    } else {
        return $this->sendSuccess($result['data']);
    }
     
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
}
public function removeRole(Request $request, $userId, $roleId)
{
    try {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);

        // Check if the user has the role
        if (!$user->hasRole($role)) {
            return response()->json(['message' => 'User does not have this role'], 404);
        }

        // Remove the role from the user
        $user->removeRole($role);

        return response()->json(['message' => 'Role removed successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred'], 500);
    }
}
}
