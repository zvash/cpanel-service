<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class LoginController extends Controller
{
    use RedirectsUsers;
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('nova::auth.login');
    }

    public function login(Request $request, AuthService $authService)
    {
        $response = $authService->login($request);
        if (isset($response['data']['access_token'])) {
            session()->put('access_token', $response['data']['access_token']);
            return redirect()->intended($this->redirectPath());
        }
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return Nova::path();
    }
}
