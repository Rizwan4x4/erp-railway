<?php

namespace App\Repositories\Admin\Roles;

use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;
use App\Contracts\Repository\Admin\Roles\RolesRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Spatie\Permission\Models\Permission;






use App\Http\Requests\Rules\UniqueRule;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Session;

class RolesRepository implements RolesRepositoryInterface
{
    public function getAllRolesAndPermissions()
    {
        try {
            $permissionsdata = [];
        $types = Role::where('source', 'backend')
            ->distinct('type')
            ->pluck('type');

        $rolesData = [];

        foreach ($types as $type) {
            $roles = Role::where('source', 'backend')
                ->where('type', $type)
                ->with('permissions')
                ->get();

            $formattedRoles = [];

            foreach ($roles as $role) {
                $permissions = $role->permissions->pluck('name', 'id')->toArray();
                $formattedPermissions = [];

                foreach ($permissions as $id => $name) {
                    $formattedPermissions[] = [
                        "id" => $id,
                        "name" => $name,
                        "type" => 'permission',
                    ];
                }

                $formattedRoles[] = [
                    "id" => $role->id,
                    "name" => $role->name,
                    "type" => $role->type,
                    "permissions" => $formattedPermissions,
                ];
            }

            $rolesData[$type] = $formattedRoles;
     
        }

$categoryPermissions = Permission::whereNotNull('type')->get(['id', 'name'])->toArray();

$permissionsdata['type'] = $rolesData;
$permissionsdata['categoryPermissions'] = [];

foreach ($categoryPermissions as $permission) {
    $permissionsdata['categoryPermissions'][] = [
        'id' => $permission['id'],
        'name' => $permission['name'],
    ];
}

$permissionsdataArray = [
    'type' => $permissionsdata['type'],
    'categoryPermissions' => $permissionsdata['categoryPermissions'],
];



return $permissionsdataArray;

} catch (\Exception $e) {
    Log::error('Exception in ClubRegistrationService: ' . $e->getMessage());
    throw $e;
}
    }

    public function getSingleRolePermission($roleId)
    {
        try {
            // Fetch the role based on $roleId
            $role = Role::findOrFail($roleId);

            // Extract permissions associated with the role
            $permissions = $role->permissions->pluck('id')->toArray();

            // Check the 'source' column to decide whether to fetch backend roles
            if ($role->source === 'frontend') {
                // Get the IDs of all permissions associated with the frontend role
                $frontendPermissionIds = $permissions;

                // Fetch the backend roles that have all the permissions of the frontend role
                $backendRoles = Role::where('source', 'backend')
                    ->whereHas('permissions', function ($query) use ($frontendPermissionIds) {
                        $query->whereIn('id', $frontendPermissionIds);
                    })
                    ->get();
            } else {
                $backendRoles = [];
            }

            return [
                'permissions' => $permissions,
                'backendRoles' => $backendRoles,
            ];
        } catch (\Exception $e) {
            Log::error('Exception in ClubRegistrationService: ' . $e->getMessage());
            throw $e;
        }
    }
  
    public function createRole($roleName, $source = 'frontend', $selectedPermissions )
    {
        try{
        $role = Role::create([
            'name' => $roleName,
            'source' => $source,
        ]);

        // Attach selected permissions to the role (assuming you have a pivot table)
        if (isset($selectedPermissions) && !empty($selectedPermissions)) {
            $role->permissions()->sync($selectedPermissions);
        }

        return $role;
    } catch (\Exception $e) {
        Log::error('Exception in ClubRegistrationService: ' . $e->getMessage());
        throw $e;
    }

    }
    public function updateRoleNameAndPermissions( $role, $name, $selectedPermissions)
    {
        try{
        // Update the role's name 

        $role->name = $name;
        $role->save();

        // Sync selected permissions to the role (assuming you have a pivot table)
        if (isset($selectedPermissions)) {
            $permissions = array_map('intval', $selectedPermissions);
            $role->permissions()->sync($permissions);
        } else {
            // If no permissions are selected, detach all existing permissions
            $role->permissions()->detach();
        }

    } catch (\Exception $e) {
        Log::error('Exception in ClubRegistrationService: ' . $e->getMessage());
        throw $e;
    }
    }
    
    public function assignRole( $user,  $roleNames)
    {
        try{
        // Check if the user already has the roles
        $existingRoles = $user->getRoleNames()->toArray();
        $duplicateRoles = array_intersect($existingRoles, $roleNames);

        if (!empty($duplicateRoles)) {
            return ['error' => 'User already has one or more of the already assigned roles', 'code' => 400];
        }

        // Find the roles by name
        $roles = Role::whereIn('name', $roleNames)->get();

        // Check if all roles were found
        if (count($roles) !== count($roleNames)) {
            return ['error' => 'One or more roles not found', 'code' => 400];
        }

        // Assign the roles to the user
        $user->assignRole($roles);

        return ['message' => 'Roles assigned successfully', 'code' => 200];
    } catch (\Exception $e) {
        Log::error('Exception in ClubRegistrationService: ' . $e->getMessage());
        throw $e;
    }
}
 public function getUserRoles($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return ['error' => 'User not found', 'code' => 404];
            }

            // Get the roles assigned to the user
            $roleIds = [];
            foreach ($user->getRoleNames() as $roleName) {
                $role = Role::where('name', $roleName)->first();
                if ($role) {
                    $roleIds[] = $role->id;
                }
            }

            $roles = Role::where('source', 'frontend')
                ->whereIn('id', $roleIds) // Use 'whereIn' to filter by an array of role IDs
                ->with('users', 'permissions')
                ->get();

            return ['data' => ['roles' => $roles]];
        } catch (\Exception $e) {
            return ['error' => 'An error occurred', 'code' => 500];
        }
    }
}
