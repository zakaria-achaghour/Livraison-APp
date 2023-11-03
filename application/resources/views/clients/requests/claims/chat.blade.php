@extends('clients.layouts.app')

@section('title', __('Show Claim'))

@section('after_css')
<style>
    .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image.svg') }}');
    }

    [data-bs-theme="dark"] .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image-dark.svg') }}');
    }                
</style>
@endsection

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <div class="d-flex flex-stack flex-row-fluid">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="page-title d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Show Claim") }}</span>
                    </h1>
                </div>

                <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="{{ route('clients.home') }}" class="text-white text-hover-primary">
                            <i class="ki-outline ki-home text-gray-700 fs-6"></i> </a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> 
                    </li>

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="{{ route('clients.requests.claims.index') }}" class="text-gray-700 text-hover-primary ">
                        {{ __('Claims') }} 
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("Show Claim") }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content mt-5 flex-column-fluid">
            
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <!--begin::Messenger-->
            <div class="card shadow-md card-flush card-rounded" id="kt_chat_messenger">
                <!--begin::Card header-->
                <div class="card-header {{($claim->claims_statut != App\Enums\ClaimsStatusEnum::Claim_Processed) ? 'bg-primary': 'bg-success'}} border-bottom-5" id="kt_chat_messenger_header">
                    <!--begin::Title-->
                    <div class="card-title">
                        <!--begin::User-->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1"> {{ __($claim->claims_object) }} </a>

                            <!--begin::Info-->
                            <div class="mb-0 lh-1">
                                <span class="badge badge-info badge-circle w-10px h-10px me-1"></span>
                                <span class="fs-7 fw-semibold text-muted">{{ $claim->parcel_code }}</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body " id="kt_chat_messenger_body">
                    <!--begin::Messages-->
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-300px  placeholder-loader holder-active" data-kt-element="messages" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" 
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body"
                        data-kt-scroll-offset="5px"
                        id="messages" data-id="{{$claim->claims_id}}">
                    </div>
                    <!--end::Messages-->
                </div>
                <!--end::Card body-->

                <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                @if ($claim->claims_statut != App\Enums\ClaimsStatusEnum::Claim_Processed)
                <!--begin::Card footer-->
                    <form id="messageForm" action="">
                        <textarea class="form-control form-control-solid  mb-3" rows="2" data-kt-element="input"
                            placeholder="Type a message" name="message"></textarea>
                        <!--end::Input-->
                        <input type="hidden" value="{{$claim->claims_id}}" name="claimId"/>
                        <!--begin:Toolbar-->
                        <div class="d-flex justify-content-center ">
                            <!--begin::Send-->
                            <button class="btn btn-primary btn-lg" type="button" data-kt-element="send" id="sendMessage">Send</button>
                            <!--end::Send-->
                        </div>
                    </form>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card footer-->
                </div>
                @endif
            <!--end::Messenger-->
        </div>
</div>

</div>
@endsection

@section('after_js')
<script src="{{ asset('assets/clients/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        if ($('#messageForm').length > 0) {
            $('#messageForm')[0].reset();
        }
        var claimId = $("#messages").data('id');
        var url = '{{ route('clients.requests.claims.messages.load', ['id' => 0]) }}';
        var messagesUrl = url.slice(0, -1) + claimId;
        function loadMessages() {
            $.ajax({
                url: messagesUrl,
                complete: function() {
                        $('.placeholder-loader').removeClass('holder-active');
                },
                type: 'GET',
                success: function(data) {
                    // Update the content of the message-container with the loaded HTML
                    $('#messages').html(data.messages);
                }
            });
        }

        $('#sendMessage').on('click', function(e) {
                e.preventDefault();
                var formData = new FormData($('#messageForm')[0]);

                $.ajax({
                    url: '{{ route('clients.requests.claims.chat.message') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success) {
                            $('#messageForm')[0].reset();
                            loadMessages();
                        }
                    }
                });
            });

         // Load messages initially
        loadMessages();
        setInterval(loadMessages, 300000);
      });
</script>
@endsection