<div id="kt_app_header" class="app-header " data-kt-sticky="true" data-kt-sticky-activate-="true" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    <div class="app-container  container-xxxl d-flex align-items-stretch justify-content-between " id="kt_app_header_container">
        <div class="app-header-wrapper d-flex flex-grow-1 align-items-stretch justify-content-between" id="kt_app_header_wrapper">
            <div class="app-header-logo d-flex flex-shrink-0 align-items-center justify-content-between justify-content-lg-center">
                <button class="btn btn-icon btn-color-gray-600 btn-active-color-primary ms-n3 me-2 d-flex d-xl-none" id="kt_app_sidebar_toggle">
                    <i class="ki-solid ki-burger-menu-5 fs-2x"></i>
                </button>

                <a href="{{ route('clients.home') }}">
                    <img alt="Logo" src="{{ asset('assets/global/logo.png') }}" class="h-40px h-lg-60px theme-light-show" />
                    <img alt="Logo" src="{{ asset('assets/global/logo.png') }}" class="h-40px h-lg-40px theme-dark-show" />
                </a>
            </div>

            @php
            $user = auth()->user();
            @endphp

            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item ms-3 ms-lg-5" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-circle symbol-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"  data-kt-menu-placement="bottom-end">
                        <div class="symbol-label fs-4 fw-semibold bg-success text-inverse-success">
                            {{ $user->getAvatarLetters() }}
                        </div>
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-350px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px symbol-circle me-5">
                                    <div class="symbol-label fs-4 fw-semibold bg-success text-inverse-success">
                                        {{ $user->getAvatarLetters() }}
                                    </div>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        <span class="text-capitalize">{{ $user->name }}</span>
                                        @if($user->type == "CUSTOMER")
                                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">
                                                {{ __("Client") }}
                                            </span>
                                        @else
                                            <span class="badge badge-light-primary fw-bold fs-8 px-2 py-1 ms-2">
                                                {{ __("Staff") }}
                                            </span>
                                        @endif
                                    </div>
                                    <div  class="fw-semibold text-muted text-hover-primary fs-7">
                                        {{ $user->email }} 
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5 my-1">
                            <a href="{{ route('clients.profile.index')}}" class="menu-link px-5">
                                {{ __("Paramètres du compte") }}
                            </a>
                        </div>


                        <div class="menu-item px-5">
                            <a href="{{ route('clients.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="menu-link px-5">
                                {{ __("Deconnexion") }}
                            </a>

                            <form id="logout-form" action="{{ route('clients.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

                {{-- <div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-custom btn-active-color-primary btn-color-gray-700 w-35px h-35px w-md-40px h-md-40px" id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-text-align-left fs-1"></i> </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>