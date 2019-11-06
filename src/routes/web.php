<?php

// Auth::routes();

Route::middleware(['web'])->namespace('MoriTiza\LaraLog\Http\Controllers')->group(function () {
    Route::get('logs', 'LaraLogController@index');
});
