<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Javaabu\EfaasSocialite\EfaasUser;
use Javaabu\EfaasSocialite\Enums\UserStates;
use Javaabu\EfaasSocialite\Enums\UserTypes;
use Javaabu\EfaasSocialite\Enums\VerificationLevels;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $efaas_token = session('efaas_token');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($efaas_token) {
            return Socialite::driver('efaas')->logOut($efaas_token, url('/'));
        }

        return redirect('/');
    }


    /**
     * Redirect user to eFaas Login
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider() {

        return Socialite::driver('efaas')->redirect();
    }

    /**
     * Fake data
     *
     * @return array
     */
    protected function getFakeData()
    {
        return [
            'name' => 'Arushad Ahmed',
            'given_name' => 'Arushad',
            'middle_name' => '',
            'family_name' => 'Ahmed',
            'idnumber' => 'A00000',
            'gender' => 'M',
            'address' => 'Honey Rose',
            'phone_number' => '777777',
            'email' => 'arushad@example.com',
            'fname_dhivehi' => 'އަރުޝަދު',
            'mname_dhivehi' => '',
            'lname_dhivehi' => 'އަޙްމަދު',
            'user_type' => UserTypes::MALDIVIAN,
            'verification_level' => VerificationLevels::VERIFIED_IN_PERSON,
            'user_state' => UserStates::ACTIVE,
            'birthdate' => '19/10/1993',
            'is_workpermit_active' => false,
            'updated_at' =>  '20/10/2017',
        ];
    }

    /**
     * Process the eFaas Callback
     * @param Request $request
     */
    public function handleProviderCallback(Request $request) {
        try {
            /** @var EfaasUser $efaas_user */
            $efaas_user = Socialite::driver('efaas')->user();

            /*$fake_data = $this->getFakeData();
            $efaas_user = (new \Javaabu\EfaasSocialite\EfaasUser)->setRaw($fake_data)->map($fake_data);*/

            $access_token = $efaas_user->token;

            // find and update the user
            $user = User::findEfaasUserAndUpdate($efaas_user);

            // login
            Auth::guard()->login($user, true);

            $request->session()->regenerate();

            session('efaas_token', $access_token);

            // redirect to home
            return redirect(RouteServiceProvider::HOME);

        }catch (\Exception $e) {
            Log::error('eFaas Login Error: '.$e->getMessage());

            return redirect()->route('login')->withErrors([
                'efaas' => 'eFaas Login Failed: '.$e->getMessage(),
            ]);
        }
    }
}
