<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->hasRole('customer')) {
                $request->session()->regenerate();
                return redirect()->intended(route('customer.shop.index'));
            } else {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'You do not have customer access.']);
            }
        }
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    // Forgot Password
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password'); // Use existing forgot-password view
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->email;
        $user = \App\Models\User::where('email', $email)->first();
        
        // Generate reset token
        $token = Str::random(64);
        
        // Store token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]
        );
        
        // Generate reset URL
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);
        
        // Prepare email data
        $emailData = [
            'name' => $user->name ?? $user->email,
            'reset_url' => $resetUrl,
            'email' => $email
        ];
        
        // Send custom email
        try {
            Mail::to($email)->send(new PasswordResetMail($emailData));
            return redirect()->back()->with('status', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['email' => 'Failed to send reset email. Please try again.']);
        }
    }

    // Reset Password
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password'); // Use existing reset-password view
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                Auth::login($user);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return redirect()->back()->withErrors(['email' => [__($status)]]);
    }
}

