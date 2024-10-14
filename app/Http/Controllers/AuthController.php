<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if($redirect = $this->checkIfLoggedIn()) {
            return $redirect;
        }
        $data['guard'] = request()->whoIs;
        return view('admin.auth.login', $data);
    }

    public function login(Request $request)
    {
        if($redirect = $this->checkIfLoggedIn()) {
            return $redirect;
        }
        $credentials = $request->only('email', 'password');

        if($redirect = self::checkAuth($credentials)) {
            return $redirect;
        }
    }

    public function logout()
    {
        $request = request();
        $guard = $request->whoIs;
        if($guard == 'superadmin') {
            Auth::guard('superadmin')->logout();
            Auth::guard('admin')->logout();
            Auth::guard('customer')->logout();
            Auth::guard('driver')->logout();
        }else{
            Auth::guard($guard)->logout();
        }
        return redirect()->route($guard.'.login');
    }

    /**
     * check if admin/superadmin is already logged in
     * @author M Nabeel Arshad
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function checkIfLoggedIn()
    {
        $request = request();
        $guard = $request->whoIs;
        if (Auth::guard($guard)->check()) {
            return redirect()->route($guard.'.dashboard');
        }
    }


    /**
     * check auth of guard
     * @param $credentials
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function checkAuth($credentials) {
        $guard = request()->whoIs;
        if (Auth::guard($guard)->attempt($credentials)) {
            return redirect()->route($guard.'.dashboard');
        }

        return redirect()->back()->withErrors(['errors' => 'Invalid credentials']);
    }
}
