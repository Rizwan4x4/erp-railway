<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
       if(!(Session::get('username'))){
           return response()->json(['message' => 'User is not logged in.'], 403);
       }
       
        $user = User::where('email', Session::get('username'))->first();
//        $user = User::where('email', 'umairahmad@sasystems.solutions')->first();
//
//        dd($user->getAllPermissions()->toArray('name'));
        if (!$user) {
            // User with the given email not found
            return response()->json(['message' => 'User not found.'], 404);
        }
        
        // Loop through the permissions and check if the user has at least one of them
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if ($user->hasPermissionTo($permission)) {
                $hasPermission = true;
                break; // If the user has one permission, break the loop
            }
        }
        
        if (!$hasPermission) {
            return response()->json(['message' => 'You do not have permission.'], 403);
        }
        
        return $next($request);
    }
}
