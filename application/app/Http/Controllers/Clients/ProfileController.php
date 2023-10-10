<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\PaymentMode;

class ProfileController extends Controller
{
    public function index(Request $request) {
        return view('clients.profile.index');
    }

    public function connexion(Request $request) {
        return view('clients.profile.connexion');
    }

    public function paiement(Request $request) {
        return view('clients.profile.paiement');
    }

    public function numInvoices(Request $request) {
        $numInvoices = \Auth::user()->activeInvoices()->count();

        return Response::json([
                'success' => true, 
                'numInvoices' => $numInvoices
            ], 200);
    }

    public function numParcels(Request $request) {
        $numInvoices = \Auth::user()->parcelsAllReceived()->count();

        return Response::json([
                'success' => true, 
                'numParcels' => $numInvoices
            ], 200);
    }

    public function addPaiement(Request $request) {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'in:virement,cheque,espece'],
            'bank_id' => ['required', 'exists:banks,id'],
            'rib' => ['required', 'regex:/^\d{3}\s\d{3}\s\d{16}\s\d{2}$/'],
            'name' => ['required', 'min:1', 'max:50'],
        ], [
            'rib.regex' => __('Le format du RIB est invalide. Veuillez fournir un numéro de RIB valide.'),
        ]);

        $validator->setAttributeNames([
            'bank_id' => __('banque'),
            'name' => __('nom complete'),
            'type' => __('type'),
            'rib' => __('RIB'),
        ]);

        if ($validator->fails()) {
            $message = '<div class="d-flex flex-column" style="text-align: left;">';
            $message .= '<li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ';
            $message .= implode('</li><li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ', $validator->messages()->all());
            $message .= '</li></ul>';

            return Response::json([
                'success' => false, 
                'message' => $message
            ], 200);
        }

        $paymentMode = new PaymentMode();
        $paymentMode->customer_id = \Auth::user()->id;
        $paymentMode->type = $request->type;
        $paymentMode->bank_id = $request->bank_id;
        $paymentMode->name = $request->name;
        $paymentMode->rib = $request->rib;
        $paymentMode->save();

        return Response::json([
                "success" => true,
            ]);
    }

    public function deletePaiement(Request $request, $id) {
        PaymentMode::destroy($id);
        
        return Response::json([
                'success' => true,
            ], 200);
    }

    public function getAllPaiement(Request $request) {
        $paiment_modes = \Auth::user()->paimentModes()->with('bank')->get();
        return Response::json($paiment_modes, 200);
    }

    public function updatePassword(Request $request) {
        $user = \Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => ['confirmed', 'min:8', 'max:250', 'regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$/', 'different:old_password'],
        ]);

        $validator->setAttributeNames([
            'old_password' => __('ancien mot de passe'),
            'password' => __('nouveau mot de passe'),
        ]);

        if ($validator->fails()) {
            $message = '<div class="d-flex flex-column" style="text-align: left;">';
            $message .= '<li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ';
            $message .= implode('</li><li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ', $validator->messages()->all());
            $message .= '</li></ul>';

            return Response::json([
                'success' => false, 
                'message' => $message
            ], 200);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return Response::json([
                'success' => false, 
                'message' => __("L'ancien mot de passe ne correspond pas")
            ], 200);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return Response::json([
                "success" => true,
                "message" => __('Le mot de passe a été changé')
            ]);
    }

}
