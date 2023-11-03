<?php

 
Route::prefix('clients')->name('clients.')->group(function () {
    
    
    Route::get('language/{locale}', [\App\Http\Controllers\GlobalController::class, 'languageSwitch'])->name('language.switch');
    // login
    Route::get('login', [\App\Http\Controllers\Clients\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Clients\Auth\LoginController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Clients\Auth\LoginController::class, 'logout'])->name('logout');

    // register
    Route::get('register', [\App\Http\Controllers\Clients\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Clients\Auth\RegisterController::class, 'register']);
  

   

    // password reset
    Route::get('password/reset', [\App\Http\Controllers\Clients\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Clients\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Clients\Auth\ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Clients\Auth\ResetPasswordController::class, 'reset'])
        ->name('password.update');
    Route::get('password/success', [\App\Http\Controllers\Clients\Auth\ResetPasswordController::class, 'success'])
        ->name('password.success');
 
   
    // Email Verification Routes...
    Route::get('email/verify', [\App\Http\Controllers\Clients\Auth\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Clients\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/resend', [\App\Http\Controllers\Clients\Auth\VerificationController::class, 'resend'])->name('verification.resend');

 
    Route::post('email/change', [\App\Http\Controllers\Clients\Auth\VerificationController::class, 'changeEmail'])
        ->name('email.change');


    // DASHBOARD
    Route::group(['middleware' => ['auth:clients','verified']], function () {
        Route::get('/', [\App\Http\Controllers\Clients\DashboardController::class, 'index'])->name('home');

        // Profile
        Route::prefix('profile')->controller(\App\Http\Controllers\Clients\ProfileController::class)->group(function () {
            Route::get('/', 'index')->name('profile.index');
            Route::get('/num-invoices', 'numInvoices')->name('profile.num-invoices');
            Route::get('/num-parcels', 'numParcels')->name('profile.num-parcels');

            Route::get('connexion', 'connexion')->name('profile.connexion');
            Route::post('password', 'updatePassword')->name('profile.password');

            Route::get('mode-paiement', 'paiement')->name('profile.paiement');
            Route::post('mode-paiement', 'addPaiement')->name('profile.paiement.add');
            Route::delete('mode-paiement/{id?}', 'deletePaiement')->name('profile.paiement.delete');
            Route::get('mode-paiement/get-all', 'getAllPaiement')->name('profile.paiement.all');
        });

        // Parcels
        Route::prefix('parcels')->controller(\App\Http\Controllers\Clients\ParcelController::class)->group(function () {
            Route::get('/', 'index')->name('parcels.index');
            Route::get('load', 'load')->name('parcels.load');
            
            Route::get('from-inventory', 'fromInventory')->name('parcels.from-inventory');
            Route::get('from-inventory/load', 'fromInventoryLoad')->name('parcels.from-inventory.load');

            Route::get('load-cities', 'loadCities')->name('parcels.load.cities');
            Route::get('tracking/{id?}', 'tracking')->name('parcels.tracking');
            Route::get('informations/{id?}', 'informations')->name('parcels.informations');
            Route::get('livreur/{id?}', 'livreur')->name('parcels.livreur');

            // ADD
            Route::get('add', 'add')->name('parcels.add');
            Route::post('save', 'save')->name('parcels.save');
            Route::post('city/tarifs', 'getCityTarfis')->name('parcels.city.tarifs');

            // REMOVE
            Route::delete('{id}', 'delete')->name('parcels.delete');

            // EDIT
            Route::get('edit/{id}', 'edit')->name('parcels.edit');
            Route::post('update', 'update')->name('parcels.update');
        });

        Route::prefix('parcels/waiting-pick-up')->controller(\App\Http\Controllers\Clients\ParcelWaitingController::class)->group(function () {
            Route::get('', 'index')->name('parcels.waiting-pick-up');
            Route::get('load', 'load')->name('parcels.waiting-pick-up.load');
        });

        Route::prefix('parcels/from-inventory')->controller(\App\Http\Controllers\Clients\ParcelStockController::class)->group(function () {
            Route::get('/', 'index')->name('parcels.from-inventory');
            Route::get('load', 'load')->name('parcels.from-inventory.load');
        });

        // EDIT REQUEST
        Route::prefix('edit-requests')->controller(\App\Http\Controllers\Clients\ParcelEditController::class)->group(function () {
            Route::get('/{id?}', 'editRequest')->name('parcels.edit-request');
            Route::post('send', 'sendEditRequest')->name('parcels.edit-request.send');
        });


        // Inventory
        Route::prefix('inventory')->controller(\App\Http\Controllers\Clients\InventoryController::class)->group(function () {
            Route::get('/', 'index')->name('inventory.index');
            Route::get('load', 'load')->name('inventory.load');
            Route::get('add', 'add')->name('inventory.add');
            Route::post('save', 'save')->name('inventory.save');
            Route::get('edit/{id}', 'edit')->name('inventory.edit');
            Route::post('update', 'update')->name('inventory.update');
            Route::delete('{id}', 'delete')->name('inventory.delete');
            Route::get('load_for_parcel', 'loadForParcel')->name('parcels.from-inventory.load_for_parcel');
            Route::get('parcel_products/{id}', 'parcelProducts')->name('parcels.from-inventory.parcel_products');
            Route::post('parcel_products/add', 'addParcelProducts')->name('parcels.from-inventory.add_parcel_products');
            Route::post('parcel_products/remove', 'removeParcelProducts')->name('parcels.from-inventory.remove_parcel_products');
            /*Route::get('edit/parcel/{id}', 'edit')->name('inventory.edit.parcel');*/
        });

        // Bon livrasion
        Route::prefix('delivery-note')->controller(\App\Http\Controllers\Clients\DeliveryNoteController::class)->group(function () {
            Route::get('/', 'index')->name('delivery-note.index');
            Route::get('load', 'load')->name('delivery-note.load');
            Route::get('add', 'add')->name('delivery-note.add');
            Route::post('save', 'save')->name('delivery-note.save');
            Route::get('edit/{id}', 'edit')->name('delivery-note.edit');
            Route::post('update', 'update')->name('delivery-note.update');
            Route::delete('{id}', 'delete')->name('delivery-note.delete');
            Route::get('parcels/load', 'parcelsLoad')->name('delivery-note.parcels.load');
        });

        // Requests
        Route::group([
            'prefix' => '/requests',
            'as' => 'requests.',
          ], function () {
            Route::prefix('pickups')->controller(\App\Http\Controllers\Clients\PickupRequestController::class)->group(function () {
                Route::get('load', 'load')->name('pickups.load');
                Route::post('/', 'store')->name('pickups.store');
                Route::delete('/{id}', 'destroy')->name('pickups.delete');
                Route::get('/', 'index')->name('pickups.index');
            });
            Route::prefix('claims')->controller(\App\Http\Controllers\Clients\ClaimRequestController::class)->group(function () {
                Route::get('load', 'load')->name('claims.load');
                Route::post('/', 'store')->name('claims.store');
                Route::delete('/{id}', 'destroy')->name('claims.delete');
                Route::get('/', 'index')->name('claims.index');
                Route::get('/{id}', 'chat')->name('claims.chat');
                Route::post('/chat/messages', 'chatMessage')->name('claims.chat.message');
                Route::get('/chat/message/{id}', 'loadChat')->name('claims.messages.load');
            });
          });

          // utilities
        Route::group([
            'prefix' => '/utilities',
            'as' => 'utilities.',
          ], function () {
              Route::resource('users', \App\Http\Controllers\Clients\CustomerController::class);
          });
    });
});