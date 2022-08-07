<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginActivity;
use App\Models\User;
use DateTime;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('username', $credentials['username'])->first();
        $blockedTimeFromLogin = 0;

        if ($user) {
            $userLoginActivities = $user->login_activities()->limit(3)->orderBy('created_at', 'desc')->get();
            $latestLoginActivity = $userLoginActivities->first();
            $blockLoginAttempts = 5;
            $isAttemptsBlocked = false;
            $isSuccessLoginDetected = false;

            if (count($userLoginActivities) == $blockLoginAttempts) {
                $endActivity = $userLoginActivities->last();
                $latestActivityTime = new DateTime($latestLoginActivity->created_at);
                $endActivityTime = new DateTime($endActivity->created_at);
                $datetimeNow = new DateTime();

                $timestampInterval = $latestActivityTime->getTimestamp() - $endActivityTime->getTimestamp();
                $blockLoginInterval = 60*10; // 10 minutes interval login attempt before user blocked from login
                $isLoginAttemptReached = $timestampInterval <= $blockLoginInterval;

                $blockTime = 60*15; // 15 minutes block user from login
                $blockTimeRemaining = $datetimeNow->getTimestamp() - $latestActivityTime->getTimestamp();
                $isUserBlockedFromLogin = $blockTimeRemaining <= $blockTime;

                if ($isLoginAttemptReached && $isUserBlockedFromLogin) {
                    $blockedTimeFromLogin = $blockTimeRemaining;
                    $isAttemptsBlocked = true;
                }
            }
            
            foreach($userLoginActivities as $loginActivity) {
                if (boolval($loginActivity->is_successful)) {
                    $isSuccessLoginDetected = true;
                }
            }

            if ($isAttemptsBlocked && !$isSuccessLoginDetected) {
                return back()->with('loginError', "Sorry, to many attempts! $blockedTimeFromLogin");
            }
        }

        if (Auth::attempt($credentials)) {
            $this->saveLoginActivity($request, $user, true);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else if ($user) {
            $this->saveLoginActivity($request, $user, false);
        }

        return back()->with('loginError', 'Login failed, check your username or password!');
    }

    private function saveLoginActivity(Request $request, $user, bool $isSuccessful)
    {        
        if ($user) {
            $loginActivity = new LoginActivity();
            $loginActivity->user_id = $user->id;
            $loginActivity->user_agent = $request->header('User-Agent');
            $loginActivity->ipv4_address = $request->ip();
            $loginActivity->is_successful = $isSuccessful;
            $loginActivity->save();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing-page');
    }
}
