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
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

    // public function show() {
    //     return view('clients.auth.verify');
    // }

     /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user('clients')->hasVerifiedEmail()
            ? redirect()->route('clients.home')
            : view('clients.auth.verify');
    }

 /**
     * Verfy the user email.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        if (! hash_equals((string) $request->user('clients')->getKey(), (string) $request->route('id'))) {
            //id value doesn't match.
            return redirect()
                ->route('clients.verification.notice')
                ->with('error','Invalid user!');
        }

        if ($request->user('clients')->hasVerifiedEmail()) {
            return redirect()
                ->route('clients.home');
        }

        $request->user('clients')->markEmailAsVerified();

        return redirect()
            ->route('clients.home')
            ->with('status','Thank you for verifying your email!');
    }

    // public function verify(EmailVerificationRequest $request) {
    //     $request->fulfill();
     
    //     return redirect('/clients');
    // }

     /**
     * Resend the verification email.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user('clients')->hasVerifiedEmail()) {
            return redirect()->route('clients.home');
        }

        $request->user('clients')->sendEmailVerificationNotification();

        return redirect()
            ->back()
            ->with('status','We have sent you a verification email!');
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
