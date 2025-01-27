<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_success(Request $request)
    {
//        $users = User::all();
//        dd($users);
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
//        $auth = auth()->attempt($credentials);
        dd('ok');
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            // Authentication passed, create a token and return it
            $user = Auth::user();
//            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['access_token' => $token, 'token_type' => 'Bearer','user' =>  $user]);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $credentials = $request->only($email, $password);
        dd(auth::attempt($credentials));
        $user = User::where('email', $email)->where('password', $password)->first();
//        $token = $user->createToken('MyAppToken')->accessToken;
        $auth = Auth::user();
        dd($auth, $token);
    }

}
