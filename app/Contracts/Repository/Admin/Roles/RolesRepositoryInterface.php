<?php

namespace App\Contracts\Repository\Admin\Roles;

interface RolesRepositoryInterface
{
    public function getAllRolesAndPermissions();
    public function getSingleRolePermission($roleId);
    public function createRole($roleName, $source, $selectedPermissions );
    public function updateRoleNameAndPermissions( $role, $name, $selectedPermissions);
    public function assignRole( $user,  $roleNames);
    public function getUserRoles($id);
}
