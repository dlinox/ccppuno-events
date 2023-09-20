<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('Member/Auth/Login');
    }

    public function register()
    {
        return Inertia::render('Member/Auth/Register');
    }

    //
    public function signIn(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('member')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/m');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ])->onlyInput('email');
    }

    public function createPassword($token)
    {

        return Inertia::render('Member/Auth/CreatePassword', [
            'token' => $token
        ]);
    }

    public function signOut(Request $request): RedirectResponse
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }


    public function savePassword(Request $request)
    {
        try {
            $email = Crypt::decryptString($request->token);
            $member = Member::where('email', $email)->first();
            if ($member) {
                $member->password = $request->password;
                if ($member->save()) {
                    return redirect('/login');
                }
            }
        } catch (\Throwable $th) {

            return back()->withErrors(['password' => 'Error desconocido']);
        }
    }

    public function verificationEmail($email)
    {

        try {
            $verified =  false;

            $_email = Crypt::decryptString($email);
            $member = Member::where('email', $_email)->first();

            if ($member) {

                if ($member->email_verified_at != null) {
                    $verified =  true;
                } else {
                    $member->email_verified_at =  date(now());
                    if ($member->save()) {
                        $verified =  true;
                    }
                }
            }

            return Inertia::render('Member/Auth/EmailVerification', [
                'verified' => $verified,
            ]);
        } catch (\Throwable $th) {
            return Inertia::render('Member/Auth/EmailVerification', [
                'verified' => false,
            ]);
        }
    }
}
