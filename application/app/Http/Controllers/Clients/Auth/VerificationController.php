<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;



class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = 'clients.verification.notice';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:clients');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function changeEmail(Request $request) {
        // GET CURRENT USER
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:customers,email,'.$user->customers_id.',customers_id']
        ],[
            'email.email' => __("L'adresse e-mail que vous avez saisie est invalide."),
            'email.unique' => __("Cette adresse e-mail est déjà associée à un compte."),
        ]);

        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'message' => $validator->messages()->all()
            ], 200);
        }
        
        if($user->email != $request->email) {
            $user->email = $request->email;
            $user->save();
        }

        $message = __("Votre demande de mise à jour d'adresse e-mail a été prise en charge.");

        return Response::json([
            "success" => true,
            "message" => $message,
            "redirect" => route('clients.home')
        ]);
    }

    public function cancelChangeEmail(Request $request) {
        $user = $request->user();
        $user->email_tmp = null;
        $user->save();
        return redirect()->route('clients.profile.connexion')->with(['email_change_cancel' => true]);
    }
}
