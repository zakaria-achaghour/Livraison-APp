@extends('clients.layouts.auth')

@section('title', __('Verify Email Address'))

@section('content')

    
                    
        <!--begin::Logo-->
            <div class="text-center mb-14">
                <img src="{{ asset('assets/global/logo.png') }}" />
            </div>
        <!--end::Logo-->
    
        {{-- @if (session('message'))
            <div id="alert-zone" class="alert alert-info fs-5">{{ session('message') }}</div>
        @endif --}}
        <div class="separator separator-content my-14">
            
        </div>
        <!--begin::Title-->
        <h1 class="fw-bolder text-gray-900 mb-5">
            {{__('Verify Your Email Address')}}
        </h1>
        <!--end::Title--> 
        
        <!--begin::Action-->
        <div class="fs-6 mb-8">
            <span class="fw-semibold text-gray-500">{{__('Did’t receive an email?')}}</span>
    
            <a href="{{ route('clients.verification.resend') }}" class="link-primary fw-bold"> {{__('Try Again')}}</a>
        </div>
        <!--end::Action-->
        
        
        <!--begin::Illustration-->
        <div class="mb-0">
            <img src="{{ asset('assets/clients/media/auth/please-verify-your-email.png') }}" class="mw-100 mh-300px theme-light-show" alt=""/>
            <img src="{{ asset('assets/clients/media/auth/please-verify-your-email-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt=""/>
        </div>
        <!--end::Illustration-->   
    
@endsection

@section('js')
<script src="{{ asset('assets/clients/js/locale/validation_'.app()->getLocale().'.js') }}"></script>
<script src="{{ asset('assets/clients/js/custom/authentication/sign-in/general.js') }}"></script>
@endsection