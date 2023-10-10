<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;



class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'password/success';

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        $customer = \App\Models\Customer::where('email', $request->email)->first();

        if(empty($customer)) {
            return redirect()->route('clients.password.request')->withErrors(['email' => __("E-mail non valide") ]);
        }

        if (!$this->broker()->tokenExists($customer, $token)) {
            return redirect()->route('clients.password.request')->withErrors(['token' => __("Lien de réinitialisation non valide ou expiré.") ]);
        }

        return view('clients.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function success() {
        if (!session('status')) {
            return redirect()->route('clients.login');
        }
        
        return view('clients.auth.passwords.success');
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {

        return redirect()->route('clients.password.success')->with('status', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('clients');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('clients');
    }
}
