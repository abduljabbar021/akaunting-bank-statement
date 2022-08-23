<?php

use Illuminate\Support\Facades\Route;

Route::admin('bank-statement', function () {
    Route::resource('statement', 'Main')->except(['index', 'create', 'store', 'show', 'destroy']);
    Route::get('statement/print/{account}', 'Main@printStatement')->name('print');
    Route::get('statement/pdf/{account}', 'Main@pdfStatement')->name('pdf');
});
