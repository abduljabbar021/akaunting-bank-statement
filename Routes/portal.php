<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/bank-statement' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::portal('bank-statement', function () {
    // Route::get('invoices/{invoice}', 'Main@show')->name('invoices.show');
    // Route::post('invoices/{invoice}/confirm', 'Main@confirm')->name('invoices.confirm');
});
