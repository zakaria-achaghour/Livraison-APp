<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Auth\RegisterRequest;
use App\Models\City;
use App\Models\CompanyType;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $cities = City::where('active', 1)->get(['id', 'name']);
        $companyTypes = CompanyType::get(['id', 'name']);
        return view('clients.auth.register', [
                "cities" => $cities,
                "companyTypes" => $companyTypes
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(RegisterRequest $request)
    {

        $customer = new Customer();
        $customer->customers_name = $request->fullName;
        $customer->customers_store = $request->storeName;
        $customer->customers_phone = $request->phone;
        $customer->customers_address = $request->address;
        $customer->customers_pickup_city = $request->city;
        $customer->customers_website = $request->webSite;
        $customer->customers_company_type = $request->companyType;
        $customer->customers_cin = $request->cine;

        $customer->customers_email = $request->email;
        $customer->email = $request->email;
        $customer->customers_password = Hash::make($request->password);
        $customer->password = Hash::make($request->password);
        $customer->save();
        $customer->sendEmailVerificationNotification();
        return redirect()->route("clients.verification.notice")
                ->with('message',  __("Account activation link sent to your e-mail address: $customer->email Please follow the link inside to continue. "));
    //    return  redirect()->route('clients.login')
    //                      ->with('message',  __("Account activation link sent to your e-mail address: $customer->email Please follow the link inside to continue. "));
        // return Customer::create([
        //         'name' => $request->fullName,
        //         'store' => $request->storeName,
        //         'phone' => $request->phone,
        //         'email' => $request->email,
        //         'password' => Hash::make($request->password),
        //         'address' => $request->address,
        //         'city' => $request->city,
        //         'website' => $request->webSite,
        //         'company_type' => $request->companyType,
        //         'cin' => $request->cine
        //     ]);
        // return User::create([
        //     'name' => $request->,
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
