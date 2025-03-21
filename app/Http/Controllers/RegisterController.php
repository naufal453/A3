<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display register page.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle account registration request
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
   
public function register(RegisterRequest $request)
{
    try {
        // Hash the password before creating the user
        $userData = $request->validated();
        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        Auth::login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    } catch (\Exception $e) {
        \Log::error('Registration Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}
}
