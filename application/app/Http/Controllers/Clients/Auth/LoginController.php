<?php
namespace App\Http\Controllers\Clients\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\UserDevice;
use AgentDetector;
use App\Models\Customer;
use Laravel\Socialite\Facades\Socialite;


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


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('clients.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Check with old password
        $customer = Customer::where('customers_email', $request->email)
            ->whereNotNull('customers_password')
            //->whereNull('email')
            // ->whereNull('password')
            ->first();
        if ($customer->email_verified_at == null) {
            return response()->json([
                'success' => false, 
                'message' => __("This account is not activated. Contact the support to send you email activation or check your inbox.")
            ]);
        }
        if(!empty($customer) && $customer->customers_password == md5(sha1($request->password))) {
            $customer->password = $request->password;
            $customer->email = $request->email;
            //$customer->customers_password = null;
            //$customer->customers_email = null;
            $customer->save();
        }


        if (Auth::guard('clients')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            $user = Auth::guard('clients')->user();

            // REDIRECT 
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            
            return response()->json([
                'success' => true, 
                'redirect' => route('clients.home')
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return response()->json([
            'success' => false, 
            'message' => __("Ces identifiants ne correspondent pas à nos enregistrements.")
        ]);
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('clients')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()->route('clients.login');
    }
}
