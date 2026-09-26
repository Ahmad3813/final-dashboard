<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;




class AuthController extends Controller
{
    public function showRegister(Request $request)
    {

        return view("auth.register");
    }

    public function showlogin(Request $request)
    {

        return view("auth.login");
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/',
            ],

            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

            'password_confirmation' => [
                'required',
                'same:password',
            ],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.min' => 'Your name must contain at least 3 characters.',
            'email.required' => 'Please enter your Gmail address.',
            'email.email' => 'Enter a valid email address.',
            'email.regex' => 'Your email must end with @gmail.com.',
            'email.unique' => 'This Gmail address already has an account.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must contain at least 8 characters.',
            'password.mixed' => 'Password must include uppercase and lowercase letters.',
            'password.numbers' => 'Password must include at least one number.',
            'password.symbols' => 'Password must include at least one special character.',
            'password_confirmation.required' => 'Please re-enter your password.',
            'password_confirmation.same' => 'Passwords do not match.',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);

        // Marks the email as verified because OTP is disabled for now.
        $user->email_verified_at = now();

        $user->save();

        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. Please sign in.');
    }
    public function showVerification(Request $request)
    {
        if (!$request->session()->has('email_verification_user_id')) {
            return redirect()->route('register');
        }

        return view('auth.verify-email');
    }
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = $request->session()->get('email_verification_user_id');

        if (!$userId) {
            return redirect()
                ->route('register')
                ->withErrors(['otp' => 'Please create an account first.']);
        }

        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('email_verification_user_id');

            return redirect()
                ->route('register')
                ->withErrors(['otp' => 'Account not found. Please register again.']);
        }

        if (!$user->email_otp_expires_at || now()->greaterThan($user->email_otp_expires_at)) {
            return back()->withErrors([
                'otp' => 'This verification code has expired.',
            ]);
        }

        if ($user->email_otp_attempts >= 5) {
            return back()->withErrors([
                'otp' => 'Too many attempts. Please request a new code.',
            ]);
        }

        if (!Hash::check($request->otp, $user->email_otp_hash)) {
            $user->increment('email_otp_attempts');

            return back()->withErrors([
                'otp' => 'The verification code is incorrect.',
            ]);
        }

        $user->email_verified_at = now();
        $user->email_otp_hash = null;
        $user->email_otp_expires_at = null;
        $user->email_otp_attempts = 0;
        $user->save();

        $request->session()->forget('email_verification_user_id');

        return redirect()
            ->route('login')
            ->with('success', 'Email verified successfully. You can now sign in.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
    public function sendPasswordResetOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/',
            ],
        ], [
            'email.required' => 'Please enter your Gmail address.',
            'email.email' => 'Enter a valid email address.',
            'email.regex' => 'Your email must end with @gmail.com.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'No account was found with this Gmail address.',
                ])
                ->onlyInput('email');
        }

        $otp = (string) random_int(100000, 999999);

        $user->password_reset_otp_hash = Hash::make($otp);
        $user->password_reset_otp_expires_at = now()->addMinutes(10);
        $user->password_reset_otp_attempts = 0;
        $user->save();

        $request->session()->put('password_reset_user_id', $user->id);

        Mail::raw(
            "Your password reset code is: {$otp}\n\nThis code expires in 10 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Reset your password');
            }
        );

        return redirect()->route('password.verify.notice');
    }
    public function showPasswordResetVerification(Request $request)
    {
        if (!$request->session()->has('password_reset_user_id')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-otp');
    }
    public function verifyPasswordResetOtp(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ], [
            'otp.required' => 'Please enter the verification code.',
            'otp.digits' => 'The verification code must contain exactly 6 numbers.',
        ]);

        $userId = $request->session()->get('password_reset_user_id');

        if (!$userId) {
            return redirect()->route('password.request');
        }

        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('password_reset_user_id');

            return redirect()->route('password.request');
        }

        if (
            !$user->password_reset_otp_expires_at ||
            now()->greaterThan($user->password_reset_otp_expires_at)
        ) {
            return back()->withErrors([
                'otp' => 'This verification code has expired.',
            ]);
        }

        if ($user->password_reset_otp_attempts >= 5) {
            return back()->withErrors([
                'otp' => 'Too many attempts. Please request a new code.',
            ]);
        }

        if (!Hash::check($request->otp, $user->password_reset_otp_hash)) {
            $user->increment('password_reset_otp_attempts');

            return back()->withErrors([
                'otp' => 'The verification code is incorrect.',
            ]);
        }

        $request->session()->put('password_reset_verified_user_id', $user->id);

        return redirect()->route('password.reset.form');
    }
    public function showResetPasswordForm(Request $request)
    {
        if (!$request->session()->has('password_reset_verified_user_id')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password');
    }
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

            'password_confirmation' => [
                'required',
                'same:password',
            ],
        ], [
            'password.required' => 'Please create a new password.',
            'password.min' => 'Password must contain at least 8 characters.',
            'password.mixed' => 'Password must include uppercase and lowercase letters.',
            'password.numbers' => 'Password must include at least one number.',
            'password.symbols' => 'Password must include at least one special character.',

            'password_confirmation.required' => 'Please re-enter your new password.',
            'password_confirmation.same' => 'Passwords do not match.',
        ]);

        $userId = $request->session()->get('password_reset_verified_user_id');

        if (!$userId) {
            return redirect()->route('password.request');
        }

        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('password_reset_verified_user_id');

            return redirect()->route('password.request');
        }

        $user->password = Hash::make($validated['password']);
        $user->password_reset_otp_hash = null;
        $user->password_reset_otp_expires_at = null;
        $user->password_reset_otp_attempts = 0;
        $user->save();

        $request->session()->forget([
            'password_reset_user_id',
            'password_reset_verified_user_id',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Password reset successfully. Please sign in.');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' => 'Please enter your Gmail address.',
            'email.email' => 'Enter a valid email address.',
            'email.regex' => 'Your email must end with @gmail.com.',
            'password.required' => 'Please enter your password.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'The email address or password is incorrect.',
                ])
                ->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
