<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();

        // Return a view or JSON response with the users data
        return response()->json($users);
    }

    public function show($id)
    {
//        $id='1';
        $user = $this->userService->getUserById($id);
        return response()->json($user);

        // Return a view or JSON response with the user data
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // Add other validation rules
        ]);

        $user = $this->userService->createUser($data);

        // Return a response indicating success or failure
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // Add other validation rules
        ]);

        $user = $this->userService->updateUser($id, $data);

        // Return a response indicating success or failure
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        // Return a response indicating success or failure
        return response()->json("User deleted Successfully.");

    }


}
