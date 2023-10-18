<?php

namespace App\Http\Controllers\Clients;

use App\Enums\PickupRequestEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\PickupRequest\StorePickUpRequest;
use App\Models\City;
use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PickupRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $cities = City::where('active', 1)->get(['id', 'name']);
        $TYPE_OF_PICKUP_REQUEST = ['SIMPLE_PARCEL' => 'Parcel pickup'];
        return view("clients.requests.pickups.index", [
            "types" => $TYPE_OF_PICKUP_REQUEST,
            "cities" => $cities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("clients.requests.pickups.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePickUpRequest $request)
    {
        // if ($request->failedValidation()){
        //     return response()->json($request->messages());
        // }
        $pickupRequest = new PickupRequest();
        $pickupRequest->pickup_request_customer = Auth::id();
        $pickupRequest->pickup_request_type = $request->type;
        $pickupRequest->pickup_request_phone = $request->phone;
        $pickupRequest->pickup_request_address = $request->address;
        $pickupRequest->pickup_request_note = $request->note;
        $pickupRequest->pickup_request_statut = PickupRequestEnum::NEW;
        $pickupRequest->pickup_request_city = $request->city;
        $pickupRequest->pickup_request_time = Carbon::now();

        $pickupRequest->save();

        return Response::json([
            'success' => true, 
            'message' => __('The Collection added succesfully')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view("clients.requests.pickups.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
