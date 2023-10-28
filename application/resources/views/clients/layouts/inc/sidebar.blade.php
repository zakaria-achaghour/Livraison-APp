<div id="kt_app_sidebar" class="app-sidebar flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: true, xl: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="275px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_toggle">
    <div class="app-sidebar-wrapper" id="kt_app_sidebar_wrapper">
        <div id="kt_app_sidebar_nav_wrapper" class="d-flex flex-column hover-scroll-y" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="{default: false, lg: '#kt_app_header'}" data-kt-scroll-wrappers="#kt_app_sidebar, #kt_app_sidebar_wrapper" data-kt-scroll-offset="{default: '10px', lg: '40px'}"> 
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5 mt-5 menu-title-gray-700">
                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="{{ route('clients.home') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-category fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i><i class="path4"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Accueil") }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-graph-up fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i><i class="path4"></i><i class="path5"></i><i class="path6"></i>
                            </i>
                        </span>
                        <span class="menu-title">{{ __("Statistiques") }}</span>
                    </a>
                </div>

                <div class="menu-item menu-labels">
                    <div class="menu-content d-flex flex-stack fw-bold text-gray-600 text-uppercase fs-7">
                        <span class="menu-heading ps-1">{{ __("Gestion Colis") }}</span>
                    </div>
                </div>

                <div class="app-sidebar-separator separator mx-4 mb-2"></div>

                

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link fs-5 fw-bold">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-dropbox fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i><i class="path4"></i><i class="path5"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Colis") }}</span><span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('clients.parcels.add') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Nouveau Colis") }}</span>
                            </a>
                        </div> 
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('clients.parcels.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Liste Colis") }}</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('clients.parcels.waiting-pick-up') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Colis pour ramassage") }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link fs-5 fw-bold">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-bank fs-1"><i class="path1"></i><i class="path2"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Stock") }}</span><span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('clients.inventory.add') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Ajoute Produit") }}</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('clients.inventory.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Liste Produits") }}</span>
                            </a>
                        </div> 
                        
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('clients.parcels.from-inventory') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Colis Stock") }}</span>
                            </a>
                        </div>                       
                    </div>
                </div>
                
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link fs-5 fw-bold">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-delivery fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i><i class="path4"></i><i class="path5"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Bons de livraison") }}</span><span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('clients.delivery-note.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Bons de livraison") }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link fs-5 fw-bold">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-exit-down fs-1"><i class="path1"></i><i class="path2"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Bons de retour") }}</span><span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __("Ajoute Produit") }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item menu-labels">
                    <div class="menu-content d-flex flex-stack fw-bold text-gray-600 text-uppercase fs-7">
                        <span class="menu-heading ps-1">{{ __("Paiments") }}</span>
                    </div>
                </div>

                <div class="app-sidebar-separator separator mx-4 mb-2"></div>

                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-dollar fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Liste Factures") }}</span>
                    </a>
                </div>

                <div class="menu-item menu-labels">
                    <div class="menu-content d-flex flex-stack fw-bold text-gray-600 text-uppercase fs-7">
                        <span class="menu-heading ps-1">{{ __("Request") }}</span>
                    </div>
                </div>

                <div class="app-sidebar-separator separator mx-4 mb-2"></div>
                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="{{ route('clients.requests.pickups.index') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-flag fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Collection") }}</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="{{ route('clients.requests.claims.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                        </span>
                        <span class="menu-title">{{ __("Claims") }}</span>
                    </a>
                </div>

                <div class="menu-item menu-labels">
                    <div class="menu-content d-flex flex-stack fw-bold text-gray-600 text-uppercase fs-7">
                        <span class="menu-heading ps-1">{{ __("Utilities") }}</span>
                    </div>
                </div>

                <div class="app-sidebar-separator separator mx-4 mb-2"></div>

                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="{{ route('clients.utilities.users.index') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-people   fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Users") }}</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-question fs-1"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>
                        </span>
                        <span class="menu-title">{{ __("Support") }}</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link fs-5 fw-bold" href="{{ route('clients.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span class="menu-icon">
                            <i class="bi bi-box-arrow-left fs-1"></i>
                        </span>
                        <span class="menu-title">{{ __("Logout") }}</span>
                    </a>
                  
                </div>
            </div>
        </div>
    </div>
</div>